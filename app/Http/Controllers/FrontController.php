<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Jobs\DownloadCompanySymbols;
use App\Http\Requests\FormSubmitRequest;
use Illuminate\Support\Facades\Storage;
use App\Jobs\DownloadDataForCompany;
use App\Jobs\SendEmail;

class FrontController extends Controller
{
    private $csv_data = array();
	
    public function index() 
    {
        return view("front.index");
    }
    
    public function runSetup()
    {
        $this->dispatch(new DownloadCompanySymbols());
    }
    
    public function submitForm(FormSubmitRequest $request) 
    {
        $company_symbol = strtoupper($request->input("company_symbol"));
        $start_date = $request->input("start_date");
        $end_date = $request->input("end_date");
        $email = $request->input("email");    	
    	
        $data_filename = $company_symbol . '-' . date("Y-m-d") . ".txt";
        $this->dispatch(new DownloadDataForCompany($data_filename, $company_symbol));
    	
        $this->getValidRows($start_date, $end_date, $data_filename);
        
        $this->dispatch(new SendEmail($start_date, $end_date, $company_symbol, $email));
    	
        return view(
            "ajax.data_table", 
            [ 'data' => [
                'valid_rows' => $this->csv_data,
                'chart' => $this->getChart()
            ]]
        );
    }
    
    private function getChart() {
        $chart = \Lava::DataTable();
        $chart->addDateColumn("Date")
              ->addNumberColumn("Open")
              ->addNumberColumn("Close");
        
        foreach ($this->csv_data as $data) {
        	$chart->addRow([
        		$data["Date"],
        		$data["Open"],
        		$data["Close"],
        	]);
        }
        return \Lava::LineChart("Quotes", $chart, ["title" => "Quotes"]);
    }
    
    private function getValidRows($start_date, $end_date, $data_filename) {
        $csv = array_map('str_getcsv', file(storage_path("app/" . $data_filename)));
        array_walk($csv, function(&$a) use ($csv) {
           $a = array_combine($csv[0], $a);
        });
        array_shift($csv);
        
        $valid_rows = array();
        $start_date = strtotime($start_date);
        $end_date = strtotime($end_date);
        
        foreach ($csv as $row) {
            $row_time = strtotime($row['Date']);
            if ($row_time >= $start_date && $row_time <= $end_date) {
                $this->csv_data[] = $row;
            }
        }
    }
}
