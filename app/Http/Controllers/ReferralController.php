<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ReferralController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $referrals = $user->referralsMade()->with('referredUser')->latest()->paginate(15);
        $referralLink = url('/register?ref=' . $user->referral_code);
        return view('referrals.index', compact('referrals', 'referralLink'));
    }
}
