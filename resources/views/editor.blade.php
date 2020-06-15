<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Sailor | Editor</title>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="https://www.gstatic.com/firebasejs/6.5.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/6.5.0/firebase-storage.js"></script>
    <style>
        .btn-fullscreen{
            display:none;
        }
        .note-btn{
            font-size:50px;
        }
        .note-popover .popover-content .note-color .dropdown-toggle, .note-toolbar .note-color .dropdown-toggle{
            width:50px !important;
        }
        .note-editable{
            font-size:50px;
        }
        .note-modal-content{
            height: 700px !important;
            width: 90% !important;
        }
        .note-modal-title{
            font-size: 40px !important;
        }
        .note-modal .note-modal-body label{
            font-size: 30px !important;
        }
        .note-input{
            height: 100px !important;
            font-size:30px !important;
        }
        .note-btn-group{
            margin-left: 10px !important;
            margin-right: 10px !important;
        }
        .note-btn-group button {
            margin: 2px !important;
        }        
    </style>
  </head>
  <body>
    <div id="summernote"></div>
    <input type="file" accept="image/*" class="w3-hide" id="imagePicker"/>
    <button class="choose w3-button w3-indigo w3-jumbo" style="width:100%">
        Choose Post Image
    </button>
  </body>
    <script>            
        var firebaseConfig = {
            apiKey: "AIzaSyC9n71Dc_LAmQlbXG3q-aJ95ER6YZ4Rtxs",
            authDomain: "sailor-server.firebaseapp.com",
            databaseURL: "https://sailor-server.firebaseio.com",
            projectId: "sailor-server",
            storageBucket: "sailor-server.appspot.com",
            messagingSenderId: "661317463566",
            appId: "1:661317463566:web:adfbc6b9ebc03adfb5d65f",
            measurementId: "G-G6C9F1EPX0"
        };            
        firebase.initializeApp(firebaseConfig);          
    </script>
    <script>
        $('.choose').click(function(){
            $('#imagePicker').click();
        });

        $('#imagePicker').change(function(){            
            var file = $('#imagePicker').prop('files')[0];
            console.log(file);
            let filename = file.name;
            let ext =  filename.substring(filename.lastIndexOf('.')+1, filename.length) || filename;
            let image_name = Number(new Date()).toString()+'.'+ext;
            var metadata = {
                contentType: 'image/jpeg'
            };
            var storageRef = firebase.storage().ref();
            var uploadTask = storageRef.child('posts/' + image_name).put(file, metadata);
            sendSignalToRN('started');
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
                    sendSignalToRN('error');
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
                    sendSignalToRN(downloadURL);                                     
                });
            });
        });
        function sendSignalToRN(status){
            let post = $('.note-editable').html();
            let post_data = {
                status : status,
                data   : post,
            };
            window.ReactNativeWebView.postMessage(JSON.stringify(post_data));                
        }
        $('#summernote').summernote({
        placeholder: 'Write post description here..!',
        tabsize: 2,
        height: 900,
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
    </script>
  </html>