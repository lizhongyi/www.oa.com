<?php 

 
import('Model');
class CandidateModel extends Model

{
   
   protected $_scope=array(
              
			  'default'=>array(     
			  'where'=>array(
			              'status'=>1),
			              'limit'=>10,    
						      ),   
   
   );
   
  // protected $fields = array(            'id', 'username', 'email', 'age', '_pk' => 'id', '_autoinc' => true        );    
   
    public function getTopUser(){       
	
	     echo 'nihao';
	
	}
   
}