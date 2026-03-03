<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $submissions = Submission::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total' => $submissions->count(),
            'pending' => $submissions->where('status', 'Pending')->count(),
            'approved' => $submissions->where('status', 'Approved')->count(),
            'rejected' => $submissions->where('status', 'Rejected')->count(),
        ];

        return view('dashboard', compact('submissions', 'stats'));
    }
}
