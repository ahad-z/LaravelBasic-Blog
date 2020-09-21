<?php
namespace App\Http\Controllers;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use App\Exports\UserMultiSheetExport;
/*use Maatwebsite\Excel\Facades\Excel;*/
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
class UsersExportController extends Controller
{
	public function __construct(Excel $excel)
	{
		return $this->excel = $excel;
	}
	public function export(Request $request)
	{
		/* this is way to download excel file
		return 	Excel::download(new UsersExport, 'usersData.xlsx','
		 we can do it by using exportable facades. But for that first of all we have to add exportable class in UserExport.php then we can use here
		return (new UsersExport)->download('userData.fileFormate)
		We can do it another way just need to define our file name in our userExport  file
		if we want to store our file into our server so then just use store instead of download */
		try {
			$fileExtention = $request->fileExtention;
			$this->excel->store(new UserMultiSheetExport(2020), 'users.'.$fileExtention);
			return redirect()->back()->with('success','File store successFully in your local storage');

		} catch (\Exception $e) {
			return redirect()->back()->with('danger',$e->getMessage());

		}

	}
}
