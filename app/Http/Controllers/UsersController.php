<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\Users\UsersProfileRequest;

class UsersController extends Controller
{
    public function index()
    {
    	return view('users.index')->with('users', User::all());
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
    	return view('users.edit')->with('user', auth()->user());	//ログインユーザー
    }

    public function update(UsersProfileRequest $request)
    {
    	$user = auth()->user();
    	$user->update([
            'name' => $request->name,
            'about' => $request->about
    	]);
    	session()->flash('success', '更新しました');

    	return redirect()->back();
    }
}
