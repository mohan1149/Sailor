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
        <title>Sailor | My Notifictions</title>
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
                /* border-right: 1px solid gray; */
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
                background-color: red !important;
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
            .unread{
              display: flex;
              background-color: rgb(61, 94, 161);
            }
            .unread:hover{
              background-color: #ccc;
            }
            .read{
              background-color: black;
            }
            .read:hover{
              background-color: #ccc;
            }
            .notif-title{
              font-family: 'Nunito', sans-serif;
              font-weight: 600;
              color: #fff;
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
            <a class=""><i class="fa fa-cogs w3-text-blue w3-xlarge"></i> Notifictions</a>
            <a class="w3-button" href="/add/notification"><i class="fa fa-plus w3-text-blue w3-xlarge"></i> Add Notifiaction</a>
        </header>
        <div class="w3-container w3-margin-bottom">
          <span><i class="fa fa-circle w3-text-red"></i> Active</span>
          <span><i class="fa fa-circle w3-text-black"></i> Read</span>
          <span><i class="fa fa-circle w3-text-indigo"></i> Not Read</span>
        </div>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="add-institute">
                <div class="w3-row">
                    <div class="w3-third s_info w3-margin-top" style="height:auto">
                      <?php
                        for ($i=0; $i < 10; $i++) {
                          ?>
                              <div class="notif-side-panel unread center-list <?php echo $i ?>">
                                  <!-- <i class="fa fa-bell w3-xlarge w3-text-white w3-margin-right"></i> -->
                                  <p class="notif-title">2nd Mind Examination Timetable</p>
                                  <i class="fa fa-chevron-right w3-margin-left w3-text-white"></i>
                              </div>
                              <hr style="margin:0;border-top:2px solid #eee;"></hr>
                          <?php
                        }
                      ?>
                    </div>
                    <div class="w3-twothird s_data">
                        <div class="w3-margin">
                            <div class="w3-container">
                                <p class="notif-title-right">Notifiaction Title</p>
                                <hr>
                                <p>Hello, i just wanted to let you know that i'll be home at lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.

Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                              <hr>
                              <i class="fa fa-clock-o w3-xlarge"></i><span> 2020/04/21 by admin</span>
                            </div>
                        </div>
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
