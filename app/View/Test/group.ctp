<?php 
//pr($group);
?>
<style>
	.row{
		font-size: 20px;
	}
</style>
<div class="row">
	<div class="span6">
		グループA : <a href="test_a">テスト</a>
		<br />

		<?php
			$a_count = 0;
			foreach ($group['a'] as $key => $value) {
				echo $value['name'];
				echo "\t";
				echo $value['point'];
				$a_count += $value['point'];
				echo "<br />";
			}

			echo "平均点[" .$a_count / count($group['a']) . "]";
		?>
	</div>

	<div class="span6">
		グループB : <a href="test_b">テスト</a>
		<br />
		<?php
			$b_count = 0;
			foreach ($group['b'] as $key => $value) {
				echo $value['name'];
				echo "\t";
				echo $value['point'];
				$b_count += $value['point'];
				echo "<br />";
			}
			echo "平均点[".$b_count / count($group['b']) . "]";
		?>
	</div>
</div>

<?php 
foreach ($data as $key => $value) {
	echo $value['TestUser']['name']."@s.iwate-pu.ac.jp";
	//echo "\t";
	//echo $value['TestUser']['point'];
	echo "<br />";
}
?>