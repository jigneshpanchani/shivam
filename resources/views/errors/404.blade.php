<!doctype html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <link rel="icon" type="image') }}" href="{{ asset('assets/img/favicon.png') }}" sizes="16x16">
    <link rel="icon" type="image') }}" href="{{ asset('assets/img/favicon.png') }}" sizes="32x32">

    <title>{{ config('app.name') }} - 404 error</title>

    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>

    <!-- uikit -->
    <link rel="stylesheet" href="{{ asset('bower_components/uikit/css/uikit.almost-flat.min.css') }}" />

    <!-- altair admin error page -->
    <link rel="stylesheet" href="{{ asset('assets/css/error_page.min.css') }}" media="all">

</head>
<body class="error_page">

<div class="error_page_header">
    <div class="uk-width-8-10 uk-container-center">
        404 - Key expired!
    </div>
</div>
<div class="error_page_content">
    <div class="uk-width-8-10 uk-container-center">
        <p class="heading_b">Please upgrade your activation key</p>
        <p class="uk-text-large">
            The requested URL was not found on this server.
        </p>
        <a href="error_404.html#" onclick="history.go(-1);return false;">Go back to previous page</a>
    </div>
</div>
</body>
</html>