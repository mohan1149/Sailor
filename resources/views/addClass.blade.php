<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>STM::Add Staff</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                /* color: #636b6f; */
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .title {
                font-size: 84px;
                color:#2196F3;
                margin-top:50px;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
            .form-group{
                border:3px solid #2196F3;
                margin:10px;
                border-radius:15px;
                padding-left:30px;

            }
            .form-group input{
                border:none;
                height:50px;
                width:100%;
                border-radius:25px;
                background:transparent;
                color:gray;
                font-size:20px;
            }
            .form-group span{
                color:#2196F3; 
            }
            .addClass-form{
                margin-bottom:80px;
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
                    Add class to STM system
                </div>
                <div class='addClass-form'>
                    <form action='/api/add/time-table' method="POST">
                        <div class='form-group'>
                            <span><i class='fa fa-book'></i></span>
                            <input type='text' autofocus name='className' placeholder='Ex: X-Spark' >
                            <h5><strong>Note:</strong>Add a meaningfull class label.[class-section]</h5>
                        </div>
                        <div class='form-group'>
                            <span><i class='fa fa-bank'></i></span>
                            <select class="w3-input"name='school_id'style='width:95%;border-radius:50px;background:transparent;border:none;height:50px;color:gray;font-size:20px'>
                            <option>School</option>
                                <?php
                                    foreach($schools as $school){
                                        ?>
                                            <option value=<?php echo $school->id;?>><?php echo $school->school_name ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <span><i class='fa fa-book'></i></span>
                            <input type='tel' name='subjects' class="subjects" placeholder='Number of subjects' >
                        </div>
                        <div class="w3-row">
                            <div class="w3-half grid1">
                            </div>
                            <div class="w3-half grid2">
                            </div>
                        </div>
                        <div class='form-group' style='text-align:center'>
                            <input type='submit' value="Next">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
    <footer class='w3-bottom'>
        @include('footer')
    </footer>
</html>
