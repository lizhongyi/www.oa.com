<?php 
/**


 */
 

class CommissionModel extends RelationModel

{
   
   protected $_scope=array(
              
			  'default'=>array(     
			  'where'=>array(
			              'status'=>1),
			              'limit'=>10,    
						      ),   
   
   );
   
  // protected $fields = array(            'id', 'username', 'email', 'age', '_pk' => 'id', '_autoinc' => true        );    
   
    public function get_juese($juese,$tc){       
	
	    foreach($juese as $b=>$c){
							  
							   
						        $ni.="工作角色:".$this->p_t_array[$c]."　提成比例:".$tc[$b]."%<br/>";
								
						   
						  }    
	return $ni;
	}
	
   
}