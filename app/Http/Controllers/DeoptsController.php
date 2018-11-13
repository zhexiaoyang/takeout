<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Deopt;
use App\Models\Good;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeoptRequest;
use MeiTuanOpenApi\Api\CategoryService;
use MeiTuanOpenApi\Api\GoodsService;
use MeiTuanOpenApi\Config\Config;

class DeoptsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
//        $this->authorize('before', Deopt::class);
        $keyword = $request->keyword;
        $deopts = Deopt::select('id','name','spec','is_otc','upc','category','common_name','company');
        if ($keyword)
        {
            $deopts = $deopts->where('name','like',"%{$keyword}%")->orWhere('common_name', 'like', "%{$keyword}%")->orWhere('upc', 'like', "%{$keyword}%");
        }
        $deopts = $deopts->orderBy('id', 'desc')->paginate(10);
		return view('deopts.index', compact('deopts','keyword'));
	}

    public function show(Deopt $deopt)
    {
        return view('deopts.show', compact('deopt'));
    }

	public function create(Deopt $deopt)
	{
		return view('deopts.create_and_edit', compact('deopt'));
	}

	public function store(DeoptRequest $request, Deopt $deopt)
	{
        $shop_id = 1;
        $data = $request->all();

        $deopt->fill($data);
        if (!$deopt->unit)
        {
            $deopt->unit = '';
        }
        if (!$deopt->price)
        {
            $deopt->price = 0;
        }
        if (!$deopt->description)
        {
            $deopt->description = '';
        }
        if (!$deopt->picture)
        {
            $deopt->picture = '';
        }
        if (!$deopt->common_name)
        {
            $deopt->common_name = '';
        }
        $status = $deopt->save();

        if ($status)
        {
            $category = Category::where(['name' => $request->category, 'shop_id' => $shop_id])->first();
            if (!$category)
            {
                $category = Category::create(['name' => $request->category, 'shop_id' => $shop_id, 'sort' => 100]);
                $server = New CategoryService(New Config(env('MT_APPID'),env('MT_SECRET')));
                $category_create_status = $server->create($category);
                if (!$category_create_status)
                {
                    $category->delete();
                }
            }
            if ($category->meituan_id)
            {
                $data['category_id'] = $category->id;
                $data['price'] = 66;
                $data['shop_id'] = $shop_id;
                $data['deopt_id'] = $deopt->id;
                $good = Good::create($data);
                $server = New GoodsService(New Config(env('MT_APPID'),env('MT_SECRET')));
                $good_create_status = $server->create($good);
                if (!$good_create_status)
                {
                    $good->delete();
                    $deopt->delete();
                    return redirect()->back()->with('message', '创建失败');
                }
            }
        }
		return redirect()->route('deopts.show', $deopt->id)->with('message', '创建成功');
	}

	public function edit(Deopt $deopt)
	{
        $this->authorize('update', $deopt);
		return view('deopts.create_and_edit', compact('deopt'));
	}

	public function update(DeoptRequest $request, Deopt $deopt)
	{
		$this->authorize('update', $deopt);
		$deopt->update($request->all());

		return redirect()->route('deopts.show', $deopt->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Deopt $deopt)
	{
		$this->authorize('destroy', $deopt);
		$deopt->delete();

		return redirect()->route('deopts.index')->with('message', 'Deleted successfully.');
	}
}