<?php


ini_set('date.timezone','Asia/Shanghai'); 

function upload($model='',$path = 1,$fileSize = 0,$thumbStatus = 1,$thumbSize = 0,$allowExts = 0,$attachFields = 'attach_file')
{
	

if(attachTrue($_FILES[$attachFields]['name'])){
$globalConfig = getContent('sys.config.php','.');
$globalAttachSize = intval($globalConfig['global_attach_size']);
$globalAttachSuffix = $globalConfig['global_attach_suffix'];
$dot = '/';
$setFolder = empty($model) ?'file/': $model .$dot ;
$setUserPath = empty($path) ?'': makeFolderName($path) ;
if($model=='User'){
	$finalPath = C("UPLOAD_PATH")."/User/face/";
	}else{
		$finalPath =  C("UPLOAD_PATH").$setFolder.$setUserPath;
		}



if(!is_dir($finalPath)){
  @mkdir($finalPath);
}
 import("@.ORG.UploadFile");
 $upload = new UploadFile();



$upload->savePath = $finalPath;
        
	
		 
    $upload->thumb = true;
	
        // 设置引用图片类库包路径
        $upload->imageClassPath = '@.ORG.Image';
        //设置需要生成缩略图的文件后缀
        $upload->thumbPrefix = 'm_,s_';  //生产2张缩略图
		
			
		

		switch ($model){
case 'News':
$globalThumbStatus = intval($globalConfig['news_thumb_status']);;
$upload->thumbMaxWidth = trim($globalConfig['news_thumb_size']);
$upload->thumbMaxHeight = trim($globalConfig['news_thumb_size']);
break;
case 'Product':
$globalThumbStatus = intval($globalConfig['product_thumb_status']);;
$upload->thumbMaxWidth = trim($globalConfig['product_thumb_size']);
$upload->thumbMaxHeight = trim($globalConfig['product_thumb_size']);


break;
case 'Download':
$globalThumbStatus = intval($globalConfig['download_thumb_status']);;
$upload->thumbMaxWidth = trim($globalConfig['download_thumb_size']);
$upload->thumbMaxHeight = trim($globalConfig['download_thumb_size']);
break;

case 'User':
$imgsize=getimagesize($_FILES[$attachFields]['tmp_name']);
if($imgsize[0] > 400){
	$wh=400;
	$ht=$imgsize[0]*(400/$imgsize[0]);
	}else{
		$wh=$imgsize[0];
		$ht=$imgsize[1];
		}
$upload->thumbMaxWidth =$wh;
$upload->thumbMaxHeight =$ht;
break;

default:
$globalThumbStatus = intval($globalConfig['global_thumb_status']);;
$upload->thumbMaxWidth = trim($globalConfig['global_thumb_size']);
$upload->thumbMaxHeight = trim($globalConfig['global_thumb_size']);
break;
}
       //设置上传文件规则
        $upload->saveRule = uniqid;
        //删除原图
        $upload->thumbRemoveOrigin = true;


           if(!$upload->upload())
            {
             echo ($upload->getErrorMsg());
             }else
            {
	      $uuu=$upload->getUploadFileInfo();
		  
		  
          import("@.ORG.Image");
            //给m_缩略图添加水印, Image::water('原文件名','水印图片地址')
           // Image::water($uuu[0]['savepath'].'m_'.$uuu[0]['savename'], './Public/Common/watermark.png');
		//echo "<pre>";
//print_r($uuu);	
	
	return $upload->getUploadFileInfo();
	
}
}
}
function isEnglist($param)
{
if (!eregi("^[A-Z0-9]{1,26}$",$param)) {
return false;
}else {
return true;
}
}
function safe_b64encode($string)
{
$data = base64_encode($string);
$data = str_replace(array('+','/','='),array('-','_',''),$data);
return $data;
}
function safe_b64decode($string)
{
$data = str_replace(array('-','_'),array('+','/'),$string);
$mod4 = strlen($data) %4;
if ($mod4)
{
$data .= substr('====',$mod4);
}
return base64_decode($data);
}
function dHtml($string)
{
if(is_array($string))
{
foreach($string as $key =>$val)
{
$string[$key] = dhtml($val);
}
}else
{
$string = str_replace(array('"','\'','<','>',"\t","\r",'{','}'),array('&quot;','&#39;','&lt;','&gt;','&nbsp;&nbsp;','','&#123;','&#125;'),$string);
}
return $string;
}
function cvHttp($http)
{
if ($http == '')
{
return '';
}else
{
$link = substr($http,0,7) == "http://"?$http : 'http://'.$http;
return $link;
}
}
function htmlCv($string)
{
$pattern = array('/(javascript|jscript|js|vbscript|vbs|about):/i','/on(mouse|exit|error|click|dblclick|key|load|unload|change|move|submit|reset|cut|copy|select|start|stop)/i','/<script([^>]*)>/i','/<iframe([^>]*)>/i','/<frame([^>]*)>/i','/<link([^>]*)>/i','/@import/i');
$replace = array('','','&lt;script${1}&gt;','&lt;iframe${1}&gt;','&lt;frame${1}&gt;','&lt;link${1}&gt;','');
$string = preg_replace($pattern,$replace,$string);
$string = str_replace(array('</script>','</iframe>','&#'),array('&lt;/script&gt;','&lt;/iframe&gt;','&amp;#'),$string);
return stripslashes($string);
}
function splitThumb($attach)
{
$thumb="s_".$attach;	
return $thumb;
}

function splitbig($attach)
{
$thumb="m_".$attach;	
return $thumb;
}




function formatAttachPath($path,$find = './Uploads/',$replace ='')
{
if(!empty($path)){
return str_replace($find,$replace,$path);
}
}
function string2checked($sring,$param,$split = ',')
{
$splitParam = explode($split,$sring);
if (in_array($param,$splitParam)) $result = ' checked=checked';
return $result;
}
function array2string($data = array(),$split = ',')
{
if (is_array($data)) {
return implode($split,$data);
}else{
return $data;
}
}
function selected($string,$param =1,$type = 'select')
{
$returnString = '';
if ($string == $param)
{
$returnString = $type == 'select'?'selected="selected"': 'checked="checked"';
}
return $returnString;
}
function a2bc($a,$param =1,$b = '',$c = '')
{
$returnString = $a == $param ?$b : $c;
return $returnString;
}
function disable($param,$typeParam =1,$stringParam = array(' disabled="disabled"',''))
{
return $param == $typeParam ?$stringParam[0] : '';
}
function getMethod()
{
return  strtolower($_SERVER['REQUEST_METHOD']);
}
function getDir($dirname)
{
$files = array();
if(is_dir($dirname))
{
$fileHander = opendir($dirname);
while (($file = readdir($fileHander)) !== false)
{
$filepath = $dirname .'/'.$file;
if (strcmp($file,'.') == 0 ||strcmp($file,'..') == 0 ||is_file($filepath))
{
continue;
}
$files[] = auto_charset($file,'GBK','UTF8');;
}
closedir($fileHander);
}
else
{
$files = false;
}
return $files;
}
function getFile($dirname)
{
$files = array();
if(is_dir($dirname))
{
$fileHander = opendir($dirname);
while (($file = readdir($fileHander)) !== false)
{
$filepath = $dirname .'/'.$file;
if (strcmp($file,'.') == 0 ||strcmp($file,'..') == 0 ||is_dir($filepath) )
{
continue;
}
$files[] = auto_charset($file,'GBK','UTF8');;
}
closedir($fileHander);
}
else
{
$files = false;
}
return $files;
}
function formatQuery($string)
{
return $string;
}
function makeFolderName($type =0,$prefix=1)
{
$setPrefix = empty($prefix) ?'': '/';
switch ($type){
case 1: $result = date('Ym').$setPrefix ;break ;
case 2: $result = date('Y-m').$setPrefix ;break ;
case 3: $result = date('Ymd').$setPrefix ;break ;
case 4: $result = date('Y-m-d').$setPrefix ;break ;
case 5: $result = date('Y').$setPrefix ;break ;
default: $result = date('Ym').$setPrefix ;break ;
}
return $result;
}
function attachTrue($fields,$trueNum = 0)
{
if(is_array($fields)){
foreach ($fields as $value) {
if(!empty($value)){
$trueNum = $trueNum+1;
}
}
}else {
if(empty($fields)){
$trueNum = 0;
}else {
$trueNum = 1;
}
}
return $trueNum;
}
function statusIcon($data = 1,$status = 1,$folder = 0,$icon = 'hidden.png',$alt = '显示',$condition = 'eq'){
$strStart = '<img src="';
$strMiddle = $folder.'/Public/Admin/'.$icon;
$strEnd = '" alt="'.$alt.'" align="absmiddle" />';
if ($condition == 'eq'){
if($data == $status){
return $strStart.$strMiddle.$strEnd;
}
}elseif($condition == 'neq'){
if($data != (int)$status){
return $strStart .$strMiddle .$strEnd;
}
}
}
function attachStatus($data = 1,$status = 1,$folder = 0,$icon = 'hidden.png',$alt = '显示'){
$string = '<img src="'.$folder.'/Public/Admin/'.$icon.'" alt="'.$alt.'" align="absmiddle" />';
switch ($status){
case '1':
$returnString = !empty($data) ?$string : '';
break;
case '0':
$returnString = empty($data) ?$string : '';
break;
default:
$returnString = $data == $status ?$string : '';
break;
}
return $returnString;
}
function str2time($string,$time = 0){
if(!empty($string)){
return strtotime($string);
}
}
function createStyle($data,$style = array(),$styleArray = array())
{
$dataStyle = '';
if($data){
if(strtolower($data['style_color']) != '#ffffff'&&!empty($data['style_color'])){
$style['color'] = $data['style_color'];
$styleArray[] = 'color:'.$data['style_color'];
}
if(!empty($data['style_bold'])){
$style['bold'] = $data['style_bold'];
$styleArray[] = 'font-weight:bold';
}
if(!empty($data['style_underline'])){
$style['underline'] = $data['style_underline'];
$styleArray[] = 'TEXT-DECORATION: underline';
}
$dataStyle['title_style'] = empty($styleArray) ?'': implode(';',$styleArray);
$dataStyle['title_style_serialize'] = empty($style) ?'': serialize($style);
}
return $dataStyle;
}
function string2Checkbox($string = '',$emptyString = '未定义'){
if(empty($string)){
$resultString = $emptyString;
}else{
$stringSplit = explode(',',$string);
foreach ($stringSplit as $row){
$resultString .= '<input name="run_system[]" type="checkbox" id="run_system[]" value="'.$row.'"/>'.$row;
}
}
return $resultString;
}
function string2checkboxSelect($string = '',$param = '',$emptyString = '未定义')
{
if(empty($string)){
$resultString = $emptyString;
}else{
$stringSplit = explode(',',$string);
foreach ($stringSplit as $row){
if(in_array($row,explode(',',$param))){
$resultString.='<input name="run_system[]" type="checkbox" id="run_system[]" value="'.$row.'" checked="checked"/>'.$row;
}else{
$resultString.='<input name="run_system[]" type="checkbox" id="run_system[]" value="'.$row.'"/>'.$row;
}
}
}
return $resultString;
}
function setOrder($orderFields = 0,$selectField = 'id',$orderType = 'DESC',$join = NULL){
$orderValue = empty($join) ?'id': 'a.id';
foreach ((array)$orderFields as $value){
if(is_array($value)){
if($value[0] == $selectField){
$orderValue = $value[1];
}
}else{
if($value == $selectField){
$orderValue = $value;
}
}
}
$orderByValue = empty($orderValue) ?'id': $orderValue ;
$orderByType = empty($orderType) ?'DESC': $orderType ;
return $orderByValue.' '.$orderByType;
}
function setTime($time = 0,$time1 = 0){
$createTime = empty($time) ?0 : strtotime($time) ;
$createTime1 = strtotime($time1) ;
if(!empty($time1)){
return $createTime.','.$createTime1;
}
}
function setViewCount($count = 0,$count1 = 0)
{
$viewCount = empty($count) ?0 : $count ;
$viewCount1 = $count1 ;
if(!empty($count1)){
return $viewCount.','.$viewCount1;
}
}
function styleSelected($titelStyle = 0,$type = 'color',$returnString = 'checked="checked"')
{
$result = '';
if(!empty($titelStyle)){
$unserialize = unserialize($titelStyle);
switch ($type) {
case 'color':
$result = empty($unserialize['color']) ?'#ffffff': $unserialize['color'];
break;
case 'bold':
$result = empty($unserialize['bold']) ?'': $returnString ;
break;
case 'underline':
$result = empty($unserialize['underline']) ?'': $returnString ;
break;
default:
break;
}
}
return $result;
}
function formatTags($data)
{
if(!empty($data)){
$tagCount = 0;
$tag = explode(',',$data);
foreach ($tag as $value){
if(!empty($value)){
$tags[] = $value;
$tagCount ++;
if($tagCount >4) {
unset($tag);
break;
}
}
}
return implode(',',$tags);
}else {
return '';
}
}
function tagsGet($tags,$module = '')
{
if(!empty($tags)){
$str = '';
$format = explode(',',$tags);
foreach ((array)$format as $row){
$str .= '<a href="'.U("Tags/getList",array('module'=>$module,'name'=>urlencode($row))).'" target="_blank">'.$row.'</a> ';
}
echo $str;
}
}
function fileExit($file)
{
return file_exists($file) ?true : false ;
}
function explodeRole($permission,$inData = '',$field = 'role_permission')
{
if(!empty($permission)){
$str = '';
$pmArray = explode('|',$permission);
foreach ((array)$pmArray as $row){
$subRow = explode('=',$row);
if(in_array($subRow[1],explode(',',$inData))){
$str .= '<span style="float:left; padding:0 15px"><input name="'.$field.'[]" type="checkbox" id="'.$field.'[]" value="'.trim($subRow[1]).'" class="checkbox" checked="checked"/>'.trim($subRow[0]).'</span>';
}else{
$str .= '<span style="float:left; padding:0 15px"><input name="'.$field.'[]" type="checkbox" id="'.$field.'[]" value="'.trim($subRow[1]).'" class="checkbox"/>'.trim($subRow[0]).'</span>';
}
}
return $str;
}
}
function splitsql($sql) {
$sql = str_replace("\r","\n",$sql);
$returnSql = array();
$num = 0;
$queryArray = explode(";\n",trim($sql));
unset($sql);
foreach($queryArray as $query) {

$queries = explode("\n",trim($query));
foreach($queries as $query) {
$returnSql[$num] .= $query[0] == "#"||$query[0].$query[1] == '--'?NULL : $query;
}
$num ++;
}
return($returnSql);
}
if(!function_exists('file_put_contents')) {
function file_put_contents($filename,$data) {
if($fp = @fopen($filename,'w') === false)
{
exit($filename.'if not writeable');
}else {
$bytes = fwrite($fp,$contents);
fclose($fp);
}
}
}
function writeCache($name = NULL,$data = NULL,$order = '',$where = '',$path = './cache/')
{
if(empty($data)){
$dao = M($name);
$getData = $dao->where($where)->order($order)->select();

$fileName =$name;
$writeData = "<?php\n/** \n* cache.{$fileName}.php\n*\n* @package    YIGECMS\n* @author     \n* @copyright  Copyright (c) 2008-2010  (http://www.oa.com)\n* @license    http://www.oa.com/license.txt\n   \n*/\n\nif (!defined('jobOA')) exit();\n\nreturn ";
$writeData .= var_export($getData,true);
$writeData .= ';';
}else{
$writeData = $data;
}
$writeFile = 'cache.'.$fileName.'.php';
$rr=file_put_contents($path .$writeFile,$writeData);

if(!$rr){
	exit('写入失败');
	}

return $writeData;
}



function configCache($id = 1,$data = NULL,$file = NULL,$path = NULL)
{
$writePath = empty($path) ?'./': $path ;
$writeFile = empty($file) ?'sys.config.php': $file ;
$writeDataHeader = "<?php\n/*** \n* sys.config.php\n*\n* @package    YIGECMS\n* @author     \n* @copyright  Copyright (c) 2008-2010  (http://www.YIGECMS.cn)\n* @license    http://www.YIGECMS.cn/license.txt\n*/\n\nif (!defined('YIGECMS')) exit();\n\nreturn array(\r\n";
$writeDataFooter =  ');';
if(empty($data)){
$configDao = D('Config');
$getConfig = $configDao->where("id=1")->find();
foreach((array)$getConfig as $key =>$value)
{
if(strtolower($value) == "true"||strtolower($value) == "false"||is_numeric($value)){
$data .= "    '".$key."' => ".dadds($value).",\r\n";
}else{
$data .= "    '".$key."' => '".dadds($value)."',\r\n";
}
}
$writeData = $writeDataHeader .$data .$writeDataFooter;
}else {
$writeData = $writeDataHeader .$data .$writeDataFooter;
}
@file_put_contents($writePath .$writeFile,$writeData);
return $getConfig;
}
function clearCore()
{
delFile('./App/Runtime/Cache');
delFile('./App/Runtime/Data');
delFile('./App/Runtime/Logs');
delFile('./App/Runtime/Temp');
@unlink('./App/Runtime/~app.php');
@unlink('./App/Runtime/~runtime.php');
delFile('./Admin/Runtime/Cache');
delFile('./Admin/Runtime/Data');
delFile('./Admin/Runtime/Logs');
delFile('./Admin/Runtime/Temp');
@unlink('./Admin/Runtime/~app.php');
@unlink('./Admin/Runtime/~runtime.php');
}
function delDir($directory,$subdir=true)
{
if (is_dir($directory) != false)
{
$handle = opendir($directory);
while (($file = readdir($handle)) !== false)
{
if ($file != "."&&$file != "..")
{
is_dir("$directory/$file")?
delDir("$directory/$file"):
unlink("$directory/$file");
}
}
if (readdir($handle) == false)
{
closedir($handle);
rmdir($directory);
}
}
}
function delFile($directory)
{
if (is_dir($directory) != false)
{
$handle = opendir($directory);
while (($file = readdir($handle)) !== false)
{
if ($file != "."&&$file != ".."&&is_file("$directory/$file"))
{
unlink("$directory/$file");
}
}
closedir($handle);
}
}





function getCache($name = '',$root = './cache/',$returnData = '')
{
$formatName  = strtolower($name);

$getFile = $root .'cache.'.$formatName .'.php';
if(fileExit($getFile)){
$returnData = @require($getFile);
}else{
switch ($formatName)
{
case 'adminrole': $returnData = writeCache('AdminRole') ;break;
case 'config': $returnData = configCache(1);break;
case 'category': $returnData = writeCache('Category',0,' display_order DESC,id DESC') ;break;
case 'link': $returnData = writeCache('Link',0,'display_order DESC,id DESC');break;
case 'menu': $returnData = writeCache('Menu',0,'display_order DESC,id DESC');break;
case 'persona': $returnData = writeCache('Persona',0,'id asc');break;
case 'module': $returnData = writeCache('Module');break;
}
}
//print_r($where);
return $returnData;
}
function getContent($file = NULL,$path = NULL){
	//exit($path);
$gFile = empty($file) ?exit('error function getFile: file is LOST') : $file ;
$getPath = empty($path) ?CMS_DATA : $path ;
$getFile = $getPath.'/'.$gFile;
if(!file_exists($getFile)) die("file:$getFile is LOST");
return @require($getFile);
}
function putContent($data,$file = NULL,$path = NULL)
{
$pFile = empty($file) ?exit('error function getFile: file is LOST') : $file ;
$pPath = empty($path) ?CMS_DATA : $path ;
if ($path != '.'){
if(!is_dir($pPath)){
@mk_dir($pPath);
}
}
$putFile = $pPath.'/'.$pFile;
@file_put_contents($putFile,$data);
}
function xCopy($source,$dest,$child = 0){
if(!is_dir($source)){
echo("Error:the $source is not a direction!");
exit();
}
if(!is_dir($dest)){
@mk_dir($dest,0777);
}
$fileHander = opendir($source);
while (($file = readdir($fileHander)) !== false)
{
$filepath = $source .'/'.$file;
if (strcmp($file,'.') == 0 ||strcmp($file,'..') == 0 )
{
continue;
}
if(is_dir($filepath)){
if($child) xCopy($source."/".$file,$dest."/".$file,$child);
}else{
copy($source."/".$file,$dest."/".$file);
}
}
}
function copyDir($source,$dest,$child = 0){
if(!is_dir($source)){
echo("Error:the $source is not a direction!");
exit();
}
if(!is_dir($dest)){
@mk_dir($dest,0777);
}
$fileHander = opendir($source);
while (($file = readdir($fileHander)) !== false)
{
$filepath = $source .'/'.$file;
if (strcmp($file,'.') == 0 ||strcmp($file,'..') == 0 ) continue;
if(is_dir($filepath)){
if($child) xCopy($source."/".$file,$dest."/".$file,$child);
}
}
}
function getCategory($array,$parentid = 0,$level = 0,$add = 2,$repeat = '　') {
$str_repeat = '';
if($level) {
for($j=0;$j<$level;$j++) {
$str_repeat .= $repeat;
}
}
$newarray = array();
$temparray = array();
foreach((array)$array as $v) {
if($v['parent_id'] == $parentid) {
$newarray[] = array(
'id'=>$v['id'],
'module'=>$v['module'],

'title'=>$v['title'],
'parent_id'=>$v['parent_id'],
'biaozhi'=>$v['biaozhi'],
'html_url'=>$v['html_url'],
'menu'=>$v['menu'],
'level'=>$level,
'display_order'=>$v['display_order'],
'description'=>$v['description'],
'status'=>$v['status'],
'create_time'=>$v['create_time'],
'update_time'=>$v['create_time'],
'status'=>$v['status'],
'protected'=>$v['protected'],
'str_repeat'=>$str_repeat
);
$temparray = getCategory($array,$v['id'],($level +$add));
if($temparray) {
$newarray = array_merge($newarray,$temparray);
}
}
}
return $newarray;
}












function getCategory2($array,$parentid = 0,$level = 0,$add = 1,$repeat = '　') {
$str_repeat = '';
if($level) {
for($j=0;$j<$level;$j++) {
$str_repeat .= $repeat;
}
}
$newarray = array();
$temparray = array();
foreach((array)$array as $v) {
	
if($v['pid'] == $parentid) {
$c=$c+1;	
	
$newarray[] = array(
'id'=>$v['id'],
'title'=>$v['title'],
'pid'=>$v['pid'],
'level'=>$v['level'],
'xulie'=>$c,
'str_repeat'=>$str_repeat
);



$temparray = getCategory2($array,$v['id'],($v['level']+$add));
if($temparray) {
$newarray = array_merge($newarray,$temparray);
}
}
}
return $newarray;
}























function getCategory1($array,$parentid = 0,$level = 0,$add = 2,$repeat = 'child_') {
$str_repeat = '';
if($level) {
for($j=0;$j<$level;$j++) {
$str_repeat .= $level;
}
}
$newarray = array();
$temparray = array();
foreach((array)$array as $v) {
if($v['parent_id'] == $parentid) {
$newarray[] = array(
'id'=>$v['id'],
'module'=>$v['module'],
'title'=>$v['title'],
'parent_id'=>$v['parent_id'],
'level'=>$level,
'display_order'=>$v['display_order'],
'description'=>$v['description'],
'status'=>$v['status'],
'create_time'=>$v['create_time'],
'update_time'=>$v['create_time'],
'status'=>$v['status'],
'protected'=>$v['protected'],
'str_repeat'=>$str_repeat
);
$temparray = getCategory1($array,$v['id'],($level +$add));
if($temparray) {
$newarray = array_merge($newarray,$temparray);
}
}
}
return $newarray;
}






function bgStyle($data,$param = 1,$color = '#00F'){
if($data == $param){
return $color;
}
}
function buildSelect($data,$parentId = 0,$selected = 0,$str = '')
{
$formatArray = getCategory($data,$parentId);
foreach ((array)$formatArray as $row){
if($row['id'] == $selected){
$str .= '<option value="'.$row['id'] .'" selected="selected">'.$row['str_repeat'] .$row['title'] .'</option>';
}else{
$str .= '<option value="'.$row['id'] .'">'.$row['str_repeat'] .$row['title'] .'</option>';
}
}
return $str;
}





function buildSelect2($data,$parentId = 0,$selected = 0,$str = '')
{
$formatArray = getCategory2($data,$parentId);
foreach ((array)$formatArray as $row){
if($row['id'] == $selected){
$str .= '<option value="'.$row['id'] .'" selected="selected">'.$row['str_repeat'] .$row['title'] .'</option>';
}else{
$str .= '<option value="'.$row['id'] .'">'.$row['str_repeat'] .$row['title'] .'</option>';
}
}
return $str;
}










function moduleTitle($name = '',$file = NULL,$path = NULL){
$getData = getCache('Module');
foreach ((array)$getData as $key=>$value){
if($value['module_name'] == $name){
echo $value['module_title'];
}
}
}
function dadds($str)
{
$content = (!get_magic_quotes_gpc ()) ?addslashes($str) : $str;
return trim($content);
}
function categoryModule($data)
{
foreach ((array)$data as $row){
if(in_array($row['module_name'],array('News','Product','Download','Job','Link','Ad'))){
$datas[] = $row;
}
}
return $datas;
}
//获取分类名字
function selectCategory($slid){
$category = getCache('Category');
foreach ((array)$category as $c){
if($c['id'] == $slid){
echo $c['title'];
}
}
}
function explodeUrl($url,$img = '')
{
$str = empty($url) ?'': explode("\n",$url);
foreach ((array)$str as $key=>$row){
$key = $key+1;
$result .= "<a href='$row' target='_blank'><img src='$img' align='absmiddle'/>下载地址 $key</a><br />";
}
echo $result;
}
//获取父级分类
function get_parent_cat($arr,$cid,$jingtai,$mod)

{   
  
	foreach($arr as $k=>$v)
	{
	 if($v['id'] == $cid)
	  { $ff.=" >> ";
	    if($jingtai==1 && $v['html_url'] != "" && file_exists($v['html_url'])){
		$ff.= "<a href='/".$v['html_url']."'>".$v['title']."</a>";
		}else{
		$ff.= "<a href='".U("".$mod."/nlist",array('category'=>$v['id']))."'>".$v['title']."</a>";
			}
		 get_parent_cat($arr,$v['parent_id'],$jingtai,$mod);
	  }	
	}
	
	echo $ff;
}

//获取父级mod

function getmod($arr,$pid){
	 
	 global $uu;
	  $uu="";
	  foreach($arr as $k=>$v){
		  
		     if($v['id']==$pid){
			  
			getmod($arr,$v['parent_id'])  ;
			
			
			if($v['parent_id']==0){
				 
			
				$uu = $v['module'];
				
		      }
		  }
		  
		  }
	  
	 return $uu;
	}

/*
 *
 * 获取未知分类层级
 *  
 */

function get_cat_p($arr,$pid){
	
	global $uu;
	  $uu="";
	  foreach($arr as $k=>$v){
		  
		     if($v['id']==$pid && $v['parent_id'] == $pid){
			  
			getmod($arr,$v['parent_id'])  ;
		    
				
		     $uu.= $v['title']; 
		  }
		  
		  }
	   return $uu;
	}

/**
 * utf-8、gb2312都支持的汉字截取函数
 *
 * @param string $string
 * @param integer $sublen
 * @param integer $start
 * @param string $code
 * @return string
 */

function cut_str($string,$sublen,$start=0,$code='UTF-8')
{
 if($code=='UTF-8')
 {
  $pa="/[x01-x7f]|[xc2-xdf][x80-xbf]|xe0[xa0-xbf][x80-xbf]|[xe1-xef][x80-xbf][x80-xbf]|xf0[x90-xbf][x80-xbf][x80-xbf]|[xf1-xf7][x80-xbf][x80-xbf][x80-xbf]/";
  preg_match_all($pa,$string,$t_string);

  if(count($t_string[0])-$start>$sublen) return join('',array_slice($t_string[0],$start,$sublen))."...";
  return join('',array_slice($t_string[0],$start,$sublen));
 }
 else
 {
  $start=$start*2;
  $sublen=$sublen*2;
  $strlen=strlen($string);
  $tmpstr='';

  for($i=0;$i<$strlen;$i++)
  {
   if($i>=$start&&$i<($start+$sublen))
   {
    if(ord(substr($string,$i,1))>129)
    {
     $tmpstr.=substr($string,$i,2);
    }
    else
    {
     $tmpstr.=substr($string,$i,1);
    }
   }
   if(ord(substr($string,$i,1))>129) $i++;
  }
  if(strlen($tmpstr)<$strlen ) $tmpstr.="...";
  return $tmpstr;
 }
}

//$str="新程php培训";
//echo cut_str($str,8,0,'gb2312');
/*生成静态函数*/
function get_ip() {
  if(getenv("HTTP_CLIENT_IP")&&strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
    $ip =getenv("HTTP_CLIENT_IP");
  else if (getenv("HTTP_X_FORWARDED_FOR")&&strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
    $ip =getenv("HTTP_X_FORWARDED_FOR");
  else if (getenv("REMOTE_ADDR")&&strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
    $ip =getenv("REMOTE_ADDR");
  else if (isset($_SERVER['REMOTE_ADDR'])&& $_SERVER['REMOTE_ADDR']&&strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
    $ip =$_SERVER['REMOTE_ADDR'];
  else
    $ip ="unknown";
  return $ip;
}
//获取URL 函数

function get_url($id,$htmlurl,$model,$jingtai){
	
	   if($jingtai==0 || $htmlurl==""){
		   
		   $url=U($model.'/detail',array('item'=>$id));
		   
		 } else {
			
			$url=$htmlurl; 
			 
		 }
	   return $url;
	
	}
	//判断是否有静态页面
	function is_html($mod,$jintai){
		
		if($jingtai==1 || file_exists("html/".$mod."/index.html")){
		
		    redirect("/html/".$mod."/index.html");//跳转到静态页面
		   
	      }
		
		
		
		}
		
		/*安全过滤函数*/  
		function rfilter($str){
			
			$bt=array('<','>','\\"',"\\'",'\\\\');
			$gt=array('&lt;','&gt;','"',"'",'\\');
                     if(is_array($str)){
				        foreach ($str as $k=>$v){
                        $retuen[$k]=str_replace($bt,$gt,$str[$k]);  
                       }
				   
				 }else{
	               $retuen = str_replace($bt,$gt,$str[$k]);
                   }
			   return $retuen;
			
			}
			
			
	/*获取用户名*/
	function getuname($id,$num){
		
		if(!$id) return false;
		
		$uname=D('User')->field('username,realname,face')->where('id='.$id)->find();
		
		
		
		   if($num!=1){
		    if($uname['realname'] != ""){
			 
			 return $uname['realname'];
			
			}else{
				
				return $uname['username'];
				}
		   }
		   else{
			   
			   if($uname['face'] != ""){
			   return $uname['face'];
		   }else{
			   
			   return "/Public/img/face.jpg";
			   }
			   
			   }
		}
		  
		  
		  //获取用户真是姓名
		  
		  function getTruename($uid){
			   
			    if(!intval($uid)) return false;
				$user_info=M('User')->Field('username,realname')->where('uid='.$uid)->find();
				if($user_info['realname'] != ""){
				      $yy=$user_info['realname']; 
				    }else{
				      $yy=$user_info['username']; 	
				 }
				
			    return $yy;
			   }
		  
		  
		  //获得公司Id
		  
		  function  get_comid($uid){
			      
				  global $yy;
				  $yy="";
				  if(!intval($uid)) return false;
	              $url=C('API_URL')."/json.php?act=user_name&uid=$uid";
			      $comid=file_get_contents($url);
				  $comid=(array)json_decode($comid);
				   
				   if($comid['pid'] !=0){
					   
					    get_comid($comid['pid']);
						 //$yy = $comid['uid'];
				  
				   }else{
					   $yy = $comid['uid'];
					   }
					   
					 return $yy;  
			  }
			  
		
			  
		
		  
	function sub1($str){
		   
		   return substr($str,1,strlen($str));
		
		}	
		
		/*压缩图片函数*/
		
		
		 function resize_img($filename,$destImage,$newwidth,$newheight,$pictype){
             list($width, $height) = getimagesize($filename);
             header('Content-type:image/jpeg');
             $thumb = imagecreatetruecolor($newwidth, $newheight);
              
			 if($pictype=="gif")
				  {$source = imagecreatefromgif($filename);
			      }else if($pictype=="png")
				  {$source = imagecreatefrompng($filename);
			      }else if($pictype=="bmp")
				  {$source = imagecreatefromwbmp($filename);
			      }
				  else if($pictype=="jpg")
				  {$source = imagecreatefromjpeg($filename);
			      }else{
				  exit();
			 }
             
              imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                  ob_start();
                  imagejpeg($thumb);
                  $i = ob_get_clean(); 
                  $fp = fopen ($destImage,'w');
                  fwrite ($fp, $i);
                  fclose ($fp);
             if(file_exists($destImage))
			 {return 1;}else{return 0;}
           }
	
		function get_realid($id){
			      
				  $arr=array(1=>'企业用户',2=>'普通用户',3=>'一般用户',0=>'猎头用户');
				  return $arr[$id];
			 
			  }
			  
			  
			  
			  //curl  防暑获取接口数据
			  
			  function curl($url){
				     
					 
					 if(function_exists('curl_init')) {
                            $ch = curl_init();
                            $timeout = 1;
                            curl_setopt ($ch, CURLOPT_URL,$url);
                            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                            $info = curl_exec($ch); 
							return $info;
                            
							
							
                            }else{
                             $info= file_get_contents($url);
							  return $info;	
	                         }
				   
				         
				  }
				  
				  //获取hr联系人
				  
				   
				    function getHrName($id,$fl){
					   
					   if(!intval($id)) return false;
					   $hname=D("hr_contacts")->where("company_id=".$id)->limit("1")->find();
					   return $hname['hname']; 
						
					  }
				  //获取团队成员
				  
				   
				    function get_teamer($id){
					   
					   if(!intval($id)) return false;
					   $hname=D("Team")->where("uid=".$id)->limit("1")->find();
					   return $hname['uname']; 
						
					  }
				  //获取候选人名称
				  
				   function get_houxuan($id){
					   
					   if(!intval($id)) return false;
					   $hname=D("candidate")->where("id=".$id)->limit("1")->find();
					    if($hname['source']==0){
							 
							 $hn=M('Talent')->where('id='.$hname['resume_id'])->getField('realname');
							 return "<a href='/Talent/detail/id/".$hname['resume_id']."' target='_blank'>".$hn."</a>";
							}else if($hname['source']==1){
								
								 $hn=M('User')->where('uid='.$hname['resume_id'])->getField('realname');
								return $hn;
								} else if($hname['source']==1){
								
								 $hn=M('User')->where('uid='.$hname['resume_id'])->getField('realname');
								return $hn;
								} 
						
					  }
				  
				  
				  
				  
				  
				  
				  
				  
				  //获取下拉菜单
				  function get_select($arr,$id){
					  
					if(!isset($id) || $id==0){
					      
					}
					       foreach($arr as $k=>$v){
							     
								 
								 if($k<8){
								 if($id!=$k){
							     $sel.="<option value='$k'>$v</option>";
								 }else{
									 $sel.="<option value='$k' selected>$v</option>";
									 }
								 }
							   }
					  
						  return $sel;	   
					  
					  }
					  
					  
					  
					  
					  
					  
					  
					   //获取下拉菜单
				  function get_select1($arr,$id){
					  
					if(!isset($id) || $id==0){
					      
					}
					       foreach($arr as $k=>$v){
							     
								 
								
								 if($id!=$k){
							     $sel.="<option value='$k'>$v</option>";
								 }else{
									 $sel.="<option value='$k' selected>$v</option>";
									 }
								
							   }
					  
						  return $sel;	   
					  
					  }
					  
					  
					  
					  
					  
					  
					  function set_array($arr){
		                            foreach ((array)$arr as $k=>$v){
								    if(!is_array($arr[$k])){
									array($arr[$k]);
									}
								  }
							  
						  
						  }
						  
						  //获取公用数组的项目
						  
						  function get_pb_arr($arr){
							  
							      foreach($arr as $k=>$v){
									      
									      $nrr[]=$arr[$k];
									  }
							       return $nrr;
							  }
							  
							  
						//获取工作角色
						function get_juese($id){
							
							 //if($id) return false;
							 $arr=array('寻访员','面试顾问','客户协调','销售','录入','其他');
							 return $arr[intval($id)];
							
							}
							
						function get_time($time,$geshi){
							
							         if($time < 10000){
										return false; 
									  }else{
										 return  date($geshi,time());
										}
							
							}	
							
						
				//implode强化
				
				function imp($arr,$fenge='',$field=''){
					      
						  if(!is_array($arr)) return false;
						  if(empty($fenge)) $fenge =',';
						  if(empty($field)) exit('没有字段');
						  
						     foreach($arr as $k=>$v){
							         
									 $nrr[]=$v[$field];
                                   							  
							  }
					      return implode($fenge,$nrr);
					}		  
					  
					  
				//get resume info
				
				function get_resume($id){
					
					     if(!intval($id)) return false;
				         
						 $info=M('Talent')->find($id);
						  
			        	 return $info;
			    
			   }
			   
			   
			   
			   
			   function get_resume_name($id){
					
					     if(!intval($id)) return false;
				         
						 $info=M('Talent')->field('realname')->find($id);
						  
			        	 return $info['realname'];
			    
			   }
					
					
					  
					  
					  
			// get candidate stage nums
			
			function get_stage_nums($gid,$sid){
				
				  if(!$sid) return false;
				   $ns="";
				   $nums=M("Candidate")->where("gid=".$gid." and stage=".$sid." and  display=1")->count();
				  if($nums != 0){
					     
						$ns= "<span class='s_nums'>".$nums."</span>";
					   
					  }
				   return $ns;
				}		  
				
				
				//获取工作但部门
				
				function get_deparment($gid){
					      
						   if(!$gid) return false;
						   
						   $dpid=M('Works')->where('id='.$gid)->getField('department_id');
					       
						   return $dpid;
					}	  
					
					
					
					
					function get_bumen($id){
					      
						   if(!$id) return false;
						   
						   $dpid=M('User_group')->where('id='.$id)->getField('title');
					       
						   return $dpid;
					}	
					
					
					
					
			  //get job name
			  
			  	function get_job($gid){
					      
						   if(!$gid) return false;
						   
						   $dpid=M('Works')->where('id='.$gid)->getField('Search_posts');
					       
						   return $dpid;
					}		
					
					
					  
			 //获取客户名称
			 
			 function get_clientname($id){
				 
				         if(!$id) return false;
						 $name=M('Client')->where('id='.$id)->getField('short_name');
				          return $name;
				 }
					  
					  
					  
					function get_user_face($uid){
				
				         if($uid){
							   
							   $face1=M('User')->Field('face,type')->where('uid='.$uid)->find();
							   
							   $face=$face1['face'];
							   
							   
							   if(!$face){
								     
									 $face='/images/face.png';
									 
								   }
							  
							 }else{
								 $face='/images/face.png';
								 
								 }
							 if($face1['type']==3){
								 
								 
							
							
							     return 'http://www.jobme.cn'.$face;
								 
							 }else{
								  
								  return $face;
								 
								 }
				}	    
					  
					  
					  
					  
					  
					  
					  
					  
					  function Pinyin($_String, $_Code='UTF8'){ //GBK页面可改为gb2312，其他随意填写为UTF8

        $_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha".

                        "|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|".

                        "cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er".

                        "|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui".

                        "|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang".

                        "|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang".

                        "|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue".

                        "|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne".

                        "|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen".

                        "|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang".
                        "|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|".

                        "she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|".

                        "tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu".

                        "|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you".

                        "|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|".

                        "zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo";

        $_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990".

                        "|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725".

                        "|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263".

                        "|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003".

                        "|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697".

                        "|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211".

                        "|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922".

                        "|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468".

                        "|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664".

                        "|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407".

                        "|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959".

                        "|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652".

                        "|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369".

                        "|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128".

                        "|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914".

                        "|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645".

                        "|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149".

                        "|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087".

                        "|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658".

                        "|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340".

                        "|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888".

                        "|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585".

                        "|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847".

                        "|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055".

                        "|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780".

                        "|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274".

                        "|-10270|-10262|-10260|-10256|-10254";
        $_TDataKey   = explode('|', $_DataKey);

        $_TDataValue = explode('|', $_DataValue);

        $_Data = array_combine($_TDataKey, $_TDataValue);

        arsort($_Data);

        reset($_Data);

        if($_Code!= 'gb2312') $_String = _U2_Utf8_Gb($_String);

        $_Res = '';

        for($i=0; $i<strlen($_String); $i++) {

                $_P = ord(substr($_String, $i, 1));

                if($_P>160) {

                        $_Q = ord(substr($_String, ++$i, 1)); $_P = $_P*256 + $_Q - 65536;

                }

                $_Res .= _Pinyin($_P, $_Data);

        }

        return preg_replace("/[^a-z0-9]*/", '', $_Res);

}

function _Pinyin($_Num, $_Data){

        if($_Num>0 && $_Num<160 ){

                return chr($_Num);
        }elseif($_Num<-20319 || $_Num>-10247){

                return '';

        }else{

                foreach($_Data as $k=>$v){ if($v<=$_Num) break; }

                return $k;
        }

}

function _U2_Utf8_Gb($_C){

        $_String = '';

        if($_C < 0x80){

                $_String .= $_C;

        }elseif($_C < 0x800) {
                $_String .= chr(0xC0 | $_C>>6);

                $_String .= chr(0x80 | $_C & 0x3F);

        }elseif($_C < 0x10000){

                $_String .= chr(0xE0 | $_C>>12);

                $_String .= chr(0x80 | $_C>>6 & 0x3F);

                $_String .= chr(0x80 | $_C & 0x3F);

        }elseif($_C < 0x200000) {

                $_String .= chr(0xF0 | $_C>>18);

                $_String .= chr(0x80 | $_C>>12 & 0x3F);

                $_String .= chr(0x80 | $_C>>6 & 0x3F);

                $_String .= chr(0x80 | $_C & 0x3F);

        }

        return iconv('UTF-8', 'GB2312', $_String);

}

					  
		
		/*获取模块名称*/
		
		function get_module($st){
			
			    
					 
					 $mname=M('Module')->where('mname="'.$st.'"')->find();
	                 if ($mname) {
						 
						 return $mname['title'];			 
					 }
				 
			}
			/*获取操作名*/
		
		   function get_action($st){
			
			     if(!$st){
					  
					  return false;
					 
					 }
					 
					$arr=array('index'=>'','add'=>'新增','edit'=>'编辑','modfy'=>'编辑','recycle'=>'回收站','partake'=>'我参与的工作单','all'=>'工作单管理','detail'=>'详情','search'=>'查询',
					'feedback'=>'建议反馈',
					'contact'=>'联系我们',
					'about'=>'关于我们');	 
					  
					  return $arr[$st];
				 
			}
		
		
		
		
		
		
		
		
		
		
		
		
		
		//邮件发送函数
		
		function send_email($address,$subject,$body, $charset, $is_html, $receipt = false){
		
		
		 require_cache('includes/class.phpmailer.php');
				
				   require_cache('includes/mailer.class.php');
				
				         $from      =    'jobme.cn';
				         $email     =    'team@jobme.cn';
						 $protocol  =    '1';
						 $host      =    'smtp.exmail.qq.com';
						 $port      =    '25'; 
						 $user      =    'team@jobme.cn'; 
						 $pass      =    'zhimei123'; 
						
						
						
			            $smtp      =     new Mailer($from, $email, $protocol, $host, $port, $user, $pass);
						
						       //对邮件内容进行必要的过滤
					
						
						if($smtp){
						                 $fasong=$smtp->send($address,$subject,$body, $charset, $is_html=true, $receipt = false);
						                 if($fasong){
							
							               return 1;
							
							             }else{
							                return  0;	
							             }
										 
						     }
						  else
						{
						 
						 echo  "邮件错误";	
							
						}
						
						
						
						
						
						
						
						
						

		}
		
		
		 
						function get_tlent($id){
							
							   if(!$id) return false;
							   
							     $in=M('User')->where('uid='.$id)->find();
								 return $in;
							}
						
						
						
						
						
						
					
							
							
							
							
							
							
							
							
							
							
							
							function get_geren_yeji($yue,$uid){
							     
								 if(!$yue) return false;
								 if($yue==1){
								  $nian=strtotime(date('Y',time())."-01-01",time());
								  $nian2=strtotime(date('Y',time())."-01-30",time());
								 }
								 
								 if($yue==2){
								  $nian=strtotime(date('Y',time())."-02-01",time());
								  $nian2=strtotime(date('Y',time())."-02-28",time());
								 }
								 
								 if($yue==3){
								  $nian=strtotime(date('Y',time())."-03-01",time());
								  $nian2=strtotime(date('Y',time())."-03-31",time());
								 }
								 
								 if($yue==4){
								  $nian=strtotime(date('Y',time())."-04-01",time());
								  $nian2=strtotime(date('Y',time())."-04-30",time());
								 }
								 if($yue==5){
								  $nian=strtotime(date('Y',time())."-05-01",time());
								  $nian2=strtotime(date('Y',time())."-05-31",time());
								 }
								 
								 if($yue==6){
								  $nian=strtotime(date('Y',time())."-06-01",time());
								  $nian2=strtotime(date('Y',time())."-06-30",time());
								 }
								 
								 if($yue==7){
								  $nian=strtotime(date('Y',time())."-07-01",time());
								  $nian2=strtotime(date('Y',time())."-07-31",time());
								 }
								 
								 if($yue==8){
								  $nian=strtotime(date('Y',time())."-08-01",time());
								  $nian2=strtotime(date('Y',time())."-08-31",time());
								 }
								 
								 if($yue==9){
								  $nian=strtotime(date('Y',time())."-09-01",time());
								  $nian2=strtotime(date('Y',time())."-09-30",time());
								 }
								  
								  
								  if($yue==10){
								  $nian=strtotime(date('Y',time())."-10-01",time());
								  $nian2=strtotime(date('Y',time())."-10-30",time());
								 }
								  
								  
								  
								  if($yue==11){
								  $nian=strtotime(date('Y',time())."-11-01",time());
								  $nian2=strtotime(date('Y',time())."-11-30",time());
								 }
								 
								 
								 if($yue==12){
								  $nian=strtotime(date('Y',time())."-10-01",time());
								  $nian2=strtotime(date('Y',time())."-12-31",time());
								 }
								  
								  
								  // echo $nian;
								  $where=" uid =".$uid;
								  $where.=" and create_time >=$nian and create_time <=$nian2";
								  $person=M('Commission')->field('uid,yeji')->where($where)->select();
								 
								  $yeji=0;
								  foreach($person as $k=>$v){
									  
									     $yeji=$yeji+$v['yeji'];
									  }
							       
								   
								   
								   
							     return $yeji;
							}
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							function get_bm_yeji($yue,$bid,$cid){
							     
								 if(!$yue) return false;
								 if($yue==1){
								  $nian=strtotime(date('Y',time())."-01-01",time());
								  $nian2=strtotime(date('Y',time())."-01-30",time());
								 }
								 
								 if($yue==2){
								  $nian=strtotime(date('Y',time())."-02-01",time());
								  $nian2=strtotime(date('Y',time())."-02-28",time());
								 }
								 
								 if($yue==3){
								  $nian=strtotime(date('Y',time())."-03-01",time());
								  $nian2=strtotime(date('Y',time())."-03-31",time());
								 }
								 
								 if($yue==4){
								  $nian=strtotime(date('Y',time())."-04-01",time());
								  $nian2=strtotime(date('Y',time())."-04-30",time());
								 }
								 if($yue==5){
								  $nian=strtotime(date('Y',time())."-05-01",time());
								  $nian2=strtotime(date('Y',time())."-05-31",time());
								 }
								 
								 if($yue==6){
								  $nian=strtotime(date('Y',time())."-06-01",time());
								  $nian2=strtotime(date('Y',time())."-06-30",time());
								 }
								 
								 if($yue==7){
								  $nian=strtotime(date('Y',time())."-07-01",time());
								  $nian2=strtotime(date('Y',time())."-07-31",time());
								 }
								 
								 if($yue==8){
								  $nian=strtotime(date('Y',time())."-08-01",time());
								  $nian2=strtotime(date('Y',time())."-08-31",time());
								 }
								 
								 if($yue==9){
								  $nian=strtotime(date('Y',time())."-09-01",time());
								  $nian2=strtotime(date('Y',time())."-09-30",time());
								 }
								  
								  
								  if($yue==10){
								  $nian=strtotime(date('Y',time())."-10-01",time());
								  $nian2=strtotime(date('Y',time())."-10-30",time());
								 }
								  
								  
								  
								  if($yue==11){
								  $nian=strtotime(date('Y',time())."-11-01",time());
								  $nian2=strtotime(date('Y',time())."-11-30",time());
								 }
								 
								 
								 if($yue==12){
								  $nian=strtotime(date('Y',time())."-10-01",time());
								  $nian2=strtotime(date('Y',time())."-12-31",time());
								 }
								  
								  
								  // echo $nian;
								  $where=" department =".$bid." and comid = ".$cid;
								  $where.=" and create_time >=$nian and create_time <=$nian2";
								  $person=M('Commission')->field('uid,yeji')->where($where)->select();
								
								  $yeji=0;
								  foreach($person as $k=>$v){
									  
									     $yeji=$yeji+$v['yeji'];
									  }
							       
								   
								   
								   
							     return $yeji;
							}
							
							
							
							
							
							
							
							
							
							
							
							
							function get_com_yeji($yue,$cid){
							     
								 if(!$yue) return false;
								 if($yue==1){
								  $nian=strtotime(date('Y',time())."-01-01",time());
								  $nian2=strtotime(date('Y',time())."-01-30",time());
								 }
								 
								 if($yue==2){
								  $nian=strtotime(date('Y',time())."-02-01",time());
								  $nian2=strtotime(date('Y',time())."-02-28",time());
								 }
								 
								 if($yue==3){
								  $nian=strtotime(date('Y',time())."-03-01",time());
								  $nian2=strtotime(date('Y',time())."-03-31",time());
								 }
								 
								 if($yue==4){
								  $nian=strtotime(date('Y',time())."-04-01",time());
								  $nian2=strtotime(date('Y',time())."-04-30",time());
								 }
								 if($yue==5){
								  $nian=strtotime(date('Y',time())."-05-01",time());
								  $nian2=strtotime(date('Y',time())."-05-31",time());
								 }
								 
								 if($yue==6){
								  $nian=strtotime(date('Y',time())."-06-01",time());
								  $nian2=strtotime(date('Y',time())."-06-30",time());
								 }
								 
								 if($yue==7){
								  $nian=strtotime(date('Y',time())."-07-01",time());
								  $nian2=strtotime(date('Y',time())."-07-31",time());
								 }
								 
								 if($yue==8){
								  $nian=strtotime(date('Y',time())."-08-01",time());
								  $nian2=strtotime(date('Y',time())."-08-31",time());
								 }
								 
								 if($yue==9){
								  $nian=strtotime(date('Y',time())."-09-01",time());
								  $nian2=strtotime(date('Y',time())."-09-30",time());
								 }
								  
								  
								  if($yue==10){
								  $nian=strtotime(date('Y',time())."-10-01",time());
								  $nian2=strtotime(date('Y',time())."-10-31",time());
								 }
								  
								  
								  
								  if($yue==11){
								  $nian=strtotime(date('Y',time())."-11-01",time());
								  $nian2=strtotime(date('Y',time())."-11-30",time());
								 }
								 
								 
								 if($yue==12){
								  $nian=strtotime(date('Y',time())."-12-01",time());
								  $nian2=strtotime(date('Y',time())."-12-31",time());
								 }
								  
								  
								  // echo $nian;
								  $where=" comid =".$cid;
								  $where.=" and create_time >=$nian and create_time <=$nian2";
								  $person=M('Commission')->field('uid,yeji')->where($where)->select();
								
								  $yeji=0;
								  foreach($person as $k=>$v){
									  
									     $yeji=$yeji+$v['yeji'];
									  }
							       
								   
								   
								   
							     return $yeji;
							}
							
							
							
							 function htmlc($str){
			  
			              $str2=str_replace("&lt;","<",$str);
				         
				           return $str2;
			  
			  }
							
							
							
							
							
							
							
							
	function get_import($id){
		
		
		          if(!intval($id)) return false;
				         
						 $info=M('Talent_import')
						// ->Field('uid,title,last_company,post,id')
						 ->find($id);
					
			        	 return $info;   
		
		}						
							
							
							
				function get_hou($id){
					 
					 if(!$id) return false;
					 
					 $rs=M('Candidate')->Field('id,realname,source,resume_id')->where('id='.$id)->find();
					  
					  if($rs['realname'] <> 0){
					     return $rs['realname'];
					  }else{
						  
						    if($rs['source']==0){
								  
								  $r=M('Talent')->where('id='.$rs['resume_id'])->getField('realname');
								   return $r;	
								}
								
								
								if($rs['source']==2){
								  
								  $r=M('Talent_import')->where('id='.$rs['resume_id'])->getField('title');
								   return $r;	
								}
							
							
							if($rs['source']==1){
								  
								  $r=M('User')->where('uid='.$rs['resume_id'])->getField('realnamen');
								   return $r;
								}
							
						  
						  }
					
					}			
							
							
					
		//检验简历库候选人被加入了那些工作单
		
		/*function checkCan($gid,$rid){
			
			   if(!$gid || !$rid) return false;
			   
			   $nid=M('Candidate')->where('resume_id='.$rid.' and gid ='.$gid.' and source=0')->count();
			   
			   
			   
			   
			   if($nid==0){
				    
					return 0;
				   
				   }else{
					 
					 return 1;   
					   }
			
			
			}*/
		
		
					  
?>