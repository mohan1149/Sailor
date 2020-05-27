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
        <title>Sailor | View Class</title>
        <!-- Styles -->
        <style>
            html, body {
                /* color: #636b6f; */
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .left{
                background-color: rgb(61, 94, 161);
                height:100vh;
            }
            .right{
                height:100vh;
            }
            .left-container{
                margin-top:10vh;
            }
            .logo-text{
                margin-top:10px;
            }
            .right-container{
                margin-top:10vh;
            }
            .title{
                font-family: 'Nunito', sans-serif;
                font-weight:200;
                text-align:center;
            }
            .school-logo{
                display:flex;
                justify-content: center;
            }
            .logo{
                width:200px;
                height:200px;
                border-radius: 50%;
                margin-bottom: 15px;
            }
            .school-data .data-item{
                cursor: pointer;
                list-style: none;
            }
            .s_info{
                border-right: 1px solid gray;
            }
            .school-data .active{
                color:#2196F3 !important;
                background:black;
            }
            .data{
                display:none;
            }
            .data a {
                text-decoration:none;
            }
            .active{
                display:block;
            }
            li h3{
                color: #fff;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                font-family: 'Nunito', sans-serif;
            }
            .count-text{
                color: #636b6f;
                text-transform: uppercase;
                font-family: 'Nunito', sans-serif;
                letter-spacing: .1rem;
                font-weight: 600;
            }
            .class_name{
                color: #636b6f;
                text-transform: uppercase;
                font-family: 'Nunito', sans-serif;
                letter-spacing: .1rem;
                font-weight: 600;
            }
        </style>
    </head>
    <header class='w3-top'>
        @include('header')
    </header>
    <body class="w3-light-grey">
    <!-- Sidebar/menu -->
    @include('school.dashboardSidebar')
    <div class="w3-main"  style="margin-left:310px;margin-top:43px;margin-right:10px;">
        <header class="w3-container" style="padding-top:22px">
            <h5 class="w3-xlarge"><b><i class="fa fa-eye w3-text-blue w3-xlarge"></i> View Class</b></h5>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card w3-twothird">
            <div class="w3-container data-container w3-row w3-center">
                <h2 class="class_name"><?php echo $responseData['class_data']->class_name?></h2>               
                <div class="center-list">
                    <div class="w3-quarter w3-margin-bottom">
                        <div class="w3-margin-top"><i class="fa fa-graduation-cap w3-jumbo w3-text-blue"></i></div>
                        <span class="w3-xxxlarge count"><?php echo $responseData['students'] ?></span>
                        <div class="w3-xlarge count-text">Students</div>                             
                    </div>                          
                    <div class="w3-quarter w3-margin-bottom">
                        <div class="w3-margin-top"><i class="fa fa-book w3-jumbo w3-text-blue"></i></div>
                        <span class="w3-xxxlarge count"><?php echo $responseData['class_data']->class_num_subjects ?></span>
                        <div class="w3-xlarge count-text">Subjects</div>     
                    </div>
                </div>                       
            </div>
        </div>
    </div>
    </body>
    <footer class='footer w3-bottom'>
        @include('footer')
    </footer>
</html>
