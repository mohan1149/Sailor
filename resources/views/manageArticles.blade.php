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
          <a class=""><i class="fa fa-cogs w3-text-blue w3-xlarge"></i> Manage Articles</a>
          <a href = "/add/article"class="w3-button"><i class="fa fa-plus w3-text-blue"></i> Add Article</a>
      </header>
        <div class="w3-row-padding w3-margin-bottom w3-white w3-card">
            <div class="school-tables">
                <table class="w3-striped w3-padding w3-responsive w3-bordered w3-table">
                    <tr class="w3-white">
                        <th><i class='fa fa-bank'></i> Title</th>
                        <th><i class='fa fa-calendar'></i> Published at</th>
                        <th><i class='fa fa-heart'></i> Likes</th>
                    </tr>
                    <?php
                        foreach($articles as $article)
                            {
                            ?>
                                <tr>
                                    <td><?php echo $article->title?></td>
                                    <td><?php echo $article->created?></td>
                                    <td><?php echo $article->likes?></td>
                                    <td>
                                        <a class="w3-indigo w3-button" href="<?php echo $article->html_link?>">View <i class="fa fa-eye"></i></a>
                                    </td>
                                    <td>
                                        <a class="w3-blue w3-button" href="/api/delete/school/">Share <i class="fa fa-share-alt"></i></a>
                                    </td>
                                    <td>
                                        <a class="w3-red w3-button" href="/api/delete/school/">Delete <i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php
                        }
                    ?>
                </table>
            </div>
            <div class="w3-center">
                <button class="w3-button w3-green w3-margin pager-prev">Prev</button>
                <button class="w3-button w3-green w3-margin pager-next">Next</button>
            </div>
        </div>
    </div>
    </body>
    <footer class='footer w3-bottom'>
        @include('footer')
    </footer>
</html>
