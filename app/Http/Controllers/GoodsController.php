<?php

namespace App\Http\Controllers;

use App\Jobs\CreateGoods;
use App\Models\Category;
use App\Models\Deopt;
use App\Models\Good;
use App\Models\Shop;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Requests\GoodRequest;
use MeiTuanOpenApi\Api\CategoryService;
use MeiTuanOpenApi\Api\GoodsService;
use MeiTuanOpenApi\Config\Config;
use Excel;

class GoodsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function index(Request $request)
	{
        $keyword = $request->keyword;
        $shop_id = $request->shop_id;
        $good = Good::allowShops()->select('id','ele_id','baidu_id','meituan_id','shop_id','deopt_id', 'category_id', 'sort', 'stock');
        if ($keyword)
        {
//            $good = $good->where('name','like',"%{$keyword}%");
            $good = $good->whereHas('deopt', function($query) use ($keyword){
                $query->where('name', 'like', "%$keyword%")->orWhere('id', 'like', "%$keyword%");
            });
        }
        if ($shop_id)
        {
            $good = $good->where('shop_id',$shop_id);
        }
        $goods = $good->orderBy('id', 'DESC')->paginate(10);
        $shops = Shop::allowShops()->select('id', 'name', 'meituan_id')->get();
        return view('goods.index', compact('goods','keyword', 'shops','shop_id'));
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
                        $good->delete();
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
        if (!empty($request->sync) && in_array(1, $request->sync))
        {
            $good->update($request->all());
            $shop_server = New GoodsService(New Config(env('MT_APPID'),env('MT_SECRET')));
            $res = $shop_server->update($good);
            $res = json_decode($res, true);
            if (!$res || $res['data'] != 'ok')
            {
                return back()->withErrors(isset($res['error']['msg'])?'美团返回错误：'.$res['error']['msg']:'更新失败');
            }
        }
        return back()->with('alert', '更新成功');
	}

	public function destroy(Good $good)
	{
		$this->authorize('destroy', $good);

        $shop_server = New GoodsService(New Config(env('MT_APPID'),env('MT_SECRET')));
        $res = $shop_server->destroy($good);
        $res = json_decode($res, true);
        if (!$res || $res['data'] != 'ok')
        {
            $good->meituan_id = 0;
        }

        if (!$good->metuan_id && !$good->ele_id && !$good->baidu_id)
        {
            $good->delete();
        }

		return redirect()->back()->with('alert', '删除成功！');
	}

	public function deopt(Deopt $deopt, Good $good)
    {
        $shops = Shop::allowShops()->select('id', 'name')->get();
        return view('goods.create_and_edit', compact('deopt', 'good', 'shops'));
    }

    public function file(Request $request)
    {
        $file = $request->goods;
        $shop_id = $request->shop_id;
        $shop = Shop::where(['id' => $shop_id])->first();
        $result = [];

        $folder_name = "uploads/goods/" . date("Ym/d", time());
        $upload_path = public_path() . '/' . $folder_name;
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'xls';
        $filename = time() . '_' . str_random(10) . '.' . $extension;
        $file->move($upload_path, $filename);
        Excel::load($upload_path.'/'.$filename, function($reader)use($shop, $result) {
            $reader->each(function($item)use($shop, $result) {
                $data = $item->toArray();
//                dispatch(new CreateGoods($shop, $data));
		        $tmp = $data;
                array_push($tmp,$this->upFileGoods($shop, $data));
                $result[] = $tmp;
                echo implode('--',$tmp)."<br>";
            });
        });
//        Excel::create('上传结果',function($excel) use ($result){
//            $excel->sheet('score', function($sheet) use ($result){
//                $sheet->rows($result);
//            });
//        })->export('xls');
    }

    public function upFileGoods(Shop $shop, $data)
    {
        if (!$data['upc'])
        {
            return '条码不存在';
        }
        if (!$data['price'])
        {
            return '价格不存在';
        }
        if (!$data['stock'])
        {
            return '库存不存在';
        }
        $deopt = Deopt::where(['upc' => $data['upc']])->first();
        if (!$deopt)
        {
            return '品库中暂无此药品';
        }
        $goods = Good::where(['shop_id' => $shop->id, 'deopt_id' => $deopt->id])->first();
        if ($goods && $goods->meituan_id)
        {
//            return '药品已存在';
            $goods_server = New GoodsService(New Config(env('MT_APPID'),env('MT_SECRET')));
            if ($goods_server->syncStock($goods,($goods->stock + $data['stock'])) )
            {
                $goods->stock = ($goods->stock + $data['stock']);
                $goods->save();
                return '药品已存在，同步成功';
            }else{
                return '药品已存在，同步库存失败';
            }
        }else{
            $category = Category::where(['name' => $deopt->category, 'shop_id' => $shop->id])->first();
            if (!$category || !$category->meituan_id)
            {
                $category = Category::create(['name' => $deopt->category, 'shop_id' => $shop->id, 'sort' => 100]);
                $server = New CategoryService(New Config(env('MT_APPID'),env('MT_SECRET')));
                $category_create_status = $server->create($category);
                if (!$category_create_status)
                {
                    $category->delete();
                    return '该药品分类创建失败';
                }
            }
            if ($category->meituan_id)
            {
                $goods_data = [
                    'deopt_id' => $deopt->id,
                    'third_id' => $data['id'],
                    'price' => $data['price'],
                    'shop_id' => $shop->id,
                    'category_id' => $category->meituan_id,
                    'sort' => 1000,
                    'stock' => $data['stock'],
                    'online' => 1,
                ];
                $good = Good::create($goods_data);
                $server = New GoodsService(New Config(env('MT_APPID'),env('MT_SECRET')));
                $good_create_status = $server->create($good);
                if (!$good_create_status)
                {
                    $good->delete();
                    return '该药品创建失败';
                }
            }
        }
        return '成功';
    }
}
