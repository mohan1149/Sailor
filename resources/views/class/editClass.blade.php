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
        <title>Sailor | Edit Class</title>
        <!-- Styles -->
        <style>
            html, body {
                /* color: #636b6f; */
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }
            .subjects{
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 600;
                text-transform:uppercase;
                letter-spacing:.1rem
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
            }
        </style>
        <script>
            function hide(id){
                id.style.display = 'none';
                let val = id.id.replace(/_/gi,' ');
                window.subjects = window.subjects.filter(function(subject){ return subject.subject_name !== val;});
                document.getElementById('final_subs').value = JSON.stringify(window.subjects);
            }   
            window.subjects = [];
            <?php
                if(isset($class['subjects'])){
                    foreach($class['subjects'] as $subject){
                        ?>
                            var subject = {                            
                                'subject_name'       : '<?php echo $subject->subject_name;?>',
                                'subject_completion' : <?php echo $subject->subject_completion;?>
                            };
                            window.subjects.push(subject);
                        <?php
                    }
                }                
            ?>
        </script>
    </head>
    <header class='w3-top'>
        @include('header')
    </header>
    <body class="w3-light-grey">
    <!-- Sidebar/menu -->    
    @if($_SESSION['ins'] == 'college')
        @include('college.dashboardSidebar')
    @else
        @include('school.dashboardSidebar')
    @endif
    <div class="w3-main"  style="margin-left:310px;margin-top:43px;margin-right:10px;">
        <header class="w3-container" style="padding-top:22px">            
            <ul class="breadcrumb">
              <li><a href="/dashboard">Dashboard</a></li>
              <li><a href="/manage/class">Manage Classes</a></li>
              <li><a href="">Edit Class</a></li>
              <li><?php echo $class['class']->class_name; ?></li>
            </ul>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="add-institute">                
                <form action='/update/class/<?php echo $class['class']->class_id ?>' method="POST" class="w3-center edit-class">
                    @csrf
                    <div class='form-group'>
                        <span><i class='fa fa-book w3-xlarge w3-text-blue'></i></span>
                        <input value="<?php echo $class['class']->class_name ?>"required type='text' class="form-input"autofocus name='className' placeholder='Ex: X-Spark' >
                    </div>
                    <div class='form-group'>
                        <span style="width:20%!important"class="form-input w3-button w3-indigo add-subject">Add Subject</span>
                    </div>
                    <div class="w3-margin subjects-list">
                        <span class="subjects">Subjects</span>
                        <?php
                            if(isset($class['subjects'])){
                                foreach($class['subjects'] as $key => $subject){
                                    ?>
                                        <span value="<?php echo $subject->subject_name ?>" id="sub-<?php echo $key?>"class="w3-button subject w3-blue w3-margin-bottom"><?php echo $subject->subject_name ?> <i class="fa fa-times"></i></span>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                    <input type="hidden" value="" id="final_subs"name="subjects">
                    <div class='form-group w3-center'>
                        <input class="w3-button form-input form-submit"type='submit' value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- add subject modal -->
    <div class="w3-modal subject-modal" id="subject-modal">
        <div class="w3-modal-content w3-animate-top w3-card-4">
            <header class="w3-container w3-indigo">
                <span onclick="document.getElementById('subject-modal').style.display='none'"
                    class="w3-button w3-xlarge w3-display-topright">&times;</span>
                <h2>Add Subject</h2>
            </header>
            <div class="w3-container">
                <div class='form-group w3-margin'>
                    <span><i class='fa fa-pencil w3-xlarge w3-text-blue'></i></span>
                    <input required type='text' class="form-input subject-name" autofocus placeholder='subject name' >
                </div>
                <button class="w3-blue w3-margin w3-button w3-xlarge add-confirm">Add</button>
                <button class="w3-red w3-margin w3-button w3-xlarge" onclick="document.getElementById('subject-modal').style.display='none'" >Cancel</button>
            </div>
            <footer class="w3-container w3-dark-grey">
                <p>@Sailor Sytem </p>
            </footer>
        </div>
    </div>
    <!-- end -->
    </body>
    <script>        
        document.getElementById('final_subs').value = JSON.stringify(window.subjects);
    </script>
</html>
