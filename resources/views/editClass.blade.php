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
        <title>Sailor | Edit Class</title>
        <!-- Styles -->
        <style>
            html, body {
                /* color: #636b6f; */
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .subjects{
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 600;   
                text-transform:uppercase;
                letter-spacing:.1rem
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
            function hide(id){
                id.style.display = 'none';
                //document.getElementById(id).style.display = 'none';
            }
        </script>
    </head>
    <header class='w3-top'>
        @include('header')
    </header>
    <body class="w3-light-grey">
    <!-- Sidebar/menu -->
    @include('dashboardSidebar')
    <div class="w3-main"  style="margin-left:310px;margin-top:43px;margin-right:10px;">
        <header class="w3-container" style="padding-top:22px">
            <h5><b><i class="fa fa-plus w3-text-blue w3-xlarge"></i> Edit Class</b></h5>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="add-institute">
                <div class="instructions">
                    <h4>Instructions</h4>
                </div>
                <form action='/update/class/<?php echo $class['class']->id?>' method="POST" class="w3-center">
                    @csrf
                    <div class='form-group'>
                        <span><i class='fa fa-book w3-xlarge w3-text-blue'></i></span>
                        <input value="<?php echo $class['class']->value?>"required type='text' class="form-input"autofocus name='className' placeholder='Ex: X-Spark' >
                    </div>
                    <div class='form-group'>
                        <span style="width:20%!important"class="form-input w3-button w3-indigo add-subject">Add Subject</span>
                    </div>
                    <div class="w3-margin subjects-list">
                        <span class="subjects">Subjects</span>
                        <?php 
                            foreach($class['subjects'] as $subject){
                                ?>
                                    <span class="w3-button subject w3-blue w3-margin-bottom"><?php echo $subject?> <i class="fa fa-times"></i></span>
                                <?php
                            }
                        ?>
                    </div>
                    <div class='form-group w3-center' >
                        <input class="w3-button form-input form-submit"type='submit' value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- add subject modal -->
    <div class="w3-modal subject-modal" id="subject-modal">
        <div class="w3-modal-content w3-animate-top w3-card-4">
            <header class="w3-container w3-indigo">
                <span onclick="document.getElementById('subject-modal').style.display='none'"
                    class="w3-button w3-xlarge w3-display-topright">&times;</span>
                <h2>Add Subject</h2>
            </header>
            <div class="w3-container">
                <div class='form-group w3-margin'>
                    <span><i class='fa fa-pencil w3-xlarge w3-text-blue'></i></span>
                    <input required type='text' class="form-input subject-name" autofocus placeholder='subject name' >
                </div>
                <button class="w3-blue w3-margin w3-button w3-xlarge add-confirm">Add</button>
                <button class="w3-red w3-margin w3-button w3-xlarge" onclick="document.getElementById('subject-modal').style.display='none'" >Cancel</button>
            </div>
            <footer class="w3-container w3-dark-grey">
                    <p>@Sailor Sytem </p>
            </footer>
        </div>
    </div>
    <!-- end -->
    </body>
    <footer class='footer w3-bottom'>
        @include('footer')
    </footer>
</html>