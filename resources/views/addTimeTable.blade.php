<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>STM::Add Staff</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                /* color: #636b6f; */
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .title {
                font-size: 84px;
                color:#2196F3;
                margin-top:50px;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
            .form-group{
                border:3px solid #2196F3;
                margin:10px;
                border-radius:15px;
                padding-left:30px;

            }
            .form-group input{
                border:none;
                height:50px;
                width:100%;
                border-radius:25px;
                background:transparent;
                color:gray;
                font-size:20px;
            }
            .form-group span{
                color:#2196F3; 
            }
            .addClass-form{
                margin-bottom:80px;
            }
        </style>
        <script>
            function openDay(e,day){
                switch(day){
                    case "mon": 
                        $(".monday").show();
                        $(".mon").addClass('w3-border-red');
                        $(".tue,.wed,.thu,.fri,.sat").removeClass('w3-border-red');
                        $(".tuesday,.wednesday,.thursday,.friday,.saturday").hide();
                        break;
                    case "tue": 
                        $(".tuesday").show();
                        $(".tue").addClass('w3-border-red');
                        $(".mon,.wed,.thu,.fri,.sat").removeClass('w3-border-red');
                        $(".monday,.wednesday,.thursday,.friday,.saturday").hide();
                        break;
                    case "wed": 
                        $(".wednesday").show();
                        $(".wed").addClass('w3-border-red');
                        $(".mon,.tue,.thu,.fri,.sat").removeClass('w3-border-red');
                        $(".monday,.tuesday,.thursday,.friday,.saturday").hide();
                        break;
                    case "thu": 
                        $(".thursday").show();
                        $(".thu").addClass('w3-border-red');
                        $(".mon,.tue,.wed,.fri,.sat").removeClass('w3-border-red');
                        $(".monday,.tuesday,.wednesday,.friday,.saturday").hide();
                        break;
                    case "fri": 
                        $(".friday").show();
                        $(".fri").addClass('w3-border-red');
                        $(".mon,.tue,.wed,.thu,.sat").removeClass('w3-border-red');
                        $(".monday,.tuesday,.wednesday,.thursday,.saturday").hide();
                        break;
                    case "sat": 
                        $(".saturday").show();
                        $(".sat").addClass('w3-border-red');
                        $(".mon,.tue,.wed,.thu,.fri").removeClass('w3-border-red');
                        $(".monday,.tuesday,.wednesday,.thursday,.friday").hide();
                        $(".save-tt").removeAttr('disabled');
                        break;
                }
            }
        </script>
    </head>
    <header class='w3-top'>
        @include('header')
    </header>
    <?php
        $subjects = $viewData['subjects'];
        $staff    = $viewData['staff'];
        $periods  = $viewData['periods']->periods;
        $cid      = $viewData['class_id'];
    ?>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Add Time Table to <?php echo $viewData['className'];?>
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
                    <div class="w3-row">
                        <a href="javascript:void(0)" onclick="openDay(event, 'mon');">
                            <div class="w3-col l2 tablink w3-bottombar w3-hover-teal w3-padding mon">Monday</div>
                        </a>
                        <a href="javascript:void(0)" onclick="openDay(event, 'tue');">
                            <div class="w3-col l2 tablink w3-bottombar w3-hover-green w3-padding tue">Tuesday</div>
                        </a>
                        <a href="javascript:void(0)" onclick="openDay(event, 'wed');">
                            <div class="w3-col l2 tablink w3-bottombar w3-hover-yellow w3-padding wed">Wednesday</div>
                        </a>
                        <a href="javascript:void(0)" onclick="openDay(event, 'thu');">
                            <div class="w3-col l2 tablink w3-bottombar w3-hover-blue w3-padding thu">Thursday</div>
                        </a>
                        <a href="javascript:void(0)" onclick="openDay(event, 'fri');">
                            <div class="w3-col l2 tablink w3-bottombar w3-hover-indigo w3-padding fri">Friday</div>
                        </a>
                        <a href="javascript:void(0)" onclick="openDay(event, 'sat');">
                            <div class="w3-col l2 tablink w3-bottombar w3-hover-gray w3-padding sat">Saturday</div>
                        </a>
                        </div>
                    <form action='/api/add/timetable' method="POST">
                        <?php
                            $weeks = ['monday','tuesday','wednesday','thursday','friday','saturday'];
                            foreach($weeks as $week){
                                ?>
                                    <div class="<?php echo $week;?>" style="display:none">
                                        <h2 style="text-align:center;text-transform: uppercase;letter-spacing: 2px;"><?php echo $week;?></h2>
                                        <table class="w3-table">
                                            <th>Period</th>
                                            <th>Subject/Faculty</th>
                                            <?php
                                                for($i=1;$i<=$periods;$i++){
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo "Period ".$i ?>
                                                            </td>
                                                            <td>
                                                                <select required class="w3-input" name="<?php echo $week.'_'.$i.'_subject'?>">
                                                                    <option>Subject Name</option>
                                                                    <?php
                                                                        foreach($subjects as $subject){
                                                                            ?>
                                                                                <option><?php echo $subject ?></option>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                                <select required class="w3-input" name="<?php echo $week.'_'.$i.'_staff'?>">
                                                                    <option>Staff Name</option>
                                                                    <?php
                                                                        foreach($staff as $teacher){
                                                                            ?>
                                                                                <option><?php echo $teacher->username ?></option>
                                                                            <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                }
                                            ?>
                                        </table>
                                    </div>
                                <?php
                            }
                        ?>
                            <input type="hidden" value="<?php echo $periods?>" name="periods">
                            <input type="hidden" value="<?php echo $cid?>" name="cid">
                            <input type='submit' disabled value="Save" class="save-tt w3-blue w3-button w3-input w3-padding-16" style="margin:10px;border-radius:50px;font-size:20px">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <footer class='w3-bottom'>
        @include('footer')
    </footer>
</html>
