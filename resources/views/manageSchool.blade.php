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
        <header class="w3-container" style="padding-top:22px">
            <h5><b><i class="fa fa-cogs w3-text-blue"></i> Manage Institutes</b></h5>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="school-tables">
                <table class="w3-striped w3-padding w3-responsive w3-bordered w3-table">
                    <tr class="w3-white">
                        <th><i class='fa fa-list'></i> ID</th>
                        <th><i class='fa fa-bank'></i> Name</th>
                        <th><i class='fa fa-phone'></i> Phone</th>
                        <th><i class='fa fa-envelope'></i> Email</th>
                        <th><i class='fa fa-globe'></i> Website</th>
                    </tr>
                    <?php 
                        foreach($schools as $school)
                            {
                            ?>
                                <tr>
                                    <td><?php echo $school->id ?></td>
                                    <td><?php echo $school->school_name ?></td>
                                    <td><?php echo $school->phone ?></td>
                                    <td><a href="mailto:<?php echo $school->email ?>"><?php echo $school->email ?></a></td>
                                    <td><a href="<?php echo $school->website ?>"><?php echo $school->website ?></a></td>
                                    <!-- <td><?php echo $school->school_address ?></td> -->
                                    <!-- <td><img width="38px" class='school_logo'src="<?php echo $school->logo_path ?>"></td> -->
                                    <td>
                                        <a class="w3-indigo w3-button" href="/api/view/school/<?php echo $school->id ?>">View <i class="fa fa-eye"></i></a>
                                    </td>
                                    <td>
                                        <a class="w3-blue w3-button" href="/api/edit/school/<?php echo $school->id ?>">Edit <i class="fa fa-pencil"></i></a>
                                    </td>
                                    <td>
                                        <a class="w3-red w3-button" href="/api/delete/school/<?php echo $school->id ?>">Delete <i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php
                        }
                    ?>
                </table>
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