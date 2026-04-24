<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use App\Models\Specialization;

class OpportunityController extends Controller
{
    public function index()
    {
        $specializations = Specialization::orderBy('name')->get();

        $opportunities = Opportunity::with(['company', 'city', 'specializations', 'image'])
            ->where('status', 'مفتوحة')
            ->orderBy('id', 'desc')
            ->paginate(8);

        return view('front.home.opportunities', compact('opportunities', 'specializations'));
    }

    public function show($id)
    {
        $opportunity = Opportunity::with(['company.user', 'city', 'specializations', 'image'])
            ->where('status', 'مفتوحة')
            ->findOrFail($id);

        $similarOpportunities = Opportunity::with(['company', 'image'])
            ->where('status', 'مفتوحة')
            ->where('id', '!=', $opportunity->id)
            ->latest()
            ->take(8)
            ->get();

        return view('front.home.opportunity-details', compact('opportunity', 'similarOpportunities'));
    }
}
