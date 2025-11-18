<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FoodRequest;
use Illuminate\Http\Request;

class RequestAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $requests = FoodRequest::with(['beneficiary:id,name,email'])
            ->when($q, function ($query) use ($q) {
                $query->where('food_type', 'like', "%{$q}%")
                    ->orWhere('status', 'like', "%{$q}%");
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.requests.index', compact('requests', 'q'));
    }

    public function edit(FoodRequest $requestModel)
    {
        return view('admin.requests.edit', ['request' => $requestModel]);
    }

    public function update(Request $request, FoodRequest $requestModel)
    {
        $validated = $request->validate([
            'food_type' => ['required', 'string', 'in:' . implode(',', \App\Helpers\FoodTypes::values())],
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,matched,fulfilled'],
        ]);

        $requestModel->update($validated);

        return redirect()->route('admin.requests.index')->with('status', 'Request updated');
    }

    public function destroy(FoodRequest $requestModel)
    {
        $requestModel->delete();
        return redirect()->route('admin.requests.index')->with('status', 'Request deleted');
    }
}


