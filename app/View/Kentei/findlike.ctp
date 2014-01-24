<?php

echo count($data)."<br />";
foreach ($data as $key => $value) {
			echo $value['Problem']['sentence']." ".
			$value['Problem']['choice1']." ".
			$value['Problem']['choice2']." ".
			$value['Problem']['choice3']." ".
			$value['Problem']['choice4']."<br />";
		}
?>