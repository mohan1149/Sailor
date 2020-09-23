<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/paginate.css">     
        <link rel="stylesheet" href="css/ligne.css">   
        <title>Sailor | Classes List</title>
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
        <script src="/js/paginate.js" ></script>  
    </header>
    <body class="w3-light-grey">
    <!-- Sidebar/menu -->
    @include('school.dashboardSidebar')
    <div class="w3-main"  style="margin-left:310px;margin-top:43px;margin-right:10px;">
        <header class="w3-container w3-margin" style="padding-top:22px">
          <ul class="breadcrumb">
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href=""><?php echo $classes['ins_name']; ?></a></li>
            <li>Classes List</li>
          </ul>            
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card w3-padding-32">
            <div class="school-tables">
                <div class="search-container">
                    <input type="text" id="search" class="search" placeholder="Search here..."> <i class="fa fa-search"></i>
                </div>  
                <table class="w3-padding w3-bordered w3-table myTable">
                    <tr class="w3-white">
                        <th class="w3-text-grey"><i class='fa fa-diamond w3-text-purple w3-xlarge'></i><span class="w3-small"> Section </span></th>                        
                        <th class="w3-text-grey"><i class='fa fa-list w3-text-purple w3-xlarge'></i><span class="w3-small"> No.of Subjects</span></th>
                        <th class="w3-text-grey"><i class='fa fa-book w3-text-purple w3-xlarge'></i><span class="w3-small"> Class</span></th>                        
                    </tr>
                    <?php
                        if(count($classes['classes']) == 0){
                            ?>
                                <tr>
                                    <td>
                                        <i class="w3-text-red w3-xlarge fa fa-exclamation-triangle"></i> No classes added
                                    </td>
                                </tr>
                            <?php
                        }else{
                            foreach($classes['classes'] as $class)
                            {
                            ?>
                                <tr>
                                    <td class="w3-large"><?php echo $class->class_name ?></td>
                                    <td class="w3-large"><?php echo $class->class_num_subjects ?></td>     
                                    <td class="w3-large"><?php echo $class->grade_year ?></td>     
                                    <td class="w3-large"><a href="/view/class/<?php echo base64_encode($class->id)?>"><i class="w3-text-indigo fa fa-eye w3-xlarge"></i></a></td>   
                                </tr>
                            <?php
                        }
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
    </body>
        <footer>
        <script>                    
            let options = {
                numberPerPage:12, 
                //goBar:true, 
                //pageCounter:true, 
            };
            let filterOptions = {
                el:'#search' 
            };
            paginate.init('.myTable',options,filterOptions);
        </script>
    </footer>
</html>
