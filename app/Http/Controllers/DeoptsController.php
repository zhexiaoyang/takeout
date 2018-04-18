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
        $deopts = Deopt::select('id','name','spec','is_otc','upc','category','common_name');
        if ($keyword)
        {
            $deopts = $deopts->where('name','like',"%{$keyword}%")->orWhere('common_name', 'like', "%{$keyword}%");
        }
        $deopts = $deopts->paginate(10);
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

	public function store(DeoptRequest $request)
	{
		$deopt = Deopt::create($request->all());
		return redirect()->route('deopts.show', $deopt->id)->with('message', 'Created successfully.');
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