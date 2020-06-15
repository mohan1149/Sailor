<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Sailor | Permissions</title>
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
                background-color:#2196F3 !important;
                color:#fff !important;
            }
            .active .fa{
                color:#fff !important;
            }
            .roles{
                display:none;
            }
            .perms{
                display:none;
            }
            .active-wrapper{
                display:block;
            }
            .inactive-wrapper{
                display:none;
            }
            .select-data-entry{
                display:none;
            }
            .select-admin{
                display:none;
            }
            .select-principal{
                display:none;
            }
            .select-hod{
                display:none;
            }
            .select-teaching-staff{
                display:none;
            }
            .perm_button{
                border-right: 2px solid darkgray !important;
            }
        </style>
        <script>
            window.school_data = <?php echo json_encode($return_data['institutes'])?>;
        </script>
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
          <li><a href="">Roles & Permissions</a></li>
        </ul>
      </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="w3-container">
                <div class="w3-white w3-margin">
                    <button id="users" class="active perm_button w3-button w3-xlarge">Users <i class="w3-text-indigo fa fa-users"></i></button>
                    <button id="roles" class="perm_button w3-button w3-xlarge">Roles <i class=" w3-text-indigo fa fa-user-secret"></i></button>
                    <button id="perms" class="perm_button w3-button w3-xlarge">Permissions <i class=" w3-text-indigo fa fa-lock"></i></button>
                </div>
                <hr>
                <div class="users perm_container active-wrapper">
                    <button class="w3-button w3-purple w3-margin-left assign-role">Assign Role To User</button>
                    <table class="w3-table w3-bordered">
                        <tr>
                            <th><i class="fa fa-user w3-text-indigo w3-xlarge"></i> Name</th>
                            <th><i class="fa fa-user-secret w3-text-indigo w3-xlarge"></i> Role</th>
                            <th><i class="fa fa-tag w3-text-indigo w3-xlarge"></i> Role Code</th>
                        </tr>
                        <?php
                            if(count($return_data['users']) == 0){
                                ?>
                                    <tr>
                                        <td>
                                            <i class="fa fa-exclamation-triangle w3-xlarge w3-text-red"></i> No Users are assigned to any roles.
                                        </td>
                                    </tr>
                                <?php
                            }
                            foreach($return_data['users'] as $user){
                                //print_r($user);
                                ?>
                                    <tr>
                                        <td><?php echo $user->emp_username ?></td>
                                        <td><?php echo strtoupper($user->role_name) ?></td>
                                        <td><?php echo $user->role_code ?></td>
                                    </tr>
                                <?php
                            }
                        ?>                   
                    </table>
                </div>
                <div class="roles perm_container">
                    <table class="w3-table w3-bordered">
                        <tr>                        
                            <th><i class="fa fa-user-secret w3-text-indigo w3-xlarge"></i> Role Name</th>
                            <th><i class="fa fa-tag w3-text-indigo w3-xlarge"></i> Role Code</th>
                        </tr>
                        <?php
                            foreach($return_data['roles'] as $role){
                                ?>
                                    <tr>
                                        <td><?php echo strtoupper($role->role_name) ?></td>
                                        <td><?php echo $role->role_code?></td>
                                    </tr>
                                <?php
                            }
                        ?>
                    </table>
                </div>
                <div class="perms perm_container">
                    <table class="w3-table w3-bordered">
                        <tr>
                            <th><i class="fa fa-lock w3-text-indigo w3-xlarge"></i> Permission </th>                        
                            <th><i class="fa fa-tag w3-text-indigo w3-xlarge"></i> Permission Code</th>
                        </tr>
                    </table>
                </div>                            
            </div>
            <!-- assign  role modal start -->
            <div class="w3-modal role-assign-modal" id="role-assign-modal">
                <div class="w3-modal-content w3-animate-top w3-card-4">
                    <header class="w3-container w3-indigo">
                        <span onclick="document.getElementById('role-assign-modal').style.display='none'"
                            class="w3-button w3-xlarge w3-display-topright">&times;</span>
                        <h2>Assign Role to User.!</h2>
                    </header>
                    <div class="w3-container">
                        <div class="w3-margin">
                            <select class="w3-input select-role">
                                <option>Role</option>
                                <?php 
                                    foreach($return_data['roles'] as $role){
                                        ?>
                                            <option value=<?php echo $role->role_code; ?> ><?php echo strtoupper($role->role_name) ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                            <div class="select-admin">
                                <select class="w3-input w3-margin-top 2">
                                    <option>User</option>
                                    <?php 
                                        foreach($return_data['emps'] as $emp){
                                            ?>
                                                <option value=<?php echo $emp->id; ?> ><?php echo $emp->emp_username ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="select-data-entry">
                                <select class="w3-input w3-margin-top 5">
                                    <option>User</option>
                                    <?php 
                                        foreach($return_data['emps'] as $emp){
                                            ?>
                                                <option value=<?php echo $emp->id; ?> ><?php echo $emp->emp_username ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="select-principal">
                                <select class="w3-input w3-margin-top 3">
                                    <option>User</option>
                                    <?php 
                                        foreach($return_data['emps'] as $emp){
                                            ?>
                                                <option value=<?php echo $emp->id; ?> ><?php echo $emp->emp_username ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <select class="w3-input w3-margin-top prin-school">
                                    <option>Institute</option>
                                    <?php 
                                        foreach($return_data['institutes'] as $institute){                                                                                       
                                            ?>
                                                <option value=<?php echo $institute['school_id']; ?> ><?php echo $institute['school_name'] ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="select-hod">
                                <select class="w3-input w3-margin-top 4">
                                    <option>User</option>
                                    <?php 
                                        foreach($return_data['emps'] as $emp){
                                            ?>
                                                <option value=<?php echo $emp->id; ?> ><?php echo $emp->emp_username ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <select class="w3-input w3-margin-top select-institute">
                                    <option>Institute</option>
                                    <?php 
                                        foreach($return_data['institutes'] as $key => $institute){
                                            ?>
                                                <option value = <?php echo $key?> ><?php echo $institute['school_name'] ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <select class="w3-input w3-margin-top select-dept">
                                    <option>Department</option>                                    
                                </select>
                            </div>
                            <div class="select-teaching-staff">
                                <select class="w3-input w3-margin-top ts-school">
                                    <option>Institute</option>
                                    <?php 
                                        foreach($return_data['institutes'] as $key => $institute){
                                            ?>
                                                <option value = <?php echo $institute['school_id'] ?> ><?php echo $institute['school_name'] ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <select class="w3-input w3-margin-top 6">
                                    <option>User</option>
                                    <?php 
                                        foreach($return_data['emps'] as $emp){
                                            ?>
                                                <option value=<?php echo $emp->id; ?> ><?php echo $emp->emp_username ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <button class="w3-indigo w3-margin w3-button w3-xlarge assign-confirm">Assign Role</button>
                        <button class="w3-red w3-margin w3-button w3-xlarge" onclick="document.getElementById('role-assign-modal').style.display='none'" >Cancel</button>
                    </div>
                    <footer class="w3-container w3-dark-grey">
                        <p>@Sailor Sytem </p>
                    </footer>
                </div>
            </div>
            <!-- end -->
        </div>
    </div>
    </body>
    <footer class='footer w3-bottom'>
        @include('footer')
    </footer>
</html>
