<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class DownloadDataForCompany extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    const URL = "http://ichart.finance.yahoo.com/table.csv?s=";
    
    private $filename;
    private $symbol;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filename, $symbol)
    {
        $this->filename = $filename;
        $this->symbol = $symbol;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (Storage::exists($this->filename)) {
            return true;
        }
        
        Storage::put(
            $this->filename, file_get_contents(self::URL . $this->symbol)
        );
    }
}
