<?php

//receive all inputs
$count = $_POST['chances'];
$box_number = $_POST['number'];
$box_letter = $_POST['letter'];
$stacked_array = $_POST['obj'];
$stack = json_decode($stacked_array, true);
$box_order = $_POST['order'];


if($count >= 2) {
	$position = (count($box_order) >= 2) ? (count($box_order) - 2) : 1;

	foreach ($box_order as $key => $value) {
		if($key == $position){
			$previous_box = $box_order[$key];
		}
	}

	if ($previous_box === $box_number){
		exit();
	}

	//comparing current value with previous value

	foreach ($stack as $key => $value) {
		if($key == $box_number){
			$currentValue = $stack[$key];
		}
		if($key == $previous_box){
			$previousValue = $stack[$key];
		} 
	}
	if ($previousValue === $currentValue) {
		$keys = array_keys($stack, $previousValue);
		foreach ($keys as $key => $value) {
			echo $value.'/';
		}
	}	
}


	



