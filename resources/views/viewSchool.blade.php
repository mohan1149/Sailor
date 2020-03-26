<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Sailor | View School or College</title>
        <!-- Styles -->
        <style>
            .content-container{
                margin-top:60px;
            }
        </style>
    </head>
    <header class='w3-top'>
        @include('header')
    </header>
    <body class="w3-light-grey content-container">
        <div class="w3-row">
            <div class="w3-third">
                <div class="w3-margin w3-card">
                    <div class="w3-display-container">
                        <img src="https://www.w3schools.com/w3images/avatar_hat.jpg" width="100%">
                        <div class="w3-display-bottomleft w3-container w3-text-black">
                            <h2>Jane Doe</h2>
                        </div>
                    </div>
                    <div class="w3-container">
                        <p><i class="fa fa-map-marker fa-fw w3-margin-right w3-large w3-text-teal"></i>London, UK</p>
                        <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>ex@mail.com</p>
                        <p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-teal"></i>1224435534</p>
                    </div>
                </div>
            </div>
            <div class="w3-twothird">
                <div class="w3-margin w3-card">
                    <img src="https://www.w3schools.com/w3images/avatar_hat.jpg" width="100%">
                </div>
            </div>
    </body>
    <footer class='footer w3-bottom'>
        @include('footer')
    </footer>
</html>
