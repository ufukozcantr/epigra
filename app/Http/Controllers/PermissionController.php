<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(Request $request){

        $users = User::all();
        return view('role', compact('users'));
    }
}
