	<form>
	<button type="button">Upload Files</button>
	<input type="submit"  value="submit file brother"/>
	</form>
	<?php

	$ourArray = array(1,2,3);
	echo '<pre>';
		print_r($ourArray);
	echo '</pre>';

	$ourArray= array_unique($ourArray);
	$ourArray = array_slice($ourArray, 0,3);

	array_push($ourArray,4);

	echo 'pushed <pre>';
		print_r($ourArray);
	echo '</pre>';


	$ourArray = array_reverse($ourArray);

		echo 'reverserd<pre>';
		print_r($ourArray);
	echo '</pre>';

	$ourArray= array_unique($ourArray);
	$ourArray = array_slice($ourArray, 0,3);

	echo '<pre>';
		print_r($ourArray);
	echo '</pre>';

	$arr = array('Hello','World!','Beautiful','Day!');
	$arra= implode(",",$arr);
	var_dump($arra);

	$arra= explode(",",$arra);
	var_dump($arra);

	
	?>

<script>

	test('kapil',12,null);
	test('kapil',23,'kalaki');
	function test(name,age,adress){
		if(adress==null){
			console.log('first Function');
		}else{
			console.log('Second Function');
		}
	}

</script>