<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderDetailRequest;

class OrderDetailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
		$order_details = OrderDetail::paginate();
		return view('order_details.index', compact('order_details'));
	}

    public function show(OrderDetail $order_detail)
    {
        return view('order_details.show', compact('order_detail'));
    }

	public function create(OrderDetail $order_detail)
	{
		return view('order_details.create_and_edit', compact('order_detail'));
	}

	public function store(OrderDetailRequest $request)
	{
		$order_detail = OrderDetail::create($request->all());
		return redirect()->route('order_details.show', $order_detail->id)->with('message', 'Created successfully.');
	}

	public function edit(OrderDetail $order_detail)
	{
        $this->authorize('update', $order_detail);
		return view('order_details.create_and_edit', compact('order_detail'));
	}

	public function update(OrderDetailRequest $request, OrderDetail $order_detail)
	{
		$this->authorize('update', $order_detail);
		$order_detail->update($request->all());

		return redirect()->route('order_details.show', $order_detail->id)->with('message', 'Updated successfully.');
	}

	public function destroy(OrderDetail $order_detail)
	{
		$this->authorize('destroy', $order_detail);
		$order_detail->delete();

		return redirect()->route('order_details.index')->with('message', 'Deleted successfully.');
	}
}