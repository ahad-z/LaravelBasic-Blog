<?php
namespace App\Exports;

use App\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Fromview;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithTitle;
use Carbon\Carbon;
class UsersExport implements
	ShouldAutoSize,
	WithMapping,
	WithHeadings,
	WithEvents,
	FromQuery,
	WithDrawings,
	WithCustomStartCell,
	WithTitle

{
	/*We use it here bcz of using Exportable class */
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    /* If we use formQuery so then dont need to use collection*/
    private $year;
    private $month;
    public function __construct(int $year,int $month)
    {
    	$this->year = $year;
    	$this->month = $month;

    }
    public function query()
    {
    	return $users =  User::query()
    	->whereYear('created_at', $this->year)
    	->whereMonth('created_at' , $this->month);
  	    // $users->first()->posts()->first()->title;
    }
    public function map($user):array
    {
    	return [
    		$user->id,
    		$user->name,
    		$user->email,
    		/*$user->posts()->count() > 0 ? $user->posts()->first()->title : '',*/
    		$user->created_at,
       	];
    }

    public function headings($value=''): array
    {
    	return ['Id','Name','Email','Added Time'];
    }
    public function registerEvents():array
    {
    	return [
    		AfterSheet::class => function(AfterSheet $event){
    			$event->sheet->getStyle('D1:E1')->applyFromArray([
    				'font' => [
    					'bold' => true
    				]
    			]);
    		}
    	];
    }
     public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/log.png'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('B3');

        return $drawing;
    }
   	public function startCell():string
   	{
   		return 'A8';
   	}
   	public function title(): string
    {
        return Carbon::createFromFormat('Y-m-d', '2020-'. $this->month .'-01')->format('Y-F');
    }
}
