<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Sailor | Manage Departments</title>
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
            <b class="w3-xlarge"><i class="fa fa-cogs w3-text-blue w3-xlarge"></i> Manage Departments</b>
            <a href="/add/department"class="w3-button w3-xlarge"><i class="fa fa-plus w3-text-blue w3-xlarge"></i> Add Department</a>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="school-tables">
            <div>
                    <?php 
                        foreach($deps as $dep){
                            ?>
                                <div class="w3-container w3-margin w3-accordion">
                                    <button class="w3-blue w3-xlarge w3-button w3-block w3-left-align staff-show" id ="school-<?php echo $dep[0]->id?>">
                                        <?php echo $dep[0]->school_name; ?>
                                        <i class="fa fa-chevron-down w3-right-align"></i>
                                    </button>
                                    <table width='100%' style='text-align:center' class="inactive w3-table w3-margin w3-accordion-content content-table school-<?php echo $dep[0]->id?>">
                                        <tr class="w3-white">
                                            
                                            <th><i class='fa fa-user w3-text-purple w3-xlarge'></i> Department Name</th>
                                            <th><i class='fa fa-envelope w3-text-purple w3-xlarge'></i> Department Email</th>
                                            <th><i class='fa fa-globe w3-text-purple w3-xlarge'></i> Department Website</th>
                            
                                        </tr>
                                        <?php 
                                            foreach($dep as $dep_data){
                                                ?>   
                                                    <tr>
                                                        <td><?php echo $dep_data->d_name?></td>
                                                        <td><?php echo $dep_data->email?></td>
                                                        <td><?php echo $dep_data->website?></td>
                                                        <td><a href="/edit/department/<?php echo base64_encode($dep_data->id)?>"class='w3-button w3-blue'>Edit</a></td>
                                                        <td><a href="/delete/department/<?php echo base64_encode($dep_data->id)?>"class='w3-button w3-red'>Delete</a></td>
                                                    </tr>
                                                <?php
                                            }
                                        ?>
                                    </table>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
            <div class="w3-center">                        
                <button class="w3-button w3-green w3-margin pager-prev">Prev</button>
                <button class="w3-button w3-green w3-margin pager-next">Next</button>
            </div>
        </div>
    </div>
    </body>
    <footer class='footer w3-bottom'>
        @include('footer')
    </footer>
</html>