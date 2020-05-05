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
        <title>Sailor | View Article</title>
        <!-- Styles -->
        <style>
            html, body {
                /* color: #636b6f; */
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

        </style>
    </head>
    <header class='w3-top'>
        @include('header')
    </header>
    <body class="w3-light-grey">
    <!-- Sidebar/menu -->
    @include('dashboardSidebar')
    <div class="w3-main"  style="margin-left:310px;margin-top:43px;margin-right:10px;">
        <header class="w3-container" style="padding-top:22px">
            <h5 class="w3-xlarge"><b><i class="fa fa-bell w3-text-blue w3-xlarge"></i> View Article</b></h5>
        </header>
        <div class="w3-row-padding w3-margin w3-margin w3-white w3-card">
            <div class="w3-margin-top">
                 <div  class="w3-container">
                   <span><?php echo base64_decode($_GET['title']); ?></span>
                 </div>
                 <hr>
                 <div class="article-content">
                 </div>
                 <script>
                    $('.article-content').load("<?php echo base64_decode($_GET['url']) ?>");
                 </script>
            </div>
        </div>
    </div>
    </body>
    <footer class='footer w3-bottom'>
        @include('footer')
    </footer>
</html>
