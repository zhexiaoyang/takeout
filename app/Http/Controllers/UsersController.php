<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Auth;

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
        $users = $users->orderBy('id','desc')->paginate(10);
        return view('users.index', compact('users', 'keyword'));
    }

    public function edit(User $user)
    {
        $this->authorize('before', User::class);
        $shops = Shop::select('id', 'name')->get();
        $roles = Role::all();
        return view('users.create_and_edit', compact('user', 'shops', 'roles'));
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorize('before', User::class);
        if ( $user->update($request->all()) )
        {
            $shops = isset($request->shop_ids)?$request->shop_ids:[];
            $user->shops()->detach();
            $user->shops()->attach($shops);
            $roles = isset($request->role)?[$request->role]:[];
            $user->syncRoles([$roles]);
        }

        return redirect()->route('users.edit', $user->id)->with('success', '更新成功！');
    }

    public function create(User $user)
    {
        $this->authorize('before', User::class);
        $shops = Shop::select('id', 'name')->get();
        $roles = Role::all();
        return view('users.create_and_edit', compact('user', 'shops', 'roles'));
    }

    public function store(UserRequest $request, User $user)
    {
        $this->authorize('before', User::class);
        $user->fill($request->all());
        $user->password = $request->password;
        $user->save();
        $shops = isset($request->shop_ids)?$request->shop_ids:[];
        $user->shops()->detach();
        $user->shops()->attach($shops);
        $roles = isset($request->role)?[$request->role]:[];
        $user->syncRoles([$roles]);
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

        $user->password = '654321';

        $user->save();

        return redirect()->route('users.index')->with('alert', '重置成功');
    }

    public function getReset(User $user)
    {
        return view('users.get_reset', compact('user'));
    }

    public function postReset(Request $request)
    {
        $oldpassword = $request->input('oldpassword');
        $password = $request->input('password');
        $data = $request->all();
        $rules = [
            'oldpassword'=>'required|between:6,20',
            'password'=>'required|between:6,20|confirmed',
        ];
        $messages = [
            'required' => '密码不能为空',
            'between' => '密码必须是6~20位之间',
            'confirmed' => '新密码和确认密码不匹配'
        ];
        $validator = Validator::make($data, $rules, $messages);
        $user = Auth::user();
        $validator->after(function($validator) use ($oldpassword, $user) {
            if (!\Hash::check($oldpassword, $user->password)) {
                $validator->errors()->add('oldpassword', '原密码错误');
            }
        });
        if ($validator->fails()) {
            return back()->withErrors($validator);  //返回一次性错误
        }
        $user->password = bcrypt($password);
        $user->save();
        Auth::logout();  //更改完这次密码后，退出这个用户
        return redirect('/login');
    }
}
