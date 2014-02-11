<?php
require (ROOT_PATH.'includes/conn.php');

   function Getx2x($table,$fields,$id,$str){
        $aa=M($table);
        if(empty($str)){
            $expression='getByid';
        }else{
            $expression='getBy'.$str;
        }
        $thisaa=$aa->field($fields)->$expression($id);
        $bb=explode(',',$fields);
        if(count($bb)<=1){
            return $thisaa[$fields];
        }else{
            return $thisaa;
        }        
    }
?>