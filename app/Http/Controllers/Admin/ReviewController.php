<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['product', 'user'])->latest();

        if ($request->filled('statut')) {
            $query->where('is_approved', $request->statut === 'approved');
        }

        if ($request->filled('q')) {
            $term = $request->q;
            $query->where(function ($q) use ($term) {
                $q->whereHas('product', fn($s) => $s->where('name', 'like', "%{$term}%"))
                  ->orWhereHas('user',    fn($s) => $s->where('name', 'like', "%{$term}%"));
            });
        }

        $reviews      = $query->paginate(20)->withQueryString();
        $pendingCount = Review::where('is_approved', false)->count();

        return view('admin.pages.avis', compact('reviews', 'pendingCount'));
    }

    public function disapprove(Review $review)
    {
        $review->update(['is_approved' => false]);

        return back()->with('success', 'Avis masqué.');
    }

    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);

        return back()->with('success', 'Avis réapprouvé et publié.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Avis supprimé.');
    }
}
