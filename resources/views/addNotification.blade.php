<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Sailor | Add Notification</title>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="<?php echo asset('axios.min.js')?>"></script>
  </head>
  <style>
    .notif-title{
      margin-bottom:10px;
      border-radius:5px;
      border: 1px solid lightgray !important;
    }
    .note-editable{
      height:390px!important;
    }
  </style>
  <header>
    @include('articleHeader')
  </header>
  <body class="w3-light-grey">
    @include('dashboardSidebar')
    <div class="w3-main" style="margin-left:310px;margin-top:10px;margin-right:10px;">
      <header class="w3-container">
        <h5><b><i class="fa fa-plus w3-text-blue"></i> Add Notification</b></h5>
      </header>
      <div class="w3-row-padding w3-margin-bottom">
        <input class="w3-input notif-title" placeholder="Notification title" type="text">
        <div class="w3-margin-top w3-margin-bottom">
          <span>Intented For</span>
          <select class="school">
            <option>Institute</option>
            <?php
              $school_data = json_decode($return_data);
              foreach($school_data as $key => $school){                
                ?>
                  <option value="<?php echo $key ?>"><?php echo $school->school_name ?></option>
                <?php
              }
            ?>
          </select>
          <select class="year">
            <option>Year</option>
          </select>
          <select class="dept">
            <option>Department</option>
          </select>
          <select class="class">
            <option>Class</option>
          </select>
        </div>
        <div id="summernote"></div>
        <button class="w3-button w3-margin w3-blue publish">Publish</button>
      </div>
    </div>
    <footer class="w3-bottom">
     @include('footer')
    </footer>
  </body>
  <script>
    function updateClass(){
      let dept_id    = $('.dept').val();      
      let school_id  = window.school_id;
      let class_data = JSON.parse( window.school_data )[school_id].dep_data[dept_id].class_data;
      let class_sel  = "<select class='class'>";
      class_sel     += "<option value='-1'>Class</option>";
      class_data.map(function(dynClass){
        class_sel += "<option value="+dynClass.id+">"+dynClass.value+"</option>";
      });
      class_sel += "</select>";
      $('.class').replaceWith(class_sel);
    }
    window.school_data = <?php echo json_encode($return_data);?> 
    $('#summernote').summernote({
      placeholder: 'This is What You See What You Get editor. Have fun..!',
      tabsize: 2,
      height: 120,
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'codeview']]
      ]
    });
    $('.publish').click(function(){
      let art_title = $('.art-title').val();
      let article  = $('.note-editable').html();
      axios({
        method: 'post',
        url: "/post/notification",
        data: {
          art_title: art_title,
          article: article,
        }
      })
      .then(function(response){
        if(response.status === 200){
          location.assign('/manage/articles');
        }else{
          alert('Unabble to Publish the article. Please try again later');
        }
      });
    });
  </script>
</html>
