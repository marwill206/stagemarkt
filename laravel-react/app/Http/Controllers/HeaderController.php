<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Student;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HeaderController extends Controller
{
    public function index(Request $request)
    {

        $searchOpleiding = $request->get('opleiding', '');
        $searchLocation = $request->get('locatie', '');
        $searchDistance = $request->get('locatie-range', 0);
        $searchType = $request->get('search_type', 'stages');
        // Get current authenticated user or use demo user
        $user = Auth::user();

        if (!$user) {
            // For demo purposes, create a demo user if none exists
            $user = User::with(['student.profession', 'student.school', 'company.profession'])->first();

            if (!$user) {
                // Create a demo user linked to first student
                $firstStudent = Student::first();
                if ($firstStudent) {
                    $user = User::create([
                        'name' => $firstStudent->Student_Name,
                        'email' => $firstStudent->Student_Email,
                        'password' => bcrypt('password'),
                        'user_type' => 'student',
                        'role' => 'student',
                        'student_id' => $firstStudent->Student_ID,
                        'company_id' => null,
                    ]);
                }
            }
        }

        $userType = $user ? $user->getUserType() : 'student';
        $userId = $user ? $user->getProfileId() : null;

        $matches = collect();
        $existingMatches = collect();
        $matchTitle = 'Welcome to Stagemarkt';
        $matchSubtitle = 'Vind jouw perfecte stagiair.';

        $allProfessions = Profession::all()->pluck('Profession_Name')->toArray();

        if ($userId) {
            if ($userType === 'student' || $searchType === 'leerbedrijven') {
                // Student sees companies they haven't matched with yet
                $query = Company::with(['profession']);

                if (!empty($searchOpleiding)) {
                    $query->whereHas('profession', function ($q) use ($searchOpleiding) {
                        $q->where('Profession_Name', 'LIKE', '%' . $searchOpleiding . '%');
                    })->orWhere('Company_Name', 'LIKE' . $searchOpleiding . '%');
                }

                $matches =  $query->whereNotIn('Company_ID', function ($query) use ($userId) {
                    $query->select('Company_ID')
                        ->from('matches')
                        ->where('Student_ID', $userId);
                })
                    // Limit for homepage
                    ->get()
                    ->map(function ($company) {
                        return [
                            'id' => $company->Company_ID,
                            'name' => $company->Company_Name,
                            'email' => $company->Company_Email,
                            'address' => $company->Company_Address,
                            'profession' => $company->profession ? $company->profession->Profession_Name : 'N/A',
                            'field' => $company->field,
                            'type' => 'company'
                        ];
                    });

                if (!empty($searchOpleiding)) {
                    $matchTitle = "Zoekresultaten voor '{$searchOpleiding}'";
                    $matchSubtitle = "Bedrijven die zoeken naar {$searchOpleiding}";
                } else {
                    $matchTitle = 'Companies Looking for Students';
                    $matchSubtitle = 'Vind jouw perfecte stage.';
                }

                // Get existing matches for this student
                $existingMatches = DB::table('matches')
                    ->where('Student_ID', $userId)
                    ->join('companies', 'matches.Company_ID', '=', 'companies.Company_ID')
                    ->leftJoin('professions', 'companies.Profession_ID', '=', 'professions.Profession_ID')
                    ->select(
                        'companies.*',
                        'matches.created_at as match_date',
                        'professions.Profession_Name'
                    )
                    ->orderBy('match_date', 'desc')
                    ->take(3) // Limit for homepage
                    ->get();

                $matchTitle = 'Companies Looking for Students';
                $matchSubtitle = 'Vind jouw perfecte stage.';
            } else {
                // Company sees students they haven't matched with yet
                $query = Student::with(['profession', 'school']);

                if (!empty($searchOpleiding)) {
                    $query->whereHas('profession', function ($q) use ($searchOpleiding) {
                        $q->where('Profession_Name', 'LIKE', '%' . $searchOpleiding . '%');
                    })->orWhere('Student_Name', 'LIKE', '%' . $searchOpleiding . '%');
                }


                $matches = $query->whereNotIn('Student_ID', function ($query) use ($userId) {
                    $query->select('Student_ID')
                        ->from('matches')
                        ->where('Company_ID', $userId);
                })
                    // Limit for homepage
                    ->get()
                    ->map(function ($student) {
                        return [
                            'id' => $student->Student_ID,
                            'name' => $student->Student_Name,
                            'email' => $student->Student_Email,
                            'address' => $student->Address,
                            'age' => $student->Age,
                            'profession' => $student->profession ? $student->profession->Profession_Name : 'N/A',
                            'school' => $student->school ? $student->school->School_Name : 'N/A',
                            'portfolio' => $student->Portfolio_Link,
                            'about' => $student->About_Text,
                            'type' => 'student'
                        ];
                    });



                // Get existing matches for this company
                $existingMatches = DB::table('matches')
                    ->where('Company_ID', $userId)
                    ->join('students', 'matches.Student_ID', '=', 'students.Student_ID')
                    ->leftJoin('professions', 'students.Profession_ID', '=', 'professions.Profession_ID')
                    ->leftJoin('schools', 'students.School_ID', '=', 'schools.School_ID')
                    ->select(
                        'students.*',
                        'matches.created_at as match_date',
                        'professions.Profession_Name',
                        'schools.School_Name'
                    )
                    ->orderBy('match_date', 'desc')
                    ->take(3) // Limit for homepage
                    ->get();

                $matchTitle = 'Students Looking for Opportunities';
                $matchSubtitle = 'Vind getalenteerde studenten voor je bedrijf!';

                if (!empty($searchOpleiding)) {
                    $matchTitle = "Zoekresultaten voor '{$searchOpleiding}'";
                    $matchSubtitle = "Studenten met {$searchOpleiding} achtergrond";
                } else {
                    $matchTitle = 'Students Looking for Opportunities';
                    $matchSubtitle = 'Vind jouw perfecte stagiair.';
                }
            }
        }

        return Inertia::render('index', [
            'exampleProp' => 'This is a test message from Laravel!',
            'anotherProp' => 12345,
            'matches' => $matches,
            'existingMatches' => $existingMatches,
            'userType' => $userType,
            'currentUser' => $user ? [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'user_type' => $userType,
                'profile_id' => $userId,
                'profile' => $user->getProfile()
            ] : null,
            'matchTitle' => $matchTitle,
            'matchSubtitle' => $matchSubtitle,
            'totalMatches' => $matches->count()
        ]);
    }
}
