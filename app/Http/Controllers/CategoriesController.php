<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use MeiTuanOpenApi\Api\CategoryService;
use MeiTuanOpenApi\Config\Config;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function index(Request $request)
	{
        $keyword = $request->keyword;
        $category = Category::allowShops()->select('id','name', 'sort','ele_id','baidu_id','meituan_id','shop_id');
        if ($keyword)
        {
            $category = $category->where('name','like',"%{$keyword}%");
        }
        $categories = $category->paginate(3);
		return view('categories.index', compact('categories','keyword'));
	}

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

	public function create(Category $category)
	{
	    $shops = Shop::allowShops()->select('id','name')->get();
//	    dd($shops);
		return view('categories.create_and_edit', compact('category','shops'));
	}

	public function store(CategoryRequest $request)
	{
        $shops = $request->shop_id;
        $data = $request->all();
        foreach ($shops as $shop) {
            $data['shop_id'] = $shop;
            $category = Category::create($data);
            if (!empty($request->sync) && in_array(1, $request->sync))
            {
                $server = New CategoryService(New Config(env('MT_APPID'),env('MT_SECRET')));
                $server->create($category);
            }
        }

		return redirect()->route('categories.index', $category->id)->with('alert', '创建分类成功');
	}

	public function edit(Category $category)
	{
        $this->authorize('update', $category);
        $shops = Shop::allowShops()->select('id','name')->get();
		return view('categories.create_and_edit', compact('category', 'shops'));
	}

	public function update(CategoryRequest $request, Category $category)
	{
		$this->authorize('update', $category);
        $category->update($request->all());

        if (!empty($request->sync) && in_array(1, $request->sync))
        {
            $server = New CategoryService(New Config(env('MT_APPID'),env('MT_SECRET')));
            $server->update($category);
        }

		return redirect()->route('categories.index', $category->id)->with('alert', '更新分类成功');
	}

	public function destroy(Category $category)
	{
		$this->authorize('destroy', $category);

        $server = New CategoryService(New Config(env('MT_APPID'),env('MT_SECRET')));
        $res = $server->destroy($category);
        $res = json_decode($res, true);
        if (!$res || $res['data'] != 'ok')
        {
            $category->meituan_id = 0;
        }

        if (!$category->metuan_id && !$category->ele_id && !$category->baidu_id)
        {
            $category->delete();
        }

        return redirect()->back()->with('alert', '删除成功！');
	}
}