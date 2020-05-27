<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Sailor | Manage Articles</title>
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
    @include('dashboardSidebar')
    <div class="w3-main"  style="margin-left:310px;margin-top:43px;margin-right:10px;">
      <header class="w3-container w3-margin" style="padding-top:22px">
        <ul class="breadcrumb">
          <li><a href="/dashboard">Dashboard</a></li>
          <li><a href="">Manage Articles</a></li>
        </ul>
      </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="school-tables">
                <table class="w3-bordered w3-table">
                    <tr class="w3-white">
                        <th><i class='fa fa-bank w3-text-purple w3-xlarge'></i> Title</th>
                        <th><i class='fa fa-calendar w3-text-purple w3-xlarge'></i> Published at</th>
                        <th><i class='fa fa-heart w3-text-purple w3-xlarge'></i> Likes</th>
                    </tr>
                    <?php
                        if(count($articles) == 0){
                            ?>
                            <tr>
                                <td><i class="fa fa-exclamation-triangle w3-xlarge w3-text-red"></i> Articles Data Not Available</td>
                            </tr>
                            <?php
                        }
                        foreach($articles as $article)
                            {
                            ?>
                                <tr>
                                    <td><?php echo $article->title?></td>
                                    <td><?php echo $article->created?></td>
                                    <td><?php echo $article->likes?></td>
                                    <td>
                                        <a class="w3-xlarge w3-text-indigo" target="_blank" title="View" href="/view/article?url=<?php echo base64_encode($article->html_link); ?>&title=<?php echo base64_encode($article->title);?>"><i class="fa fa-eye"></i></a>
                                    </td>
                                    <!-- <td>
                                        <a title="Share" href="#"><i class=" w3-xlarge w3-text-blue fa fa-share-alt"></i></a>
                                    </td> -->
                                    <td>
                                        <a href='javascript:void(0)' url = "/delete/article/<?php echo $article->id ?>" class='w3-xlarge w3-text-red delete-button' title='Delete'><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php
                        }
                    ?>
                </table>
            </div>
        </div>
        <!-- delete modal start -->
        <div class="w3-modal delete-modal" id="delete-modal">
            <div class="w3-modal-content w3-animate-top w3-card-4">
                <header class="w3-container w3-indigo">
                    <span onclick="document.getElementById('delete-modal').style.display='none'"
                        class="w3-button w3-xlarge w3-display-topright">&times;</span>
                    <h2>Are you sure to Delete?</h2>
                </header>
                <div class="w3-container">
                    <p class="w3-dark-text-grey w3-xlarge">Once you delete,all class related information such as staff linked,students will be removed from the Sailor System.</p>
                    <button class="w3-red w3-margin w3-button w3-xlarge delete-confirm">Sure! Delete</button>
                    <button class="w3-green w3-margin w3-button w3-xlarge" onclick="document.getElementById('delete-modal').style.display='none'" >Cancel</button>
                </div>
                <footer class="w3-container w3-dark-grey">
                    <p>@Sailor Sytem </p>
                </footer>
            </div>
        </div>
        <!-- end -->
    </div>
    </body>
    <footer class='footer w3-bottom'>
        @include('footer')
    </footer>
</html>
