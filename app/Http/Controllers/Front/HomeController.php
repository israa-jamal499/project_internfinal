<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;


class HomeController extends Controller
{
     public function index()
    {
        $latestOpportunities = Opportunity::with(['company', 'specializations', 'image'])
            ->where('status', 'مفتوحة')
            ->latest()
            ->take(3)
            ->get();

        return view('front.home.index', compact('latestOpportunities'));
    }
}