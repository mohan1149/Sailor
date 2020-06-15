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
        <title>Sailor | Add School</title>
        <!-- Styles -->
        <style>
            html, body {
                /* color: #636b6f; */
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .left{
                background-color: rgb(61, 94, 161);
                height:100vh;
            }
            .right{
                height:100vh;
            }
            .left-container{
                margin-top:10vh;
            }
            .logo-text{
                margin-top:10px;
            }
            .right-container{
                margin-top:10vh;
            }
            .title{
                font-family: 'Nunito', sans-serif;
                font-weight:200;   
                text-align:center;
            }
            .intro{
                font-family: 'Nunito', sans-serif;
                font-weight:200;
                margin-left:50px;
                margin-right:50px;
            }
            .form-input{
                width:60%;
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
                width:50%;
                border-radius:30px;
                background-color: rgb(61, 94, 161)!important;
            }
            .add-institute{
                margin:10px;
            }
            .form-group{
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
        <header class="w3-container" style="padding-top:22px">
        <ul class="breadcrumb">
              <li><a href="/school/dashboard">Dashboard</a></li>
              <li><a href="">Add School</a></li>
        </ul>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="add-institute">                
                <form action='/add/school' method="POST" class="w3-center" enctype="multipart/form-data">
                    @csrf
                    <div class='form-group'>
                        <span><i class='fa fa-bank w3-text-blue w3-xlarge'></i></span>
                        <input class="form-input"placeholder="<?php echo $$strings['name']?>" type='text' name='name' required autofocus>
                    </div>
                    <div class='form-group'>
                        <span><i class='fa fa-id-card w3-text-blue w3-xlarge'></i></span>
                        <input class="form-input"placeholder="<?php echo $$strings['reg']?>" type='text' name='reg-num' required >
                    </div>
                    <div class='form-group'>
                        <span><i class='fa fa-phone w3-text-blue w3-xlarge'></i></span>
                        <input placeholder="<?php echo $$strings['phone']?>" type='tel' name='phone' class="form-input" required>
                    </div>
                    <div class='form-group'>
                        <span><i class='fa fa-envelope w3-text-blue w3-xlarge'></i></span>
                        <input placeholder="<?php echo $$strings['email']?>" type='email' name='email' class="form-input" >
                    </div>
                    <div class='form-group'>
                        <span><i class='fa fa-globe w3-text-blue w3-xlarge'></i></span>
                        <input placeholder="<?php echo $$strings['website']?>" type='url' name='website' class="form-input">
                    </div>
                    <div class='form-group'>
                        <span><i class='fa fa-map-marker w3-text-blue w3-xlarge'></i></span>
                        <input placeholder="<?php echo $$strings['address']?>" type='text' name='address' class="form-input">
                    </div>
                    <div class='form-group'>
                        <span><i class='fa fa-clock-o w3-text-blue w3-xlarge'></i></span>
                        <input placeholder="<?php echo $$strings['numofprds']?>" type='number' name='periods' class="form-input">
                    </div>
                    <div class="form-group">
                        <span><i class='fa fa-clock-o w3-text-blue w3-xlarge'></i></span>
                        <input placeholder="<?php echo $$strings['prdslen']?>" type='number' name='period-length' class="form-input">
                    </div>
                    <div class='form-group'>
                        <span><i class='fa fa-image w3-text-blue w3-xlarge'></i></span>
                        <input id ="image" type='file' name='logo'  accept="image/*" class="form-input">
                        <span><i class='fa fa-refresh w3-hide loader w3-spin w3-text-blue w3-xlarge'></i></span>                        
                    </div>
                    <input type="hidden" name="image_url" class = "image_url" value=""/>
                    <div class='form-group'>
                        <input class="form-submit w3-button w3-disabled w3-text-white w3-xlarge w3-margin" type='submit' value="<?php echo $$strings['add']?>">
                    </div>
                </form>
            </div>
        </div>
    </div>
    </body>
    <script>
        $('#image').change(function(){
            $('.loader').removeClass('w3-hide');            
            var file = $('#image').prop('files')[0];
            let filename = file.name;
            let ext =  filename.substring(filename.lastIndexOf('.')+1, filename.length) || filename;
            let image_name = Number(new Date()).toString()+'.'+ext;
            var metadata = {
                contentType: 'image/jpeg'
            };
            var storageRef = firebase.storage().ref();
            var uploadTask = storageRef.child('school_images/' + image_name).put(file, metadata);		
            uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
            function(snapshot) {    
                var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                console.log('Upload is ' + progress + '% done');
                switch (snapshot.state) {
                    case firebase.storage.TaskState.PAUSED:
                        console.log('Upload is paused');
                    break;
                    case firebase.storage.TaskState.RUNNING:
                        console.log('Upload is running');
                    break;
                }
            }, function(error) {
                    switch (error.code) {
                    case 'storage/unauthorized':      
                    break;
                    case 'storage/canceled':
                    break;
                    case 'storage/unknown':
                    break;
                }
            }, function() {
                uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
                    console.log('File available at', downloadURL);                    
                    $('.loader').removeClass('fa-refresh');
                    $('.loader').removeClass('w3-spin');
                    $('.loader').addClass('fa-check');
                    $('.form-submit').removeClass('w3-disabled');
                    $('.image_url').attr('value',downloadURL)
                });
            });
        });
    </script>
    <footer class='footer w3-bottom'>
        @include('footer')
    </footer>
</html>