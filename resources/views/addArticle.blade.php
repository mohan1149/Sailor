<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Sailor | Add Article</title>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  </head>
  <style>
    .art-title{
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
        <h5><b><i class="fa fa-plus w3-text-blue"></i> Add Article</b></h5>
      </header>
      <div class="w3-row-padding w3-margin-bottom">
        <input class="w3-input art-title" placeholder="Article title" type="text">
        <div id="summernote"></div>
        <button class="w3-button w3-margin w3-blue publish">Publish</button>
      </div>
    </div>
    <footer class="w3-bottom">
     @include('footer')
    </footer>
  </body>
  <script>
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
        url: "/publish/article",
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
