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
            }
            .s_info{
                border-right: 1px solid gray;
            }
            .active{
                color:#2196F3 !important;
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
                            <img class="w3-margin logo "src="<?php echo $school->logo_path?>" width="100%">
                        </div>
                        <div class="w3-container w3-text-black">
                            <h2><?php echo $school->school_name?></h2>
                        </div>
                        <div class="w3-container">
                            <p><i class="fa fa-map-marker fa-fw w3-margin-right w3-large w3-text-red w3-xlarge"></i><?php echo $school->school_address?></p>
                            <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-red w3-xlarge"></i><?php echo $school->email?></p>
                            <p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-red w3-xlarge"></i><?php echo $school->phone?></p>
                            <p><i class="fa fa-globe fa-fw w3-margin-right w3-large w3-text-red w3-xlarge"></i><?php echo $school->website?></p>
                        </div>
                    </div>
                    <div class="w3-twothird s_data">
                        <div class="w3-margin w3-card">

                            <div class="w3-third">
                                <ul class="w3-ul school-data">
                                    <li class="data-item active"><h3>Departments &#8618;</h3></li>
                                    <li class="data-item"><h3>Classes &#8618;</h3></li>
                                    <li class="data-item"><h3>Staff &#8618;</h3></li>
                                    <li class="data-item"><h3>Students &#8618;</h3></li>
                                </ul>
                            </div>
                            <div class="w3-twothird">
                                <table class="w3-table w3-striped w3-padding">
                                    <th>Department Name</th>
                                    <th>Department Strength</th>
                                    <tr>
                                        <td>Computer Science</td>
                                        <td>650</td>
                                    </tr>
                                </table>
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
