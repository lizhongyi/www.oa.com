<?php

	function found($arr,$f){
	
		$index=0;
		$sum=0;
		$a=0;
		for($i=0;$i<count($arr);$i++){
		
			if($arr[$i]==$f){
			
				$index=$i;
				$sum++;
				$a=1;
			}
		if($a){
			echo "�������ҵ�ֵ�������е��±�".$sum."�ǣ�".$index."<br/>";
			$a=0;	
			}
		
		}
		echo "��".$sum."����ͬ��ֵ".$arr[$index];

	}

	$arr=array(1,2,3,2,5,6,9,2);
	found($arr,2);

?>