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
        <title>Sailor | View Class</title>
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
            .school-logo{
                display:flex;
                justify-content: center;
            }
            .logo{
                width:200px;
                height:200px;
                border-radius: 50%;
                margin-bottom: 15px;
            }
            .school-data .data-item{
                cursor: pointer;
                list-style: none;
            }
            .s_info{
                border-right: 1px solid gray;
            }
            .school-data .active{
                color:#2196F3 !important;
                background:black;
            }
            .data{
                display:none;
            }
            .data a {
                text-decoration:none;
            }
            .active{
                display:block;
            }
            li h3{
                color: #fff;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                font-family: 'Nunito', sans-serif;
            }
            .count-text{
                color: #636b6f;
                text-transform: uppercase;
                font-family: 'Nunito', sans-serif;
                letter-spacing: .1rem;
                font-weight: 600;
            }
            .class_name{
                color: #636b6f;
                text-transform: uppercase;
                font-family: 'Nunito', sans-serif;
                letter-spacing: .1rem;
                font-weight: 600;
            }
            .active{
                display:block;
            }
            .inactive{
                display:none!important;
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
            <li><a href="/manage/classes">Manage Classes</a></li>
            <li><a href="">View Class</a></li>
            <li><?php echo $responseData['class_data']->class_name; ?></li>
          </ul>
        </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="w3-margin-top">                
                <button style="width:95%"class="w3-indigo w3-margin w3-button w3-block w3-left-align staff-show" id ="students">
                    Students
                    <i class="fa fa-plus w3-right"></i>
                </button>
                <table style='text-align:center;width:95%!important;' class="inactive w3-bordered w3-table w3-margin w3-accordion-content content-table students">
                    <tr class="w3-white">
                        <th><i class='fa fa-black-tie w3-text-purple w3-xlarge'></i> <span class="w3-small"> Student ID</span></th>
                        <th><i class='fa fa-graduation-cap w3-text-purple w3-xlarge'></i> <span class="w3-small"> Student Name</span></th>
                        <th><i class='fa fa-male w3-text-purple w3-xlarge'></i> <span class="w3-small"> Father</span></th>
                        <th><i class='fa fa-female w3-text-purple w3-xlarge'></i> <span class="w3-small"> Mother</span></th>
                    </tr>
                    <?php
                        foreach($responseData['students'] as $student){
                            ?>
                                <tr>
                                    <td><?php echo $student->sid; ?></td>
                                    <td><?php echo $student->fname.' '.$student->lname;?></td>
                                    <td><?php echo $student->father_name; ?></td>
                                    <td><?php echo $student->mother_name; ?></td>
                                    <td><a title="Promote" href="#"><i class="fa fa-arrow-up w3-xlarge w3-text-green"></i></a></td>
                                    <td><a title="Demote" href="#"><i class="fa fa-arrow-down w3-xlarge w3-text-red"></i></a></td>                                    
                                </tr>
                            <?php
                        }
                    ?>                         
                </table>
                <button style="width:95%"class="w3-indigo w3-margin w3-button w3-block w3-left-align staff-show" id ="syllabus">
                    Syllabus
                    <i class="fa fa-plus w3-right"></i>
                </button>
                <div class="inactive w3-table w3-bordered w3-margin w3-accordion-content content-table syllabus">
                    <table class="w3-table w3-bordered">
                        <th><i class="fa fa-book w3-text-purple w3-large"></i> Subject</th>
                        <th> <i class="fa fa-percent w3-text-purple w3-large"></i> Syllabus Completion</th>
                        <th> <i class="fa fa-chevron-up w3-text-purple w3-large"></i> Update Syllabus</th>
                        <th> <i class="fa fa-plus w3-text-purple w3-large"></i> Add Chapters</th>                   
                        <?php
                            $subjects = json_decode($responseData['subjects']->subjects_list);
                            foreach($subjects as $key => $subject){
                                ?>
                                <tr>
                                    <td class="w3-large"><?php echo $subject->subject_name; ?></td>
                                    <td>
                                        <div class="w3-light-grey w3-round-xlarge w3-padding">
                                            <div class="w3-container w3-center w3-round-xlarge w3-teal" style="width:<?php echo $subject->subject_completion;?>%">
                                                <?php echo $subject->subject_completion;?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" url="/update/syllabus/<?php echo $responseData['class_data']->id.'/'.$key; ?>" class=" w3-button w3-indigo btn_syllbus_up">Update</a>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0)" url="/add/chapters/<?php echo $responseData['class_data']->id.'/'.$key; ?>" class="btn_add_chapters w3-blue w3-button">Add</a>
                                    </td>
                                </tr>
                            <?php
                            }
                        ?>
                    </table>
                </div>
            </div>  
        </div>
    </div>
    <!-- Update syllabus modal -->
        <div class="w3-modal syllabus_up" id="syllabus_up">
            <div class="w3-modal-content w3-animate-top w3-card-4">
                <header class="w3-container w3-indigo">
                    <span onclick="document.getElementById('syllabus_up').style.display='none'"
                        class="w3-button w3-xlarge w3-display-topright">&times;</span>
                    <h3>What percent did syllabus completed ?</h3>
                </header>
                <div class="w3-container">
                    <div class="w3-center">
                        <div class="w3-margin">
                            <span class="up_value w3-margin w3-button w3-grey w3-round w3-xlarge w3-text-white">10</span>
                            <span class="up_value w3-margin w3-button w3-grey w3-round w3-xlarge w3-text-white">20</span>
                            <span class="up_value w3-margin w3-button w3-grey w3-round w3-xlarge w3-text-white">30</span>
                            <span class="up_value w3-margin w3-button w3-grey w3-round w3-xlarge w3-text-white">40</span>
                        </div>
                        <div class="w3-margin">
                            <span class="up_value w3-margin w3-button w3-grey w3-round w3-xlarge w3-text-white">50</span>
                            <span class="up_value w3-margin w3-button w3-grey w3-round w3-xlarge w3-text-white">60</span>
                        </div>
                        <div class="w3-margin">
                            <span class="up_value w3-margin w3-button w3-grey w3-round w3-xlarge w3-text-white">70</span>
                            <span class="up_value w3-margin w3-button w3-grey w3-round w3-xlarge w3-text-white">80</span>
                            <span class="up_value w3-margin w3-button w3-grey w3-round w3-xlarge w3-text-white">90</span>
                            <span class="up_value w3-margin w3-button w3-grey w3-round w3-xlarge w3-text-white">100</span>
                        </div>
                    </div>                    
                    <button class="w3-indigo w3-margin w3-button w3-xlarge update_confirm">Update</button>
                    <button class="w3-red w3-margin w3-button w3-xlarge" onclick="document.getElementById('syllabus_up').style.display='none'" >Cancel</button>
                </div>
                <footer class="w3-container w3-dark-grey">
                    <p>@SailorERP Sytem </p>
                </footer>
            </div>
        </div>
    <!-- end -->
        <!-- add chapters modal -->
        <div class="w3-modal add_chapters" id="add_chapters">
            <div class="w3-modal-content w3-animate-top w3-card-4">
                <header class="w3-container w3-indigo">
                    <span onclick="document.getElementById('add_chapters').style.display='none'"
                        class="w3-button w3-xlarge w3-display-topright">&times;</span>
                    <h3>Add Chapters to the subject.</h3>
                </header>
                <div class="w3-container">
                    <form method="post" action="" class="add_chapter_form">
                        @csrf
                        <div class="w3-center">
                            <input name="chapters_count"placeholder="Number of Chapters or Units" type="number" class="w3-input w3-margin w3-xlarge w3-padding chapters">
                        </div>
                        <div class="chapters_list w3-margin">
                        </div>                                         
                        <input class="w3-indigo w3-margin w3-button w3-xlarge" type="submit" value="Add"/>
                        <input type="reset" class="w3-red w3-margin w3-button w3-xlarge" onclick="document.getElementById('add_chapters').style.display='none'" value="Cancel"/>
                    </form>
                </div>
                <footer class="w3-container w3-dark-grey">
                    <p>@SailorERP Sytem </p>
                </footer>
            </div>
        </div>
    <!-- end -->
    </body>
</html>
