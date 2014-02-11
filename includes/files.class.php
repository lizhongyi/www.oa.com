<?php 
class files{
    
    /**
    * upload
    *
    * 文件上传
    *
    * @param String $path   e.g. Zend_Registry::get('upload')
    * @param Array  $files  e.g. $_FILES['Filedata']
    * @param String $dir    e.g. $_POST['dir']
    *
    * return Array $msg  e.g. if($msg['error']) 
    */
    static function upload($path,$files,$dir)
    {
        $msg=array();
        
        //文件保存目录路径
        $save_path = $path;
        //文件保存目录URL
        $save_url = $path;
        //定义允许上传的文件扩展名
        $ext_arr = array(
            'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
            'flash' => array('swf', 'flv'),
            'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
            'file' => array('doc', 'docx', 'xls','xlsx','pdf','txt'),
        );
		
		if($files['name']['type']=='doc'){
			$save_path="files/doc";
			}elseif($files['name']['type']=='pdf'){
				$save_path="files/pdf";
				
				}
				
		
		
        //最大文件大小
        $max_size = 1000000;
        
        $save_path = realpath($save_path) . '/';
        
        //有上传文件时
        if (empty($_FILES) === false) {
            //原文件名
            $file_name = $files['name'];
            //服务器上临时文件名
            $tmp_name = $files['tmp_name'];
            //文件大小
            $file_size = $files['size'];
            //目录名
            
            //检查目录
             if (@is_dir($save_path) === false) {
                $msg['error'] = "上传目录不存在。请联系管理员";
            }
            //检查目录写权限
            else if (@is_writable($save_path) === false) {
                $msg['error'] = "上传目录没有写权限。请联系管理员";
            }
            //检查是否已上传
            else if (@is_uploaded_file($tmp_name) === false) {
                $msg['error'] = "临时文件可能不是上传文件。请重新上传";
            }
            //检查文件大小
            else if ($file_size > $max_size) {
                $msg['error'] = "上传文件大小超过限制。";
            }
            //检查目录名
           
            else
            {
                //获得文件扩展名
                $temp_arr = explode(".", $file_name);
                $file_ext = array_pop($temp_arr);
                $file_ext = trim($file_ext);
                $file_ext = strtolower($file_ext);
                //检查扩展名
                if (in_array($file_ext, $ext_arr['file']) === false) {
                    $msg['error'] = "上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr['file']) . "格式。";
                }
                else
                {
                    //创建文件夹
                    
                    $dbsave = ""; //数据库中存放的路径
                    
                    if ($dir_name !== '') {
                        $save_path .= $file_ext . "/";
                        $save_url .= "/".$file_ext . "/";
                        $dbsave = $file_ext.'/';
                        if (!file_exists($save_path)) {
                            mkdir($save_path);
                        }
                    }
                    
                    $y = date("Y");
                    $m = date("m");
                    $d = date("d");
                                
                    $save_path .= $y . "/";
                    $save_url .= $y . "/";
                    $dbsave .= $y.'/';
                    if (!file_exists($save_path)) {
                        mkdir($save_path);
                    }
                    
                    $save_path .= $m . "/";
                    $save_url .= $m . "/";
                    $dbsave .= $m.'/';
                    if (!file_exists($save_path)) {
                        mkdir($save_path);
                    }
                    
                    $save_path .= $d . "/";
                    $save_url .= $d . "/";
                    $dbsave .= $d.'/';
                    if (!file_exists($save_path)) {
                        mkdir($save_path);
                    }
                    
                    //新文件名
                    $new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
                    //移动文件
                    $file_path = $save_path . $new_file_name;
                    
                    if (move_uploaded_file($tmp_name, $file_path) === false) {
                        $msg['error'] = "上传文件失败。";
                    }
                    //数据库最终存储的文件
                    $dbsave .= $new_file_name; 
                    @chmod($file_path, 0644);
                    $file_url = $save_url . $new_file_name;
                    $msg['file_url'] = $file_url;
                    $msg['file_size'] = $file_size;
                    $msg['db_path'] = $dbsave;
					$msg['type']=substr($file_ext,0,3);
                }//检查扩展名
            }//目录正确性
            return $msg;
        }
    }
    //文件上传
}