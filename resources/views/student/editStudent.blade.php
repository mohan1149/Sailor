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
        <title>Sailor | Add Student</title>
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
            #school-info{
              display: none;
            }
        </style>
        <script>
          function showSchoolInfo(){
            $('#bio-info').hide();
            $('#school-info').show();
          }
          function getGrades(){
            var id = $('.department').val();
            axios.get('/get/classes/' + id)
            .then(function(response){
              let classes = "<select class='form-input classes-by-dept' name='class'>";
              response.data.map((data)=>{
                  classes+= "<option value="+data.id+">"+ data.value+"</option>"
              })
              classes+= "</select>";
              $('.classes-by-dept').replaceWith(classes);
            });
          }
        </script>
    </head>
    <header class='w3-top'>
        @include('header')
    </header>
    <body class="w3-light-grey">
    <!-- Sidebar/menu -->
    @if($_SESSION['ins'] == 'college')
        @include('college.dashboardSidebar')
    @else
        @include('school.dashboardSidebar')
    @endif    
    <div class="w3-main"  style="margin-left:310px;margin-top:43px;margin-right:10px;">
        <header class="w3-container" style="padding-top:22px">
            <ul class="breadcrumb">
              <li><a href="/dashboard">Dashboard</a></li>
              <li><a href="/manage/students">Manage Students</a></li>
              <li><a href="">Edit Student</a></li>
              <li><?php echo $student->fname; ?></li>
            </ul>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="add-institute">                         
                <form action='/update/student/<?php echo $student->id?>' method="POST" enctype="multipart/form-data">
                    @csrf
                        <div id = "bio-info">
                          <div class='form-group'>
                              <span><i class='fa fa-id-badge w3-xlarge w3-text-blue'></i></span>
                              <input value="<?php echo $student->sid?>" class="form-input" type='text' name='reg-id' placeholder='student id' >
                          </div>
                          <div class='form-group'>
                              <span><i class='fa fa-user w3-xlarge w3-text-blue'></i></span>
                              <input value="<?php echo $student->fname ?>" class="form-input" type='text' name='fname' placeholder='first name' >
                          </div>
                          <div class='form-group'>
                              <span><i class='fa fa-user w3-xlarge w3-text-blue'></i></span>
                              <input value="<?php echo $student->lname?>" class="form-input" type='text' name='lname' placeholder='last name' >
                          </div>
                          <div class='form-group'>
                              <span><i class='fa fa-venus-mars w3-xlarge w3-text-blue'></i></span>
                              <select  class="form-input" name='gender'>
                                <option vlaue="-1">Gender</option>
                                <option vlaue="Male">Male</option>
                                <option value="Female">Female</option>
                              </select>
                          </div>
                          <div class='form-group'>
                              <span><i class='fa fa-male w3-xlarge w3-text-blue'></i></span>
                              <input value="<?php echo $student->father_name?>" class="form-input" type='text' name='father' placeholder='father name' >
                          </div>
                          <div class='form-group'>
                              <span><i class='fa fa-female w3-xlarge w3-text-blue'></i></span>
                              <input value="<?php echo $student->mother_name?>" class="form-input" type='text' name='mother' placeholder='mother name' >
                          </div>
                          <div class='form-group'>
                              <span><i class='fa fa-phone w3-xlarge w3-text-blue'></i></span>
                              <input value="<?php echo $student->phone?>" class="form-input" type='tel' placeholder='phone' name='phone'>
                          </div>
                          <div class='form-group'>
                              <span><i class='fa fa-envelope w3-xlarge w3-text-blue'></i></span>
                              <input value="<?php echo $student->email?>"  class="form-input"  type='email' placeholder='email' name='email'>
                          </div>
                          <div class='form-group'>
                              <span><i class='fa fa-map-marker w3-xlarge w3-text-blue'></i></span>
                              <input value="<?php echo $student->address?>"   class="form-input" type='text' placeholder='address' name='address'>
                          </div>
                          <div class='form-group'>
                              <span><i class='fa fa-image w3-text-blue w3-xlarge'></i></span>
                              <input type='file' name='photo'accept="image/*" class="form-input">
                          </div>
                          <div class='form-group' style='text-align:center'>
                              <input  class="w3-button form-input form-submit" type='submit' value="Update">
                          </div>                          
                        </div>                        
                    </form>
            </div>
        </div>
    </div>
    </body>    
</html>
