<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-3-5
 * Time: 上午11:56
 * className:Colllection
 * dever:yige
 * ProjectName:jobmedia OA.
 */
 
 class CollectionModel extends Model{
	 


    protected $_validate = array(

       

    );



    protected $_auto = array(

        array('create_time', 'strtotime', Model:: MODEL_BOTH, 'function'),

        array('update_time', 'time', Model:: MODEL_UPDATE, 'function'),

    );

}
	 
	 
	