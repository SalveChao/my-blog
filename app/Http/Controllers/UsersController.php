<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
    	return view('users.index')
    	    ->with('users', User::all());
    }

    public function makeAdmin(User $user)
    {
    	$user->role = 'admin';
    	$user->save();
    	session()->flash('success', '権限を付与しました。');
    	return redirect(route('users.index'));
    }

    public function edit()
    {
    	return view('users.edit')
    	    ->with('user', auth()->user());	//ログインユーザー
    }

    public function update(Request $request)
    {
    	$user = auth()->user();
    	$user->update([
            'about' => $request->about
    	]);
    	session()->flash('success', '更新しました');

    	return redirect()->back();
    }
}
