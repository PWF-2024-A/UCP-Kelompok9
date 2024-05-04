<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $search = request('search');
        if ($search){
            $users = User::where(function ($query) use ($search){
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            })
            ->orderBy('name')
            ->where('id', '!=', '1')
            ->paginate(20)
            ->withQueryString();
        }else{
            $users = User::where('id', '!=', '1')
            ->orderBy('name')
            ->paginate(20);
        }

        return view('user.index', compact('users'));
    }

    public function makeadmin(User $user)
    {
        $user->timestamps = false;
        $user->is_admin = true;
        $user->save();

        return back()->with('success', 'User has been made admin');
    }

    public function revokeadmin(User $user)
    {
        if ($user->id != 1){
            $user->timestamps = false;
            $user->is_admin = false;
            $user->save();

            return back()->with('success', 'Admin has been revoked');
        }else{
            return redirect()->route('user.index')->with('error', 'You cannot revoke the admin status of the super admin');
        }
    }

    public function destroy(User $user)
    {
        if ($user->id != 1){
            $user->delete();
            return back()->with('success', 'User has been deleted');
        }else{
            return redirect()->route('user.index')->with('error', 'You cannot delete the super admin');
        }
    }
}
