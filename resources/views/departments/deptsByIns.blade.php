<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Sailor | Manage schools</title>
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
    @include('college.dashboardSidebar')
    <div class="w3-main"  style="margin-left:310px;margin-top:43px;margin-right:10px;">
        <header class="w3-container w3-margin" style="padding-top:22px">
          <ul class="breadcrumb">
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href=""><?php echo $depts['ins_name']; ?></a></li>
            <li>Departments List</li>
          </ul>            
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="school-tables">
                <table class="w3-padding  w3-bordered w3-table">
                    <tr class="w3-white">                        
                        <th class="w3-text-grey"><i class='fa fa-share-alt w3-text-purple w3-xlarge'></i><span class="w3-small"> Name</span></th>                        
                        <th class="w3-text-grey"><i class='fa fa-envelope w3-text-purple w3-xlarge'></i><span class="w3-small"> Email</span></th>
                        <th class="w3-text-grey"><i class='fa fa-globe w3-text-purple w3-xlarge'></i><span class="w3-small"> Website</span></th>                        
                    </tr>
                    <?php
                        if(count($depts['ins']) == 0){
                            ?>
                                <tr>
                                    <td>
                                        <i class="w3-text-red w3-xlarge fa fa-exclamation-triangle"></i> No Schools added
                                    </td>
                                </tr>
                            <?php
                        }else{
                            foreach($depts['ins'] as $dept)
                            {
                            ?>
                                <tr>
                                    <td class="w3-large"><?php echo $dept->dept_name ?></td>
                                    <td class="w3-large"><?php echo $dept->dept_email ?></td>
                                    <td class="w3-large"><?php echo $dept->dept_website ?></td>                                    
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
    <footer class='footer w3-bottom'>
        @include('footer')
    </footer>
</html>
