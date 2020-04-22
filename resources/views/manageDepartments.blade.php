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
            <a class=""><i class="fa fa-cogs w3-text-blue w3-xlarge"></i> Manage Departments</a>
            <a href="/add/department"class="w3-button"><i class="fa fa-plus w3-text-blue "></i> Add Department</a>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="school-tables">
            <div>
                    <?php
                        foreach($deps as $dep){
                            ?>
                                <div class="w3-container w3-margin w3-accordion">
                                    <button class="w3-indigo w3-button w3-block w3-left-align staff-show" id ="school-<?php echo $dep[0]->id?>">
                                        <?php echo $dep[0]->school_name; ?>
                                        <i class="fa fa-plus w3-right"></i>
                                    </button>
                                    <table width='100%' style='text-align:center' class="inactive w3-table w3-margin w3-accordion-content content-table school-<?php echo $dep[0]->id?>">
                                        <tr class="w3-white">
                                            <th><i class='fa fa-user w3-text-purple w3-xlarge'></i> <span class="w3-small"> Department Name</span></th>
                                            <th><i class='fa fa-envelope w3-text-purple w3-xlarge'></i> <span class="w3-small"> Department Email</span></th>
                                            <th><i class='fa fa-globe w3-text-purple w3-xlarge'></i> <span class="w3-small"> Department Website</span></th>

                                        </tr>
                                        <?php
                                            foreach($dep as $dep_data){
                                                ?>
                                                    <tr>
                                                        <td><?php echo $dep_data->d_name?></td>
                                                        <td><?php echo $dep_data->email?></td>
                                                        <td><?php echo $dep_data->website?></td>
                                                        <td><a href="/edit/department/<?php echo base64_encode($dep_data->id)?>" title='Edit'><i class="w3-text-blue fa fa-edit w3-xlarge"></i></a></td>
                                                        <td><a href="javascript:void(0)"url="/delete/department/<?php echo $dep_data->id?>" title="Delete"class='del-dept'><i class="w3-text-red fa fa-trash w3-xlarge"></i></a></td>
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
                    <p class="w3-dark-text-grey w3-xlarge">Once you delete,all departmet related information such as Classes linked, Staff and Students will be removed from the Sailor System.</p>
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
</html>
