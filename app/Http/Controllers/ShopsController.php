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
        $shops = $shops->orderBy('id','DESC')->paginate(10);
        $shop_ids = [];
        $shops_status = [];
        foreach ($shops as $shop) {
            $shop_ids[] = $shop->meituan_id;
        }
        if (!empty($shop_ids))
        {
            $shop_server = New ShopService(New Config(env('MT_APPID'),env('MT_SECRET')));
            $res = $shop_server->shop_info(implode(',', $shop_ids));
            $data = json_decode($res, true);
            $shops_by_mt = $data['data'];
//            dd($shops_by_mt);
            if (!empty($shops_by_mt))
            {
                foreach ($shops_by_mt as $v) {
                    $shops_status[$v['app_poi_code']]['line'] = (int)$v['is_online'] === 1 ? 1 : 0;
                    $shops_status[$v['app_poi_code']]['open'] = (int)$v['open_level'] === 1 ? 1 : 0;
                }
            }
        }
//        dd($shops_status);
//        dd($shops_status['5685381']['line']);
        return view('shops.index', compact('shops','keyword', 'shops_status'));
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

    public function syncMeituan(Request $request)
    {
        $result = [];
        $shop_ids = [];

        $shop_server = New ShopService(New Config(env('MT_APPID'),env('MT_SECRET')));

        $res = $shop_server->shop_list();

        if ($res)
        {
            $res = json_decode($res, true);
            $shop_ids = $res['data'];
        }

        if (!empty($shop_ids))
        {
            $shop_list = [];

            foreach ($shop_ids as $shop_id) {
                if ($shop_id && ( (int)$shop_id > 9999 ) && !Shop::where(['meituan_id' => $shop_id])->exists())
                {
                    $shop_list[] = $shop_id;
                }
            }

            if (!empty($shop_list))
            {
                $res = $shop_server->shop_info(implode(',', $shop_list));
                $data = json_decode($res, true);
                $shops = $data['data'];
                if (!empty($shops))
                {
                    foreach ($shops as $shop) {
                        $info = [
                            'meituan_id' => $shop['app_poi_code'],
                            'name' => $shop['name'],
                            'address' => $shop['address'],
                            'latitude' => $shop['latitude']/1000000,
                            'longitude' => $shop['longitude']/1000000,
                            'pic_url' => $shop['pic_url'],
                            'pic_url_large' => $shop['pic_url_large'],
                            'phone' => $shop['phone'],
                            'standby_tel' => $shop['standby_tel'],
                            'shipping_fee' => $shop['shipping_fee'],
                            'shipping_time' => $shop['shipping_time'],
                            'promotion_info' => $shop['promotion_info']==null?'':$shop['promotion_info'],
                            'open_level' => $shop['open_level'],
                            'is_online' => $shop['is_online'],
                            'invoice_support' => $shop['invoice_support'],
                            'invoice_min_price' => $shop['invoice_min_price'],
                            'invoice_description' => $shop['invoice_description'],
                            'third_tag_name' => $shop['third_tag_name'],
                            'pre_book' => $shop['pre_book'],
                            'time_select' => $shop['time_select'],
                            'app_brand_code' => $shop['app_brand_code']==null?'':$shop['app_brand_code'],
                            'mt_type_id' => $shop['mt_type_id']==null?0:$shop['app_brand_code'],
                        ];
//                dd($info);
                        if ($info['meituan_id'] && Shop::create($info))
                        {
                            $result[] = $shop['app_poi_code'].':创建成功';
                        }else{
                            $result[] = $shop['app_poi_code'].':创建失败';
                        }
                    }
                }
            }
        }
        return back()->with('sync_shop', '更新成功 '.count($result).' 家门店');
	}

    public function sync()
    {
        $result = [];
        $shop_list = ["5216283","5216284","5216285","5216287","5216288","5216289","5216290","5216291","5216292","5216294","5216272","5216273","5216274","5216275","5216276","5216277","5216278","5216279","5216280","5216282","5216257","5216260","5216261","5216262","5216265","5216266","5216267","5216269","5216270","5216271"];
        if (empty($shop_list))
        {
            abort(404);
        }
        $shop_server = New ShopService(New Config(env('MT_APPID'),env('MT_SECRET')));
        $res = $shop_server->shop_info(implode(',', $shop_list));
        $data = json_decode($res, true);
        $shops = $data['data'];
        if (!empty($shops))
        {
            foreach ($shops as $shop) {
                $info = [
//                    'id' => $shop['app_poi_code'],
                    'meituan_id' => $shop['app_poi_code'],
                    'name' => $shop['name'],
                    'address' => $shop['address'],
                    'latitude' => $shop['latitude']/100000,
                    'longitude' => $shop['longitude']/100000,
                    'pic_url' => $shop['pic_url'],
                    'pic_url_large' => $shop['pic_url_large'],
                    'phone' => $shop['phone'],
                    'standby_tel' => $shop['standby_tel'],
                    'shipping_fee' => $shop['shipping_fee'],
                    'shipping_time' => $shop['shipping_time'],
                    'promotion_info' => $shop['promotion_info']==null?'':$shop['promotion_info'],
                    'open_level' => $shop['open_level'],
                    'is_online' => $shop['is_online'],
                    'invoice_support' => $shop['invoice_support'],
                    'invoice_min_price' => $shop['invoice_min_price'],
                    'invoice_description' => $shop['invoice_description'],
                    'third_tag_name' => $shop['third_tag_name'],
                    'pre_book' => $shop['pre_book'],
                    'time_select' => $shop['time_select'],
                    'app_brand_code' => $shop['app_brand_code']==null?'':$shop['app_brand_code'],
                    'mt_type_id' => $shop['mt_type_id']==null?0:$shop['app_brand_code'],
                ];
//                dd($info);
                if ($info['meituan_id'] && Shop::create($info))
                {
                    $result[] = $shop['app_poi_code'].':创建成功';
                }else{
                    $result[] = $shop['app_poi_code'].':创建失败';
                }
            }
        }
        dd($result);
	}

    public function goods(Shop $shop)
    {
        $goods_server = New GoodsService(New Config(env('MT_APPID'),env('MT_SECRET')));
        $res = $goods_server->lists($shop);
        $data = json_decode($res, true);
        if (!empty($data['data']))
        {
            foreach ($data['data'] as $goods) {
                $goods_server->destroy2($shop->meituan_id, $goods['app_medicine_code']);
            }
        }

        $category_server = New CategoryService(New Config(env('MT_APPID'),env('MT_SECRET')));
        $res = $category_server->lists($shop);
        $data = json_decode($res, true);
        if (!empty($data['data']))
        {
            foreach ($data['data'] as $goods) {
                $category_server->destroy2($shop->meituan_id, $goods['category_code']);
            }
        }
	}

	public function goodsOnline(Shop $shop)
    {
        $goods = Good::where(['shop_id' => $shop->id])->get();
        if (!empty($goods))
        {
            foreach ($goods as $good) {
                $goods_service = New GoodsService(New Config(env('MT_APPID'),env('MT_SECRET')));
                $goods_service->online($good);
            }
        }
        dd("同步成功");
    }

    public function open(Shop $shop)
    {

        $shop_server = New ShopService(New Config(env('MT_APPID'),env('MT_SECRET')));
        $result = $shop_server->open($shop);
        $result = json_decode($result, true);
        if ($result['data'] == 'ok')
        {
            return redirect()->back()->with('alert', '操作成功！');
        }else{
            $error = isset($result['error']['msg'])?$result['error']['msg']:'请求接口错误';
            return back()->withErrors($error);
        }
    }

    public function close(Shop $shop)
    {

        $shop_server = New ShopService(New Config(env('MT_APPID'),env('MT_SECRET')));
        $result = $shop_server->close($shop);
        $result = json_decode($result, true);
        if ($result['data'] == 'ok')
        {
            return redirect()->back()->with('alert', '操作成功！');
        }else{
            $error = isset($result['error']['msg'])?$result['error']['msg']:'请求接口错误';
            return back()->withErrors($error);
        }
    }
}