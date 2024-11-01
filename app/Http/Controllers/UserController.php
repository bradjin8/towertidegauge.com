<?php

namespace App\Http\Controllers;

use App\Models\TideGauge;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
//            'is_admin' => 'required|boolean',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'company_name' => $request->company_name,
            'is_admin' => false,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        //
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'User not found');
        }
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:15',
            'company_name' => 'nullable|string|max:255',
            'is_admin' => 'required|boolean',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone_number = $validated['phone_number'];
        $user->company_name = $validated['company_name'];
        $user->is_admin = $validated['is_admin'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();


        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    /**
     * Display the form to assign tide gauges to a user.
     */
    public function assignTideGaugesPage()
    {
        $users = User::where('is_admin', false)->get();
        $tideGauges = TideGauge::all();
        return view('admin.assign-tidegauges', compact('users', 'tideGauges'));
    }

    /**
     * Store the tide gauge assignment.
     */
    public function storeTideGaugesAssignment(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tide_gauges' => 'array',
            'tide_gauges.*' => 'exists:tidegauges,id',
        ]);

        $user = User::find($request->user_id);
        $user->tideGauges()->sync($request->tide_gauges);

        return redirect()->route('assign.tidegauges')->with('success', 'Tide Gauges assigned successfully.');
    }
}
