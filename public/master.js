$(document).ready(function(){
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
        $(this).addClass('active');
    });
}); 


