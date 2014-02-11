$(document).ready(function() {
	
   //折叠版
   
     $("a.im-bar").click(function(e) {
        //总感觉这是是个比较鸡肋的功能
		
		
		
		$this=$(this);
		
		
	/*	left=($(window).width()-700) / 2;
		window.open ($this.attr('link'), 'newwindow'+$this.attr('uid'), 'height=540, width=700, top=200, left='+left+', toolbar=no, menubar=no, scrollbars=no, resizable=no,location=no, status=no')
		*/
		
		
		
		
		
		
		
		
		$wid="w_"+$this.attr('uid');
		//这个地方真的是鸡肋的功能
		if($("#"+$wid).length==0){
		
		$("<div class='windows modal' id='"+$wid+"' > <div class='modal-header' style=' position:absolute !important; background:none !important; width:80%; height:60px;z-index:999999; border:0px;cursor:move'> </div><iframe frameborder=\"0\" width=\"100%\" height=\"100%\" src="+$this.attr('link')+"></iframe></div>").appendTo('body').show().draggable({ handle: ".modal-header" });
		
		$this.find('.tome').remove();
		
		
		
		
		
	
		
		
		
		
		
		
		

		}else{
			
			$("#"+$wid).show();
			
			}
		
    });
	
	
	
	
	
	
	
	$('.bottom_tooltip').tooltip({
		placement: 'bottom'
	});
	$('.left_tooltip').tooltip({
		placement: 'left'
	});
	$('.right_tooltip').tooltip({
		placement: 'right'
	});
	$('.top_tooltip').tooltip();
	$('.dropdown-menu.dropdown-user-account').click(function(event){
		event.stopPropagation();
	});
	//$('#myEditor').wysihtml5();
	$('.accordion-body.collapse.in').prev('.accordion-heading').addClass('acc-active');
	$('.accordion-heading').live('click', function(){
		$('.accordion-heading').removeClass('acc-active');
		$(this).addClass('acc-active');
	});
	   
	   
	   //备注提示
	  $(".beizhu").popover().
      click(function(e) {
        e.preventDefault()
      });
	  
	  $("input:text").attr('autocomplete','off');
		  
		  
	/*分页操作*/

$("a.page-a").live("click", function(e) {


    $("#" + $(this).attr("loadbox")).load($(this).attr('link'));


});	  
		  
		 
	
	
	
//set persona	
$(".set_persona").click(function(e) {
  
	 $("#set_persona").empty();
	 geta($("#set_persona"),$(this).attr('link'),loadGif);
	
});

	
		  
	 
	
});


function checkAll(form, name) {
	for(var i = 0; i < form.elements.length; i++) {
		var e = form.elements[i];
		if(e.name.match(name)) {
			e.checked = form.elements['chkall'].checked;
			e.dis
			if(e.checked==true){
			$(e).parents("tr").css("background","#F0FFF0");
			}else{
				e.disabled=false;
				$(e).parents("tr").css("background","#FFF");
				}
		}
	}
}



function geta(obj,url,bef,tdata,fun){
	   
	   $.ajax({
		   url:url,
		   data:tdata,
		   type:"GET",
		    cache:true,
		   beforeSend: function(){
			    if(bef){
			     obj.html(loadGif);
				}
			   },success: function(data){
				   
				   if(typeof(data)=='object'){
				   obj.html("<div class='nodata'>"+data.info+"</div>");
				   }else{
					    obj.html(data);
					   }
				 
				   setTimeout(function(){
					     checkJine(); 
						 
					   },10);
				   
					   
				   if(fun){
				      fun();
				    }
				   }
			    })
		   }
		   
		   
		   
//全局tab
$('.tab .tab-bar').click(function(index) {

    $(this).addClass('hover').siblings().removeClass('hover');
    $(this).parent().next().find(".tab_con_box").eq($(this).index()).fadeIn(0).siblings().fadeOut(0);
    //alert(location.hash);

});

// checkJine();
//金额三位加一个逗号
//alert($("span.jine").length)
function checkJine(){
	
  $("span.jine").each(function(index, element) {
     
	 
	 $jin=$(this).text().replace("￥","").split("").reverse().join("");
	 
	 
	//alert($jin)
	 nus="";
	
	 for(i=$jin.length-1;i>=0;i--){
		   
               if(i % 3 == 0 && i !=0){		  
			   
			   nus+=$jin[i]+',';
			   }else{
				    nus+=$jin[i];
				   }
			
		   
		 }
		 if(nus!=0){
			 
	  $(this).text("￥"+nus);
	  $(this).removeClass('jine');
	  }else{
		   $(this).text("");
		   $(this).removeClass('jine');
	}
});

}
 checkJine();

  $(function() {
	  //指定给里面的拖动h3 移动父窗口
    $( ".modal" ).draggable({ handle: ".modal-header" });
	
	
	// this code is  inform jumpwindow for show  list  
  $(".inform-bar").click(function(e) {
	  if($(this).attr("id")=='sms'){
		  
		  window.location=$(this).attr('link');
		    
	  }else{
        geta($("#inform_box"),$(this).attr('link'),loadGif);
	  }
});

$("#zhidaole").click(function(e) {
      
	$("#msgbar").click();
});


    $(".menu-t").click(function(e) {
        // alert("nihao");
		 $(this).next().toggle();
		
    });
	
	
	
	
	
	
	
	
	
  });

function yan_fn(obj,msg,btn){
	
	     
		 
		         if(msg!=''){
				               obj.addClass('bred');
				               if(obj.next().length==0){
					           obj.parent().append("<span class='ms'>"+msg+"</span>")
					         }  //obj.val("");
				               btn.attr('disabled',true);
							   return false;
				 }else{
					   obj.removeClass('bred'); 
					   obj.next(".ms").remove();
					     btn.attr('disabled',false);
					 }
					 
	    
	}

//提示函数

function msg(str,status){
	   
	   if(status=='s'){
		    
			
			var $msg="<h4 class='ui-pnotify-title'>Good News Everyone</h4>";
			 $msg+=str;
			 
			$("#msg .msg-text").html($msg);
		    $("#msg").addClass('ui-pnotify-container alert-success ui-pnotify-shadow').add(str).fadeIn(400);
			 
			 setTimeout(function(){
				 $("#msg").fadeOut(300);
				 },3000)
			
		   }else{
			    $("#msg").addClass('red').html(str).show();
				return false;
			   }
	
	}
//alert ui-pnotify-container alert-success ui-pnotify-shadow