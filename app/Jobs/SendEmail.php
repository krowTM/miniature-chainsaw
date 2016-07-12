<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    private $start_date;
    private $end_date;
    private $company_symbol;
    private $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($start_date, $end_date, $company_symbol, $email)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->company_symbol = $company_symbol;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "company_symbol" => $this->company_symbol,
            "email" => $this->email
        ];
        Mail::send("emails.notification", $data, function ($message) use ($data) {
            $message->subject($data["company_symbol"])
                    ->to($data["email"]);
        });
    }
}