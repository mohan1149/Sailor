<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Sailor | Manage schools</title>
        <!-- Styles -->
        <style>
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
            th{
                text-transform:uppercase;
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
            <li><a href="/school/dashboard">Dashboard</a></li>
            <li><a href="">Manage Schools</a></li>
          </ul>            
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="school-tables">
                
                <?php
                    if(count($schools) != 0){
                        foreach($schools as $school){
                            ?>
                                <div class="w3-container">
                                    <div class="w3-round w3-margin w3-padding w3-left">
                                        <div class="">
                                            <img class="w3-animate w3-animate-left" width="15%" src="<?php echo $school->school_logo?>">
                                            <span class="w3-xlarge"><?php echo $school->school_name; ?></span>
                                        </div>
                                        <div class="w3-margin">                                         
                                            <p>
                                                <strong class="w3-half"><i class="fa fa-list w3-text-purple fa-fw"></i>REG ID</strong>
                                                <span><?php echo $school->school_reg_num ?></span>
                                            </p>
                                            <p>
                                                <strong class="w3-half"><i class="fa fa-phone w3-text-purple fa-fw"></i>PHONE</strong>
                                                <span><?php echo $school->school_phone ?></span>
                                            </p>
                                            <p>
                                                <strong class="w3-half"><i class="fa fa-envelope w3-text-purple fa-fw"></i>EMAIL</strong>
                                                <span><?php echo $school->school_email ?></span>
                                            </p>
                                            <p>
                                                <strong class="w3-half"><i class="fa fa-globe w3-text-purple fa-fw"></i>WEBSITE</strong>
                                                <span><?php echo $school->school_website ?></span>
                                            </p>
                                        </div>                                     
                                    </div>
                                    <div class="w3-round w3-margin w3-padding w3-border w3-right">
                                        <a target="_blank" title="View"class="w3-text-indigo w3-margin" href="/view/school/<?php echo base64_encode($school->id) ?>"> <i class="fa fa-eye w3-xlarge"></i></a>
                                        <a target="_blank" title="Edit"class="w3-text-blue w3-margin" href="/edit/school/<?php echo base64_encode($school->id) ?>"> <i class="fa fa-edit w3-xlarge"></i></a>
                                        <a title="Delete" class="w3-text-red delete-button w3-margin" href="javascript:void(0)" url="/delete/school/<?php echo $school->id ?>"> <i class="fa fa-trash w3-xlarge"></i></a>
                                    </div>
                                </div>
                                <hr style="border:3px solid grey;">
                            <?php
                        }
                    }else{
                        ?>
                            <p class="w3-panel w3-red">
                                Data not available.
                            </p>
                        <?php
                    }
                ?>                
            </div>
        </div>
    </div>

    <!-- delete modal -->
    <div class="w3-modal delete-modal" id="delete-modal">
        <div class="w3-modal-content w3-animate-top w3-card-4">
            <header class="w3-container w3-indigo">
                <span onclick="document.getElementById('delete-modal').style.display='none'"
                    class="w3-button w3-xlarge w3-display-topright">&times;</span>
                <h2>Are you sure to Delete?</h2>
            </header>
            <div class="w3-container">
                <p class="w3-dark-text-grey w3-xlarge">Once you delete,all school related information such as Departments, Classes, Staff and Students will be removed from the Sailor Syatem.</p>
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
    <footer class='footer'>
        <!-- @include('footer') -->
    </footer>
</html>
