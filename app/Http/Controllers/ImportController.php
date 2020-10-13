<?php

namespace App\Http\Controllers;

use App\Jobs\TestJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
	public function index()
	{
		$files = DB::table('import_files')->get();

		return view('admin.import.index', compact('files'));
	}

	public function start($id)
	{
		try {
			$import = DB::table('import_files')->where('id', $id)->first();
			dispatch(new TestJob($import));

			DB::table('import_files')->where('id', $id)->update(['status' => 'running']);

			return redirect()->back()->with('success', 'File import has been started, We ill notify you once its done.');
		}catch (\Exception $e) {
			return redirect()->back()->with('danger', $e->getMessage());
		}
    }
}
