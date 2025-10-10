<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MatchController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            $user = User::first();
        }

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to view matches');
        }

        $userType = $user->user_type;
        $userId = $user->getProfileId();

        if ($userType === "student") {
            $matches = Company::with(['profession'])
                ->whereNotIn('Company_ID', function ($query) use ($userId) {
                    $query->select('Company_ID')
                        ->from('matches')
                        ->where('Student_ID', $userId);
                })
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

            $existingMatches = DB::table('matches')
                ->where('student_ID', $userId)
                ->join('companies', 'matches.Company_ID', '=', 'companies.Company_ID')
                ->leftJoin('professions', 'companies.Profession_ID', '=', 'professions.Profession_ID')
                ->select(
                    'companies.*',
                    'matches.created_at as match_date',
                    'professions.Profession_Name'
                )
                ->orderBy('match_date', 'desc')
                ->get();
            $matchTitle = 'Companies Looking for Students';
            $matchSubtitle = 'Find your perfect internship';
        } else {
            $matches = Student::with(['profession', 'school'])->whereNotIn('Student_ID', function ($query) use ($userId) {
                $query->select('Student_ID')
                    ->from('matches')
                    ->where('Company_ID', $userId);
            })
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
                ->get();

            $matchTitle = 'Students Looking for Opportunities';
            $matchSubtitle = 'Find talented students for your company';
        }

        return Inertia::render('match', [
            'matches' => $matches,
            'existingMatches' => $existingMatches,
            'userType' => $userType,
            'currentUser' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'profile_id' => $userId,
                'profile' => $user->getProfile()
            ],
            'matchTitle' => $matchTitle,
            'matchSubtitle' => $matchSubtitle,
            'totalMatches' => $matches->count()
        ]);
    }

    public function createMatch(Request $request)
    {
        $user = Auth::user() ?? User::first();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate(['target_id' => 'required|integer']);

        $userType = $user->user_type;
        $userId = $user->getProfileId();

        $existingMatch = DB::table('matches')
            ->when($userType === 'student', function ($query) use ($userId, $validated) {
                return $query->where('Student_ID', $userId)->where('Company_ID', $validated['target_id']);
            })
            ->when($userType === 'company', function ($query) use ($userId, $validated) {
                return $query->where('Company_ID', $userId)
                    ->where('Student_ID', $validated['target_id']);
            })
            ->first();

        if ($existingMatch) {
            return response()->json(['message' => 'Match already exists'], 409);
        }

        if ($userType === 'student') {
            DB::table('matches')->insert([
                'Student_ID' => $userId,
                'Company_ID' => $validated['target_id'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {
            DB::table('matches')->insert([
                'Company_ID' => $userId,
                'Student_ID' => $validated['target_id'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        return response()->json(['message' => 'Match created successfully!'], 201);
    }

    public function removeMatch(Request $request)
    {
        $user = Auth::user() ?? User::first();


        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'target_id' => 'required|integer'
        ]);

        $userType = $user->user_type;
        $userId = $user->getProfileId();

        $deleted = DB::table('matches')
            ->when($userType === 'student', function ($query) use ($userId, $validated) {
                return $query->where('Student_ID', $userId)
                    ->where('Company_ID', $validated['target_id']);
            })
            ->when($userType === 'company', function ($query) use ($userId, $validated) {
                return $query->where('Company_ID', $userId)
                    ->where('Student_ID', $validated['target_id']);
            })
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Match removed successfully'], 200);
        }

        return response()->json(['message' => 'Match not found'], 404);
    }
}
