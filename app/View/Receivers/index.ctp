<?php 

 		echo '<ul>';
 			foreach($receiver_datas as $receiver){
 				echo '<li>';
 					echo $receiver['Receiver']['last_name_1'];
					echo $receiver['Receiver']['first_name_1'];
				echo '</li>';
			};
		echo '</ul>';
		
?>