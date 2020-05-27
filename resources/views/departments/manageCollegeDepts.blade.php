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
    @include('college.dashboardSidebar')
    <div class="w3-main"  style="margin-left:310px;margin-top:43px;margin-right:10px;">
        <header class="w3-container w3-margin" style="padding-top:22px">
            <ul class="breadcrumb">
              <li><a href="/dashboard">Dashboard</a></li>
              <li><a href="">Manage Departments</a></li>
            </ul>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="department-tables">
                <div class="departments">                    
                    <?php
                        if(count($return_data) != 0){                                                         
                            foreach($return_data['colleges'] as $college){                                                  
                                ?>
                                    <div class="w3-container w3-margin w3-accordion">
                                        <button class="w3-indigo w3-button w3-block w3-left-align staff-show" id ="college-<?php echo $college['clg_id']; ?>">
                                            <?php echo $college['clg_name']; ?>
                                            <i class="fa fa-plus w3-right"></i>
                                        </button>
                                        <div class="inactive w3-margin w3-accordion-content content-table college-<?php echo $college['clg_id']?> ">
                                            <div class="search-container">
                                                <input type="text" class="search" placeholder="Search here..."> <i class="fa fa-search"></i>
                                            </div>                                            
                                            <table width='100%' style='text-align:center' class="searchable w3-table">
                                                <tr class="w3-white">
                                                    <th><i class='fa fa-user w3-text-purple w3-xlarge'></i> <span class="w3-small"> Department Name</span></th>
                                                    <th><i class='fa fa-envelope w3-text-purple w3-xlarge'></i> <span class="w3-small"> Department Email</span></th>
                                                    <th><i class='fa fa-globe w3-text-purple w3-xlarge'></i> <span class="w3-small"> Department Website</span></th>
                                                    <th><i class='fa fa-tag w3-text-purple w3-xlarge'></i> <span class="w3-small"> Department ID</span></th>
                                                </tr>
                                                <?php
                                                    foreach($college['clg_depts'] as $dep_data){                                                    
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $dep_data->dept_name?></td>
                                                                <td><?php echo $dep_data->dept_email?></td>
                                                                <td><?php echo $dep_data->dept_website?></td>
                                                                <td><?php echo $dep_data->id?></td>
                                                                <td><a target="_blank"  href="/view/department/<?php echo base64_encode($dep_data->id)?>" title='View'><i class="w3-text-indigo fa fa-eye w3-xlarge"></i></a></td>
                                                                <td><a target="_blank"  href="/edit/department/<?php echo base64_encode($dep_data->id)?>" title='Edit'><i class="w3-text-blue fa fa-edit w3-xlarge"></i></a></td>
                                                                <td><a href="javascript:void(0)"url="/delete/department/<?php echo $dep_data->id?>" title="Delete"class='delete-button'><i class="w3-text-red fa fa-trash w3-xlarge"></i></a></td>
                                                            </tr>
                                                        <?php
                                                    }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                <?php
                            }
                        }
                        else{
                            ?>
                                <div class=" w3-red w3-container w3-margin">
                                    <p class="w3-xlarge"><i class="fa fa-exclamation-triangle w3-xxxlarge"></i>  No Department has added. <a href="/add/department">Click here to add.</a></p>
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
