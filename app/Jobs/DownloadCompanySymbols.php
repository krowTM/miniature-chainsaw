<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class DownloadCompanySymbols extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    const URL = "http://www.nasdaq.com/screening/companies-by-name.aspx?render=download&letter=";

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        set_time_limit(0);
        Storage::delete('symbols.db');
        $this->writeProgress("Starting...");
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {        
        for ($i = 97; $i <= 122; $i++) {
            $this->writeProgress(
                "Downloading companies starting with " . strtoupper(chr($i))
            );
            $csv = array_map('str_getcsv', file(self::URL . chr($i)));
            array_walk($csv, function(&$a) use ($csv) {
                $a = array_combine($csv[0], $a);
            });
            array_shift($csv);
            
            foreach ($csv as $line) {
                $this->writeSymbol(trim($line['Symbol']));
            }
        } 
        
        $this->writeProgress("Done.");
    }
    
    private function writeProgress($message)
    {
        file_put_contents(
            public_path() . '/progress/progress.json', json_encode($message)
        );
    }
    
    private function writeSymbol($symbol) 
    {
        Storage::append('symbols.db', $symbol);
    }
}
