<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromotionController extends Controller
{
    public function index()
    {
        // $active  = Promotion::where('is_active', true)->latest()->get();
        // $expired = Promotion::where(function ($q) {
        //     $q->where('is_active', false)
        //       ->orWhere('expires_at', '<', now());
        // })->latest()->get();

        // $activeCount = $active->count();

        // return view('admin.pages.promotions', compact('active', 'expired', 'activeCount'));
        

        // Vous n'avez plus rien à passer ici ! 
        // Le View Composer injectera $active, $expired et $activeCount automatiquement
        return view('admin.pages.promotions');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'description'      => ['required', 'string', 'max:100'],
            'code'             => ['required', 'string', 'max:50', 'unique:promotions,code'],
            'type'             => ['required', 'in:percent,fixed'],
            'value'            => ['required', 'numeric', 'min:0'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'usage_limit'      => ['nullable', 'integer', 'min:1'],
            'starts_at'        => ['nullable', 'date'],
            'expires_at'       => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_active'        => ['boolean'],
        ]);

        $data['code']      = strtoupper($data['code']);
        $data['is_active'] = $request->boolean('is_active', true);

        Promotion::create($data);

        return redirect()->route('admin.promotions')
            ->with('success', 'Promotion "' . $data['code'] . '" créée.');
    }

    public function update(Request $request, Promotion $promotion)
    {
        $data = $request->validate([
            'description'      => ['required', 'string', 'max:100'],
            'code'             => ['required', 'string', 'max:50', 'unique:promotions,code,' . $promotion->id],
            'type'             => ['required', 'in:percent,fixed'],
            'value'            => ['required', 'numeric', 'min:0'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'usage_limit'      => ['nullable', 'integer', 'min:1'],
            'starts_at'        => ['nullable', 'date'],
            'expires_at'       => ['nullable', 'date'],
            'is_active'        => ['boolean'],
        ]);

        $data['code']      = strtoupper($data['code']);
        $data['is_active'] = $request->boolean('is_active');

        $promotion->update($data);

        return redirect()->route('admin.promotions')
            ->with('success', 'Promotion mise à jour.');
    }

    public function toggle(Promotion $promotion)
    {
        $promotion->update(['is_active' => ! $promotion->is_active]);

        return redirect()->route('admin.promotions')
            ->with('success', 'Statut mis à jour.');
    }

    public function destroy(Promotion $promotion)
    {
        $code = $promotion->code;
        $promotion->delete();

        return redirect()->route('admin.promotions')
            ->with('success', 'Promotion "' . $code . '" supprimée.');
    }
}
