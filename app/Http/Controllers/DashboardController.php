<?php

namespace App\Http\Controllers;

use App\Events\CartEvents;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Foundation\Auth\User;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = User::latest()->paginate(10);
        $categories = Category::all();

        return view('employee.pages.home', [
            'title' => 'Home',
            'employees' => $employees,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->has('btn-new')) {
            session()->flash('ShowNewEntries', true);
        }

        $messages = [
            'new-username.required' => 'Username is required.',
            'new-username.unique' => 'Username has already been taken.',
            'new-username.min' => 'Username must be at least :min characters long.',
            'new-username.max' => 'Username must not exceed :max characters in length.',
            'new-email.required' => 'Email address is required.',
            'new-email.email' => 'Please enter a valid email address.',
            'new-email.unique' => 'Email address has already been registered.',
            'new-password.required' => 'Password is required.',
            'new-password.confirmed' => 'Password confirmation does not match.',
            'new-password.min' => 'Password must be at least :min characters long.',
            'new-password.regex' => 'Password must contain at least one uppercase letter, one symbol, and one number.',
            'new-access.required' => 'Permissions is required.',
        ];

        $validation = $request->validate([
            'new-username' => 'required|unique:users,username|min:3|max:20',
            'new-email' => 'required|email|unique:users,email',
            'new-password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*\d).+$/'
            ],
            'new-access' => 'required'
        ], $messages);

        $user = new User();
        $user->username = $validation['new-username'];
        $user->email = $validation['new-email'];
        $user->password = bcrypt($validation['new-password']);
        $user->access = $validation['new-access'];

        $user->save();
        if ($user->save()) {
            session()->forget('ShowNewEntries');
        }

        return back()->with('success', 'The record has been successfully saved.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->has('btn-update')) {
            session()->flash('ShowModalEdit', true);
            session()->put('editData', ['id' => $id]);
        }

        $user = User::find($id);
        if (!$user) {
            return redirect(route('emp.home'))->with('error', 'User not found.');
        }

        $Messages = [
            'edit-username.required' => 'Username is required.',
            'edit-username.unique' => 'Username has already been taken.',
            'edit-username.min' => 'Username must be at least :min characters long.',
            'edit-email.required' => 'Email address is required.',
            'edit-email.email' => 'Please enter a valid email address.',
            'edit-email.unique' => 'Email address has already been registered.',
            'edit-password.confirmed' => 'Password confirmation does not match.',
            'edit-password.min' => 'Password must be at least :min characters long.',
            'edit-password.regex' => 'Password must contain at least one uppercase letter, one symbol, and one number.',
            'edit-access.required' => 'Permissions is required.',
        ];

        $validated = $request->validate([
            'edit-username' => 'required|unique:users,username,' . $user->id . '|min:3',
            'edit-email' => 'required|email|unique:users,email,' . $user->id,
            'edit-password' => [
                'nullable',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[!@#$%^&*])(?=.*\d).+$/'
            ],
            'edit-access' => 'required'
        ], $Messages);

        $user->username = $validated['edit-username'];
        $user->email = $validated['edit-email'];

        if ($request->filled('edit-password')) {
            $user->password = bcrypt($validated['edit-password']);
        }

        $user->access = $validated['edit-access'];
        $user->save();

        if ($user->save()) {
            session()->forget('ShowModalEdit');
        }

        return redirect(route('emp.home'))->with('success', 'The record has been successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return back()->with('error', 'User not found');
        }

        $user->delete();

        return back()->with('success', 'User deleted successfully');
    }
}
