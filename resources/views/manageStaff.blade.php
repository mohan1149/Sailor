<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>STM::Manage Staff</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Styles -->
        <style>
            html, body {
                /* background-color: ; */
                /* color: #636b6f; */
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            legend{
                color:teal;
                font-size:25px;
                font-family:bold;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
                margin-top:50px;
            }

            .title {
                font-size: 84px;
                color:#636b6f;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
            td{
                font-size:20px;
            }
        </style>
    </head>
    <header class='w3-top'>
        @include('header')
    </header>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Manage staff added to your STM system
                </div>
                <div>
                    <?php 
                        foreach($staff as $employee){
                            ?>
                                <fieldset>
                                    <legend><?php echo $employee[0]->school_name; ?></legend>
                                        <table width='100%' style='text-align:center' class="w3-table">
                                            <tr class="w3-white">
                                                <th><i class='fa fa-list-ol'></i> Staff ID</th>
                                                <th><i class='fa fa-user'></i> Staff Name</th>
                                                <th><i class='fa fa-phone'></i> Staff Phone</th>
                                                <th><i class='fa fa-envelope'></i> Staff Email</th>
                                                <th><i class='fa fa-graduation-cap'></i> Designation</th>
                                                <th><i class='fa fa-book'></i> Main Field</th>
                                                <th><i class='fa fa-clipboard'></i> Class Teacher</th>
                                            </tr>
                                            <?php 
                                                foreach($employee as $employee_data){
                                                    ?>   
                                                        <tr>
                                                            <td><?php echo $employee_data->id?></td>
                                                            <td><?php echo $employee_data->username?></td>
                                                            <td><?php echo $employee_data->phone?></td>
                                                            <td><?php echo $employee_data->email?></td>
                                                            <td><?php echo $employee_data->designation?></td>
                                                            <td><?php echo $employee_data->main_field?></td>
                                                            <td><?php echo $employee_data->class_teacher_for?></td>
                                                            <td><input type='button' class='w3-button w3-blue' value='Edit'></td>
                                                            <td><input type='button' class='w3-button w3-red' value='Delete'></td>
                                                        </tr>
                                                    <?php
                                                }
                                            ?>
                                        </table>  
                                </fieldset>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
    <footer class='w3-bottom'>
        @include('footer')
    </footer>
</html>
