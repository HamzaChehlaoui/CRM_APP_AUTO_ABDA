<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{


public function index()
{
    $users = User::with('branch')->
    whereNotIn('role_id', [1, 2])->paginate(6);
    return view('page.siteUsers', compact('users'));
}
public function destroy(User $user)
{
    $user->delete();

    return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès');
}
}
