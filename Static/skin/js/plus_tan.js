

//调取负责人ajax

$(".c_fuze").click(function(e) {

    //$("#add_fuzeren").empty();
    if ($("#add_fuzeren").html() == "" || 1 == 1) {
        geta($("#add_fuzeren"), '/Works/plus/act/fuze', loadGif);

    } else {


        $("#add_fuze").text("新增负责人");
        $(".fuze_add").hide();
        $(".fuze_list").show();
        $("#add_fuzeren .modal-header h3").text("选择负责人");


    }

});

//添加负责热弹窗操作

$("#add_fuze").live("click", 
function(e) {



    if ($(this).text() == "新增负责人") {

        $(this).text("选择负责人");
        $(".fuze_add").show();
        $(".fuze_list").hide();
        $(".plus_save").show();
        $("#add_fuzeren .modal-header h3").text("新增负责人");


    } else {
        $(this).text("新增负责人");
        $(".fuze_add").hide();
        $(".fuze_list").show();
        $(".plus_save").hide();
        $("#add_fuzeren .modal-header h3").text("选择负责人");


    }


});

//负责人传值


$(".fuze_a").live("click", 
function() {


    $("#principal_cn").val($(this).text());
    $("#principal").val($(this).attr('fid'));




});






//调用添加HR联系人ajax

$(".add_hr").click(function(e) {

    if ($("#custom_cn").val() == '') {
        $("#custom_cn").click();
        return false;

    }

    if ($("#add_hr_contact").html() == "" || 1 == 1) {
        //$("#add_hr_contact").load('/Works/plus/act/hr_contact/com_id/'+$(this).attr('com_id'));
	
        geta($("#add_hr_contact"), '/Works/plus/act/hr_contact/com_id/' + $(this).attr('com_id'), loadGif);


    } else {

        $("#add_hr").text("新增HR联系人");
        $(".hr_add").hide();
        $(".hr_list").show();
        $("#add_hr_contact .modal-header h3").text("选择HR联系人");


    }

});



$("#chongzhi").click(function(e) {


    var p = 0;
    $("#ad-gd input,#ad-gd textarea,#ad-gd select").each(function(index, element) {

        if ($(this).val() == '') {
            p = p + 1
            $(this).css({
                'border': '1px solid #ddd'
            });


        }


    });



    //if(p>0) return false;


});



$("#add_hr").live("click", 
function(e) {



    if ($(this).text() == "新增HR联系人") {

        $(this).text("选择HR联系人");
        $(".hr_add").show();
        $(".hr_list").hide();
        $(".plus_save").show();
        $("#add_hr_contact .modal-header h3").text("新增HR联系人");


    } else {
        $(this).text("新增HR联系人");
        $(".hr_add").hide();
        $(".hr_list").show();
        $(".plus_save").hide();
        $("#add_hr_contact .modal-header h3").text("选择HR联系人");


    }


});


//HR传值
$(".hr_a").live("click", 
function() {


    $("#hr_contact").val($(this).text());
    $("#hr_c").val($(this).attr('fid'));




});








/*添加客户弹窗*/


 $(".custom").click(function(e) {

    //$("#add_fuzeren").empty();
    if ($("#add_custom").html() == "" || 1 == 1) {


        //$("#add_custom").load('/Works/plus/actclientps/10');
        geta($("#add_custom"),$(this).attr('link'), loadGif);


    } else {


        $("#add_fuze").text("新增客户");
        $(".fuze_add").hide();
        $(".fuze_list").show();
        $("#add_fuzeren .modal-header h3").text("选择客户");


    }

});




$("#custom_add").live("click", 
function(e) {



    if ($(this).text() == "新增客户") {

        $(this).text("选择客户");
        $(".custom_add").show();
		
		
		
        $(".custom_list").hide();
        $(".plus_save").show();
        $("#add_custom .modal-header h3").text("新增客户");
         
		geta($(".custom_add"),'/Client/add/ajax/1',loadGif);

    } else {
        $(this).text("新增客户");
        $(".custom_add").hide();
        $(".custom_list").show();
        $(".plus_save").hide();
        $("#add_custom .modal-header h3").text("选择客户");


    }


});

//客户传值

$(".custom_a").live("click", 
function() {

    $("#custom_cn").val($(this).text());
    $("#cid").val($(this).attr('fid'));
    $(".add_hr").attr("com_id", $(this).attr('fid'));
	$("#hr_contact").val("");
	$("#hr_c").val("");
	 $("#custom_cn").blur();




});



//分页按钮

$("#add_custom .pag a").live("click", 
function() {

    $("#add_custom").load($(this).attr('link'));


});













$("#ad-gd input.bitian,#ad-gd textarea.bitian,#ad-gd select.bitian").blur(function(e) {

    if ($(this).val() == '' || $(this).val() == '请选择') {

        $(this).css({
            //'border': '1px solid orange'
        });
        //$(this).focus();


    } else {
        $(this).css({
           // 'border': '1px solid #ddd'
        });

    }


});
$("#area_cn,#industry_input,#hr_contact,#principal_cn").keyup(function() {

    $(this).val('请选择');


});


//添加负责热弹窗操作

















//*==========================================客户页面查看详细=================================*//



//展开详细的评论


$(".zk_detail").click(function(e) {
    $(this).parent().height() == 200 ? $(this).parent().css('height','auto') : $(this).parent().height(200);
    $(this).find(".str").text() == '折叠工单详情' ? $(this).find(".str").text('展开工单详情') : $(this).find(".str").text('折叠工单详情');

});











//调用候选人添加表单


$("#stage_box .tab-bar").click(function(e) {

        $yuan = $(this).parent().next().find(".tab_con_box").eq($(this).index());
		
		    if ($(this).attr("zid") == 1) {
                $(".add_condidate").show();

            } else {
                $(".add_condidate").hide();

            }
			
			if ($(this).attr("zid") == 10) {
                   
                   $('.add_works_team').show();
                } else {
                   $('.add_works_team').hide();

                }
			
			
			
			
      
   

        if ($(this).attr("zid") < 10) {

         if ($yuan.find('.clist').html() == "") {
			 
                geta($yuan.find('.clist'),$(this).attr('link'), loadGif);

            } else {
                geta($yuan.find('.clist'),$(this).attr('link'));

            }
			
            var stage_k=parseInt($(this).attr("zid")+1);
        } 
            
          


            if ($(this).attr("zid") == 10) {
                $url=$(this).attr('link');
				 
				 
            if ($yuan.find('.clist').html() == "") {
				
                geta($yuan.find('.clist'), $url, loadGif);

            } else {
                geta($yuan.find('.clist'), $url);

            }
			
            } 
			
			
			
			
			
			
			 if ($(this).attr("zid") == 11) {
				 
				
                $url=$(this).attr('link');
				 
				 
            if ($yuan.find('.clist').html() == "") {
				
                geta($yuan.find('.clist'), $url, loadGif);

            } else {
                geta($yuan.find('.clist'), $url);

           }}
		   
		   
		   if ($(this).attr("zid") == 12) {
				 
				
                $url=$(this).attr('link');
				 
				 
            if ($yuan.find('.clist').html() == "") {
				
                geta($yuan.find('.clist'), $url, loadGif);

            } else {
                geta($yuan.find('.clist'), $url);

           }}




          //统计
		  
		  
		  if ($(this).attr("zid") == 13) {
				 
				
                $url=$(this).attr('link');
				 
				 
            if ($yuan.find('.clist').html() == "") {
				
                geta($yuan.find('.clist'), $url, loadGif);

            } else {
                geta($yuan.find('.clist'), $url);

           }}






       


});














//保持刷新不变这里我原来写了一大堆废话真难受啊。。。。
$('.tab .tab-bar').each(function(index, element) {

    if (decodeURI(location.hash) == $(this).attr('href')) {
	
      $("#tab_"+$(this).attr('zid')).click();
		
     }

});







//添加候选人js

$(".add_condidate").click(function(e) {

    geta($("#add_candidate"),$(this).attr('link'), loadGif);


});


//添加内部团队js


$(".add_works_team").live("click", 
function(e) {

    geta($("#add_works_team"),$(this).attr('link'), loadGif);


});


//设置提成属性js


$(".set_ticheng").live("click", 
function(e) {
  //$("#set_ticheng").empty();
    geta($("#set_ticheng"), '/Ticheng/index/ajax/1/cid/' + $(this).attr('gid')+'/hname/'+$(this).attr('hname'), loadGif);


});

//查看佣金详情

$(".yeji_detail").live("click", 
function(e) {
    
	
	/*$tr=$(this).closest('tr').html();
	$rr=/<td align="center">(.*)<\/td>/ig;
	$tr=$tr.replace($rr,"");*/
	
	
	
	           /* 这一段代码不是很实用好学要后台去调出
			   
			    $tdh="";
				 $arr=$(this).closest('tr').find('td');
				 $arr.each(function(i) {
					if(i<6){ 
					$tdh+='<td>'+$(this).html()+'</td>';
					}
                });
	*/
	 
    
	
	
    $("#yeji_detail").empty();
	
	
     
		
		
	  geta($("#yeji_detail"),$(this).attr('link'), loadGif); 
	
	
	
	
});

//设置候选人团队

$(".set_nteam").live("click", 
function(e) {
	geta($($(this).attr('href')),$(this).attr('link')+'/ajax/2', loadGif); 
	
});







/*修改操作*/

$(".modfy-a").live("click", 
function(e) {

    geta($($(this).attr('href')), $(this).attr('link'), loadGif);


});


$("a.page-a").live("click", 
function(e) {
    $("#" + $(this).attr("loadbox")).load($(this).attr('link'));
});	  
	



/*删除操作*/
$(".del-a").live("click", 
function(e) {
    if (ajax == 1) {

            tdata={ajax:1};
			
		 cb={bf:function(){
			
			   },su:function(data){
				 
				 $(this).attr('loadbox').click();
				 
				}
				
		 }
		
            ajaxForm($(this).attr('link')+'&ajax=1', tdata,cb);
			
		   
			  
			

    } else {

        window.location = $(this).attr('link') + "/maodian/" + location.hash.substr(1, 20);


    }

});





//================批量操作表格北京变色==================//

$(".piliang_box").live("change",function(e) {
	
     
	    if($(this).attr('checked')=='checked'){
		  
		   $(this).parents("tr").css("background","#F0FFF0");
		    
		 }else{
			 $(this).parents("tr").css("background","#FFF");
			 }
	
});


/**=================二级联动菜单=================*/

$(".erji-s .big-s").live("change", 
function(e) {
    $v = $(this).val();
    $opts = get_select_c(selecter.stages[$v]);
    if ($opts == '') {
        $(this).parent().find('.small-s').html("").hide();
        return false;

    }
    if ($v != '') {
        $(this).parent().find('.small-s').html($opts).show();

    } else {
        $(this).parent().find('.small-s').html("").hide();

    }

});


/****=====================操作二级菜单=========================****/


$(".stage_ul li a").live("click", 
function(e) {

    $(this).parents().find('.ckd').html($(this).text() + '　<span class="caret" style="color:#CCC"></span>');
    $(this).parents().find('.sid').val($(this).attr('sid'));
    $(this).parents().find('.stage_cn').val($(this).attr('stage_cn'));


});


/*=== 查询团队候选人====*/


$("#se_team_bt").click(function(e) {
	   $url=$(this).attr('action')+'/uid/'+$("#t_uid").val()+'/ajax/1';
        if($("#t_stage").val()!=0){
	 	$url+='/s_stage/'+$("#t_stage").val();
		}
		if($("#kewords").val()!=""){
              $url+='/keywords/'+$("#kewords").val();
           }
		//window.location=$url;
	
	geta($("#tlist_box"),$url, loadGif); 
	
	
	
});


	  //指定给里面的拖动h3 移动父窗口
    $( ".modal" ).draggable({ handle: ".modal-header" });


/*******************=========ajax 批量提交操作===========*******************************/








 /*异步加载js数据*/
    $(".suser").bind("keyup paste",function() {
		       
			    $this=	$(this);
				// $("#"+$this.attr('toid')).val("");
		        setTimeout(function(){
				 if ($this.val() == "") {
                 //$(this).blur();
			       xx=1
			      }else{
				   xx=2
				  }
				 // alert(1); 
				  y=$this.offset().top+27+'px';
				  x=$this.offset().left+'px';
				  w=$this.width()+8;
				  $(".uli").css({'top':y,'left':x,'width':w});
                  $this.attr("toid","");
				   xuhao = "[";
				   nr = "<div class='ajax_list'>";
		           p = 0;
				   s =$this.val();
				  datalist=eval($this.attr('data'));
				 // alert(d);
				  /*先匹配用户名*/

for (k = 0; k < 10; k++) {
            time = 0;
                while (time < xx && p < 10) {
                    type = ['realname', 'pinyin'];

                for (var i = 0; i < datalist.length; i++) {

                        items = datalist[i][type[time]].toLowerCase();
                        result = items.indexOf($this.val().toLowerCase());
                    if (result == k && p < 10) {
                        nr += "<a href=\"javascript:;\" class=\"x_user\" toid=" + datalist[i].id + " uname=" + datalist[i].realname + " order=" + result + p + ">";
                        nr += "<div class=\'ubox\'>";
                       // nr += "<div class=\'uface\'>";
                        //nr += "<img src='" + userlist[i].face + "' width=\'30\' height=\'26\'/>";
                       // nr += "</div>";
                        nr += "<div class=\'ucont\'>";
						nr += "<div class=\'u_name\'><span>" + datalist[i].realname.split(s).join('<b>' + s + '</b>') + "</span> </div>";
						nr += "</div>";
                        nr += "<div class=\'cl\'></div>";
                        nr += "</div>";
                        nr += "</a>";
                        xuhao += (result + time) * (time + 1) + ",";
                        p++;
						
						
                    } else {
                      
                        
                    }

                }
                time++;
             }
         }


         nr += "</div>"
		 
		 
        $(".uli").html(nr).show();
		
	
			$(document).click(function(e) {
               var e = e || window.event,
               target = e.srcElement || e.target;
               if (target.id != $this.attr("id"))
               {
				
				$(".uli").hide();
		      }
		
		 });	
	   
		  },12);		
		  
		  
		  
		  
		  
		  
		  
		$('.ajax_list .x_user').live("click", 
              function() {
						  $this.val($(this).attr("uname"));
						  $this.prev().val($(this).attr("toid"));
						  $(".uli").html("").hide();
						  //$("#ajax_user").hide();
        
        

    });  
		  
		  
		

	});
	
	
				 

		  

 //cancle have no keyword show div.
/*
$(".suser").focus(function(e) {
     $(this).val("");
	 $(this).prev().val("");
	 $(this).keyup();
	 
});*/

$(".suser").blur(function(e) {
          $this=$(this);
		  setTimeout(function(){
	        if($("#uid").val()=="" && $this.val() != ''){
		      msg("没有这个用户请正确选择",2000);
			  $("#suser").val("");
		    }
		  },20);
	 
});

 /*$('.datepicker').each(function(e) {
    
	     if($(this).val()==''){
			 
			var d = new Date(new Date().getTime());
 $(this).val(d.getFullYear()+"-"+(d.getMonth()+1)+"-"+d.getDate()+"");
			 
			 }
});*/


  var defaultOptions = {
            dateFormat: "yy-mm-dd",
            showMonthAfterYear: true,
            dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
			monthNames:['1','2','3','4','5','6','7','8','9','10','11','12'],
            nextText: '>',
            prevText: '<',
			changeMonth: true,
            changeYear: true
			
		

        };
       // $("#time").datepicker(defaultOptions);
      
  
  $('.datepicker').datepicker(defaultOptions);
  
   $(".guanbi").click(function(){
	   
	   $(this).parent().remove();
	 
	 });




//读取所有客户名称


$(".client_name").each(function(index, element) {
    
	  
	  $(this).text(showname(customlist,$(this).attr('cid')));
	 
	
});

$("#msgbar").click(function(e) {
    
	// alert(1);
	 //geta($("#messages"),'/Inform/getTotal',loadGif);
	 
});


function guolv(str) {
    var regS = new RegExp(/(\'|\"|\\)/g);
    var ge = '\$1';
    var regR = /\r/g;
    var regN = /\n/g;
    var ret = str.replace(regR, "<br/>").replace(regN, "<br/>").replace(regS, ge);


    return ret;


}


  $("#chongzhi").click(function(e) {
      
	  window.location=$(this).attr('link');
	
});




//刷新职位
$(".shua").click(function(e) {
     //加载刷新代码
	 $this=$(this);
	 gid=$(this).attr('gid');
	// alert(gid);
	 if(!gid){
		   return false;
	}
	
	$.ajax({
		   url:"/Works/up",
		   type:"POST",
		   data:{gid:gid},
		   beforeSend: function(){
			  $this.find('i').attr('class','icon-time');
			},
		    success:function(data){
				if(data.status==1){
				 	
				    window.location.reload();
				   
					}else{
						
						alert("出错了")
						
						}
				
		}
	      	
		
	})
	  
});