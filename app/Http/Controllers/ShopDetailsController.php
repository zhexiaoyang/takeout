<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\ShopDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShopDetailRequest;

class ShopDetailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function show($shop_id)
    {
        $detail = ShopDetail::where(['shop_id' => $shop_id])->get()->toArray();
        if (!$detail)
        {
            return redirect()->to(route('shop_details.create', $shop_id));
        }else{
            return redirect()->to(route('shop_details.edit', $shop_id));
        }
        return view('shop_details.show', compact('detail'));
    }

	public function create($shop_id)
	{
	    $shop = Shop::find($shop_id);
	    $shop_detail = new Shop;
		return view('shop_details.create_and_edit', compact('shop', 'shop_detail'));
	}

	public function store(ShopDetailRequest $request)
	{
		$shop_detail = ShopDetail::create($request->all());
		return redirect()->route('shop_details.edit', $shop_detail->shop_id)->with('message', '创建成功');
	}

	public function edit($shop_id)
	{
//        $this->authorize('update', $shop_detail);
        $shop = Shop::find($shop_id);
        $shop_detail = ShopDetail::where(['shop_id' => $shop_id])->first();
		return view('shop_details.create_and_edit', compact('shop_detail','shop'));
	}

	public function update(ShopDetailRequest $request, ShopDetail $shop_detail)
	{
		$this->authorize('update', $shop_detail);
		$shop_detail->update($request->all());

		return redirect()->route('shop_details.edit', $shop_detail->shop_id)->with('message', '更新成功');
	}

	public function destroy(ShopDetail $shop_detail)
	{
		$this->authorize('destroy', $shop_detail);
		$shop_detail->delete();

		return redirect()->route('shop_details.index')->with('message', 'Deleted successfully.');
	}
}