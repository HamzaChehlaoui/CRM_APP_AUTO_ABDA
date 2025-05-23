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
    return view('AssistantDirector.siteUsers', compact('users'));
}
}
