<?php
include "data.php";
$a = new showData();
//$sth = $a -> jsonShowAllItemsDataWithField("apples", "sugar");
$sth = $a -> jsonShowAllItemsData($_GET[abc]);
//print_r (json_decode($sth));
?>
<!DOCTYPE html>
<head>
	<title></title>
	<script type="text/javascript">
	</script>
	<script type="text/javascript">
	var selectedName = "<? echo $_GET[abc]; ?>";
		window.onload = function() {
			var myJson = <?php echo $sth; ?>;
			var jsArray = new Array({label:"Fat", y : myJson.fat}, 
			{label:"Carbs",y:myJson.carbs},{label:"Prot",y:myJson.prot}, 
			{label:"Calories",y:myJson.calories},{label:"Net carbs",y:myJson.net_carbs},
			{label:"Sugar",y:myJson.sugar},{label:"Fiber",y:myJson.fiber},
			{label:"Total carbs",y:myJson.total_carbs},{label:"Trans",y:myJson.trans},
			{label:"Mono",y:myJson.mono},{label:"poly",y:myJson.poly},
			{label:"Sat",y:myJson.sat},{label:"Total fat",y:myJson.total_fat},
			{label:"Protein",y:myJson.protein},{label:"Sodium",y:myJson.sodium},
			{label:"Cholesterol",y:myJson.cholesterol},{label:"Iron",y:myJson.iron},
			{label:"Calcium",y:myJson.calcium},{label:"Vitamin a",y:myJson.vitamin_a},{label:"Vitamin c",y:myJson.vitamin_c}
			);
			var chart = new CanvasJS.Chart("chartContainer", {
				theme : "theme2",
				title : {
					text : "This is a chart for " + selectedName
				},
				data : [{
					type : "pie",
					dataPoints : jsArray
				}]
			});

			chart.render();
		}
	</script>
	<script type="text/javascript" src="canvasjs.min.js"></script>

</head>
<body>
	<!--<h2><?php //print_r(json_decode($sth)); ?></h2>-->
	<input id="sFood" type="text" placeholder="Input the food." />
	<input type="submit" onClick="searchStart();" />
	<div id="chartContainer" style="width: 800px; height: 380px;"></div>

<script>
function searchStart(){
location.href='chart.php?abc='+document.getElementById('sFood').value;
}
</script>

</body>
</html>
