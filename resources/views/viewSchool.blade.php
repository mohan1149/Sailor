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
        <title>Sailor | Edit Institute</title>
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
            <h5 class="w3-xlarge"><b><i class="fa fa-eye w3-text-blue w3-xlarge"></i> View Institute</b></h5>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="add-institute">
                <div class="w3-row">
                    <div class="w3-third s_info">
                        <div class="w3-display-container school-logo">
                            <img class="w3-margin logo "src="<?php echo $responseData['school']->logo_path?>" width="100%">
                        </div>
                        <div class="w3-container w3-text-black">
                            <h2><?php echo $responseData['school']->school_name?></h2>
                        </div>
                        <div class="w3-container">
                            <p><i class="fa fa-map-marker fa-fw w3-margin-right w3-large w3-text-red w3-xlarge"></i><?php echo $responseData['school']->school_address?></p>
                            <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-red w3-xlarge"></i><?php echo $responseData['school']->email?></p>
                            <p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-red w3-xlarge"></i><?php echo $responseData['school']->phone?></p>
                            <p><i class="fa fa-globe fa-fw w3-margin-right w3-large w3-text-red w3-xlarge"></i><?php echo $responseData['school']->website?></p>
                        </div>
                    </div>
                    <div class="w3-twothird s_data">
                        <div class="w3-margin">
                            <div class="w3-row">
                                <ul class="center-list w3-indigo school-data">
                                    <li class="data-item active deps tablink"><h3>Departments </h3></li>
                                    <li class="data-item classes"><h3>Classes</h3></li>
                                    <li class="data-item staff"><h3>Staff</h3></li>
                                    <!-- <li class="data-item students"><h3>Students</h3></li> -->
                                </ul>
                            </div>
                            <div class="w3-twothird">
                                <div class="">
                                    <div class="data active deps">
                                        <table class="w3-bordered w3-table w3-striped">
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Website</th>
                                            <?php 
                                            foreach($responseData['deps'] as $dep){
                                                ?>
                                                    <tr>
                                                        <td><?php echo $dep->d_name?></td>
                                                        <td><?php echo $dep->email?></td>
                                                        <td><?php echo $dep->website?></td>
                                                    </tr>
                                                <?php
                                            }
                                        ?>
                                        </table>
                                    </div>
                                    <div class="data classes" style="height:72vh;overflow:scroll;">
                                        <table class="w3-bordered w3-table w3-striped">
                                            <th>Name</th>
                                            <th>Subjects</th>
                                            <?php 
                                            foreach($responseData['classes'] as $class){
                                                ?>
                                                    <tr>
                                                        <td><?php echo $class->value?></td>
                                                        <td><?php echo $class->num_subjects?></td>                                                
                                                    </tr>
                                                <?php
                                            }
                                        ?>
                                        </table>
                                    </div>
                                    <div class="data staff" style="height:72vh;overflow:scroll;">
                                        <table class="w3-bordered w3-table w3-striped">
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <?php 
                                            foreach($responseData['staff'] as $staff){
                                                ?>
                                                    <tr>
                                                        <td><?php echo $staff->username?></td>
                                                        <td><?php echo $staff->designation?></td>                                              
                                                        <td><?php echo $staff->phone?></td>
                                                        <td><?php echo $staff->email?></td>
                                                    </tr>
                                                <?php
                                            }
                                        ?>
                                        </table>
                                    </div>
                                    <div class="data students">
                                        <a href="#"><h2> <?php echo count($responseData['deps']).' Students'?></h2></a>
                                    </div>
                                </div>        
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
