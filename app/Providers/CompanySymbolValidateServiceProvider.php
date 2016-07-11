<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class CompanySymbolValidateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend("valid_company_symbol", function($attribute, $value, $parameters, $validator) {
            $value = strtoupper($value);
            $valid_symbols = file(storage_path("app/symbols.db"));
            array_walk($valid_symbols, function(&$a) use ($valid_symbols) {
                $a = trim($a);
            });
            return in_array($value, $valid_symbols);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
