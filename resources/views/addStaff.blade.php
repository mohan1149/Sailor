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
            .intro{
                font-family: 'Nunito', sans-serif;
                font-weight:200;
                margin-left:50px;
                margin-right:50px;
            }
            .form-input{
                width:60%!important;
                margin-bottom:10px;
                border-radius:30px;
                padding:4px;
                padding-left:10px;
                margin-left:2px;
                height:50px;
                font-size:20px;
                border: 2px solid #2196F3;
            }
            .form-submit{
                color:#fff!important;
                width:50%;
                border-radius:30px;
                background-color: rgb(61, 94, 161)!important;
            }
            .add-institute{
                margin:10px;
            }
            .form-group{
                margin-bottom:5px;
                text-align: center;
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
            <h5><b><i class="fa fa-plus w3-text-blue w3-xlarge"></i> Add Staff</b></h5>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="add-institute">
                <div class="instructions">
                    <h4>Instructions</h4>
                </div>
                <form action='/manage/staff' method="POST">
                    @csrf
                        <div class='form-group'>
                            <span><i class='fa fa-user w3-xlarge w3-text-blue'></i></span>
                            <input class="form-input" type='text' name='staffname' placeholder='staff name' >
                        </div>
                        <div class='form-group'>
                            <span><i class='fa fa-phone w3-xlarge w3-text-blue'></i></span>
                            <input  class="form-input" type='tel' placeholder='phone' name='phone'>
                        </div>
                        <div class='form-group'>
                            <span><i class='fa fa-envelope w3-xlarge w3-text-blue'></i></span>
                            <input class="form-input"  type='email' placeholder='email' name='email'>
                        </div>
                        <div class='form-group'>
                            <span><i class='fa fa-book w3-xlarge w3-text-blue'></i></span>
                            <input  class="form-input" type='text' placeholder='designation' name='designation'>
                        </div>
                        <div class='form-group'>
                            <span><i class='fa fa-bank w3-xlarge w3-text-blue'></i></span>
                            <select  class="form-input select-school" name='school_id'>
                            <option value="-0">School</option>
                                <?php
                                    foreach($schools as $school){
                                        ?>
                                            <option value=<?php echo $school->id;?>><?php echo $school->school_name ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class='form-group'>
                            <span><i class='fa fa-share-alt w3-xlarge w3-text-blue'></i></span>
                            <select class="form-input department"  name='department'>
                                <option>Department</option>
                            </select>
                        </div>
                        <!-- <div class='form-group'>
                            <span><i class='fa fa-book w3-xlarge w3-text-blue'></i></span>
                            <select  class="form-input classes" name='class_teacher_for'>
                                <option>Class Teacher for</option>
                            </select>
                        </div> -->
                        <div class='form-group' style='text-align:center'>
                            <input  class="w3-button form-input form-submit" type='submit' value="Add">
                        </div>
                    </form>
            </div>
        </div>
    </div>
    </body>
    <footer class='footer w3-bottom'>
        @include('footer')
    </footer>
</html>
