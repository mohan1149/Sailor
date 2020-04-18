<?php
    include(app_path().'/translations/strings.php');
    $strings = $_SESSION['lang'];
      if($_SESSION['role'] === 0){
        ?>
          <nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:0;width:300px;margin-top:15px;" id="mySidebar"><br>
              <div class="w3-container w3-row">
                  <div class="w3-col s4">
                      <img src="https://www.w3schools.com/w3images/avatar2.png" class="w3-circle w3-margin-right" style="width:46px">
                  </div>
                  <div class="w3-col s8 w3-bar">
                      <span class="w3-xlarge">Welcome, <strong>Mohan</strong></span><br>
                      <a href="/dashboard"><i title ="Home" class="w3-text-indigo w3-margin fa fa-home" style="font-size:24px;"></i></a>
                      <i title ="Profile" class="w3-text-red  fa fa-user" style="font-size:24px;"></i>
                      <i title ="Mailbox" class="w3-text-green w3-margin fa fa-envelope" style="font-size:24px;"></i>
                      <i title ="Notifcations" class="w3-text-blue fa fa-bell" style="font-size:24px;"></i>
                  </div>
              </div>
              <hr>
              <div class="w3-container">
                  <h5 class="w3-xlarge"><?php echo $$strings['dashboard']?></h5>
              </div>
              <div class="w3-bar-block sidenav">
                  <a href="/manage/schools" class="w3-bar-item w3-button w3-padding w3-large"><i class="fa fa-bank fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo 'Institutes'?></a>
                  <a href="/manage/departments" class="w3-bar-item w3-button w3-padding w3-large"><i class="fa fa-share-alt fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo 'Departments'?></a>
                  <a href="/manage/class" class="w3-bar-item w3-button w3-padding w3-large"><i class="fa fa-book fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo 'Classes'?></a>
                  <a href="/manage/staff" class="w3-bar-item w3-button w3-padding w3-large"><i class="fa fa-users fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo 'Staff'?></a>
                  <a href="/manage/student" class="w3-bar-item w3-button w3-padding w3-large"><i class="fa fa-graduation-cap fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo 'Students'?></a>
                  <a href="/manage/articles" class="w3-bar-item w3-button w3-padding w3-large"><i class="fa fa-comment fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo $$strings['articles']?></a>
                  <a href="#" class="w3-bar-item w3-button w3-padding w3-xlarge"><i class="fa fa-diamond fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo $$strings['payments']?></a>
                  <a href="#" class="w3-bar-item w3-button w3-padding w3-xlarge"><i class="fa fa-user-secret fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo 'Permissions'?></a>
                  <a href="#" class="w3-bar-item w3-button w3-padding w3-xlarge"><i class="fa fa-cloud fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo 'Archives'?></a>
                  <a href="/webrtc" class="w3-bar-item w3-button w3-padding w3-xlarge"><i class="fa fa-laptop fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo 'Online Classes'?></a>
                  <a href="#" class="w3-bar-item w3-button w3-padding w3-xlarge"><i class="fa fa-laptop fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo 'Online Exams'?></a>
              </div>
          </nav>
        <?php
      }else{
        ?>
          <nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:0;width:300px;margin-top:15px;" id="mySidebar"><br>
              <div class="w3-container w3-row">
                  <div class="w3-col s4">
                      <img src="https://www.w3schools.com/w3images/avatar2.png" class="w3-circle w3-margin-right" style="width:46px">
                  </div>
                  <div class="w3-col s8 w3-bar">
                      <span class="w3-xlarge">Welcome, <strong>Mohan</strong></span><br>
                      <a href="/dashboard"><i title ="Home" class="w3-text-indigo w3-margin fa fa-home" style="font-size:24px;"></i></a>
                      <i title ="Profile" class="w3-text-red  fa fa-user" style="font-size:24px;"></i>
                      <i title ="Mailbox" class="w3-text-green w3-margin fa fa-envelope" style="font-size:24px;"></i>
                      <i title ="Notifcations" class="w3-text-blue fa fa-bell" style="font-size:24px;"></i>
                  </div>
              </div>
              <hr>
              <div class="w3-container">
                  <h5 class="w3-xlarge"><?php echo $$strings['dashboard']?></h5>
              </div>
              <div class="w3-bar-block sidenav">
                  <a href="/add/class" class="w3-bar-item w3-button w3-padding w3-large"><i class="fa fa-book fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo $$strings['addclass']?></a>
                  <a href="/add/student" class="w3-bar-item w3-button w3-padding w3-large"><i class="fa fa-user-plus fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo $$strings['addstud']?></a>
                  <!-- <a href="/add/school" class="w3-bar-item w3-button w3-padding w3-large"><i class="fa fa-clock-o fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo $$strings['timetable']?></a>
                  <a href="#" class="w3-bar-item w3-button w3-padding w3-large"><i class="fa fa-calendar fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo $$strings['calendar']?></a> -->
                  <a href="/manage/articles" class="w3-bar-item w3-button w3-padding w3-large"><i class="fa fa-comment fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo $$strings['articles']?></a>
                  <a href="#" class="w3-bar-item w3-button w3-padding w3-xlarge"><i class="fa fa-cloud fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo 'Archives'?></a>
                  <a href="/webrtc" class="w3-bar-item w3-button w3-padding w3-xlarge"><i class="fa fa-laptop fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo 'Online Classes'?></a>
                  <a href="#" class="w3-bar-item w3-button w3-padding w3-xlarge"><i class="fa fa-laptop fa-fw w3-xlarge w3-text-blue"></i>&nbsp; <?php echo 'Online Exams'?></a>
              </div>
          </nav>
        <?php
      }
    ?>
    <style>
        .sidenav a{
            color: #636b6f!important;
            padding: 0 25px;
            font-size: 13px!important;
            font-weight: 600;
            text-decoration: none;
            text-transform: uppercase;
            font-family: 'Nunito', sans-serif;
        }
    </style>
