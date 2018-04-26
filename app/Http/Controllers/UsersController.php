<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->authorize('before', User::class);
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
        $this->authorize('before', User::class);
        $shops = Shop::select('id', 'name')->get();
        return view('users.create_and_edit', compact('user','shops'));
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorize('before', User::class);
        if ( $user->update($request->all()) )
        {
            $shops = isset($request->shop_ids)?$request->shop_ids:[];
            $old_shops = $user->shops;
            if (!empty($old_shops))
            {
                foreach ($old_shops as $shop)
                {
                    $user->shops()->detach($shop->id);
                }
            }
            $user->shops()->attach($shops);
        }

        return redirect()->route('users.edit', $user->id)->with('success', '更新成功！');
    }

    public function create(User $user)
    {
        $this->authorize('before', User::class);
        return view('users.create_and_edit', compact('user'));
    }

    public function store(UserRequest $request, User $user)
    {
        $this->authorize('before', User::class);
        $user->fill($request->all());
        $user->password = $request->password;
        $user->save();
        return redirect()->route('users.index')->with('message', '创建成功');
    }

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);

        $user->delete();

        return redirect()->route('users.index')->with('alert', '成功删除用户！');
    }

    public function reset(User $user)
    {
        $this->authorize('before', User::class);

        $user->password = substr($user->phone, -6);

        $user->save();

        return redirect()->route('users.index')->with('alert', '成功修改用户密码！');
    }
}
