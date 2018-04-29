<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Deopt;
use App\Models\Good;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShopRequest;
use MeiTuanOpenApi\Api\CategoryService;
use MeiTuanOpenApi\Api\GoodsService;
use MeiTuanOpenApi\Api\ShopService;
use MeiTuanOpenApi\Config\Config;

class ShopsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
	{
        $keyword = $request->keyword;
        $shops = Shop::allowShops()->select('id','name', 'address','ele_id','baidu_id','meituan_id');
        if ($keyword)
        {
            $shops = $shops->where('name','like',"%{$keyword}%");
        }
        $shops = $shops->paginate(10);
        return view('shops.index', compact('shops','keyword'));
	}

    public function show(Shop $shop)
    {

        $shop_server = New ShopService(New Config(env('MT_APPID'),env('MT_SECRET')));
//        $shop_server = New ShopService($shop_client);
        $shop_server->create_shop($shop);

        return view('shops.show', compact('shop'));
    }

	public function create(Shop $shop)
	{
		return view('shops.create_and_edit', compact('shop'));
	}

	public function store(ShopRequest $request)
	{
		$shop = Shop::create($request->all());

		if (!empty($request->sync) && in_array(1, $request->sync))
        {
            $shop_server = New ShopService(New Config(env('MT_APPID'),env('MT_SECRET')));
            $res = $shop_server->create_shop($shop);
            $res = json_decode($res, true);
            if ($res && $res['data'] == 'ok')
            {
                $shop->meituan_id = $shop->id;
                $shop->save();
                $shop_server->upArea($shop);
                $category_server = New CategoryService(New Config(env('MT_APPID'),env('MT_SECRET')));
                $category = new Category;
                $category->name = '我的分类';
                $category->shop_id = $shop->id;
                $category->sort = 100;
                $category->save();
                $category_server->create($category);
                $good_server = New GoodsService(New Config(env('MT_APPID'),env('MT_SECRET')));
                $good = new Good;
                $good->shop_id = $shop->id;
                $good->deopt_id = 1;
                $good->price = 999;
                $good->stock = 999;
                $good->online = 1;
                $good->sort = 999;
                $good->category_id= $category->id;
                $good->save();
                $good_server->create($good);
                $category->delete();
                $good->delete();
            }else{
//                $shop->delete();
                return back()->withErrors(isset($res['error']['msg'])?'美团返回错误：'.$res['error']['msg']:'超时了，请核对是否创建成功');
            }
        }
        return redirect()->route('shops.index')->with('alert', '创建成功');
	}

	public function edit(Shop $shop)
	{
        $this->authorize('update', $shop);
		return view('shops.create_and_edit', compact('shop'));
	}

	public function update(ShopRequest $request, Shop $shop)
	{
		$this->authorize('update', $shop);

        if (!empty($request->sync) && in_array(1, $request->sync))
        {
            $shop->update($request->all());
            $shop_server = New ShopService(New Config(env('MT_APPID'),env('MT_SECRET')));
            $res = $shop_server->update_shop($shop);
            $res = json_decode($res, true);
            if (!$res || $res['data'] != 'ok')
            {
                return back()->withErrors(isset($res['error']['msg'])?'美团返回错误：'.$res['error']['msg']:'更新失败');
            }
        }
		return back()->with('alert', '更新成功');
	}

	public function destroy(Shop $shop)
	{
		$this->authorize('destroy', $shop);
		$shop->delete();

		return redirect()->route('shops.index')->with('alert', '成功删除门店');
	}
}