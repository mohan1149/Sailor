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
        <title>Sailor | View Staff</title>
        <!-- Styles -->
        <style>
            html, body {
                /* color: #636b6f; */
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
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
            .count-text{
                color: #636b6f;
                text-transform: uppercase;
                font-family: 'Nunito', sans-serif;
                letter-spacing: .1rem;
                font-weight: 600;
                cursor: pointer;
            }
            .inner-content table{
              display: none;
            }
            .active{
                display:block;
            }
            .inactive{
                display:none!important;
            }
            .week{
              color: #636b6f;
              text-transform: uppercase;
              font-family: 'Nunito', sans-serif;
              letter-spacing: .1rem;
              font-weight: 600;
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
          <ul class="breadcrumb">
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="/manage/students">Manage Students</a></li>
            <li><a href="">View Student</a></li>
            <li><?php echo $student_data['student']->fname?></li>
          </ul>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="add-institute">
                <div class="w3-row">
                    <div class="w3-third s_info">
                        <div class="w3-display-container school-logo">
                            <img class="w3-margin logo "src="<?php echo $student_data['student']->photo ?>" width="100%">
                        </div>
                        <div class="w3-container w3-text-black">
                            <h2><?php echo $student_data['student']->fname.' '.$student_data['student']->lname ?></h2>
                        </div>
                        <div class="w3-container">
                            <p><i class="fa fa-black-tie fa-fw w3-margin-right w3-large w3-text-red w3-xlarge"></i><?php echo $student_data['student']->sid ?></p>
                            <p><i class="fa fa-bank fa-fw w3-margin-right w3-large w3-text-red w3-xlarge"></i><?php echo $student_data['student']->school_name ?></p>
                            <p><i class="fa fa-share-alt fa-fw w3-margin-right w3-large w3-text-red w3-xlarge"></i><?php echo $student_data['student']->d_name ?></p>
                            <p> <i class="fa fa-calendar w3-margin-right w3-xlarge w3-text-red"></i><?php echo ' '.$student_data['student']->year ?><i class="fa fa-book fa-fw w3-large w3-text-red w3-xlarge"></i><?php echo $student_data['student']->value ?></p>
                            <!-- <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-red w3-xlarge"></i><?php echo $student_data['student']->email ?></p>
                            <p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-red w3-xlarge"></i><?php echo $student_data['student']->phone ?></p> -->
                        </div>
                    </div>
                    <div class="w3-twothird s_data">
                        <div class="w3-margin">
                            <div class="w3-container">
                              <div class="w3-container w3-margin w3-accordion">
                                  <button class="w3-indigo w3-margin w3-button w3-block w3-left-align staff-show" id ="timetable">
                                      Timetable
                                      <i class="fa fa-plus w3-right"></i>
                                  </button>
                                  <div class="inactive w3-table w3-bordered w3-margin w3-accordion-content content-table timetable">
                                      content
                                  </div>
                                  <button class="w3-indigo  w3-margin w3-button w3-block w3-left-align staff-show" id ="syllabus">
                                      Syllabus
                                      <i class="fa fa-plus w3-right"></i>
                                  </button>
                                  <div class="inactive w3-table w3-bordered w3-margin w3-accordion-content content-table syllabus">
                                    content
                                  </div>
                                  <button class="w3-indigo w3-margin w3-button w3-block w3-left-align staff-show" id ="leaves">
                                      Leaves
                                      <i class="fa fa-plus w3-right"></i>
                                  </button>
                                  <div class="inactive w3-table w3-bordered w3-margin w3-accordion-content content-table leaves">
                                    content
                                  </div>
                              <div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>
