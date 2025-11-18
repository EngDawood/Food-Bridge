<?php

namespace App\Http\Controllers;

use App\Models\DeliveryTask;
use App\Models\Donation;
use App\Models\Feedback;
use App\Models\FoodRequest;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalDonations = Donation::count();
        $deliveredDonations = Donation::where('status', 'delivered')->count();
        $totalRequests = FoodRequest::count();
        $fulfilledRequests = FoodRequest::where('status', 'fulfilled')->count();
        $completedDeliveries = DeliveryTask::where('status', 'completed')->count();

        $foodSavedQty = Donation::where('status', 'delivered')->sum('quantity');
        $beneficiariesHelped = FoodRequest::where('status', 'fulfilled')->distinct('beneficiary_id')->count('beneficiary_id');

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalDonations',
            'deliveredDonations',
            'totalRequests',
            'fulfilledRequests',
            'completedDeliveries',
            'foodSavedQty',
            'beneficiariesHelped'
        ));
    }

    public function users(Request $request)
    {
        $q = $request->get('q');
        $users = User::query()
            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('role', 'like', "%{$q}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users', compact('users', 'q'));
    }

    public function usersCreate()
    {
        return view('admin.users.create');
    }

    public function usersStore(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:admin,donor,beneficiary,volunteer'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'location' => $validated['location'] ?? null,
        ]);

        return redirect()->route('admin.users')->with('status', 'User created successfully');
    }

    public function usersEdit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function usersUpdate(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', 'in:admin,donor,beneficiary,volunteer'],
            'location' => ['nullable', 'string', 'max:255'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->location = $validated['location'] ?? null;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users')->with('status', 'User updated successfully');
    }

    public function usersDestroy(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->withErrors(['error' => 'You cannot delete your own account']);
        }

        $user->delete();

        return redirect()->route('admin.users')->with('status', 'User deleted successfully');
    }

    public function transactions()
    {
        $donations = Donation::orderBy('id', 'desc')->limit(10)->get();
        $requests = FoodRequest::orderBy('id', 'desc')->limit(10)->get();
        $deliveries = DeliveryTask::orderBy('id', 'desc')->limit(10)->get();

        return view('admin.transactions', compact('donations', 'requests', 'deliveries'));
    }

    public function reportsIndex()
    {
        $reports = Report::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.reports.index', compact('reports'));
    }

    public function reportsCreate()
    {
        $admins = User::where('role', 'admin')->get(['id', 'name']);
        return view('admin.reports.create', compact('admins'));
    }

    public function reportsStore(Request $request)
    {
        $data = $request->validate([
            'admin_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $data['created_at'] = now();
        Report::create($data);

        return redirect()->route('admin.reports.index')->with('status', 'Report created successfully');
    }

    public function feedbackIndex(Request $request)
    {
        $feedback = Feedback::with(['fromUser:id,name', 'toUser:id,name'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        $users = User::orderBy('name')->get(['id', 'name']);

        return view('admin.feedback', compact('feedback', 'users'));
    }

    public function feedbackStore(Request $request)
    {
        $data = $request->validate([
            'from_user_id' => ['required', 'exists:users,id'],
            'to_user_id' => ['required', 'exists:users,id', 'different:from_user_id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string'],
        ]);

        Feedback::create($data);

        return redirect()->route('admin.feedback')->with('status', 'Feedback added successfully');
    }

    public function promoteUser(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $user = User::where('email', $data['email'])->firstOrFail();
        $user->role = 'admin';
        $user->save();

        return back()->with('status', 'User promoted to admin successfully');
    }
}


