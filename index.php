<!DOCTYPE html>
<html>
<head>
	<title>Memory Game</title>
	<style type="text/css">
		.container {
			margin: 0 auto;
			width: 80%;
			background-color: #fff8e7;
		}
		.box {
			width: 18%;
			height: 160px;
			background-color: teal;
			display: inline-block;
			margin: 0 3% 10% 3.5%;
			color: white;
			font-size: 2.5em;
			text-align: center;
			line-height: 160px;
		}
	</style>
	<script
	  src="https://code.jquery.com/jquery-3.2.1.min.js"
	  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
	  crossorigin="anonymous"></script>
</head>
<body>
	<h1>Memory Game</h1>
	<p>Select tiles with same content to make them disappear.</p>
<?php
	$box = ['a','a','b','b','c','c','d','d','e','e','f','f','g','g','h','h','i','i','j','j'];
	shuffle($box);
?>
	<div class="container">
<?php for($i=0; $i < count($box); $i++): ?>
		<div class="box"><?= $i+1; ?></div>		
<?php endfor;
?>
	<div>

	<script type="text/javascript">
		var obj = <?= json_encode($box); ?>;
		console.log(obj);
		var count = 0;
		var temp_count = 0;
		var stack = {};
		var boxOrder =[];
		
		$('.box').click(function(event) {
			count ++;
			if(count >= 40){
				$("#result").html("OOPSY !!! You have ran out of attempts. LOST THE GAME!");
				return;
			} 
			var box = $(this);
			var boxNumber = box.html();
			var boxLetter = obj[boxNumber - 1];
			box.html(boxLetter);

			setTimeout(function() {
               box.html(boxNumber);
            }, 1000); 

			boxOrder.push(boxNumber);

			var stacked_obj = JSON.stringify(stackObj(boxNumber, boxLetter));
			
			// $.ajax({
			// 	url:'index.php', 
			// 	data: {'number': boxNumber}, 
			// 	type: 'post',
			// 	success: function () {
			// 		$("#result").html(boxNumber);
			// 	}
			// });

			$.post('test.php', {chances: count,number: boxNumber,letter: boxLetter, obj: stacked_obj, order: boxOrder}, function (data) {
				$("#result").html(data);
				
				if(data.indexOf('/') > -1){
					
					var first = data.indexOf('/');
					var last = data.lastIndexOf('/');
					var box_number1 = data.slice(0, first);
					var box_number2 = data.slice(first+1, last);
					
					obj[box_number2-1] = null;
					obj[box_number1-1] = null;	

					$('.box').each(function() {
						
						if(($(this).html() === boxLetter) || ($(this).html() === box_number2) || ($(this).html() === box_number1)){
							$(this).hide();
							temp_count++;
							if(temp_count == 18)
								$("#result").html("CONGRATS !!! WON THE GAME!");
						} 
						
					});
						
				}
				
			});

		});	
		
		function stackObj (number, letter) {
			stack[number] = letter;
			return stack;
		}

	</script>
	<div id="result"></div>

</body>
</html>