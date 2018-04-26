<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShopRequest;
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
            $shop_server->create_shop($shop);
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
            $shop_server = New ShopService(New Config(env('MT_APPID'),env('MT_SECRET')));
            $shop_server->update_shop($shop);
        }

        $shop->update($request->all());

		return redirect()->route('shops.index', $shop->id)->with('alert', '更新成功');
	}

	public function destroy(Shop $shop)
	{
		$this->authorize('destroy', $shop);
		$shop->delete();

		return redirect()->route('shops.index')->with('alert', '成功删除门店');
	}
}