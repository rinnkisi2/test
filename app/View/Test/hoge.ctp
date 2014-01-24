<?php 
	foreach ($quizzes as $key => $value) {
		echo $key+1;
		echo "|";
		echo $value['Problem']['sentence'];
		echo "|";
		echo $value['Problem']['choice1'];
		echo "|";
		echo $value['Problem']['choice2'];
		echo "|";
		echo $value['Problem']['choice3'];
		echo "|";
		echo $value['Problem']['choice4'];		
		echo "<br />";
	}
?>
