<?php

namespace App\Http\Controllers;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UsersImportController extends Controller
{
	public function import()
    {
        Excel::queueImport(new UsersImport, 'users_import.xlsx');
        return redirect()->back()->with('success', 'USer Data Export successFuly');
    }

}
