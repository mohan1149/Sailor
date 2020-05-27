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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
        <title>Sailor | Dashboard</title>
        <!-- Styles -->
        <style>
            .menu{
                display:none;
            }
            h3,h4{
                color:#636b6f;
                font-weight:200 !important;
                font-family: 'Nunito', sans-serif !important;
                text-transform:uppercase;
            }
            .app-credits{
                font-family: 'Nunito', sans-serif !important;
                color:#636b6f;
                text-transform:uppercase;
            }
            .menu-item{
                margin-bottom: 16px;
            }
            .menu-item div{
                background:#fff;
            }
            .menu-item .fa{
                color: rgb(61, 94, 161);
            }
            .menu-item a{
                text-decoration: none;
            }
        </style>
    </head>
    <header class='w3-top'>
        @include('header')
    </header>
    <body class="w3-light-grey">
    <!-- Sidebar/menu -->
    @include('school.dashboardSidebar')
    <div class="w3-main"  style="margin-left:300px;margin-top:43px;">
        <header class="w3-container" style="padding-top:22px">
            <h5><b><i class="fa fa-th"></i> Institute Management</b></h5>
        </header>
        <div class="w3-row-padding w3-margin-bottom">
            <!-- <div class="w3-quarter menu-item ">
                <div class="w3-container w3-padding-16 w3-card">
                    <div class="w3-left"><i class="fa fa-bank w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4><a href="/add/college"><?php echo $$strings['addinsti']?> <i class="fa fa-chevron-right"></i></a></h4>
                </div>
            </div> -->
            <div class="w3-quarter menu-item ">
                <div class="w3-container w3-padding-16 w3-card">
                    <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4><a href="/add/department"><?php echo $$strings['adddept']?> <i class="fa fa-chevron-right"></i></a></h4>
                </div>
            </div>
            <div class="w3-quarter menu-item">
                <div class="w3-container w3-padding-16 w3-card">
                    <div class="w3-left"><i class="fa fa-black-tie w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4><a href="/add/staff"><?php echo $$strings['addstaff']?> <i class="fa fa-chevron-right"></i></a></h4>
                </div>
            </div>
            <div class="w3-quarter menu-item">
                <div class="w3-container w3-padding-16 w3-card">
                    <div class="w3-left"><i class="fa fa-graduation-cap w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4><a href="/add/student"><?php echo $$strings['addstud']?> <i class="fa fa-chevron-right"></i></a></h4>
                </div>
            </div>
            <div class="w3-quarter menu-item">
                <div class="w3-container w3-padding-16 w3-card">
                    <div class="w3-left"><i class="fa fa-book w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4><a href="/add/class"><?php echo $$strings['addclass']?> <i class="fa fa-chevron-right"></i></a></h4>
                </div>
            </div>
            <div class="w3-quarter menu-item">
                <div class="w3-container w3-padding-16 w3-card">
                    <div class="w3-left"><i class="fa fa-laptop w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4><a href="/add/lab">Add Lab <i class="fa fa-chevron-right"></i></a></h4>
                </div>
            </div>
            <div class="w3-quarter menu-item">
                <div class="w3-container w3-padding-16 w3-card">
                    <div class="w3-left"><i class="fa fa-calendar w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4><a href="/add/studying/year">Add Year <i class="fa fa-chevron-right"></i></a></h4>
                </div>
            </div>
            <div class="w3-quarter menu-item">
                <div class="w3-container w3-padding-16 w3-card">
                    <div class="w3-left"><i class="fa fa-user-plus w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4><a href="/add/employee">Add Employee <i class="fa fa-chevron-right"></i></a></h4>
                </div>
            </div>
        </div>
        <!-- Bar Graphs -->
        <div class="w3-row w3-margin">
            <div class="w3-container w3-col l7 m12 s12" id="container">
                <canvas class="w3-white w3-card w3-margin" id="institute-canvas"></canvas>
            </div>
            <div class="w3-container w3-col l5" id="container">
                <h2 class="w3-white w3-card w3-margin" id="canvas">2nd graph</h2>
            </div>
        </div>
    </div>
    </body>
    <!-- load script for bar graph -->
    <script src="/js/getSchoolsBasicData.js"></script>
</html>
