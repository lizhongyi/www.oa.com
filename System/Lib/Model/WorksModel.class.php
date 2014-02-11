<?php 
/**


 */
 

class WorksModel extends Model
{
    protected $_validate = array(
        array('title', 'require', '标题必填', 0, '', Model:: MODEL_BOTH),
        array('Search_posts', 'require', '内容必填', 0, '', Model:: MODEL_BOTH),
    );

    protected $_auto = array(
        array('title', 'dHtml', Model:: MODEL_BOTH, 'function'),
       
        array('create_time', 'strtotime', Model:: MODEL_BOTH, 'function'),
        array('update_time', 'time', Model:: MODEL_UPDATE, 'function'),
    );
}