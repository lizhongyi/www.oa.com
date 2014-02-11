 
 /***==============================操作所有select函数======================================***/
 
 //全局选项卡


 
var loadGif = "<img src='/Static/skin/images/load.gif' class='loadbig' align='center' />";
var loader="<img src='/Public/img/loader_16.gif'/>";
var ajax = 0;


function get_select(obj,arr,id){
	         
			 obj1=document.getElementById(obj+"_1");
	         opt="<select id='"+obj+"' name='"+obj+"' class='big-s span2' style='width:180px;display:block'>";
			 if(!arr) return false;
			 
		   if(!id){
		 
		   for(i=0;i<arr.length;i++){
			   
			    if(i<8){	
			
			  opt+='<option value="'+i+'">'+arr[i]+'</option>';
			}
			}
		   }else{
			   
			    for(i=0;i<arr.length;i++){
				  
				  if(i<8){	
					
			    if(id==i){
			   opt+='<option value="'+i+'" selected>'+arr[i]+'</option>';
			   
			    }else{
					 opt+='<option value="'+i+'">'+arr[i]+'</option>';
					}
			}
			}
			   
			   }
			   
			   opt+="</select>"
			   
			   //alert(obj.attr('id'));
			   
	            obj1.innerHTML=opt;
		       
			 
	}
	
	
	
	
	
	
	
	
	
	function get_select_b(obj,arr,id){
	         
			 obj1=document.getElementById(obj+"_1");
	       opt="<select id='"+obj+"' name='"+obj+"' class='small-s span2' style='width:180px;'>";
			 if(!arr) return false;
			 
		   if(!id){
		 
		   for(i=0;i<arr.length;i++){
			
			  opt+='<option value="'+i+'">'+arr[i]+'</option>';
			
			}
		   }else{
			   
			    for(i=0;i<arr.length;i++){
			    if(id==i){
			   opt+='<option value="'+i+'" selected>'+arr[i]+'</option>';
			   
			    }else{
					 opt+='<option value="'+i+'">'+arr[i]+'</option>';
					}
			
			}
			   
			   }
			   
			 
			     opt+="</select>";
	       $(obj1).prev().append(opt);
		       
			 
	}
	

	
	
	
	function get_select_c(arr,id){
	         opt="";
			 if(!arr) return false;
			 
		   if(!id){
		 
		   for(i=0;i<arr.length;i++){
			
			  opt+='<option value="'+i+'">'+arr[i]+'</option>';
			
			}
		   }else{
			   
			    for(i=0;i<arr.length;i++){
			    if(id==i){
			   opt+='<option value="'+i+'" selected>'+arr[i]+'</option>';
			   
			    }else{
					 opt+='<option value="'+i+'">'+arr[i]+'</option>';
					}
			
			}
			   
			   }
			   
    return(opt);
		       
			 
	}
	
	function get_sinfo(obj,arr,id,str){
		      
			  //
			   opt="";
			    obj=document.getElementById(obj);
			 if(!arr) return false;
			 
		   if(!id){
			   return false;
			   }
		      
			 if(str){
			 obj.innerHTML=arr[id]+str;
			 }else{
				  obj.innerHTML=arr[id];
				 }
		}
		
		
		
	function selecter_list(str,num){
		     
			 li='';
			 k=0;
			if(str){
				 
				 for(i=1;i<9;i++){
					 
					 if( i>=num){
					 k=i+1;
					
					 li+='<li><a href="javascript:;" set_pype="stage" sid='+k+' stage_cn='+selecter.stage[k]+'><i class="icon-th-large"></i>　'+selecter.stage[k]+'</a></li>'       }
					 
					
					 
					 }
					li+='<li><a href="javascript:;" set_pype="del" sid="100"><i class="icon-trash large"></i>　回收站</a></li>'; 
			      return li;	
				}
		     
		
		}	
		
		
		
		/***==============================ajax函数操作======================================***/
		
		
		
	
		   
		   
		   
		   /***========================= 获取表达===========================================================***/
		   
		   
		    function getItem() {
        var selectRow = Array();
        var obj = document.getElementsByName('module');
        var result = '';
        var j = 0;
        for (var i = 0; i < obj.length; i++) {
            if (obj[i].checked == true) {
                selectRow[j] = i + 1;
                result += obj[i].value + ",";
                j++;
            }
        }
        return result.substring(0, result.length - 1);
    }







/*===================ajax==============================*/




function ajaxForm(url,tdata,cb) {

    $.ajax({

        url: url,
        type: 'POST',
        data: tdata,
        beforeSend: function() {
                
			cb.bf();	          
 
        },

success: function(data) {
        
		  cb.su(data);
            
}




    })


};

/***********alert****************/

function msg(info,time){
	     
		 if(time){
	     $("#msg").html(info).show().fadeOut(time);
		 }else{
			 $("#msg").html(info).show();
			 }
	}


//获取客户名字



function showname($obj,id){
	     
		 
		 for(i=0;i<$obj.length;i++){
			 
			      if($obj[i].id==id){
					   
					   document.write($obj[i].companyname);
					  
					  }
				 
			 }
		  
	
	}
	
	
	function showResutl($str,$st){
		           
		           $("body").append("<div id='result'><div>");
				       if($st==0){
					        $("#result").addClass('err'); 
					   }else{
						    $("#result").addClass('suc'); 
						  }
				   $("#result").html($str).fadeIn();
				   setTimeout(function(){
					   $("#result").fadeOut();
					   
					   },3000);
				   //$("#result").remove();
		  
		}
		
		
		
		
		
		
		
		
		
		function isNumber($id){
 isNum = /^[0-9]*$/;
 alert(isNum.test($id.value));
}





















							  
							  
							  
	