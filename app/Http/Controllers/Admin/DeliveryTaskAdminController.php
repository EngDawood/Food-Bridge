<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveryTask;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Http\Request;

class DeliveryTaskAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $deliveries = DeliveryTask::with(['donation', 'volunteer:id,name,email'])
            ->when($q, function ($query) use ($q) {
                $query->where('pickup_location', 'like', "%{$q}%")
                    ->orWhere('dropoff_location', 'like', "%{$q}%")
                    ->orWhere('status', 'like', "%{$q}%");
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.deliveries.index', compact('deliveries', 'q'));
    }

    public function create()
    {
        $volunteers = User::where('role', 'volunteer')->orderBy('name')->get(['id', 'name']);
        $donations = Donation::orderByDesc('id')->get(['id', 'food_type']);
        return view('admin.deliveries.create', compact('volunteers', 'donations'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'volunteer_id' => ['required', 'exists:users,id'],
            'donation_id' => ['required', 'exists:donations,id'],
            'pickup_location' => ['required', 'string', 'max:255'],
            'dropoff_location' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:assigned,in_progress,completed'],
        ]);

        DeliveryTask::create($data);

        return redirect()->route('admin.deliveries.index')->with('status', 'Delivery task created');
    }

    public function edit(DeliveryTask $task)
    {
        $volunteers = User::where('role', 'volunteer')->orderBy('name')->get(['id', 'name']);
        $donations = Donation::orderByDesc('id')->get(['id', 'food_type']);
        return view('admin.deliveries.edit', compact('task', 'volunteers', 'donations'));
    }

    public function update(Request $request, DeliveryTask $task)
    {
        $data = $request->validate([
            'volunteer_id' => ['required', 'exists:users,id'],
            'donation_id' => ['required', 'exists:donations,id'],
            'pickup_location' => ['required', 'string', 'max:255'],
            'dropoff_location' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:assigned,in_progress,completed'],
        ]);

        $task->update($data);

        return redirect()->route('admin.deliveries.index')->with('status', 'Delivery task updated');
    }

    public function destroy(DeliveryTask $task)
    {
        $task->delete();
        return redirect()->route('admin.deliveries.index')->with('status', 'Delivery task deleted');
    }
}


