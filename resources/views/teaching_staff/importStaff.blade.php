<?php
    include(app_path().'/translations/strings.php');
    $strings = $_SESSION['lang'];
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Sailor | Import Staff</title>
        <!-- Styles -->
        <style>
            html, body {
                /* color: #636b6f; */
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            
            .form-input{
                width:60%!important;
                margin-bottom:10px;
                border-radius:30px;
                padding:4px;
                padding-left:10px;
                margin-left:2px;
                height:50px;
                font-size:20px;
                border: 2px solid #2196F3;
            }            
            .form-submit{
                color:#fff!important;
                width:50%;
                border-radius:30px;
                background-color: rgb(61, 94, 161)!important;
            }
            .add-institute{
                margin:10px;
            }
            .form-group{
                margin-bottom:5px;
                text-align: center;
            }
            
        </style>
        <script>
            window.ins_data = <?php echo json_encode($return_data); ?>
        </script>
    </head>
    <header class='w3-top'>
        @include('header')
    </header>
    <body class="w3-light-grey">
    <!-- Sidebar/menu -->
    @include('school.dashboardSidebar')
    <div class="w3-main"  style="margin-left:310px;margin-top:43px;margin-right:10px;">
        <header class="w3-container" style="padding-top:22px">
            <ul class="breadcrumb">
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="">Import Teaching Staff</a></li>
            </ul>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="add-staff">                
                <form action='/import/staff' method="POST" enctype="multipart/form-data" class="w3-margin-top">                                         
                        <div class='form-group'>
                            <span><i class='fa fa-bank w3-xlarge w3-text-blue'></i></span>
                            <select  class="form-input select-school" name='ins_id'>
                            <option value="0">School</option>
                                <?php                                
                                    foreach($return_data as $key => $ins){                                        
                                        ?>
                                            <option id="<?php echo $key; ?>" value= "<?php echo $ins['ins_id'];?> "><?php echo $ins['ins_name'] ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class='form-group'>
                            <span><i class='fa fa-share-alt w3-xlarge w3-text-blue'></i></span>
                            <select class="form-input department" name='department'>
                                <option>Department</option>
                            </select>
                        </div>  
                        <div class='form-group'>
                            <span><i class='fa fa-upload w3-text-blue w3-xlarge'></i></span>
                            <input type='file' name='data_file' class="form-input data_file">
                            <span><i class='fa fa-refresh w3-hide loader w3-spin w3-text-blue w3-xlarge'></i></span>                        
                        </div>                       
                        <div class='form-group' style='text-align:center'>
                            <input class="w3-button form-input form-submit" type='button' value="Import">
                        </div>
                    </form>
            </div>
        </div>
    </div>
    <div class="w3-modal delete-modal" id="show_modal">
            <div class="w3-modal-content w3-center w3-animate-top w3-card-4">
                <header class="w3-container w3-indigo">
                    <h2>Please wait..</h2>
                </header>
                <div class="w3-container">
                    <p class="w3-dark-text-grey w3-xlarge">Data is importing into teaching staff database. Please wait while importing.</p>
                    <span class="w3-margin"><i class='w3-margin fa fa-refresh w3-spin w3-text-blue w3-jumbo'></i></span>                        
                </div>
                <footer class="w3-container w3-dark-grey">
                    <p>@Sailor Sytem </p>
                </footer>
            </div>
    </div>
    <script>
        $('.form-submit').click(function(){
            let fd = new FormData();
            $('#show_modal').show();
            let data_file  = $('.data_file')[0].files[0];
            let school_id  = $('.select-school').val();
            let department = $('.department').val();
            fd.append('ins_id',school_id);
            fd.append('department',department);
            fd.append('data_file',data_file); 
            fd.append('_token','{{ csrf_token() }}');
            $.ajax({
                url:'/import/staff',
                type:'post',
                data :fd,
                contentType:false,
                processData:false,
                success:(response)=>{                                        
                    $('#show_modal').hide();
                    location.assign('/manage/staff');
                    console.log(response);
                },
                error:(error)=>{
                    console.log(error);
                    $('#show_modal').hide();
                    alert('Unable to Import Data. Please re-check the source file');
                }
            });               
        });
    </script>
    </body>
</html>
