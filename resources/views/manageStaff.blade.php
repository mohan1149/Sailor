<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Sailor | Manage Institutes</title>
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
        </style>
    </head>
    <header class='w3-top'>
        @include('header')
    </header>
    <body class="w3-light-grey">
    <!-- Sidebar/menu -->
    @include('dashboardSidebar')
    <div class="w3-main"  style="margin-left:310px;margin-top:43px;margin-right:10px;">
        <header class="w3-container w3-margin" style="padding-top:22px">
            <a class=""><i class="fa fa-cogs w3-text-blue w3-xlarge"></i> Manage Staff</a>
            <a class="w3-button" href="/add/staff"><i class="fa fa-plus w3-text-blue "></i> Add Staff</a>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="school-tables">
            <div>
                    <?php
                        if(count($staff) !=0){
                            foreach($staff as $employee){
                                ?>
                                    <div class="w3-container w3-margin w3-accordion">
                                        <button class="w3-indigo w3-button w3-block w3-left-align staff-show" id ="school-<?php echo $employee[0]->id?>">
                                            <?php echo $employee[0]->school_name; ?>
                                            <i class="fa fa-plus w3-right"></i>
                                        </button>
                                        <table width='100%' style='text-align:center' class="inactive w3-table w3-margin w3-accordion-content content-table school-<?php echo $employee[0]->id?>">
                                            <tr class="w3-white">
                                                <th><i class='fa fa-list-ol w3-text-purple w3-xlarge'></i> Staff ID</th>
                                                <th><i class='fa fa-user w3-text-purple w3-xlarge'></i> Staff Name</th>
                                                <th><i class='fa fa-phone w3-text-purple w3-xlarge'></i> Staff Phone</th>
                                                <th><i class='fa fa-envelope w3-text-purple w3-xlarge'></i> Staff Email</th>
                                                <th><i class='fa fa-graduation-cap w3-text-purple w3-xlarge'></i> Designation</th>
                                            </tr>
                                            <?php
                                                foreach($employee as $employee_data){
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $employee_data->id?></td>
                                                            <td><?php echo $employee_data->username?></td>
                                                            <td><?php echo $employee_data->phone?></td>
                                                            <td><?php echo $employee_data->email?></td>
                                                            <td><?php echo $employee_data->designation?></td>                                                       <td><input type='button' class='w3-button w3-blue' value='Edit'></td>
                                                            <td><input type='button' class='w3-button w3-red' value='Delete'></td>
                                                        </tr>
                                                    <?php
                                                }
                                            ?>
                                        </table>
                                    </div>
                                <?php
                            }
                        }else{
                            ?>
                                <div class=" w3-red w3-container w3-margin">
                                    <p class="w3-xlarge"><i class="fa fa-exclamation-triangle w3-xxxlarge"></i>  No Staff Added <a href="/add/staff">Click here to add.</a></p>
                                </div>
                            <?php
                        }
                        
                    ?>
                </div>
            </div>
        </div>
    </div>
    </body>
    <footer class='footer w3-bottom'>
        @include('footer')
    </footer>
</html>
