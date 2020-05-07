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
    @include('dashboardSidebar')
    <div class="w3-main"  style="margin-left:310px;margin-top:43px;margin-right:10px;">
        <header class="w3-container w3-margin" style="padding-top:22px">
          <ul class="breadcrumb">
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="">Manage Institutes</a></li>
          </ul>            
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="school-tables">
                <table class="w3-padding w3-responsive w3-bordered w3-table">
                    <tr class="w3-white">
                        <th class="w3-text-grey"><i class='fa fa-list w3-text-purple w3-xlarge'></i><span class="w3-small"> Reg ID</span></th>
                        <th class="w3-text-grey"><i class='fa fa-bank w3-text-purple w3-xlarge'></i><span class="w3-small"> Name</span></th>
                        <th class="w3-text-grey"><i class='fa fa-phone w3-text-purple w3-xlarge'></i><span class="w3-small"> Phone</span></th>
                        <th class="w3-text-grey"><i class='fa fa-envelope w3-text-purple w3-xlarge'></i><span class="w3-small"> Email</span></th>
                        <th class="w3-text-grey"><i class='fa fa-globe w3-text-purple w3-xlarge'></i><span class="w3-small"> Website</span></th>
                    </tr>
                    <?php
                        foreach($schools as $school)
                            {
                            ?>
                                <tr>
                                    <td class="w3-large"><?php echo $school->reg_num ?></td>
                                    <td class="w3-large"><?php echo $school->school_name ?></td>
                                    <td class="w3-large"><?php echo $school->phone ?></td>
                                    <td class="w3-large"><a href="mailto:<?php echo $school->email ?>"><?php echo $school->email ?></a></td>
                                    <td class="w3-large"><a target="_blank"href="<?php echo $school->website ?>"><?php echo $school->website ?></a></td>
                                    <!-- <td><?php echo $school->school_address ?></td> -->
                                    <!-- <td><img width="38px" class='school_logo'src="<?php echo $school->logo_path ?>"></td> -->
                                    <td>
                                        <a title="View"class="w3-text-indigo" href="/view/school/<?php echo base64_encode($school->id) ?>"> <i class="fa fa-eye w3-xlarge"></i></a>
                                    </td>
                                    <td>
                                        <a title="Edit"class="w3-text-blue" href="/edit/school/<?php echo base64_encode($school->id) ?>"> <i class="fa fa-edit w3-xlarge"></i></a>
                                    </td>
                                    <td>
                                        <a title="Delete"class="w3-text-red delete-button" href="javascript:void(0)" url="/delete/school/<?php echo $school->id ?>"> <i class="fa fa-trash w3-xlarge"></i></a>
                                    </td>
                                </tr>
                            <?php
                        }
                    ?>
                </table>
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
    <footer class='footer w3-bottom'>
        @include('footer')
    </footer>
</html>
