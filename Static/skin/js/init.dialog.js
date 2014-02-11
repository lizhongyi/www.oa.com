/* 
* QSdialog 1.0
* http://www.jobmedia.cn/
* Date: 2011-5-15 
* Requires jQuery
*/ 
(function($) {   
$.fn.QSdialog=function(options){
	var defaults = {
    DialogAddObj:"body",	
	DialogAddType:"append",	
	DialogClosed:"关闭",
	DialogTitle:"系统提示",
	DialogWidth:"380",
	DialogHeight:"auto",
	DialogCssName:"",
	DialogContent:"",
	DialogContentType:"text"
   }
    var options = $.extend(defaults,options);
	var AddObj=options.DialogAddObj;
	var temp_float=new String;
	temp_float="<div  class=\"floatBoxBg\" style=\"height:"+$(document).height()+"px;filter:alpha(opacity=0);opacity:0;\"></div>";
	temp_float+="<div class=\"floatBox\">";
	temp_float+="<div class=\"title\"><h4></h4><span class=\"dialog_closed\">关闭</span></div>";
	temp_float+="<div class=\"content link_lan\"></div>";
	temp_float+="</div>";
	if (AddObj=="body")
	{
	$("body").append(temp_float);	
	}
	else
	{
		$(AddObj).html(temp_float);
	}
	$(".floatBox .title h4").html(options.DialogTitle);
	var content=options.DialogContent;
	switch(options.DialogContentType){
	case "url":
	var content_array=content.split("?");
	$.ajax({
    type:content_array[0],
    url:content_array[1],
    data:content_array[2],
	error:function(){
	$(AddObj+" .floatBox .content").html("error...");
	},
    success:function(html){
	//alert(html);
    $(AddObj+" .floatBox .content").html(html);
    }
  	});
  	break;
  	case "text":
	$(AddObj+" .floatBox .content").html(content);
	break;
	case "id":
	$(AddObj+" .floatBox .content").html($(content).html());
	break;
	case "iframe":
	$(AddObj+" .floatBox .content").html("<iframe src=\""+content+"\" width=\"100%\" height=\""+(parseInt(height)-30)+"px"+"\" scrolling=\"auto\" frameborder=\"0\" marginheight=\"0\" marginwidth=\"0\"></iframe>");
	}
	function dialog_closed()
	{
	$(AddObj+" .floatBox").hide();
	$(".floatBoxBg").hide();
	}
	$(".dialog_closed").click(function(){dialog_closed();});
	dialog_closed();
	this.click(function()
	{
		var width=options.DialogWidth=="auto"?"auto":options.DialogWidth+"px";
		var height=options.DialogHeight=="auto"?"auto":options.DialogHeight+"px";
		$(AddObj+" .floatBoxBg:first-child").show();
		//alert($(AddObj).html());
		$(AddObj+" .floatBoxBg").animate({opacity:"0.2"},120);
		$(AddObj+" .floatBox").attr("class","floatBox "+options.DialogCssName);
		$(AddObj+" .floatBox").css({display:"block",left:(($(document).width())/2-(parseInt(width)/2))+"px",top:($(document).scrollTop()-(height=="auto"?350:parseInt(height))),"width":width,"height":height});
		$(AddObj+" .floatBox").animate({top:($(document).scrollTop()+120)+"px"},120);
		//alert(options.DialogWidth);
	});
}
})(jQuery); 