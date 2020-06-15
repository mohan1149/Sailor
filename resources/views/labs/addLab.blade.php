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
        <title>Sailor | Add Lab</title>
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
            }
        </style>
        <script>
            window.ins_data = <?php echo json_encode($schools); ?>
        </script>
    </head>
    <header class='w3-top'>
        @include('header')
    </header>
    <body class="w3-light-grey">
    <!-- Sidebar/menu -->
    @include('school.dashboardSidebar')
    <div class="w3-main"  style="margin-left:310px;margin-top:43px;margin-right:10px;">
        <header class="w3-container" style="padding-top:22px">
            <ul class="breadcrumb">
              <li><a href="/school/dashboard">Dashboard</a></li>
              <li><a href="/add/lab">Add Lab</a></li>
            </ul>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="add-institute">
                    <form action='/store/lab' method="POST" class="w3-center">
                        @csrf
                        <div class='form-group'>
                            <span><i class='fa fa-pencil w3-xlarge w3-text-blue'></i></span>
                            <input required type='text' class="form-input"autofocus name='lab' placeholder='Ex: Von Neumann Lab' >
                        </div>
                        <div class='form-group'>
                            <span><i class='fa fa-bank w3-xlarge w3-text-blue'></i></span>
                            <select required class="form-input select-school"name='school_id'>
                                <option value="-1">Institute</option>
                                <?php
                                    foreach($schools as $key => $school){
                                        ?>
                                            <option id ="<?php echo $key?>" value= "<?php echo $school['schoolId'];?> "><?php echo $school['schoolName'] ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class='form-group'>
                            <span><i class='fa fa-share-alt w3-xlarge w3-text-blue'></i></span>
                            <select class="form-input department"name='department'>
                                <option>Department</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <span><i class='fa fa-laptop  w3-xlarge w3-text-blue'></i></span>
                            <input required type='number' name='machines' class="subjects form-input" placeholder='Number of working machines' >
                        </div>
                        <div class='form-group w3-center' >
                            <input class="w3-button form-input form-submit"type='submit' value="Save">
                        </div>
                    </form>
            </div>
        </div>
    </div>
    </body>
</html>
