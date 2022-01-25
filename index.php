<?php 
session_start();
require_once "pdo.php";

$stmt = $pdo->query("SELECT * FROM dht11 order by date desc limit 5;");
	 
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
$stmts = $pdo->query("SELECT * FROM dht11 order by date desc limit 1;");
	 
    $rows1 = $stmts->fetchAll(PDO::FETCH_ASSOC);
	
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ) {
		$url="https://";
	} else {
		$url="http://";
		$url.=$_SERVER['HTTP_HOST'];
		$url.=$_SERVER['REQUEST_URI'];
		$url;
	}
	$page=$url;
	$sec="5";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Muhammad Qayim bin Norizan</title>
		<meta http-equiv="refresh" content="<?php echo $sec; ?>" URL="<?php echo $page;?>"
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
		
		<style>
		.container-fluid{
			text-align: center;
			margin-left: auto;
			margin-right: auto;
		}
		
		.weatherTitle{
			text-align: center;
			padding: 2%;
			font-family: "Trebuchet MS", sans-serif;
		}
		
		.weatherPic{
			padding-top: 1%;
			padding-bottom: 2%;
			margin-left: auto;
			margin-right: auto;
		}
		
		.minipic{
			height: 7%;
			width: 12%;
			margin-left: auto;
			margin-right: auto;
			padding: 1%;
		}
		.newestData{
			height: 20%;
			width: 20%;
			margin-left: auto;
			margin-right: auto;
			padding: 1%;
		}
		.col-sm-4{
			height: 20%;
			width: 40%;
			margin-left: auto;
			margin-right: auto;
		}
		
		.container-sun{
			background-color: #5ADEFF;
			padding: 2%;
		}
		.container-sunrain{
			background-color: #92BAD2;
			padding: 2%;
		}
		
		.container-rain{
			background-color: #53789E;
			padding: 2%;
		}
		.recent{
			font-size: 25px;
		}
		.date{
			font-size: 10px;
		}
		
		</style>
</head>
<body>
<div class="container-fluid">
		<?php 
		foreach ($rows1 as $row1) {
			if($row1['temperature'] > 26.0 && $row1['humidity'] < 50.0){
				$weatherForecast = "sun";
				$bg1 = "white";
				$warning = "Laundry can be safely dry out it the sun ;)";
			} else if($row1['temperature'] < 26.0 && $row1['humidity'] > 50.0){
				$weatherForecast = "rain";
				$bg1 = "danger";
				$warning = "PREPARE TO TAKE THE LAUNDRY INSIDE";
			} else{
				$weatherForecast = "sunrain";
				$bg1 = "warning";
				$warning = "Be ready it might rain anytime";
			}
	
	echo('<div class="container-'.$weatherForecast.'" id="all">');
			echo('<div class="weatherTitle">');
				echo('<h1>SunDry Laundry</h1>');
			echo('</div>');
			
			echo('<div class="weatherPic" id="all">');
				echo('<img src="weather/'.$weatherForecast.'.png" class="complogo">');
			echo('</div>');
			
			echo('<div class="newestData" id="all">');
				echo('<div class="container pt-2 border bg-'.$bg1.' text-dark rounded-3">');
					echo('<p>'.$warning.'</p>');
				echo('</div>');
			echo('</div>');
			
			echo('<div class="newestData" id="all">');
				echo('<div class="container pt-2 border bg-white text-dark rounded-3">');
					echo('<p>Temperature: '.$row1['temperature'].' C</p>');
				echo('</div>');
			echo('</div>');
			
			echo('<div class="newestData" id="all">');
				echo('<div class="container pt-2 border bg-white text-dark rounded-3">');
					echo('<p>Humidity: '.$row1['humidity'].' %</p>');
				echo('</div>');
			echo('</div>');
		}
		
			echo('<div class="tempAndHumDataList">');
			echo('<div class="recent">');
			echo('<p>Recent temperature and humidity data</p>');
			echo('</div>');
			
				foreach ($rows as $row) {
					if($row['temperature'] > 26.0 && $row['humidity'] < 50.0){
						$weatherForecastMini = "sun";
						$bg="white";
					} else if($row['temperature'] < 26.0 && $row['humidity'] > 50.0){
						$weatherForecastMini = "rain";
						$bg="danger";
					} else{
						$weatherForecastMini = "sunrain";
						$bg="warning";
					}
					echo('<div class="col-sm-4">');
						echo('<div class="data" id="all">');
							echo('<div class="container pt-3 pb-1 m-2 my-3 bg-'.$bg.' text-dark rounded-3">');
							echo('<p><img class="minipic" src="weather/'.$weatherForecastMini.'.png"/>Temperature: '.$row['temperature'].' C Humidity: '.$row['humidity'].' %</p>');
							echo('<p class="date">'.$row['date'].'</p>');
							echo('</div>');
						echo('</div>');
					echo('</div>');
				}
				
				echo('<div class="col-sm-4">');
						echo('<div class="showAll">');
							echo('<div class="container pt-3 pb-1 m-2 my-3 bg-white text-dark rounded-3">');
							echo('<a href="alldata.php"><p>SHOW ALL</p></a>');
							echo('</div>');
						echo('</div>');
				echo('</div>');
				
			echo('</div>');
			echo('</div>');
			
			?>
		
</div>
</body>
</html>
