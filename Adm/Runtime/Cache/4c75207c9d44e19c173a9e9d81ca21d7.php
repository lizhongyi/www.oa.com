<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>oa系统</title>
         <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="author" content="stilearning" />


        <!-- google font -->
        <link href="http://fonts.googleapis.com/css?family=Aclonica:regular" rel="stylesheet" type="text/css" />
 <link href="/Static/skin/css/jquery-ui.css" rel="stylesheet"/>

        <!-- styles -->
        <link href="/Public/css/bootstrap.css" rel="stylesheet" />
        <link href="/Public/css/bootstrap-responsive.css" rel="stylesheet" />
        <link href="/Public/css/stilearn.css" rel="stylesheet" />
        <link href="/Public/css/stilearn-responsive.css" rel="stylesheet" />
        <link href="/Public/css/stilearn-helper.css" rel="stylesheet" />
        <link href="/Public/css/stilearn-icon.css" rel="stylesheet" />
        <link href="/Public/css/font-awesome.css" rel="stylesheet" />
        <link href="/Public/css/animate.css" rel="stylesheet" />
        <link href="/Public/css/uniform.default.css" rel="stylesheet" />
           <script src="/Static/skin/js/functions.js"></script>
        <script src="/Static/skin/js/array.js"></script>
        <link href="/Public/css/select2.css" rel="stylesheet" />
        <link href="/Public/css/fullcalendar.css" rel="stylesheet" />
        <link href="/Public/css/bootstrap-wysihtml5.css" rel="stylesheet" />
         <link href="/Public/css/diy.css" rel="stylesheet" />

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

    <body>
        <!-- section header -->
        <header class="header">
            <!--nav bar helper-->
            <div class="navbar-helper">
                <div class="row-fluid">
                    <!--panel site-name-->
                    <div class="span2">
                        <div class="panel-sitename">
                            <h2><a href="/"><span class="color-teal"></span>OAadmin</a></h2>
                        </div>
                    </div>
                    <!--/panel name-->

                    <div class="span6">
                        <!--panel search-->
                        <!--/panel search-->
                    </div>
                    <div class="span4">
                        <!--panel button ext-->
                        <div class="panel-ext">
                            <div class="btn-group">
                                <!--notification-->
                                
                                
                                <?php if($infoTotal != 0): ?><a class="btn btn-danger btn-small" data-toggle="dropdown" href="javascript:;" title="<?php echo ($infoTotal); ?>条新通知"><?php echo ($infoTotal); ?></a><?php endif; ?>
                                
                                
                              
                                <ul class="dropdown-menu dropdown-notification">
                                    <li class="dropdown-header grd-white"><a href="#">View All Notifications</a></li>
                                    <li class="new">
                                        <a href="#">
                                            <div class="notification">John Doe commented on a post</div>
                                            <div class="media">
                                                <img class="media-object pull-left" data-src="/Public/js/holder.js/64x64" />
                                                <div class="media-body">
                                                    <h4 class="media-heading">Lorem ipsum <small class="helper-font-small"> john doe</small></h4>
                                                    <p>Raw denim you probably haven't heard of them jean shorts Austin.</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="new">
                                        <a href="#">
                                            <div class="notification">Request new order</div>
                                            <div class="media">
                                                <img class="media-object pull-left" data-src="/Public/js/holder.js/64x64" />
                                                <div class="media-body">
                                                    <h4 class="media-heading">Tortor dapibus</h4>
                                                    <p>Vegan fanny pack odio cillum wes anderson 8-bit.</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="new">
                                        <a href="#">
                                            <div class="notification">Request new order</div>
                                            <div class="media">
                                                <img class="media-object pull-left" data-src="/Public/js/holder.js/64x64" />
                                                <div class="media-body">
                                                    <h4 class="media-heading">Lacinia non</h4>
                                                    <p>Messenger bag gentrify pitchfork tattooed craft beer.</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="notification">John Doe commented on a post</div>
                                            <div class="media">
                                                <img class="media-object pull-left" data-src="/Public/js/holder.js/64x64" />
                                                <div class="media-body">
                                                    <h4 class="media-heading">Lorem ipsum <small class="helper-font-small"> john doe</small></h4>
                                                    <p>Raw denim you probably haven't heard of them jean shorts Austin.</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="notification">Request new order</div>
                                            <div class="media">
                                                <img class="media-object pull-left" data-src="/Public/js/holder.js/64x64" />
                                                <div class="media-body">
                                                    <h4 class="media-heading">Tortor dapibus</h4>
                                                    <p>Vegan fanny pack odio cillum wes anderson 8-bit.</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <div class="notification">Request new order</div>
                                            <div class="media">
                                                <img class="media-object pull-left" data-src="/Public/js/holder.js/64x64" />
                                                <div class="media-body">
                                                    <h4 class="media-heading">Lacinia non</h4>
                                                    <p>Messenger bag gentrify pitchfork tattooed craft beer.</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- <li class="dropdown-footer"><a href=""></a></li> -->
                                </ul><!--notification-->
                            </div>
                            <div class="btn-group">
                                <a class="btn btn-inverse btn-small dropdown-toggle" data-toggle="dropdown" href="#">
                                    快捷导航
                                </a>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                                                      
                                    <li><a tabindex="-1" href="<?php echo U('Works/index');?>">我的工作单</a></li>
                                    <li><a tabindex="-1" href="<?php echo U('Usermsg/index');?>">私信　<?php if($sixin != 0): ?><span class="badge badge-important"><?php echo ($sixin); ?></span><?php endif; ?></a></li><li><a tabindex="-1" href="<?php echo U('Schedule/index');?>">日程表</a></li>
                                    <li class="divider"></li>
                                    <li class="dropdown-submenu">
                                        <a tabindex="-1" href="#">系统通知</a>
                                        <ul class="dropdown-menu">
                                            <li><a tabindex="-1" href="/Inform/index">工作单通知</a></li>
                                            <li><a tabindex="-1" href="/Inform/candidate">候选人通知　<?php if($c_inform != 0): ?><span class="badge badge-important"><?php echo ($c_inform); ?></span><?php endif; ?></a></li>
                                        </ul>
                                    </li>
                                    
                                    
                                </ul>
                            </div>
                            <div class="btn-group">
                                <a class="btn btn-inverse btn-small" href="#">其他操作</a>
                            </div>
                            <div class="btn-group user-group">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <img class="corner-all" align="middle" src="/Public/img/user-thumb.jpg" title="<?php echo ($uname); ?>" alt="<?php echo ($uname); ?>" /> <!--this for display on PC device-->
                                    <button class="btn btn-small btn-inverse"><?php echo ($uname); ?></button> <!--this for display on tablet and phone device-->
                                </a>
                                <ul class="dropdown-menu dropdown-user" role="menu" aria-labelledby="dLabel">
                                    <li>
                                        <div class="media">
                                            <a class="pull-left" href="#">
                                                <img class="/Public/img-circle" src="/Public/img/user.jpg" title="profile" alt="profile" />
                                            </a>
                                            <div class="media-body description">
                                                <p><strong><?php echo ($uname); ?></strong>|<?php echo ($permission_tile); ?></p>
                                                <p class="muted">johndoe@mail.com</p>
                                                <p class="action"> <a class="link" href="#">设置</a></p>
                                                <a href="bonus-page/resume/index.html" class="btn btn-primary btn-small btn-block">详细资料</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-footer">
                                        <div>
                                            <a class="btn btn-small pull-right" href="/User/logout">登出</a>
                                            <a class="btn btn-small" href="#">新增 账号</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div><!--panel button ext-->
                    </div>
                </div>
            </div><!--/nav bar helper-->
        </header>                    
<section class="section">
            <div class="row-fluid">
                <!-- span side-left -->
                <div class="span1">
                  
                    <!--side bar-->
                    
                      <aside class="side-left">
                        <ul class="sidebar">
                            <li <?php if($module == 'index'): ?>class="active first"<?php endif; ?>> <!--always define class .first for first-child of li element sidebar left-->
                                <a href="/" title="dashboard">
                                    <div class="helper-font-24">
                                        <i class="icofont-dashboard"></i>
                                    </div>
                                    <span class="sidebar-text">控制面板</span>
                                </a>
                            </li>
                             <li <?php if($module == 'Works'): ?>class="active"<?php endif; ?>>
                                <a href="<?php echo U('User/index');?>" title="interface">
                                    <div class="helper-font-24">
                                        <i class="icofont-list-alt"></i>
                                    </div>
                                    <span class="sidebar-text">用户中心</span>
                                </a></li>
                                
                                
                                
                            <li <?php if($module == 'Works'): ?>class="active"<?php endif; ?>>
                                <a href="<?php echo U('Works/index');?>" title="interface">
                                    <div class="helper-font-24">
                                        <i class="icofont-list-alt"></i>
                                    </div>
                                    <span class="sidebar-text">工作单</span>
                                </a>
                                <ul class="sub-sidebar-form corner-top shadow-white">
                                    <li class="title muted">操作</li>                  
                                    
                                    
                                    
                                    
                                    
                                    <li>
                                       <a href="<?php echo U('Works/index');?>"><i class="icofont-file"></i><span class="sidebar-text">我的工作单</span></a>
                                    </li>
                                    <li>
                                       <a href="<?php echo U('Works/add');?>"><i class="icofont-plus"></i><span class="sidebar-text">创建工作单</span></a>
                                    </li>
                                    
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo U('Works/partake');?>" title="form element" class="corner-all">
                                            <i class="icofont-file"></i>
                                            <span class="sidebar-text">我参与的工作单</span>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo U('Works/all');?>" title="code editor" class="corner-all">
                                            <i class="icofont-book"></i>
                                            <span class="sidebar-text">工作单管理</span>
                                        </a>
                                    </li>
                                     <li class="divider"></li>
                                    <li>
                                        <a href="/Works/recycle" title="trash" class="corner-all">
                                            <i class="icofont-trash"></i>
                                            <span class="sidebar-text">回收站</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li <?php if($module == 'Candidate'): ?>class="active"<?php endif; ?>>
                                <a href="<?php echo U('Candidate/search');?>" title="候选人">
                                
                                    <div class="helper-font-24">
                                        <i class="icofont-group"></i>
                                    </div>
                                    <span class="sidebar-text">候选人</span>
                                </a>
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                <ul class="sub-sidebar-form corner-top shadow-white">
                                    <li class="title muted">操作</li>                  
                                    
                                    
                                    <li>
                                       <a href="<?php echo U('Candidate/search');?>"><i class=" icon-search"></i>
                                       <span class="sidebar-text">候选人查询</span></a>
                                    </li>
                                    
                                   
                                  
                                 
                                     <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo U('Candidate/recycle');?>" title="trash" class="corner-all">
                                            <i class="icofont-trash"></i>
                                            <span class="sidebar-text">回收站</span>
                                        </a>
                                    </li>
                                </ul>
                                
                                
                                
                                
                                
                                
                            </li>
                            
                            
                            
                             <li     <?php if($module == 'Commission' ): ?>class="active"<?php endif; ?>  <?php if($module == 'Collection' ): ?>class="active"<?php endif; ?>" >
                                <a href="<?php echo U('Collection/index');?>" title="charts">
                                    <div class="helper-font-24">
                                        <i class="icofont-credit-card"></i>
                                    </div>
                                    <span class="sidebar-text">账目</span>
                                </a>
                                
                                
                                
                                
                                
                                
                                
                                
                                <ul class="sub-sidebar-form corner-top shadow-white">
                                    <li class="title muted">操作</li>                  
                                    
                                    
                                    <li>
                                       <a href="<?php echo U('Collection/index');?>"><i class=" icon-search"></i>
                                       <span class="sidebar-text">收款查询</span></a>
                                    </li>
                                    
                                     <li>
                                       <a href="<?php echo U('Commission/index');?>"><i class=" icon-search"></i>
                                       <span class="sidebar-text">佣金业绩查询</span></a>
                                    </li>
                                   
                                  
                                 
                                     
                                </ul>
                                
                                
                                
                                
                                
                                
                                
                                
                                
                            </li>
                            
                            
                            
                            <li <?php if($module == 'Client'): ?>class="active"<?php endif; ?>>
                                <a href="<?php echo U('Client/index');?>" >
                                    <div class="helper-font-24">
                                        <i class="icofont-user"></i>
                                    </div>
                                    <span class="sidebar-text">客户</span>
                                </a>
                                
                                
                                
                                
                                
                                
                                <ul class="sub-sidebar-form corner-top shadow-white">
                                    <li class="title muted">操作</li>                  
                                    
                                    
                                    <li>
                                       <a href="<?php echo U('Client/index');?>"><i class=" icon-search"></i>
                                       <span class="sidebar-text">客户查询</span></a>
                                    </li>
                                    
                                   
                                  
                                 
                                     <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo U('Client/add');?>" title="trash" class="corner-all">
                                            <i class="icofont-trash"></i>
                                            <span class="sidebar-text">新增客户</span>
                                        </a>
                                    </li>
                                    
                                    
                                    
                                    
                                      <li class="divider"></li>
                                    
                                      <li>
                                        <a href="<?php echo U('Client/recycle');?>" title="trash" class="corner-all">
                                            <i class="icofont-trash"></i>
                                            <span class="sidebar-text">回收站</span>
                                        </a>
                                    </li>
                                    
                                    
                                    
                                    
                                    
                                </ul>
                                
                                
                                
                                
                                
                                
                                
                            </li>
                            <li <?php if($module == Schedule): ?>class='active'<?php endif; ?>>
                                <a href="<?php echo U('Schedule/index');?>" title="table">
                                    <div class="helper-font-24">
                                        <i class="icofont-table"></i>
                                    </div>
                                    <span class="sidebar-text">日程表</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo U('Talent/index');?>" title="Resume">
                                    <div class="helper-font-24">
                                        <i class="icofont-inbox"></i>
                                    </div>
                                    <span class="sidebar-text">简历库</span>
                                </a>
                                
                                
                                
                                
                                
                                <ul class="sub-sidebar-form corner-top shadow-white">
                                    <li class="title muted">操作</li>                  
                                    
                                    
                                    <li>
                                       <a href="<?php echo U('Talent/index');?>"><i class=" icon-search"></i>
                                       <span class="sidebar-text">常规简历</span></a>
                                    </li>
                                    
                                   
                                  
                                 
                                     <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo U('Talent/add');?>" title="trash" class="corner-all">
                                            <i class="icofont-trash"></i>
                                            <span class="sidebar-text">新增简历</span>
                                        </a>
                                    </li>
                                    
                                    
                                    
                                    
                                      <li class="divider"></li>
                                    
                                      <li>
                                        <a href="<?php echo U('Talent/recycle');?>" title="trash" class="corner-all">
                                            <i class="icofont-trash"></i>
                                            <span class="sidebar-text">回收站</span>
                                        </a>
                                    </li>
                                    
                                    
                                    
                                    
                                    
                                </ul>
                                
                                
                                
                                
                                
                                
                            </li>
                            <li <?php if($module == 'Staff' ): ?>class="active"<?php endif; ?>  <?php if($module == 'StaffRole' ): ?>class="active"<?php endif; ?>" >
                                <a href="<?php echo U('Staff/index');?>" title="icons">
                                    <div class="helper-font-24">
                                        <i class="icofont-user"></i>
                                    </div>
                                    <span class="sidebar-text">雇员</span>
                                </a>
                                
                                <ul class="sub-sidebar-form corner-top shadow-white">
                                    <li class="title muted">操作</li>                  
                                    
                                    
                                    <li>
                                       <a href="<?php echo U('Staff/index');?>">  <i class="icofont-user"></i>
                                       <span class="sidebar-text">雇员列表</span></a>
                                    </li>
                                    
                                   
                                  
                                 
                                     <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo U('StaffRole/index');?>" title="trash" class="corner-all">
                                            <i class="icofont-trash"></i>
                                            <span class="sidebar-text">权限管理</span>
                                        </a>
                                    </li>
                                    
                                    
                                    
                                    
                                      <li class="divider"></li>
                                    
                                     
                                    
                                    
                                    
                                    
                                    
                                </ul>
                                
                                
                                
                            </li>
                           
                                   
                                    <li>
                                        <a href="javascript:;" title="系统配置">
                                            <div class="helper-font-24">
                                                <i class="icofont-cog"></i>
                                            </div>
                                            <span class="sidebar-text">配置</span>
                                        </a>
                                        
                                        
                                        
                                        
                                        
                                        
                                        <ul class="sub-sidebar-form corner-top shadow-white">
                                    <li class="title muted">操作</li>                  
                                    
                                    
                                 
                                    
                                   
                                  
                                 
                                     <li class="divider"></li>
                                    <li>
                                       <a data-toggle="modal" class="set_persona" href="#set_persona" link="/index.php/Persona/index/ajax/1">
          　角色设置</a>
                                    </li>
                                    
                                    
                                    
                                  
                                     
                                    
                                    
                                    
                                    
                                    
                                </ul>
                                        
                                        
                                        
                                        
                                        
                                        
                                    </li>
                                 
                                   
                                </ul>
                            </li>
                        </ul>
                    </aside>
                    
                  <!--/side bar -->
                </div><!-- span side-left -->
                
                <!-- span content -->
              <div class="span9">
                    <!-- content -->
                    <div class="content">
                        <!-- content-header -->
                        <div class="content-header">
                            
                            <h2><i class="icofont-home"></i> 控制面板 <small>欢迎登陆，jobmeOA 系统</small></h2>
                        </div><!-- /content-header -->
                        
                        <!-- content-breadcrumb -->
                        <div class="content-breadcrumb">
                           
                            
                            <!--breadcrumb-->
                           <ul class="breadcrumb">
                                <li><a href="/index.html"><i class="icofont-home"></i> 控制台</a> <span class="divider">&rsaquo;</span></li>
                                <li class="active"><a href="/<?php echo ($module); ?>" class=""><?php echo ($module); ?></a></li>   
                                &rsaquo;
                                
                                <li class="active"><?php echo ($action); ?></li>   
                                
                            </ul><!--/breadcrumb-->
                        </div>
                        
                        <!-- /content-breadcrumb -->
                        
                        <!-- content-body -->
                       
                       
                       
                       
                       
                       
                        <div class="content-body" style="padding-top:10px;">
                        
                        <div class="m15">
                        
                        
                        <div class="box-header corner-top">
                                    <div class="header-control pull-right">
                                        <a data-box="collapse"><i class="icofont-caret-up"></i></a>
                                    </div>
                                    <ul class="nav nav-tabs" id="tab-stat">
                                        <li class="active"><a data-toggle="tab" href="#system-stat">注册时间</a></li>
                                        <li><a href="?act=User_list&settr=&key=&page=1" class="select">不限</a></li>
                                        <li><a href="?act=User_list&settr=3&key=&page=1" >三天内</a></li>
                                        
                                        <li><a href="?act=User_list&settr=7&key=&page=1" >一周内</a></li>
                                        
                                        <li><a href="?act=User_list&settr=30&key=&page=1" >一月内</a></li>
                                        <li><a href="?act=User_list&settr=180&key=&page=1" >半年内</a></li>
                                        <li><a href="?act=User_list&settr=360&key=&page=1" >一年内</a></li>
                                    </ul>
                                </div>
                        
                        
                        <div class="admin_main_nr_dbox">
<div class="seltpye">
		<div class="left"></div>	
		<div class="right">
		<div class="clear"></div>
		</div>
		<div class="clear"></div>
  </div>
  

  
  <form id="form1" name="form1" method="post" action="?act=delete_user">
  <table class="table">
    <tr>
      <td   class="admin_list_tit admin_list_first" ><input type="checkbox" name=" " title="全选/反选" id="chk"/></td>
      <td   class="admin_list_tit admin_list_first" >
      <label id="chkAll">用户名</label></td>
      <td  class="admin_list_tit">email</td>
      <td align="center"   class="admin_list_tit">注册时间</td>
	  <td    align="center"   class="admin_list_tit">注册IP</td>
	  <td    align="center"   class="admin_list_tit">邮箱状态</td>
      <td   align="center"   class="admin_list_tit">最后登录时间</td>
	  <td  align="center"   class="admin_list_tit">最后登录IP</td>
      <td width="13%"  align="center"  class="admin_list_tit" >操作</td>
      </tr>
    
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
	        <td class="admin_list admin_list_first"><input name="tuid[]" type="checkbox"   value="<?php echo ($vo["uid"]); ?>"/></td>
      <td class="admin_list admin_list_first">
        <?php echo ($vo["username"]); ?></td>
        <td class="admin_list"><?php echo ($vo["email"]); ?></td>
        <td align="center" class="admin_list">
		<?php echo (date("Y-m-d",$vo["reg_time"])); ?> 		</td>
        <td align="center" class="admin_list">
		<?php echo ($vo["reg_ip"]); ?></td>
         <td align="center" class="admin_list">

                  <?php if($vo["step"] < 2): ?><span style="color:#F00">未激活</span>
                  <?php else: ?>
                  <span style="color: #009900">已激活</span><?php endif; ?>
         
				     </td>
		<td align="center" class="admin_list">
        <?php if($vo["last_login_time"] == 0): ?>从未登录
        <?php else: ?>
        <?php echo (date("Y-m-d",$vo["last_login_time"])); endif; ?>
				
				</td>
		<td align="center" class="admin_list">
		<?php if($vo["last_login_ip"] == null): ?>从未登录
        <?php else: ?>
        <?php echo ($vo["last_ip"]); endif; ?>
		</td>       
        <td align="center" class="admin_list">
          <a href="?act=user_edit&tuid=1000153">修改</a>
        </td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>


          </table>
          
        
          
          
	<span id="DelSel"></span>
  </form>
  <div class="page link_bk">
    <?php echo ($page); ?>
    
  <div class="clear"></div></div>
	<div id="GetDelInfo" style="display: none" >
	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="6" >
		<tr>
		  <td width="30" height="30">&nbsp;</td>
		  <td height="30"><strong  style="color:#0066CC; font-size:14px;">你确定要删除吗？</strong></td>
		</tr>
			  <tr>
		  <td width="27" height="25">&nbsp;</td>
		  <td><label>
			<input name="delete_user" type="checkbox" id="delete_user" value="yes" checked="checked" />
			删除此会员 <span style="color:#666666">(删除后此会员将无法登录，无法管理已发布的信息等)<span></label></td>
		</tr>
		<tr>
		  <td width="27" height="25">&nbsp;</td>
		  <td width="425"><label>
			<input name="delete_resume" type="checkbox" id="delete_resume" value="yes" checked="checked" />
		  删除此会员发布的简历</label></td>
		</tr>
		<tr>
		  <td height="25">&nbsp;</td>
		  <td><input type="submit" name="delete" value="确定删除" class="admin_submit"/></td>
		  </tr>
	  </table>
	  </div>
      
      
      
      

      
      
      
      
      
</div>


                        </div>
                        <!--/content-body -->
                    </div><!-- /content -->
                </div><!-- /span content -->
            </div>    
            
                
                
                 <!-- span side-right -->
                   <div class="span2">
                    <!-- side-right -->
                    <aside class="side-right">
                        <!-- sidebar-right -->
                        <div class="sidebar-right">
                            <!--sidebar-right-header-->
                            <div class="sidebar-right-header">
                                <div class="sr-header-right">
                                   
                                </div>
                                <div class="sr-header-left">
                                   <span id="localtime" style="font-size:12px; font-family:'微软雅黑'"></span>

<script type="text/javascript">
function showLocale(objD)
{
	var str,colorhead,colorfoot;
	var yy = objD.getYear();
	if(yy<1900) yy = yy+1900;
	var MM = objD.getMonth()+1;
	if(MM<10) MM = '0' + MM;
	var dd = objD.getDate();
	if(dd<10) dd = '0' + dd;
	var hh = objD.getHours();
	if(hh<10) hh = '0' + hh;
	var mm = objD.getMinutes();
	if(mm<10) mm = '0' + mm;
	var ss = objD.getSeconds();
	if(ss<10) ss = '0' + ss;
	var ww = objD.getDay();
	if  ( ww==0 )  colorhead="";
	if  ( ww > 0 && ww < 6 )  colorhead="";
	if  ( ww==6 )  colorhead="";
	if  (ww==0)  ww="星期日";
	if  (ww==1)  ww="星期一";
	if  (ww==2)  ww="星期二";
	if  (ww==3)  ww="星期三";
	if  (ww==4)  ww="星期四";
	if  (ww==5)  ww="星期五";
	if  (ww==6)  ww="星期六";
	colorfoot=""
	str = colorhead + yy + "年" + MM + "月" + dd + "日  <br/>" + ww +""+ colorfoot + " " + hh + ":" + mm + ":" + ss ;
	return(str);
}
function tick()
{
	var today;
	today = new Date();
	document.getElementById("localtime").innerHTML = showLocale(today);
	window.setTimeout("tick()", 1000);
}
tick();
</script>
                                </div>
                            </div><!--/sidebar-right-header-->
                            <!--sidebar-right-control-->
                            <div class="sidebar-right-control">
                                <ul class="sr-control-item">
                                    <li class="active"><a href="#contact" data-toggle="tab" title="contacts"><i class="icofont-group"></i> 用户搜索</a></li>
                                  
                                </ul>
                            </div><!-- /sidebar-right-control-->
                            <!-- sidebar-right-content -->
                            <div class="sidebar-right-content m15">
                                <form id="formseh" name="formseh" method="get" action="?">	
			<div class="seh">
			    <div class="keybox"><input name="key" type="text"  class="span12"   value="" /></div>
			    <div class="selbox">
					<input name="key_type_cn" class="span12"  id="key_type_cn" type="text" value="用户名" />
						<div>
								<input name="key_type" class="span2"  id="key_type" type="hidden" value="1" />
						</div>				
				</div>
				<div class="sbtbox">
				<input name="act" type="hidden" value="User_list" />
				<input type="submit" name="" class="sbt btn" id="sbt" value="搜索"/>
				</div>
				<div class="clear"></div>
		  </div>
		  </form>
          
          
         
            <input type="button" name="ButAdd" id="ButAdd" value="添加会员" class="btn" link='__APP__/User/addusers' data-toggle="modal" href='#addUsers'/>
		<input type="btn" name="ButDel"  id="ButDel" value="删除会员" class="btn"/>
       
                           </div><!-- /sidebar-right-content -->
                        </div><!-- /sidebar-right -->
                    </aside><!-- /side-right -->
                </div>
                <!-- /span side-right -->
           </div>
           </div>
           
        </section>


   <div class="modal" id="addUsers"></div>


         <footer>
            <a rel="to-top" href="#top"><i class="icofont-circle-arrow-up"></i></a>
        </footer>

        <!-- javascript
        ================================================== -->
        
        <script src="/Public/js/jquery.js"></script>
        <script src="/Public/js/jquery-ui.min.js"></script>
        <script src="/Public/js/bootstrap.js"></script>
        <script src="/Public/js/uniform/jquery.uniform.js"></script>
        <script src="/Public/js/peity/jquery.peity.js"></script>
          <script src="/Static/skin/js/artTemplate.js"></script>


     
        <script src="/Public/js/knob/jquery.knob.js"></script>
        <script src="/Public/js/flot/jquery.flot.js"></script>
        <script src="/Public/js/flot/jquery.flot.resize.js"></script>
        <script src="/Public/js/flot/jquery.flot.categories.js"></script>
        <script src="/Public/js/wysihtml5/wysihtml5-0.3.0.js"></script>
        <script src="/Public/js/wysihtml5/bootstrap-wysihtml5.js"></script>
        <script src="/Public/js/calendar/fullcalendar.js"></script> <!-- this plugin required jquery ui-->

        <!-- required stilearn template js, for full feature-->
        <script src="/Public/js/holder.js"></script>
        <script src="/Public/js/stilearn-base.js"></script>
  <script src="/Static/skin/js/custom.js"></script>
    
      
     
    <script src="/Public/js/select2/select2.js"></script>
        
        <div class="modal ui-draggable" id="set_persona"></div>
       
       
     
 
        <script src="/Static/skin/js/plus_tan.js"></script>
<script>
  
 //私信函数			



    $(document).keydown(function(e) {
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

        if (e.ctrlKey && e.which == 13) {
            $('.sms_bt').click();

        }

    });


    $('.sms_bt').click(function(e) {


        if ($('#content').val() == '') {
            $("#msg").html('内容不能为空').show();
            return false;

        }
		  $('#msg').html(""); 

        var content = guolv($('#content').val());
        var suser = $("#inputSelect1").val();
		var url=$(this).attr("sendUrl");
		
        $.ajax({
            type: "POST",
            url:url,
            data: {
                toid: suser,
                content: content
            },
            beforeSend: function() {
                msg("发送中.....");

            },
            success: function(data) {

                if (data.status== 1) {
                    //刷新当前页面

                 window.location.reload();

                }else{
					
					//alert("chucuole");
					
					}




            }



        });

        return false;


    });

    $('button.sixin').click(function(e) {

        $(".huifu_box").toggle();


    });

    $('.hfs').click(function(e) {
        $(".huifu_box").show();
        $("#content").focus();

       $("#inputSelect1").val($(this).attr('hfid'));
	   $("#suid").hide();
        $("#hfname").html("<span class='text'>发给：  <a href='#'>" + $(this).attr("hfname") + "</a>  </span><span class='modfy'>修改</span><div class='cl'></div>").show();

    });



    /*选择私信用户*/
    $('.x_user').live("click", 
    function() {

        $("#suser").attr("toid",$(this).attr("toid")).hide();
        $("#uli").html("");

        $("#hfname").html("<span class='text'>发给:  <a href='#'>" + $(this).attr("uname") + "</a>  </span><span class='modfy'>修改</span><div class='cl'></div>").show();



    });
    /*修改发送用户*/

$("span.modfy").live("click", 
    function() {

        $(this).parent().html("").hide();
        $("#suser").val("").show();

    });

$(".deldh").click(function(e){
	
	      
		   $this=$(this);
		     if(window.confirm("你确定要删除全部对话么？")){
				   
				  $.ajax({
					    
						 url:'/Usermsg/deldh/ajax/1/id'+$this.attr('uid'),
						 
					  
					  
					  });
				 
				 }else{
					    
						return false;
					   
					 }
	
	
	})


</script>
        
<script>
					 
					 $(".quanxuan").click(function(e) {
                          
						
						  //$(".sid").val(99999);
						  $(".ckd").html('请选择 　<span class="caret" style="color:#CCC"></span>');
						  
                    });
					  $(".stage_ul.skzt li a").click(function(e) {
                        
						
						
						if($(this).attr('sid')==13){
							$("#maodian").val("佣金/业绩");
						   $(".piliang_box").each(function(index, element) {
                             
							 if($(this).attr('st')==0 || $(this).attr("fen")==1 ){
								   
								    $(this).attr('checked',false);
								    $(this).attr('disabled','disabled');
								   
								 } else{
									 
								    $(this).attr('disabled',false);
									 }
							
                        });
						}
						
						
						
						
						if($(this).attr('sid')==0){
						  $(".piliang_box").each(function(index, element) {
                             
							 if($(this).attr('st')==0 || $(this).attr("fen")==1){
								   
								   $(this).attr('checked',false);
								   $(this).attr('disabled','disabled');
								 } 
							
                        });
						}
						
						
						
						
						
						
						if($(this).attr('sid')==1){
						  $(".piliang_box").each(function(index, element) {
                             
							 if($(this).attr('st')==1){
								   
								   $(this).attr('checked',false);
								   $(this).attr('disabled','disabled');
								 } 
							
                        });
						
						}
						
						
						
						
						
                    });
					     
	                      
						  $(".beizhu").popover().
                          click(function(e) {
                          e.preventDefault()
      });
                    </script>
        
<script type="text/javascript">
            $(document).ready(function() {
                // try your js
                
                // auto complete
                $('#inputAuto').typeahead({
                    source : ["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Dakota","North Carolina","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"]
                });
                
                // select2
                $('#inputTags').select2({tags:["red", "green", "blue"]});
                $('[data-form=select2]').select2();
                $('[data-form=select2-group]').select2();
                
                // this select2 on side right
                $('#tagsSelect').select2({
                    tags:["red", "green", "blue"],
                    tokenSeparators: [",", " "]
                });
                
                
                // datepicker
                $('[data-form=datepicker]').datepicker();

             
                
                // uniform
                $('[data-form=uniform]').uniform()

                // wysihtml5
                $('[data-form=wysihtml5]').wysihtml5();
                
                
       
                
                
                
            });
			
			
			
			$("#ButAdd").click(function(e) {
                   
				    geta($($(this).attr('href')),$(this).attr('link'),loadGif);
            });
      
        </script>
        
	</body>
</html>