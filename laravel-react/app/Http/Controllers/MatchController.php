<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Company;
use App\models\Student;
use Inertia\Inertia;

class MatchController extends Controller
{
    public function index(Request $request)
    {
        $userType = $request->get('user_type', 'student');

        if ($userType === 'student') {
            $matches = Company::with(['profession'])
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

            $matchTitle = 'companies Looking for students';
            $matchSubtitle = 'Find your perfect internship or job opportunity';
        } else {
            $matches = Student::with(['profession', 'school'])
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

            $matchTitle = 'Students Looking for Opportunities';
            $matchSubtitle = 'Find talented students for your company';
        }
        return Inertia::render('match', [
            'matches' => $matches,
            'userType' => $userType,
            'matchTitle' => $matchTitle,
            'matchSubtitle' => $matchSubtitle,
            'totalMatches' => $matches->count()
        ]);
    }

    public function createMatch(Request $request)
    {
        $validated = $request->validate([
            'user_type' => 'required|in:student,company',
            'user_id' => 'required|integer',
            'target_id' => 'required|integer'
        ]);

        $existingMatch = DB::table('matches')
        ->when($validated['user_type'] === 'student', function($query) use ($validated) {
            return $query->where('Student_ID', $validated['user_id'])
            ->where('Company_ID', $validated['target_id']);
        })
        ->when($validated['user_type'] === 'company', function($query) use ($validated) {
             return $query->where('Company_ID', $validated['user_id'])
                           ->where('Student_ID', $validated['target_id']);
        })
        ->first();

        if ($existingMatch) {
             return response()->json(['message' => 'Match already exists'], 409);
        }

        if ($validated['user_type'] === 'student') {
            DB::table('matches')->instert([
                'Student_ID' => $validated['user_id'],
                'Company_ID' => $validated['target_id'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {
              DB::table('matches')->insert([
                'Company_ID' => $validated['user_id'],
                'Student_ID' => $validated['target_id'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

           return response()->json(['message' => 'Match created successfully'], 201);

    }

    public function removeMatch(Request $request){
        $validated = $request->validate([
              'user_type' => 'required|in:student,company',
            'user_id' => 'required|integer',
            'target_id' => 'required|integer'
        ]);

        $deleted = DB::table('matches')
        ->when($validated['user_type'] === 'student', function($query) use ($validated) {
                return $query->where('Student_ID', $validated['user_id'])
                           ->where('Company_ID', $validated['target_id']);
            })
            ->when($validated['user_type'] === 'company', function($query) use ($validated) {
                return $query->where('Company_ID', $validated['user_id'])
                           ->where('Student_ID', $validated['target_id']);
            })
            ->delete();

            if ($deleted) {
                return response()->json(['message' => 'Match removed successfully'], 200);
            }
    }
    public function switchUserType(Request $request)
    {
        $userType = $request->get('user_type', 'student');
        return redirect()->route('match.index', ['user_type' => $userType]);
    }
}
