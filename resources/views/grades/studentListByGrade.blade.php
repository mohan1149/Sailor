<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Sailor | Manage Grades</title>
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
                <li><a href="">Students List</a></li>
                <li><?php echo $_GET['grade']?></li>
                </ul>
            </header>
            <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
                <div class="school-tables"> 
                    <table class="w3-table w3-bordered w3-padding w3-margin">
                        <tr>
                            <th><i class="w3-text-purple w3-large fa fa-id-badge"></i> Student ID</th>
                            <th><i class="w3-text-purple w3-large fa fa-black-tie"></i> Full Name</th>
                            <th><i class="w3-text-purple w3-large fa fa-male"></i> Father Name</th>
                            <th><i class="w3-text-purple w3-large fa fa-female"></i> Mother Name</th>
                            <th><i class="w3-text-purple w3-large fa fa-phone"></i> Phone</th>
                            <th><i class="w3-text-purple w3-large fa fa-envelope"></i>  Email</th>
                        </tr>
                        <?php  
                            foreach ($students as $key => $student) {
                                ?>
                                    <tr>
                                        <td><?php echo $student->sid?></td>
                                        <td><?php echo $student->fname.' ' .$student->lname?></td>
                                        <td><?php echo $student->father_name?></td>
                                        <td><?php echo $student->mother_name?></td>
                                        <td><?php echo $student->phone?></td>
                                        <td><?php echo $student->email ?></td>
                                    </tr>
                                <?php
                            }
                        ?>
                    </table>          
                </div>
            </div>
        </div>
    </body>
</html>
