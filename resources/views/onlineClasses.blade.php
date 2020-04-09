<?php
    include(app_path().'/translations/strings.php');
    $strings = $_SESSION['lang'];
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Sailor | Add Institute</title>
        <!-- Styles -->
        <style>
            html, body {
                /* color: #636b6f; */
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .user-screens{
                display:flex;
                flex-direction: row;
                flex-wrap: wrap;
            }
            .user-screen{
                background:red;
                margin:5px;
                width:100%;
            }
            .teacher{
                width:100%;
                background:url('/atom.png');
                background-size: 300px 300px;
                background-position: center;
                background-repeat: no-repeat;
            }
        </style>
        <script>
            window.user={
                id:1, 
                name:"Mohan"
            }
            window.csrfToken = "{{ csrf_token() }}"
        </script>
    </head>
    <header class='w3-top'>
        @include('header')
    </header>
    <body class="w3-light-grey" style="margin-top:50px">
        <div  id="example">
        </div>
    </body>
    <footer class='footer w3-bottom'>
        @include('footer')
    </footer>
</html>
<script src="/js/app.js"></script>