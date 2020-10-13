<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersImportController extends Controller
{
	public function import(Request $request)
    {
		try{
			$filePath = $request->file('file')->store('ImportData');

			DB::table('import_files')->insert([
				'user_id' => auth()->id(),
				'filepath' => $filePath,
			]);

			return redirect()->back()->with('success', 'File uploaded successfully');

		}catch (\Exception $e){
			return redirect()->back()->with('danger', $e->getMessage());

		}
    }

}

