$(document).ready(function(){
    let delete_url = '';
    $(".language").change(function(e){
        //localStorage.setItem('sailorLang',e.target.value);
        location.assign(location.pathname + "?lan=" + e.target.value);
    });
    $(".menu").click(function(){
        $(".side-nav").toggle();
    });
    $(".periods").keyup(function(e){
        var num = e.target.value;
        if(isNaN(num)){
            alert('Please enter numbers only.');
            $(".periods").val('0');
        }
    });
    $(".phone").keyup(function(e){
        var num = e.target.value;
        if(isNaN(num)){
            alert('Please enter numbers only.');
            $(".phone").val('0');
        }
    });
    $(".period-length").keyup(function(e){
        var num = e.target.value;
        if(isNaN(num)){
            alert('Please enter numbers only.');
            $(".period-length").val('0');
        }
    });
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
    $('.data-item').click(function(){
        $('.data-item').removeClass('active');
        $('.data').removeClass('active');
        $(this).addClass('active');
        let classes = $(this).attr('class');
        let classArray = classes.split(" ");
        $('.' + classArray[1]).addClass('active');
    });
    $('.select-school').change(function(){
        let id = $(this).val();
        axios.get('/get/departs-classes/' + id)
        .then(function(response){
            //dynamic deps
            let deps = "<select class='form-input department' name='department'>";
            response.data.deps.map((data)=>{
                deps+= "<option value='"+ data.id+"'>"+ data.d_name+"</option>";
            });
            deps+= "</select>";
            $('.department').replaceWith(deps);
            //dynamic classes
            let classes = "<select class='form-input classes' name='class_teacher_for'>";
            response.data.classes.map((data)=>{
                classes+= "<option value='"+ data.id+"'>"+ data.value+"</option>";
            });
            classes+= "</select>";
            $('.classes').replaceWith(classes);
        });
    });
    $('.staff-show').click(function(){
        var className = '.'+$(this).attr('id');
        $('content-table').removeClass('active');
        $('.content-table').addClass('inactive');
        $(className).removeClass('inactive');
        $(className).addClass('active');
        
        
    });
    $('.delete-school').click(function(){
        delete_url = $(this).attr('url');
        $('.delete-modal').show();
    });
    $('.delete-confirm').click(function(){
        location.assign(delete_url);
    });
}); 


