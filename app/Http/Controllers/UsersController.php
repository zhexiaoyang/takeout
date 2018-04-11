<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
//        dd($request->keyword);
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
//        $this->authorize('update', $user);
        return view('users.create_and_edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
//        $this->authorize('update', $user);
        $user->update($request->all());

        return redirect()->route('users.edit', $user->id)->with('success', '更新成功！');
    }

    public function create(User $user)
    {
        return view('users.create_and_edit', compact('user'));
    }

    public function store(UserRequest $request, User $user)
    {
        $user->fill($request->all());
        $user->password = $request->password;
        $user->save();
        return redirect()->route('users.index')->with('message', '创建成功');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', '成功删除用户！');
    }
}
