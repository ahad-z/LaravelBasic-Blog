<?php

namespace App\Jobs;

use App\Imports\UsersImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
	public $importData;
	public function __construct($importData)
    {
        $this->importData = $importData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
		try {
			Excel::import(new UsersImport, $this->importData->filepath);
			DB::table('import_files')->where('id', $this->importData->id)->update(['status' => 'completed']);
		}catch (\Exception $e) {
			DB::table('import_files')->where('id', $this->importData->id)->update(['status' => 'failed']);
			throw new \Exception($e);
		}
    }
}
