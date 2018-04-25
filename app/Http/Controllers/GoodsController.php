<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Deopt;
use App\Models\Good;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Requests\GoodRequest;
use MeiTuanOpenApi\Api\CategoryService;
use MeiTuanOpenApi\Api\GoodsService;
use MeiTuanOpenApi\Config\Config;

class GoodsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request)
	{
        $keyword = $request->keyword;
        $good = Good::select('id','ele_id','baidu_id','meituan_id','shop_id','deopt_id', 'category_id', 'sort', 'stock');
        if ($keyword)
        {
            $good = $good->where('name','like',"%{$keyword}%");
        }
        $goods = $good->orderBy('id', 'DESC')->paginate(10);
        return view('goods.index', compact('goods','keyword'));
	}

    public function show(Good $good)
    {
        return view('goods.show', compact('good'));
    }

	public function create(Good $good)
	{
		return view('goods.create_and_edit', compact('good'));
	}

	public function store(GoodRequest $request)
	{
        $data = $request->all();
        $shops = $data['shop_id'];
        foreach ($shops as $shop_id) {
            $deopt_id = $data['deopt_id'];
            if (Good::where(['shop_id' => $shop_id, 'deopt_id' => $deopt_id])->first())
            {
                continue;
            }
            if (!empty($request->sync) && in_array(1, $request->sync))
            {
                $data['shop_id'] = $shop_id;
                $category = Category::where(['name' => $data['category'], 'shop_id' => $shop_id])->first();
                if (!$category)
                {
                    $category = Category::create(['name' => $data['category'], 'shop_id' => $shop_id, 'sort' => 100]);
                    $server = New CategoryService(New Config(env('MT_APPID'),env('MT_SECRET')));
                    $category_create_status = $server->create($category);
                    if (!$category_create_status)
                    {
                        $category->delete();
                        continue;
                    }
                }
                if ($category->meituan_id)
                {
                    $data['category_id'] = $category->id;
                    $good = Good::create($data);
                    $server = New GoodsService(New Config(env('MT_APPID'),env('MT_SECRET')));
                    $good_create_status = $server->create($good);
                    if (!$good_create_status)
                    {
                        continue;
                    }
                }
            }
        }

		return redirect()->route('goods.index')->with('alert', '提交成功');
	}

	public function edit(Good $good)
	{
        $this->authorize('update', $good);
		return view('goods.create_and_edit', compact('good'));
	}

	public function update(GoodRequest $request, Good $good)
	{
		$this->authorize('update', $good);
		$good->update($request->all());

		return redirect()->route('goods.show', $good->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Good $good)
	{
		$this->authorize('destroy', $good);
		$good->delete();

		return redirect()->route('goods.index')->with('message', 'Deleted successfully.');
	}

	public function deopt(Deopt $deopt, Good $good)
    {
        $shops = Shop::select('id', 'name')->get();
        return view('goods.create_and_edit', compact('deopt', 'good', 'shops'));
    }
}