<?php

namespace App\Http\Controllers;

use App\Models\Deopt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeoptRequest;

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
        $deopt->fill($request->all());
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
        $deopt->save();
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