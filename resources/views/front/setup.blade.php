<!DOCTYPE html>
<html>
    <head>
        <title>Setup</title>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Miniature Chainsaw</div>
                <div class="progress">Starting...</div>
                <div class="clear"></div>
            </div>
        </div>
    </body>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script type="text/javascript" src="{{ asset('js/jquery-3.0.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/scripts.js') }}"></script>
    <script>
        Setup.run();
        Setup.checkProgress();
    </script>
</html>
