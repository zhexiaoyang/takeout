<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $users = User::select('id','name','phone','created_at');
        if ($keyword)
        {
            $users = $users->where('name','like',"%{$keyword}%")->orWhere('phone', 'like', "%{$keyword}%");
        }
        $users = $users->paginate(10);
        return view('users.index', compact('users', 'keyword'));
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

        return redirect()->route('users.index')->with('alert', '成功删除用户！');
    }

    public function reset(User $user)
    {
        $user->password = substr($user->phone, -6);

        $user->save();

        return redirect()->route('users.index')->with('alert', '成功修改用户密码！');
    }
}
