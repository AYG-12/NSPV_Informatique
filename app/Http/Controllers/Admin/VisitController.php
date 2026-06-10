<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageVisit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function index(Request $request)
    {
        $query = PageVisit::orderByDesc('date');

        if ($request->filled('mois')) {
            $query->whereYear('date', substr($request->mois, 0, 4))
                  ->whereMonth('date', substr($request->mois, 5, 2));
        }

        $visits      = $query->paginate(31)->withQueryString();
        $totalAll    = PageVisit::sum('count');
        $todayCount  = PageVisit::where('date', today())->value('count') ?? 0;
        $monthCount  = PageVisit::whereYear('date', now()->year)
                                ->whereMonth('date', now()->month)
                                ->sum('count');
        $maxDay      = PageVisit::max('count') ?: 1;

        // Courbe des 30 derniers jours pour le mini-graphe
        $last30 = PageVisit::where('date', '>=', now()->subDays(29)->toDateString())
            ->orderBy('date')
            ->get(['date', 'count']);

        return view('admin.pages.visites', compact(
            'visits', 'totalAll', 'todayCount', 'monthCount', 'maxDay', 'last30'
        ));
    }
}
