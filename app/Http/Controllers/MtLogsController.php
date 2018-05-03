<?php

namespace App\Http\Controllers;

use App\Models\MtLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MtLogRequest;

class MtLogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index()
	{
		$mt_logs = MtLog::paginate();
		return view('mt_logs.index', compact('mt_logs'));
	}

    public function show(MtLog $mt_log)
    {
        return view('mt_logs.show', compact('mt_log'));
    }

	public function create(MtLog $mt_log)
	{
		return view('mt_logs.create_and_edit', compact('mt_log'));
	}

	public function store(MtLogRequest $request)
	{
		$mt_log = MtLog::create($request->all());
		return redirect()->route('mt_logs.show', $mt_log->id)->with('message', 'Created successfully.');
	}

	public function edit(MtLog $mt_log)
	{
        $this->authorize('update', $mt_log);
		return view('mt_logs.create_and_edit', compact('mt_log'));
	}

	public function update(MtLogRequest $request, MtLog $mt_log)
	{
		$this->authorize('update', $mt_log);
		$mt_log->update($request->all());

		return redirect()->route('mt_logs.show', $mt_log->id)->with('message', 'Updated successfully.');
	}

	public function destroy(MtLog $mt_log)
	{
		$this->authorize('destroy', $mt_log);
		$mt_log->delete();

		return redirect()->route('mt_logs.index')->with('message', 'Deleted successfully.');
	}
}