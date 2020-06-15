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
        <title>Sailor | Import Students</title>
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
            window.school_data = <?php echo json_encode($return_data)?>;
            function showSchoolInfo(){
                $('#bio-info').hide('slow');
                $('#school-info').show();
            }
            function updateClass(ins_key){
                let year_key = $($('.grade')[0].selectedOptions[0]).attr('id');                
                let classes = window.school_data[ins_key].school_years[year_key].year_classes;
                let class_select = "<select class='form-input classes-by-year' name='class'>";
                classes.map(function(class_data){
                    class_select += "<option value="+class_data.id+">"+class_data.class_name+"</option>";
                });
                class_select += "</select>";
                $('.classes-by-year').replaceWith(class_select);
            }          
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
            <li><a href="">Import Students</a></li>
          </ul>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="add-institute">                
                <form action='/import/students' method="POST" enctype="multipart/form-data">
                    @csrf
                        <div id = "data-import">
                            <div class='form-group'>
                                <span><i class='fa fa-bank w3-xlarge w3-text-blue'></i></span>
                                <select required class="form-input school_change" name='school_id'>
                                <option value="0">School</option>
                                      <?php
                                          foreach($return_data as $key => $school){                                          
                                              ?>
                                                <option id="<?php echo $key; ?>" value= "<?php echo $school['school_id'];?>" ><?php echo $school['school_name'] ?></option>
                                            <?php
                                      }
                                  ?>
                              </select>
                          </div>
                          <div class='form-group'>
                              <span><i class='fa fa-calendar w3-xlarge w3-text-blue'></i></span>
                              <select class="form-input grade" name='grade'>
                                  <option>Grade (Year of Study)</option>
                              </select>
                          </div>
                          <div class='form-group'>
                              <span><i class='fa fa-book w3-xlarge w3-text-blue'></i></span>
                              <select  class="form-input classes-by-year" name='class'>
                                  <option>Student Class</option>
                              </select>
                          </div>
                          <div class='form-group'>
                            <span><i class='fa fa-upload w3-text-blue w3-xlarge'></i></span>
                            <input type='file' name='data_file' class="form-input">
                            <span><i class='fa fa-refresh w3-hide loader w3-spin w3-text-blue w3-xlarge'></i></span>                        
                        </div>                          
                          <div class='form-group' style='text-align:center'>
                              <input class="w3-button  form-input form-submit" type='submit' value="Import">
                          </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
    </body>
</html>
