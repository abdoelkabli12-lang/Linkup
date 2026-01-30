<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the dashboard page.
     */
    public function index(Request $request)
    {
        $currentUser = Auth::user();
        
        // 1. Start the query builder (don't get() yet)
        $query = User::where('id', '!=', $currentUser->id);

        // 2. Apply search filter only if needed
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                // Fixed column names to match your User model
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
                  // Removed 'pseudo' and 'name' as they don't exist in your DB
            });
        }

        // 3. Execute the query once
        $users = $query->get(); 
        // Or use $query->paginate(9); if you want pagination

        return view('dashboard', [
            'users' => $users,
            'currentUser' => $currentUser
        ]);
    }
}