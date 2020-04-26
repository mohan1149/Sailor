$(document).ready(function(){
   // global variable to hold the delete route
    let delete_url = '';
    let toggle_class_name = '';
    /* code to toggle between the languages
    start*/
    $(".language").change(function(e){
        //localStorage.setItem('sailorLang',e.target.value);
        location.assign(location.pathname + "?lan=" + e.target.value);
    });
    /*end*/

    /* code to validate periods is integer
    start*/
    $(".periods").keyup(function(e){
        var num = e.target.value;
        if(isNaN(num)){
            alert('Please enter numbers only.');
            $(".periods").val('0');
        }
    });
    /*end*/

    /* code to validate phone numbers
    start*/
    $(".phone").keyup(function(e){
        var num = e.target.value;
        if(isNaN(num)){
            alert('Please enter numbers only.');
            $(".phone").val('0');
        }
    });
    /*end*/

    /* code to validate period length
    start*/
    $(".period-length").keyup(function(e){
        var num = e.target.value;
        if(isNaN(num)){
            alert('Please enter numbers only.');
            $(".period-length").val('0');
        }
    });
    /*end*/

    /* code to generate subject fields
    start*/
    $(".subjects").keyup(function(e){
        var num = e.target.value;
        if(isNaN(num)){
            alert('Please enter numbers only.');
            $(".subjects").val('0');
        }
        else{
            let grids = num / 2;
            if(grids !== 0){
                let check = parseInt(grids);
                let grid1 = grids;
                let grid2 = grids;
                if(check !== num / 2){
                    grid1 = check + 1;
                    grid2 = check;
                }
                for( i=1;i<=grid1;i++){
                    let str = "<div class='form-group dyn-fg'>";
                    str += "<span>Subject "+ i +"</span>";
                    str += "<input class='form-input' type='text' name='subject"+ i+"'>";
                    str += "</div>";
                    $(".grid1").append(str);
                }
                for( i=grid1+1;i<=num;i++){
                    let str = "<div class='form-group dyn-fg'>";
                    str += "<span>Subject "+ i +"</span>";
                    str += "<input class='form-input' type='text' name='subject"+ i+"'>";
                    str += "</div>";
                    $(".grid2").append(str);
                }
            }else{
                $(".dyn-fg").remove();
                $(".dyn-fg").remove();
            }
        }
    });
    /*end*/
    /* code to toggle between departments,classes,staff and students content in school viewing
    start*/
    $('.data-item').click(function(){
        $('.data-item').removeClass('active');
        $('.data').removeClass('active');
        $(this).addClass('active');
        let classes = $(this).attr('class');
        let classArray = classes.split(" ");
        $('.' + classArray[1]).addClass('active');
    });
    /*end*/

    /* code to append dynamic departments and classes while adding class and staff
    start*/
    $('.select-school').change(function(){
        let id = $(this).val();
        axios.get('/get/departs-grades/' + id)
        .then(function(response){
            //dynamic deps
            let deps = "<select onchange = 'getGrades()' class='form-input department' name='department'>";
            deps+= "<option value='-0'>Department</option>;                                                                                                                       </option>";
            response.data.deps.map((data)=>{
              deps+= "<option value='"+ data.id+"'>"+ data.d_name+"</option>";
            });
            deps+= "</select>";
            $('.department').replaceWith(deps);
            //dynamic classes
            let classes = "<select class='form-input grade' name='grade'>";
            response.data.classes.map((data)=>{
                classes+= "<option value='"+ data.id+"'>"+ data.value+"</option>";
            });
            classes+= "</select>";
            $('.grade').replaceWith(classes);
        });
    });
    /*end*/
    /* code to toggle between schools
    start*/
    $('.staff-show').click(function(){
      if(toggle_class_name !== '.'+$(this).attr('id')){
          toggle_class_name = '.'+$(this).attr('id');
          $('content-table').removeClass('active');
          $('.content-table').addClass('inactive');
          $(toggle_class_name).removeClass('inactive');
          $(toggle_class_name).addClass('active');
          //icon handling
          $('.staff-show').children().removeClass('fa-minus');
          $('.staff-show').children().addClass('fa-plus');
          $(this).children().removeClass('fa-plus');
          $(this).children().addClass('fa-minus');
        }else{
          $(toggle_class_name).addClass('inactive');
          if($(this).children().hasClass('fa-plus')){

            $(toggle_class_name).addClass('active');
            $(toggle_class_name).removeClass('inactive');
            $(this).children().addClass('fa-minus');
            $(this).children().removeClass('fa-plus');
          }else{
            $(this).children().addClass('fa-plus');
            $(this).children().removeClass('fa-minus');
          }
        }
    });
    /*end*/
    /*toggle between departments
    start*/
    $('.class-show').click(function(){
        if(toggle_class_name !== '.'+$(this).attr('id')){
            toggle_class_name = '.'+$(this).attr('id');
            $('.content-table-inner').removeClass('active-inner');
            $('.content-table-inner').addClass('inactive-inner');
            $(toggle_class_name).removeClass('inactive-inner');
            $(toggle_class_name).addClass('active-inner');
            //icon handling
            $('.class-show').children().removeClass('fa-minus');
            $('.class-show').children().addClass('fa-plus');
            $(this).children().removeClass('fa-plus');
            $(this).children().addClass('fa-minus');
          }else{
            $(toggle_class_name).addClass('inactive-inner');
            if($(this).children().hasClass('fa-plus')){
              $(toggle_class_name).addClass('active-inner');
              $(toggle_class_name).removeClass('inactive-inner');
              $(this).children().addClass('fa-minus');
              $(this).children().removeClass('fa-plus');
            }else{
              $(this).children().addClass('fa-plus');
              $(this).children().removeClass('fa-minus');
            }
          }
      });
    /*end*/

    /* code to show school delete modal
    start*/
    $('.delete-button').click(function(){
        delete_url = $(this).attr('url');
        $('.delete-modal').show();
    });
    /*end*/

    /* delete school confirm
    start*/
    $('.delete-confirm').click(function(){
        location.assign(delete_url);
    });
    /*end*/

    $('.count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).html()
        }, {
            duration: 1000,
            easing: 'linear',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
    $('.subject').click(function(){
        let id = $(this).attr('id');
        let svalue = $(this).attr('value');
        $(this).remove();
        $('.'+id).remove();
        window.subjects = window.subjects.filter(function(value){ return value !== svalue;});
        $('#final_subs').attr('value',window.subjects.toString());   
    });

    $('.add-subject').click(function(){
        $('.subject-modal').show();
    });

    $('.add-confirm').click(function(){
        $('.subject-modal').hide();
        let subject = $('.subject-name').val();
        let sub_class  = subject.replace(/ /gi,'_');
        let button = "<span style='margin-left:4px;'onclick='hide("+sub_class+")' id ="+sub_class+" class='w3-button w3-blue w3-margin-bottom'>"+ subject +"<i class='fa fa-times'></i></span>";
        $('.subjects-list').append(button);
        window.subjects.push(subject);
        $('#final_subs').attr('value',window.subjects.toString());
    });
});
