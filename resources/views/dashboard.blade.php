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
    @include('dashboardSidebar')
    <div class="w3-main"  style="margin-left:300px;margin-top:43px;">
        <header class="w3-container" style="padding-top:22px">
            <h5><b><i class="fa fa-th"></i> Institute Management</b></h5>
        </header>
        <div class="w3-row-padding w3-margin-bottom">
            <div class="w3-quarter menu-item ">
                <div class="w3-container w3-padding-16 w3-card">
                    <div class="w3-left"><i class="fa fa-bank w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4><a href="/add/institute"><?php echo $$strings['addinsti']?> <i class="fa fa-chevron-right"></i></a></h4>
                </div>
            </div>
            <div class="w3-quarter menu-item ">
                <div class="w3-container w3-padding-16 w3-card">
                    <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4><a href="/add/department"><?php echo $$strings['adddept']?> <i class="fa fa-chevron-right"></i></a></h4>
                </div>
            </div>
            <div class="w3-quarter menu-item">
                <div class="w3-container w3-padding-16 w3-card">
                    <div class="w3-left"><i class="fa fa-user-plus w3-xxxlarge"></i></div>
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
        </div>
        <header class="w3-container" style="">
            <h5><b><i class="fa fa-th"></i> Administration</b></h5>
        </header>
        <div class="w3-row-padding w3-margin-bottom">
            <div class="w3-quarter menu-item">
                <div class="w3-container w3-padding-16 w3-card">
                    <div class="w3-left"><i class="fa fa-black-tie w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4><a href="/manage/class">Employees <i class="fa fa-chevron-right"></i></a></h4>
                </div>
            </div>
            <div class="w3-quarter menu-item">
                <div class="w3-container w3-padding-16 w3-card">
                    <div class="w3-left"><i class="fa fa-home w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4><a href="/manage/class">Leaves <i class="fa fa-chevron-right"></i></a></h4>
                </div>
            </div>
            <div class="w3-quarter menu-item">
                <div class="w3-container w3-padding-16 w3-card">
                    <div class="w3-left"><i class="fa fa-money w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4><a href="/manage/class">Salaries <i class="fa fa-chevron-right"></i></a></h4>
                </div>
            </div>
        </div>
        <header class="w3-container" style="">
            <h5><b><i class="fa fa-th"></i> Exams</b></h5>
        </header>
        <div class="w3-row-padding w3-margin-bottom">
            <div class="w3-quarter menu-item">
                <div class="w3-container w3-padding-16 w3-card">
                    <div class="w3-left"><i class="fa fa-edit w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4><a href="/manage/class">Exams <i class="fa fa-chevron-right"></i></a></h4>
                </div>
            </div>
            <div class="w3-quarter menu-item">
                <div class="w3-container w3-padding-16 w3-card">
                    <div class="w3-left"><i class="fa fa-bar-chart w3-xxxlarge"></i></div>
                    <div class="w3-clear"></div>
                    <h4><a href="/manage/class">Reports <i class="fa fa-chevron-right"></i></a></h4>
                </div>
            </div>
        </div>
    </div>
    </body>
    <footer class='footer w3-bottom'>
        @include('footer')
    </footer>
</html>
