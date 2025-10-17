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
                } else {
                    return redirect()->route('home')->with('error', 'No data available. Please run seeders first.');
                }
            }
        }

        $userType = $user->getUserType();
        $userId = $user->getProfileId();

        if (!$userId) {
            return redirect()->route('home')->with('error', 'User profile not properly set up.');
        }

        if ($userType === 'student') {
            // Student sees companies they haven't matched with yet
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
                        'Website_Link' => $company->Website_Link,
                        'type' => 'company'
                    ];
                });

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


            $matchTitle = 'Companies Looking for Students';
            $matchSubtitle = 'Find your perfect internship or job opportunity';
        } else {
            // Company sees students they haven't matched with yet
            $matches = Student::with(['profession', 'school'])
                ->whereNotIn('Student_ID', function ($query) use ($userId) {
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
                'user_type' => $userType,
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
            return response()->json(['message' => 'User not found'], 401);
        }

        $validated = $request->validate([
            'target_id' => 'required|integer'
        ]);

        $userType = $user->getUserType();
        $userId = $user->getProfileId();

        if (!$userId) {
            return response()->json(['message' => 'User profile not properly set up'], 400);
        }

        // Check if match already exists
        $existingMatch = DB::table('matches')
            ->when($userType === 'student', function ($query) use ($userId, $validated) {
                return $query->where('Student_ID', $userId)
                    ->where('Company_ID', $validated['target_id']);
            })
            ->when($userType === 'company', function ($query) use ($userId, $validated) {
                return $query->where('Company_ID', $userId)
                    ->where('Student_ID', $validated['target_id']);
            })
            ->first();

        if ($existingMatch) {
            return response()->json(['message' => 'Match already exists'], 409);
        }

        // Create new match
        try {
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
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create match: ' . $e->getMessage()], 500);
        }
    }

    public function removeMatch(Request $request)
    {
        $user = Auth::user() ?? User::first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 401);
        }

        $validated = $request->validate([
            'target_id' => 'required|integer'
        ]);

        $userType = $user->getUserType();
        $userId = $user->getProfileId();

        if (!$userId) {
            return response()->json(['message' => 'User profile not properly set up'], 400);
        }

        try {
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
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to remove match: ' . $e->getMessage()], 500);
        }
    }
}
