<!DOCTYPE html>
<html>
    <head>
        <title>Form</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Miniature Chainsaw</div>
                
                <div class="row">
                    <label for="company_symbol">Company Symbol</label><input type="text" name="company_symbol" id="company_symbol">
                </div>
                <div class="clear"></div>
                
                <div class="row">
                    <label for="start_date">Start Date (YYYY-mm-dd)</label><input type="text" name="start_date" id="start_date">
                </div>
                <div class="clear"></div>
                
                <div class="row">
                    <label for="end_date">End Date (YYYY-mm-dd)</label><input type="text" name="end_date" id="end_date">
                </div>
                <div class="clear"></div>
                
                <div class="row">
                    <label for="email">Email</label><input type="email" name="email" id="email">
                </div>
                <div class="clear"></div>
                
                <div class="row">
                    <a class="submit" href="#" onclick="Form.submit(event);">Submit</a>
                </div>                
                <div class="clear"></div>
                
                <div class="result"></div>
            </div>
        </div>
    </body>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script type="text/javascript" src="{{ asset('js/jquery-3.0.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/scripts.js') }}"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <script>
    $(function(){
        var dateFormat = "yy-mm-dd";
        start = $("#start_date").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            dateFormat: dateFormat
    	}).on("change", function() {
    		end.datepicker("option", "minDate", getDate(this));
    	});
        end = $("#end_date").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            dateFormat: dateFormat
    	}).on("change", function() {
    		start.datepicker("option", "maxDate", getDate(this));
    	});
    
    	function getDate(e) {
    		var date;
    		try {
    			date = $.datepicker.parseDate(dateFormat, e.value);
    		} catch( error ) {
    	        date = null;
    		}
    
    		return date;
    	}
    });
    </script>
</html>
