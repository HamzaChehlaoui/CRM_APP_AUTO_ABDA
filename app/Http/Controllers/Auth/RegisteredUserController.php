<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('page.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
       $request->validate([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    'password' => ['required', 'confirmed', Rules\Password::defaults()],
    'branch_id' => ['required', 'exists:branches,id'],
]);
$branchRoleMap = [
    1 => 3, // branch_id 1 (Safi) => role_id 3 (Branch Manager - Safi)
    2 => 4, // branch_id 2 (Essaouira) => role_id 4 (Branch Manager - Essaouira)
    3 => 5, // branch_id 3 (Sidi Bennour) => role_id 5 (Branch Manager - Sidi Bennour)
];

$roleId = $branchRoleMap[$request->branch_id] ?? 3;

$user = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'role_id' => $roleId,
    'branch_id' => $request->branch_id,
]);

        event(new Registered($user));



         return redirect('/register')->with('success', 'Account created successfully!');
    }
}
