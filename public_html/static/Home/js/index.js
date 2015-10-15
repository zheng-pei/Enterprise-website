// JavaScript Document
$(function(){
	
	    $('.boxcon a').click(function(){
			$(this).addClass('cur').siblings().removeClass('cur');
			var setIndex=$(this).index();
			$(this).parents('.teambox').find('.teamlist').hide();
			$(this).parents('.teambox').find('.teamlist').eq(setIndex).fadeIn();
				
			})
		$('#controls a').click(function(){
			$(this).addClass('cur').siblings().removeClass('cur');
			var number=$('#controls a').index($(this));
			//$('.newscon').eq(number).css('display','block').siblings().css('display','none');
			$(this).parents('.news').find('.newscon').hide();
			$(this).parents('.news').find('.newscon').eq(number).fadeIn();
			})
		
	
	})
/*tab自动切换*/
$(function(){
    var i=0;
    var canmove=true;
    $('.conguide a').click(function(){
        //canmove=false;
        clearInterval(li_timer);
        i=$(this).index();
        $(this).addClass('cur').siblings().removeClass('cur');
        $(this).parent().siblings('.con_left_t').hide();
        $(this).parent().siblings('.con_left_t').eq(i).fadeIn();
    });
 
    $(".con_left_t").mouseenter(function(){//只要用户鼠标在这个区域内，就不自动跳转
        canmove=false;
    }).mouseleave(function(){
        clearInterval(li_timer);
        setTimeout(function(){canmove=true;},8000);//8秒后自动切换
    });
 
    function li_timer(){
        if(canmove){
            i++;
            if(i==$('#news_con .conguide a').length){
                i=0;
            }
            $('#news_con .conguide a').eq(i).addClass('cur').siblings().removeClass('cur');
			$('#news_con .con_left_t').hide();
            $('#news_con .con_left_t').eq(i).fadeIn();
			if(i==$('#news_con1 .conguide a').length){
                i=0;
            }
			$('#news_con1 .conguide a').eq(i).addClass('cur').siblings().removeClass('cur');
			$('#news_con1 .con_left_t').hide();
            $('#news_con1 .con_left_t').eq(i).fadeIn();
			if(i==$('#news_con2 .conguide a').length){
                i=0;
            }
			$('#news_con2 .conguide a').eq(i).addClass('cur').siblings().removeClass('cur');
			$('#news_con2 .con_left_t').hide();
            $('#news_con2 .con_left_t').eq(i).fadeIn();
        }
 
    }
    setInterval(li_timer,8000);//每8秒切换
});	
//全屏轮播滚动
$(function(){

    var len = $(".guide a").length;
    var index = 0;  
    var adTimer;
    $(".guide a").mouseover(function() {
        index = $(".guide a").index(this);  //获取鼠标悬浮 li 的index
        showImg(index);
    }).eq(0).mouseover();
    //滑入停止动画，滑出开始动画.
    $('#focus').hover(function() {
        clearInterval(adTimer);
    }, function() {
        adTimer = setInterval(function() {
            showImg(index)
            index++;
            if (index == len) {       //最后一张图片之后，转到第一张
                index = 0;
            }
        }, 3000);
    }).trigger("mouseleave");
   
    function showImg(index) {
        var adwidth = $(window).width();
		var ulwidth = $("#focus li").width()*len;
		$("#focus ul").css('width',ulwidth+'px');
		$("#focus li").css('width',adwidth+'px');
        $("#focus ul").stop(true, false).animate({
            "marginLeft": -adwidth * index + "px"    //改变 marginTop 属性的值达到轮播的效果
        }, 1000);
        $(".guide a").removeClass("cur").eq(index).addClass("cur");
    }
	showImg(index);
	$(window).resize(function(){
		showImg(index);
		})

	})