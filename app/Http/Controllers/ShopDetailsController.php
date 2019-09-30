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

    public function createMany($shop_ids)
    {
        if ($shop_ids) {
            $shops = Shop::whereIn("id", explode(",", $shop_ids))->get();
            return view('shop_details.create_many', compact('shops', 'shop_ids'));
        }
    }

    public function saveMany(Request $request)
    {
//        dd($request->all());
        $data = $request->only("opening_bank","username","account_number","is_invoice","type","name","number","coefficient");
        $shop_ids = explode(",", $request->shop_ids);
        if (!empty($shop_ids)) {
            foreach ($shop_ids as $shop_id) {
                if ($shop_detail = ShopDetail::where("shop_id", $shop_id)->first()) {
                    $shop_detail->opening_bank = $data['opening_bank'];
                    $shop_detail->username = $data['username'];
                    $shop_detail->account_number = $data['account_number'];
                    $shop_detail->is_invoice = $data['is_invoice'];
                    $shop_detail->type = $data['type'];
                    $shop_detail->name = $data['name'];
                    $shop_detail->number = $data['number'];
                    $shop_detail->coefficient = $data['coefficient'];
                    $shop_detail->save();
                } else {
                    $_data = array_merge($data,['shop_id' => $shop_id]);
                    ShopDetail::create($_data);
                    unset($_data);
                }
            }
        }
        return redirect()->route('finance.hit')->with('message', '编辑成功');
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

    public function info($shop_id)
    {
        $result['code'] = 1;
        $detail = ShopDetail::select('opening_bank','username','account_number')->where(['shop_id' => $shop_id])->first();
        if (!empty($detail))
        {
            $result = $detail->toArray();
            $result['code'] = 0;
        }
        return response()->json($result);
	}
}