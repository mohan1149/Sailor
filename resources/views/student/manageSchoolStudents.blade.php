
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Sailor | Manage Students</title>
        <!-- Styles -->
        <style>
            .menu{
                display:none;
            }
            h3,h4{
                color:#636b6f;
                font-weight:200 !important;
                font-family: 'Nunito', sans-serif !important;
                text-transform:uppercase;
            }
            td{
                font-weight:200 !important;
                font-family: 'Nunito', sans-serif !important;
            }
            .menu-item{
                margin-bottom: 16px;
            }
            .menu-item div{
                background:#fff;
            }
            .menu-item .fa{
                color: rgb(61, 94, 161);
            }
            .title{
                font-family: 'Nunito', sans-serif;
                font-weight:200;
                font-size:30px;
                margin-top:5px;
            }
            .active{
                display:block;
            }
            .inactive{
                display:none!important;
            }
            .active-inner{
                display:block;
            }
            .inactive-inner{
                display:none!important;
            }
            .class-show{
                margin-left:16px;
                width:90%!important;
                margin-top:5px;
                margin-bottom:5px;
            }
            .search-container{
              width: 40vw;
              margin: 10px;
              border: 2px solid grey;
            }
            .student-search{
              border: none;
              width: 90%;
              padding: 10px;
            }
            .year-sort{
              cursor: pointer;
            }
            .class-sort{
              cursor: pointer;
            }
        </style>
    </head>
    <header class='w3-top'>
        @include('header')
    </header>
    <body class="w3-light-grey">
    <!-- Sidebar/menu -->
    @include('school.dashboardSidebar')
    <div class="w3-main"  style="margin-left:310px;margin-top:43px;margin-right:10px;">
        <header class="w3-container w3-margin" style="padding-top:22px">
          <ul class="breadcrumb">
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="">Manage Students</a></li>
          </ul>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="school-tables">
            <div>
                    <?php
                        if(count($response_data) !=0 ){
                          foreach($response_data as $student){
                              ?>
                                  <div class="w3-container w3-margin w3-accordion">
                                      <button class="w3-indigo  w3-button w3-block w3-left-align staff-show" id ="student-<?php echo $student['school_id']?>">
                                          <?php echo $student['school_name']; ?>
                                          <i class="fa fa-plus w3-right"></i>
                                      </button>
                                      <div class="inactive w3-table w3-bordered w3-margin w3-accordion-content content-table student-<?php echo $student['school_id']?>">
                                        <?php
                                            if(count($student['school_years']) !=0){
                                                foreach ($student['school_years'] as $year) {
                                                ?>
                                                    <button class="w3-indigo w3-button w3-block w3-left-align class-show" id ="year-<?php echo $year['year_id']?>">
                                                        <?php echo $year['year_name']; ?>
                                                        <i class="fa fa-plus w3-right"></i>
                                                    </button>
                                                    <div class="inactive-inner w3-margin w3-accordion-content content-table-inner year-<?php echo $year['year_id']?>">
                                                      <div class="search-container">
                                                        <input type="text" class="search" placeholder="Search student..."> <i class="fa fa-search"></i>
                                                      </div>
                                                      <table style='text-align:center;width:90%' class=" searchable w3-table w3-bordered student-data-table">
                                                          <tr class="w3-white">
                                                              <th><i class='fa fa-id-badge w3-text-purple w3-xlarge'></i> ID</th>
                                                              <th><i class='fa fa-user w3-text-purple w3-xlarge'></i> Full Name</th>
                                                              <th><i class='fa fa-phone w3-text-purple w3-xlarge'></i> Phone</th>
                                                              <th><i class='fa fa-envelope w3-text-purple w3-xlarge'></i> Email</th>                                                              
                                                              <th class="class-sort"><i class='fa fa-book w3-text-purple w3-xlarge'></i> Class <i class="fa fa-sort"></i></th>

                                                          </tr>
                                                          <?php
                                                              if(count($year['year_students']) == 0){
                                                                  ?>
                                                                      <tr>
                                                                          <td>
                                                                              <i class="fa fa-exclamation-triangle w3-text-red w3-xlarge"></i><span> No Student added.</span>
                                                                          </td>
                                                                      </tr>
                                                                  <?php
                                                              }else{
                                                                  if(count($year['year_students']) != 0){
                                                                      foreach($year['year_students'] as $key => $student){
                                                                          ?>
                                                                              <tr>
                                                                                  <td><?php echo $student->sid?></td>
                                                                                  <td><?php echo $student->fname.' '.$student->lname?></td>
                                                                                  <td><?php echo $student->phone?></td>
                                                                                  <td><?php echo $student->email?></td>
                                                                                  <td><?php echo $student->class_name?></td>
                                                                                  <td><a href='/edit/student/<?php echo base64_encode($student->id)?>' class='w3-xlarge w3-text-blue' title='Edit'><i class="fa fa-edit"></i></a></td>
                                                                                  <td><a href='/view/student/<?php echo base64_encode($student->id)?>' class='w3-xlarge w3-text-purple' title='View'><i class="fa fa-eye"></i></a></td>
                                                                                  <td><a href='javascript:void(0)' url = "/delete/student/<?php echo $student->id ?>" class='w3-xlarge w3-text-red delete-button' title='Delete'><i class="fa fa-trash"></i></a></td>
                                                                              </tr>
                                                                          <?php
                                                                      }
                                                                  }else{
                                                                      ?>
                                                                          <tr>
                                                                              <td>
                                                                                  <p><i class="fa fa-exclamation-triangle w3-xlarge"></i>  No student has added. <a href="/add/student">Click here to add</a></p>
                                                                              </td>
                                                                          </tr>
                                                                      <?php
                                                                  }
                                                              }
                                                          ?>
                                                      </table>
                                                    </div>
                                                <?php
                                                }
                                            }else{
                                            ?>
                                              <div class=" w3-container">
                                                    <p><i class="fa fa-exclamation-triangle w3-xlarge w3-text-red"></i> Data does not exist.</p>
                                              </div>
                                            <?php
                                          }
                                        ?>
                                      </div>
                                  </div>
                              <?php
                          }
                        }else{
                          ?>
                              <div class="w3-panel w3-red">
                                  <p>
                                      <i class="fa fa-exclamation-triangle w3-jumbo"></i>
                                        NO STUDENT HAS ADDED TO SAILOR SYSTEM.
                                        <a class="" href="/add/student">CLICK HERE TO TO ADD</a>
                                  </p>
                              </div>
                          <?php
                        }
                    ?>
                </div>
            </div>
        </div>
        <!-- delete modal start -->
        <div class="w3-modal delete-modal" id="delete-modal">
            <div class="w3-modal-content w3-animate-top w3-card-4">
                <header class="w3-container w3-indigo">
                    <span onclick="document.getElementById('delete-modal').style.display='none'"
                        class="w3-button w3-xlarge w3-display-topright">&times;</span>
                    <h2>Are you sure to Delete?</h2>
                </header>
                <div class="w3-container">
                    <p class="w3-dark-text-grey w3-xlarge">Once you delete,all class related information such as staff linked,students will be removed from the Sailor System.</p>
                    <button class="w3-red w3-margin w3-button w3-xlarge delete-confirm">Sure! Delete</button>
                    <button class="w3-green w3-margin w3-button w3-xlarge" onclick="document.getElementById('delete-modal').style.display='none'" >Cancel</button>
                </div>
                <footer class="w3-container w3-dark-grey">
                    <p>@Sailor Sytem </p>
                </footer>
            </div>
        </div>
        <!-- end -->
    </div>
    </body>
    <footer class='footer w3-bottom'>
        @include('footer')
    </footer>
    <script src="/sortElements.js"></script>
</html>
