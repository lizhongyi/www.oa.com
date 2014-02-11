<?php
/**
文件转换
oscar 2011-11-25 jincan.liu@gmail.com
*/
class Doc2swfAction extends Action{

public function run($file)
{

$filesArr = array('pdf','doc','docx','xls','xlsx','ppt','pptx','txt');
//文件上传并转换
if($_FILES["file"] && $_FILES["file"]["error"] <=0 ){

$fileName = iconv('UTF-8','gb2312',$_FILES["file"]["name"]);
$types = explode('.',$fileName);
$typesIf = $types[1];
//改名为时间戳
$types[0] = time();
$fileName = $types[0].'.'.$types[1];
$filetype = $typesIf;

//限制上载类型
if(!in_array($typesIf,$filesArr)){
echo '<script type="text/javascript">alert("upload file types in : pdf,doc,docx,xsl,xlsx,ppt,pptx,txt");location.href=location.href;</script>';
}
/*
function check_is_chinese($s){
return preg_match('/[\x80-\xff]./', $s);
}
//检测中文文件名
if (check_is_chinese($fileName)) {
$types[0] = time();
$fileName = $types[0].'.'.$types[1];
}
*/

//更改路径
if($typesIf=='pdf'){
$path = 'converter/files/pdf/';
}else{
$path = 'converter/files/doc/';
}

if (file_exists($path . $fileName)){
echo '<script type="text/javascript">alert("文件已经存在了");location.href=location.href;</script>';
}else{
move_uploaded_file($_FILES["file"]["tmp_name"], $path.$fileName);
//var path
$docpath = '/home/wwwroot/app.jobme.cn/files/doc/';
$pdfpath = '/home/wwwroot/app.jobme.cn/files/pdf/';
$swfpath = '/home/wwwroot/app.jobme.cn/files/files/swf/';

if (file_exists($path . $fileName)){
//执行转换
if($typesIf=='pdf'){ //PDF 转SWF
$pdf = $fileName;
$swf = str_replace('pdf','swf',$pdf);
exec('/usr/local/wenku/swftools/bin/pdf2swf -o '.$swfpath.$swf.' -T -z -t -f '.$pdfpath.$pdf.' -s languagedir=/usr/share/xpdf/xpdf-chinese-simplified -s flashversion=9');
$path2 = $pdfpath.$pdf;
$path3 = $swfpath.$swf;
}else{ //DOC 转 PDF
$doc = $fileName;
$format = explode('.',$fileName);
$formatName = $format[0].'.pdf';
$command = 'java -jar /usr/local/wenku/jodconverter-2.2.2/lib/jodconverter-cli-2.2.2.jar '.$docpath.$doc.' '.$pdfpath.$formatName;
exec($command);
$path1 = $docpath.$doc;
$path2 = $pdfpath.$formatName;

if(file_exists( $pdfpath.$formatName)){
$pdf = $formatName;
$swf = str_replace('pdf','swf',$pdf);
$swfcommand = '/usr/local/wenku/swftools/bin/pdf2swf -o '.$swfpath.$swf.' -T -z -t -f '.$pdfpath.$pdf.' -s languagedir=/usr/share/xpdf/xpdf-chinese-simplified -s flashversion=9';
exec($swfcommand);
$path3 = $swfpath.$swf;
}
}
}
}

// print_r($_FILES["file"]);
$filetype = isset($filetype) ? $filetype : '';
$path1 = isset($path1) ? str_replace('/data/oa/frontend/www','',$path1) : '';
$path2 = isset($path2) ? str_replace('/data/oa/frontend/www','',$path2) : '';
$path3 = isset($path3) ? str_replace('/data/oa/frontend/www','',$path3) : '';
$reArr = array('filetype' => $filetype,'path1'=>$path1,'path2'=>$path2,'path3'=>$path3);
return $reArr;
}




}

//删除文件
public function DelFile($path,$pdfpath,$swfpath){
$pathcommand = 'rm -rf /data/oa/frontend/www'.$path;
exec($pathcommand);
$pdfpathcommand = 'rm -rf /data/oa/frontend/www'.$pdfpath;
exec($pdfpathcommand);
$swfpathcommand = 'rm -rf /data/oa/frontend/www'.$swfpath;
exec($swfpathcommand);
}

}