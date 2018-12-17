<!DOCTYPE html>
<html>
<head>
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/flat-ui.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/flat-ui.min.js"></script>
<script type="text/javascript" src="js/application.js"></script>
<script type="text/javascript" src="js/frontpage.js"></script>

	<title>CICD Score</title>
	<style type="text/css">
	.button 
	{
	    background-color:#00A6A4; 
	    border: none;
	    color: #00A6A4;
	    padding: 10px 30px;
	    text-align: center;
	    text-decoration: none;
	    display: inline-block;
	    font-size: 14px;
	    margin: 4px 2px;
	    -webkit-transition-duration: 0.4s; /* Safari */
	    transition-duration: 0.4s;
	    cursor: pointer;
	    background-color: white;
	    color: black;
	    border: 2px solid #00A6A4;
	}
	.button:hover 
	{
	    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
	}

	.button:disabled {
    opacity: 0.65; 
  cursor: not-allowed;
}
body
{
margin:0px;
}

	</style>
</head>
<body onload="init()">
<a href="https://github.com/intuit/cicdscore"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png" alt="Fork me on GitHub"></a>
<br>
<h1 align="center">#CICD Score Assessment v<sub>2</sub></h1>
<div style="position:absolute;top:20%;left:35%">
	<label style="font-size:24px"><b>Please use this tool to assess your CI/CD maturity</b></label><br>
	<label style="font-size:20px" ><b>Select Vertical</b></label><br>
    <select data-toggle="select" class="form-control select select-default select-lg" id="vertical" onchange="show_app()" style="width:400px;">
    <option value="none" selected>Select</option>
    <?php
    include 'connect_to_db.php';
	$conn = new \MySQLi($servername, $username, $password, $dbname) or die(mysqli_error());
	$sql = "SELECT DISTINCT organisation FROM all_apps";
	$result = $conn->query($sql);
	while ($row = $result->fetch_assoc()){
		echo '<option value = '.$row['organisation'].'>' . $row['organisation'] . '</option>';
	}
	?>
</select>
<br>
    <label style="font-size:20px"><b>Choose Application</b></label><br>
    <span id="app_container"><select data-toggle="select" name="searchfield" class="form-control select select-default mrs mbm" id="app" onchange="enable_next()" style="width:400px;">
    	<option value="none" selected>Select</option>

      </select></span>
		<br><br>
      <button class="button" onclick="next()" disabled style="background-color:#00A6A4; color:white;"><b>Evaluate</b></button> <a target="_blank" href="dashboard.php">&nbsp;&nbsp;&nbsp;<img src="img/dashboard.png" height="7%" width="7%" data-placement="centre" data-toggle="tooltip" />Jump to live Dashboard</a>
<br><br>
<div style="font-size:14px;"><b>*To know more about the tool, please refer to </b>  <a href="info.html" target="_blank" >this page</a></div>
</div>
</body>
</html>
