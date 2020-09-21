<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UserMultiSheetExport implements WithMultipleSheets
{
	private $year;
	public function __construct(int $year)
	{
		return $this->year = $year;
	}
	public function sheets():array
	{
		$sheets = [];
		for($month = 1 ; $month <= 12; $month++){
			$sheets[] = new UsersExport($this->year, $month);
		}
		return $sheets;
	}
}
