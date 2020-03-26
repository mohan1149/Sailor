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
                    Manage Classes added to your STM system
                </div>
                <div>
                    <?php 
                        foreach($classes as $class){
                            if(isset($class[0]->school_name)){
                                ?>
                                    <fieldset>
                                        <legend><?php echo $class[0]->school_name; ?></legend>
                                        <table width='100%' style='text-align:center' class="w3-table">
                                            <tr class="w3-white">
                                                <th><i class='fa fa-list-ol'></i> Class ID</th>
                                                <th><i class='fa fa-user'></i> Class Teacher</th>
                                                <th><i class='fa fa-bank'></i> Class Name</th>
                                                <th><i class='fa fa-book'></i> Number of Subjects</th>
                                            </tr>
                                            <?php 
                                                foreach($class as $class_data){
                                                    ?>   
                                                        <tr>
                                                            <td><?php echo $class_data->id?></td>
                                                            <td><?php echo $class_data->class_teacher == -1 ? 'Not Assigned':'Added' ?></td>
                                                            <td><?php echo $class_data->value?></td>
                                                            <td><?php echo $class_data->num_subjects?></td>
                                                            <td>
                                                                <button class="w3-blue w3-button">Subjects <i class="fa fa-book"></i></button>
                                                            </td>
                                                            <td>
                                                                <button class="w3-green w3-button">Timetable <i class="fa fa-calendar"></i></button>
                                                            </td>
                                                            <td>
                                                                <button class="w3-indigo w3-button">Edit <i class="fa fa-pencil"></i></button>
                                                            </td>
                                                            <td>
                                                                <button class="w3-red w3-button">Delete <i class="fa fa-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                }
                                            ?>
                                        </table>  
                                </fieldset>
                                <?php
                            }
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
