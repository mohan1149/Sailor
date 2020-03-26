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
                width:500px;
                border-radius:25px;
                background:transparent;
                color:gray;
                font-size:20px;
            }
            .form-group span{
                color:#2196F3; 
            }
        </style>
    </head>
    <header>
        @include('header')
    </header>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Add staff to STM system
                </div>
                <div class='signup-form'>
                    <form action='/api/manage/staff' method="POST">
                        <div class='form-group'>
                            <span><i class='fa fa-user'></i></span>
                            <input type='text' name='staffname' placeholder='staff name' >
                        </div>
                        <div class='form-group'>
                            <span><i class='fa fa-phone'></i></span>
                            <input type='tel' placeholder='phone' name='phone'>
                        </div>
                        <div class='form-group'>
                            <span><i class='fa fa-envelope'></i></span>
                            <input type='email' placeholder='email' name='email'>
                        </div>
                        <div class='form-group'>
                            <span><i class='fa fa-book'></i></span>
                            <input type='text' placeholder='designation' name='designation'>
                        </div>
                        <div class='form-group'>
                            <span><i class='fa fa-bank'></i></span>
                            <select name='school_id'style='width:95%;border-radius:50px;background:transparent;border:none;height:50px;color:gray;font-size:20px'>
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
                        <div class='form-group'>
                            <span><i class='fa fa-book'></i></span>
                            <select name='main_field'style='width:95%;border-radius:50px;background:transparent;border:none;height:50px;color:gray;font-size:20px'>
                                <option>Main Field</option>
                                <option>Telugu</option>
                                <option>Hindi</option>
                                <option>English</option>
                                <option>Mathematics</option>
                                <option>Science</option>
                                <option>Social</option>
                                <option>Computers</option>
                            </select>
                        </div>
                        <div class='form-group'>
                            <span><i class='fa fa-book'></i></span>
                            <select name='class_teacher_for' style='width:95%;border-radius:50px;background:transparent;border:none;height:50px;color:gray;font-size:20px'>
                                <option>Class Teacher for</option>
                                <option>I</option>
                                <option>II</option>
                                <option>III</option>
                                <option>IV</option>
                                <option>V</option>
                                <option>VI</option>
                                <option>VII</option>
                                <option>VIII</option>
                                <option>IX</option>
                                <option>X</option>
                            </select>
                        </div>
                        <div class='form-group' style='text-align:center'>
                            <input type='submit' value="Add">
                        </div>
                    </form>
                </div>
                <input class='w3-button w3-red' type='button' value='XLSX Export'>
            </div>
        </div>
    </body>
    <footer class='w3-bottom'>
        @include('footer')
    </footer>
</html>
