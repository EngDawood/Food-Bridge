<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $donations = Donation::with(['donor:id,name,email'])
            ->when($q, function ($query) use ($q) {
                $query->where('food_type', 'like', "%{$q}%")
                    ->orWhere('status', 'like', "%{$q}%");
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.donations.index', compact('donations', 'q'));
    }

    public function edit(Donation $donation)
    {
        return view('admin.donations.edit', compact('donation'));
    }

    public function update(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'food_type' => ['required', 'string', 'in:' . implode(',', \App\Helpers\FoodTypes::values())],
            'quantity' => ['required', 'integer', 'min:1'],
            'expiration_date' => ['nullable', 'date'],
            'pickup_time' => ['nullable', 'date'],
            'status' => ['required', 'in:pending,scheduled,delivered'],
        ]);

        $donation->update($validated);

        return redirect()->route('admin.donations.index')->with('status', 'Donation updated');
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('admin.donations.index')->with('status', 'Donation deleted');
    }
}


