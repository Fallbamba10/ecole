<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\School;
use App\Models\Student;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSchools = School::count();
        $activeSchools = School::where('is_active', true)->count();
        $totalUsers = User::count();
        $totalStudents = Student::withoutGlobalScopes()->count();

        // MRR (Monthly Recurring Revenue) - écoles avec abonnement payant
        $plans = School::select('subscription_plan')
            ->selectRaw('count(*) as count')
            ->groupBy('subscription_plan')
            ->get()
            ->keyBy('subscription_plan');

        $schools = School::withCount(['users', 'students', 'classrooms'])->latest()->get();

        return view('super-admin.dashboard', compact(
            'totalSchools',
            'activeSchools',
            'totalUsers',
            'totalStudents',
            'plans',
            'schools'
        ));
    }
}
