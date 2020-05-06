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
            <li><a href="/manage/staff">Manage Staff</a></li>
            <li><a href="">View Staff</a></li>
            <li><?php echo $staff_data['staff']->username?></li>
          </ul>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="add-institute">
                <div class="w3-row">
                    <div class="w3-third s_info">
                        <div class="w3-display-container school-logo">
                            <img class="w3-margin logo "src="<?php echo $staff_data['staff']->profile ?>" width="100%">
                        </div>
                        <div class="w3-container w3-text-black">
                            <h2><?php echo $staff_data['staff']->username?></h2>
                        </div>
                        <div class="w3-container">
                            <p><i class="fa fa-black-tie fa-fw w3-margin-right w3-large w3-text-red w3-xlarge"></i><?php echo $staff_data['staff']->staff_id ?></p>
                            <p><i class="fa fa-graduation-cap fa-fw w3-margin-right w3-large w3-text-red w3-xlarge"></i><?php echo $staff_data['staff']->designation ?></p>
                            <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-red w3-xlarge"></i><?php echo $staff_data['staff']->email ?></p>
                            <p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-red w3-xlarge"></i><?php echo $staff_data['staff']->phone ?></p>
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
                                    <table class="w3-table w3-bordered">
                                      <?php
                                        foreach ($staff_data['timetable'] as $key => $week) {
                                          ?>
                                            <tr>
                                              <td class="week"><?php echo $key; ?></td>
                                              <td>
                                                <table>
                                                  <th><i class="fa fa-clock-o w3-text-purple w3-large"></i> Period</th>
                                                  <th><i class="fa fa-book w3-text-purple w3-large"></i> Subject</th>
                                                  <th><i class="fa fa-bank w3-text-purple w3-large"></i> Class</th>
                                                  <?php
                                                    foreach ($week as $key => $day) {
                                                      ?>
                                                        <tr>
                                                          <td><span><?php echo $key?></span></td>
                                                          <td><span><?php echo isset($day->subject) ? $day->subject : "N/A";?></span></td>
                                                          <td><span><?php echo isset($day->value) ? $day->value : "N/A";?></span></td>
                                                        </tr>
                                                      <?php
                                                    }
                                                   ?>
                                                 </table>
                                              </td>
                                            </tr>
                                          <?php
                                        }
                                      ?>
                                    </table>
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
