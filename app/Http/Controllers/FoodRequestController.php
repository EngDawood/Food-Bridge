<?php

namespace App\Http\Controllers;

use App\Models\FoodRequest;
use App\Models\Donation;
use App\Services\MatchingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodRequestController extends Controller
{
    protected MatchingService $matchingService;

    public function __construct(MatchingService $matchingService)
    {
        $this->matchingService = $matchingService;
    }

    public function index()
    {
        $requests = FoodRequest::where('beneficiary_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('beneficiary.index', compact('requests'));
    }

    public function create()
    {
        return view('beneficiary.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'food_type' => ['required', 'string', 'in:' . implode(',', \App\Helpers\FoodTypes::values())],
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string'],
        ]);

        $foodRequest = FoodRequest::create([
            'beneficiary_id' => Auth::id(),
            'food_type' => $validated['food_type'],
            'quantity' => $validated['quantity'],
            'note' => $validated['note'] ?? null,
            'status' => 'pending',
        ]);

        // Try to find a matching donation
        $match = $this->matchingService->matchRequest($foodRequest);

        $message = $match 
            ? 'Request created and matched with an available donation'
            : 'Request created successfully';

        return redirect()->route('requests.index')->with('status', $message);
    }

    public function edit(FoodRequest $requestModel)
    {
        $this->authorizeOwnership($requestModel);
        return view('beneficiary.edit', ['request' => $requestModel]);
    }

    public function update(Request $request, FoodRequest $requestModel)
    {
        $this->authorizeOwnership($requestModel);

        $validated = $request->validate([
            'food_type' => ['required', 'string', 'in:' . implode(',', \App\Helpers\FoodTypes::values())],
            'quantity' => ['required', 'integer', 'min:1'],
            'note' => ['nullable', 'string'],
            'status' => ['nullable', 'in:pending,matched,fulfilled'],
        ]);

        $requestModel->update($validated);

        return redirect()->route('requests.index')->with('status', 'Request updated');
    }

    public function destroy(FoodRequest $requestModel)
    {
        $this->authorizeOwnership($requestModel);
        $requestModel->delete();
        return redirect()->route('requests.index')->with('status', 'Request deleted');
    }

    public function showMatches(FoodRequest $requestModel)
    {
        $this->authorizeOwnership($requestModel);
        
        $matches = $this->matchingService->findMatchingDonations($requestModel, 20);
        
        return view('beneficiary.matches', ['request' => $requestModel, 'matches' => $matches]);
    }

    private function authorizeOwnership(FoodRequest $request): void
    {
        abort_unless($request->beneficiary_id === Auth::id(), 403);
    }

    public function matchWithDonation(FoodRequest $requestModel, Donation $donation)
    {
        $this->authorizeOwnership($requestModel);
        abort_unless($requestModel->status === 'pending', 422);

        $this->matchingService->manualMatch($donation, $requestModel);

        return redirect()->route('requests.matches', $requestModel)
            ->with('status', 'Request matched with the selected donation');
    }
}


