
<?php
    include(app_path().'/translations/strings.php');
    $strings = $_SESSION['lang'];
    $subjects = $viewData['subjects'];
    $staff    = $viewData['staff'];
    $periods  = $viewData['periods']->periods;
    $cid      = $viewData['class_id'];
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Sailor | Add Timetable</title>
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
            .form-select-top{
                background:#fff!important;
                width:50vw!important;
                margin-right:15px;
                height:50px;
            }
            .form-select-bottom{
                background:#fff!important;
            }
            .form-group-item{
                display:flex;
                margin-left: 50px;
            }
            .form-group{
                display:flex;
                margin-left: 25px; 
                justify-content: center;
            }
            .lists a{
                width:100%;
            }
            .lists a div{
                width:100%;
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
            <h5><b><i class="fa fa-plus w3-text-blue w3-xlarge"></i> Add Timetable</b></h5>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="add-timetable">
                <div class="instructions">
                    <h4>Instructions</h4>
                </div>
                <div class="w3-container w3-card w3-blue">
                    <h2>Intructions</h2>
                    <ul>
                        <li>Click on week and add staff and subject.</li>
                        <li>Click on Save after completing all weeks.</li>
                    </ul>
                    <h4><strong>Note:</strong>Please do not refresh while addig time table.</h4>
                </div>
                <div class='addClass-form'>
                    <div class="w3-row w3-margin center-list lists">
                        <a href="javascript:void(0)" onclick="openDay(event, 'sun');">
                            <div class="w3-col tablink w3-bottombar w3-hover-teal w3-padding sun">Sunday</div>
                        </a>
                        <a href="javascript:void(0)" onclick="openDay(event, 'mon');">
                            <div class="w3-col tablink w3-bottombar w3-hover-teal w3-padding mon">Monday</div>
                        </a>
                        <a href="javascript:void(0)" onclick="openDay(event, 'tue');">
                            <div class="w3-col tablink w3-bottombar w3-hover-green w3-padding tue">Tuesday</div>
                        </a>
                        <a href="javascript:void(0)" onclick="openDay(event, 'wed');">
                            <div class="w3-col tablink w3-bottombar w3-hover-yellow w3-padding wed">Wednesday</div>
                        </a>
                        <a href="javascript:void(0)" onclick="openDay(event, 'thu');">
                            <div class="w3-col tablink w3-bottombar w3-hover-blue w3-padding thu">Thursday</div>
                        </a>
                        <a href="javascript:void(0)" onclick="openDay(event, 'fri');">
                            <div class="w3-col tablink w3-bottombar w3-hover-indigo w3-padding fri">Friday</div>
                        </a>
                        <a href="javascript:void(0)" onclick="openDay(event, 'sat');">
                            <div class="w3-col tablink w3-bottombar w3-hover-gray w3-padding sat">Saturday</div>
                        </a>
                    </div>
                    <form action='/add/timetable' method="POST">
                        @csrf
                        <?php
                            $weeks = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
                            foreach($weeks as $week){
                                ?>
                                    <div class="<?php echo $week;?>" style="display:none">
                                        <h2 style="text-align:center;text-transform: uppercase;letter-spacing: 2px;"><?php echo $week;?></h2>
                                        <div>
                                            <?php
                                                for($i=1;$i<=$periods;$i++){
                                                    ?>
                                                        <div class='form-group'>
                                                            <span style="font-size:24px">Period <?php echo $i?></span>
                                                            <div class="form-group-item">
                                                                <select required class="w3-input form-select-top" name="<?php echo $week.'_'.$i.'_subject'?>">
                                                                    <option>Subject Name</option>
                                                                    <?php
                                                                        foreach($subjects as $subject){
                                                                            ?>
                                                                                <option><?php echo $subject ?></option>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                                <select required class="w3-input form-select-bottom" name="<?php echo $week.'_'.$i.'_staff'?>">
                                                                    <option>Staff Name</option>
                                                                    <?php
                                                                        foreach($staff as $teacher){                                                                            
                                                                            ?>
                                                                                <option value="<?php echo $teacher->id.'_'.$teacher->username ?>"><?php echo $teacher->username ?></option>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                    </div>
                                <?php
                            }
                        ?>
                            <div class="w3-center w3-margin w3-padding">
                                <input type='submit' disabled value="Save" class="save-tt w3-blue w3-button form-submit w3-center">
                            </div>
                            <input type="hidden" value="<?php echo $periods?>" name="periods">
                            <input type="hidden" value="<?php echo $cid?>" name="cid">
                    </form>
                </div>
            </div>
        </div>
    </div>
    </body>
    <footer class='footer'>
        @include('footer')
    </footer>
    <!-- timetable script start-->
        <script>
            function openDay(e,day){
                switch(day){
                    case "sun": 
                        $(".sunday").show();
                        $(".sun").addClass('w3-border-red');
                        $(".mon,.tue,.wed,.thu,.fri,.sat").removeClass('w3-border-red');
                        $(".monday,.tuesday,.wednesday,.thursday,.friday,.saturday").hide();
                        break;
                    case "mon": 
                        $(".monday").show();
                        $(".mon").addClass('w3-border-red');
                        $(".tue,.wed,.thu,.fri,.sat,.sun").removeClass('w3-border-red');
                        $(".tuesday,.wednesday,.thursday,.friday,.saturday,.sunday").hide();
                        break;
                    case "tue": 
                        $(".tuesday").show();
                        $(".tue").addClass('w3-border-red');
                        $(".mon,.wed,.thu,.fri,.sat,.sun").removeClass('w3-border-red');
                        $(".monday,.wednesday,.thursday,.friday,.saturday,.sunday").hide();
                        break;
                    case "wed": 
                        $(".wednesday").show();
                        $(".wed").addClass('w3-border-red');
                        $(".mon,.tue,.thu,.fri,.sat,.sun").removeClass('w3-border-red');
                        $(".monday,.tuesday,.thursday,.friday,.saturday,.sunday").hide();
                        break;
                    case "thu": 
                        $(".thursday").show();
                        $(".thu").addClass('w3-border-red');
                        $(".mon,.tue,.wed,.fri,.sat,.sun").removeClass('w3-border-red');
                        $(".monday,.tuesday,.wednesday,.friday,.saturday,.sunday").hide();
                        break;
                    case "fri": 
                        $(".friday").show();
                        $(".fri").addClass('w3-border-red');
                        $(".mon,.tue,.wed,.thu,.sat,.sun").removeClass('w3-border-red');
                        $(".monday,.tuesday,.wednesday,.thursday,.saturday,.sunday").hide();
                        break;
                    case "sat": 
                        $(".saturday").show();
                        $(".sat").addClass('w3-border-red');
                        $(".mon,.tue,.wed,.thu,.fri,.sun").removeClass('w3-border-red');
                        $(".monday,.tuesday,.wednesday,.thursday,.friday,.sunday").hide();
                        $(".save-tt").removeAttr('disabled');
                        break;
                }
            }
        </script>
    <!-- end script -->
</html>