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
        <title>Sailor | Timetable</title>
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
            button,th{
                padding: 0 25px !important;
                font-size: 13px !important;
                font-weight: 600 !important;
                letter-spacing: .1rem !important;
                text-decoration: none !important;
                text-transform: uppercase !important;
                font-family: 'Nunito', sans-serif !important;
                padding: 10px !important;
            }
            .monday, .tuesday, .wednesday, .thursday, .friday, .saturday{
                display:none;
            }
            .active{
                display:block;
            }
            .inactive{
                display:none!important;
            }
        </style>
    </head>
    <header class='w3-top'>
        @include('header')
    </header>
    <body class="w3-light-grey">
    <!-- Sidebar/menu -->
    @if($_SESSION['ins'] == 'college')
        @include('college.dashboardSidebar')
    @else
        @include('school.dashboardSidebar')
    @endif
    <div class="w3-main"  style="margin-left:310px;margin-top:43px;margin-right:10px;">
        <header class="w3-container" style="padding-top:22px">
          <ul class="breadcrumb">
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="/manage/classes">Manage Classes</a></li>
            <li><a href="">Timetable</a></li>
            <li><?php echo base64_decode($_GET['cl']); ?></li>
          </ul>
        </header>
        <div class="w3-row-padding w3-margin w3-margin w3-white w3-card">
            <div class="w3-margin-top">
                <?php
                    $weeks = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
                    foreach($weeks as $week){
                        ?>
                        <button style="width:95%"class="w3-indigo w3-margin w3-button w3-block w3-left-align staff-show" id ="school-<?php echo $week ?>">
                            <?php echo $week; ?>
                            <i class="fa fa-plus w3-right"></i>
                        </button>
                        <table style='text-align:center;width:95%!important;' class="inactive w3-bordered w3-table w3-margin w3-accordion-content content-table school-<?php echo $week?>">
                            <tr class="w3-white">
                                <th><i class='fa fa-clock-o w3-text-purple w3-xlarge'></i> <span class="w3-small"> Period</span></th>
                                <th><i class='fa fa-book w3-text-purple w3-xlarge'></i> <span class="w3-small"> SUbject</span></th>
                                <th><i class='fa fa-black-tie w3-text-purple w3-xlarge'></i> <span class="w3-small"> Staff</span></th>
                            </tr>
                            <?php
                            $day = json_decode($timetable->$week);
                            foreach($day as $key => $weekday){
                                ?>
                                    <tr>
                                        <td><?php echo $key?></td>
                                        <td><?php echo $weekday->subject?></td>
                                        <td><?php echo $weekday->staff?></td>
                                    </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
    </body>
    <footer class='footer w3-bottom'>
        @include('footer')
    </footer>
</html>
