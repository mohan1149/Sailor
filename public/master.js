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
    $('.form-next').click(function(){
        $('.ins-select').removeClass('w3-hide');
        $('.user-basic').hide('slow');
    });
    $('.c-pwd').keyup(function(){
        let cpwd = $(this).val();
        let opwd  = $('.o-pwd').val();
        if(cpwd == opwd){
            $('.user-signup').prop('disabled', false);
            $('.correct').removeClass('w3-hide');
            $('.incorrect').addClass('w3-hide');
        }else{
            $('.incorrect').removeClass('w3-hide');
            $('.user-signup').prop('disabled', true);
            $('.correct').addClass('w3-hide');
        }
    });    
    $('.dd-outer').mouseenter(function(){
        let cls = $(this).attr('id'); 
        $(this).children().last().removeClass('fa-chevron-right');
        $(this).children().last().addClass('fa-chevron-down');
        $('.' + cls).slideDown();
    });    
    $('.dd-content').mouseleave(function(){
        $(this).slideUp();
        let id = $(this).attr('id');
        $('#' + id).children().last().addClass('fa-chevron-right');
        $('#' + id).children().last().removeClass('fa-chevron-down');
    });

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
        let ins_key =  $($(this)[0].selectedOptions[0]).attr('id');      
        let depts = window.ins_data[ins_key].ins_depts;
        let dept_select = "<select name='department' class='form-input department'>";
        depts.map(function(dept){
            dept_select += "<option value="+ dept.id +">"+ dept.dept_name+"</option>";
        });
        $('.department').replaceWith(dept_select);
        let years = window.ins_data[ins_key].ins_years;
        let year_select = "<select name='year' class='form-input year'>";
        years.map(function(year){
            year_select += "<option value="+ year.id +">"+ year.grade_year+"</option>";
        });
        $('.year').replaceWith(year_select);
          
    });
    /*end*/
    $('.school_change').change(function(){        
        let ins_key =  $($(this)[0].selectedOptions[0]).attr('id');
        let years = window.school_data[ins_key].school_years;
        let year_select = "<select onchange='updateClass("+ins_key+")' name='grade' class='form-input grade'>";
        years.map(function(year,index){
            year_select += "<option id="+ index +" value="+ year.year_id +">"+ year.year_name+"</option>";
        });
        $('.grade').replaceWith(year_select);
    });

    /* code to toggle between schools and depts
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
        let button = "<span style='margin-left:4px;'onclick='hide("+sub_class+")' id ="+sub_class+" class='w3-button w3-blue w3-margin-bottom'>"+ subject +"<i class='fa fa-times w3-margin-left'></i></span>";
        $('.subjects-list').append(button);
        window.subjects.push(subject);
        $('#final_subs').attr('value',window.subjects.toString());
    });

    $('.notif-side-panel').click(function(){
      $('.notif-side-panel').removeClass('active');
      $(this).addClass('read active');
      $(this).removeClass('unread');
    });

    //generic search code on tables
    $('.search').on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".searchable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    
    $('.school').change(function (){
        let id    = $(this).val();
        window.school_id = id;
        let data  = JSON.parse(window.school_data);
        //dynamic year data
        let year = "<select class='year'>";
        year    += "<option value='-1'>Year</option>"
        data[id].years_data.map(function(data_year){
            year+="<option value="+ data_year.id+">"+data_year.year+"</option>"
        });
        year+="</select>";
        $('.year').replaceWith(year);

        //dynamic department data
        let dept = "<select onchange='updateClass()' class='dept'>";
        dept    += "<option value='-1'>Department</option>";
        data[id].dep_data.map(function(deps,index){
            dept += "<option value="+ index +">"+deps.dept_name+"</option>"
        });
        year+="</select>";
        $('.dept').replaceWith(dept);
    });
    //sorting the student table
    var table = $('.student-data-table');
    $('.year-sort, .class-sort')
        .each(function(){
            var th  = $(this),
            thIndex = th.index(),
            inverse = false;
            th.click(function(){
                table.find('td').filter(function(){
                    return $(this).index() === thIndex;
                }).sortElements(function(a, b){
                    return $.text([a]) > $.text([b]) ? inverse ? -1 : 1 : inverse ? 1 : -1;
                }, function(){
                    return this.parentNode;
                });
                inverse = !inverse;
            });
        });

    $('.perm_button').click(function(){
        $('.perm_button').removeClass('active');
        $(this).addClass('active'); 
        let id = $(this).attr('id');
        $('.perm_container').removeClass('active-wrapper');
        $('.perm_container').addClass('inactive-wrapper');
        $('.'+id).removeClass('inactive-wrapper');        
        $('.'+id).addClass('active-wrapper');  
    });

    $('.assign-role').click(function(){
        $('.role-assign-modal').show();
    });

    // assign roles to users
    let school_id = '';
    let user_id   = '';
    let dept_id   = '';
    let role      = '';
    $('.select-role').change(function(){
        role = $(this).val();        
        if(role == 2){
            $('.select-hod').hide();
            $('.select-admin').show();
            $('.select-principal').hide();
            $('.select-data-entry').hide();
            $('.select-data-entry').hide();
            $('.select-teaching-staff').hide();    
        }
        else{
            if(role == 3){
                $('.select-hod').hide();
                $('.select-admin').hide();
                $('.select-principal').show();
                $('.select-data-entry').hide();
                $('.select-data-entry').hide();
                $('.select-teaching-staff').hide();
            }
            else{
                if(role == 4){
                    $('.select-hod').show();
                    $('.select-admin').hide();
                    $('.select-principal').hide();
                    $('.select-data-entry').hide();
                    $('.select-data-entry').hide();
                    $('.select-teaching-staff').hide();
                }
                else{
                    if(role == 5){
                        $('.select-hod').hide();
                        $('.select-admin').hide();
                        $('.select-principal').hide();
                        $('.select-data-entry').hide();
                        $('.select-data-entry').show();
                        $('.select-teaching-staff').hide();
                    }
                    else{
                        //6
                        $('.select-hod').hide();
                        $('.select-admin').hide();                    
                        $('.select-principal').hide();
                        $('.select-data-entry').hide();
                        $('.select-data-entry').hide();
                        $('.select-teaching-staff').show();                                                
                    }
                }
            }
        }
    });

    $('.select-institute').change(function(){
        let sid = $(this).val();
        let select = "<select class='w3-input w3-margin-top select-dept'>"        
        window.school_data[sid].dept_data.map(function(dept){
            select += "<option value="+ dept.id +">"+ dept.d_name +"</option>"
        });
        select+= "</select>";
        $('.select-dept').replaceWith(select);
        school_id = window.school_data[sid].school_id;
    });

    $('.assign-confirm').click(function(){        
        if(role == 2){
            //admin
            user_id   = $('.2').val();
            school_id = '';
            dept_id   = '';
        }
        else{
            if(role == 3){
                //principal
                user_id   = $('.3').val();
                school_id = $('.prin-school').val();
                dept_id   = '';
            }
            else{
                if(role == 4){
                    //hod
                    user_id   = $('.4').val();                    
                    dept_id   = $('.select-dept').val();
                }
                else{
                    if(role == 5){
                        //data entry
                        user_id   = $('.5').val();
                        dept_id   = '';
                        school_id = '';
                    }
                    else{
                        //teaching staff
                        user_id   = $('.6').val();
                        school_id = $('.ts-school').val();
                        dept_id   = '';
                    }
                }
            }
        }
        axios({
            method: 'post',
            url: "/assign/user/role",
            data: {
              role_id   : role,
              user_id   : user_id,
              school_id : school_id,
              dept_id   : dept_id
            }
        })
        .then((response)=>{
            if(response.status == 200){
                location.assign('/permissions');;
            }
            else{
                alert('User is already assigned with diffrent role.');
            }
        }).catch((error)=>{
            alert('User is already assigned with diffrent role.');
        });
    });

    $('.dept-add').click(function(){
        if($('.toggler').hasClass('fa-toggle-off')){
            $('.toggler').removeClass('fa-toggle-off');
            $('.toggler').addClass('fa-toggle-on');
        }else{
            $('.toggler').addClass('fa-toggle-off');
            $('.toggler').removeClass('fa-toggle-on');
        }     
        $('.dept-toggle').toggleClass('w3-hide');
        $('.clsss-toggle').toggle();
    });
});

