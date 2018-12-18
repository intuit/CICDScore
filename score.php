<?php
include 'connect_to_db.php';
extract($_GET);
$comp = '"'.'10001000000000000000'.'"';
$data = json_decode(file_get_contents("data/data.json"),true);

if(!isset($login))
	{
		$login = 0;
	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "SELECT composition from score_composition WHERE organisation = '".$vertical."' AND application = '".$app."' ";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$comp = '"'.$row["composition"].'"';
	if ($comp == '')
		$comp = '"'.'0000000000000000000000000'.'"';

	if(!isset($old_comp))
			$old_comp = $comp;
	}
else
{
	$login = 1;
	$comp = '"'.$comp.'"';
	if(!isset($old_comp))
		$old_comp = $comp;
	else
		$old_comp = '"'.$old_comp.'"';

}

	$app_disp = $app;
	$app = '"'.$app.'"';
	$vertical = '"'.$vertical.'"';

?>


<!DOCTYPE html>
<html>
<head>
	<title>CICD Score</title>
</head>
<style type="text/css">
	body{
            
        font-family:Tahoma, Geneva, sans-serif;
	    display: inline-block;
	    margin: 10px auto;
	    text-align: center;
	}
	table{
		border-collapse: collapse;
	}
	tr,th,td{
		border: 1px solid black;
	}
	td{
	font-size:13px;
}
	tr#factors
	{
		background-color:black;
		color: white;
		font-weight: bold;
	}

	.button {
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    margin: 4px 2px;
    -webkit-transition-duration: 0.4s;
    transition-duration: 0.4s;
    cursor: pointer;
}

.td_layout 
{
	border: 0px;
}
.tr_layout
{
	border:0px;
}
.layout
{
	border:0px;
	width:100%;
}
.level
{
	background-color: #4376A8;
	color:white;
	font-weight:bold;
	text-align: center;
}
.button1 {
    color: #ffffff;
     background-color:#34495e;
	background-color:#00A6A4;
     border: 2px solid #00A6A4;
}

.button1:hover 
{
    background-color: white;
    color: black;
    border: 2px solid #00A6A4;
}
.button2 {
    color: #ffffff; 
    background-color:#1c7d44;
	background-color:#00A6A4;
   border: 2px solid #00A6A4;
}

.button2:hover 
{
    background-color: white;
    color: black;
    border: 2px solid #00A6A4;
}
.button3 {

    color: #ffffff; 
    background-color:#00A6A4;
    border: 2px solid #00A6A4;
}

.button3:hover 
{
    background-color: white;
    color: black;
    border: 2px solid #00A6A4;
}

.modal {
    display: none; 
    position: fixed; 
    z-index: 5; 
    padding-top: 100px; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.4); 
}
.field{
    font-weight: bold;
}

.modal-content {
    background-color: #fefefe;
    margin: auto;
    width: 20%;
    padding: 20px;
    border: 1px solid #888;

}
.points
{
	font-size:10px;
	font-weight:normal;
}
</style>
<script type="text/javascript" src="js/calculate.js">
</script>
<script src="node_modules/chart.js/dist/Chart.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/flat-ui.min.js"></script>
<script type="text/javascript" src="js/application.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/flat-ui.css" rel="stylesheet">
<script type="text/javascript">

	function getCookie(cname) 
	{
	    var name = cname + "=";
	    var ca = document.cookie.split(';');
	    for(var i = 0; i <ca.length; i++) {
	        var c = ca[i];
	        while (c.charAt(0)==' ') {
	            c = c.substring(1);
	        }
	        if (c.indexOf(name) == 0) {
	            return decodeURIComponent(c.substring(name.length,c.length));
	        }
	    }
	    return "NONE";
	} 
	function init() 
	{ 
	var comp = <?php echo $comp; ?>;
	var old_comp = <?php echo $old_comp; ?>;
	var flag = 0;
	chkbox = document.getElementsByTagName('input');
		for (var i = 0; i < chkbox.length; i++) 
		{
			if(chkbox[i].type == "checkbox")
			{
				if(comp[i] == '1')
				{
					chkbox[i].checked = true;
					
					flag = 1;
				}
				if (old_comp[i] == '1')
				{
					chkbox[i].checked = true;
					flag = 1;
				}
				else
				{
					chkbox[i].checked = false;
				}
			}
		}
		if(flag)
		{
			calculate();
		}
		else
		{
			old_comp = '0000000000000000000000000';
		}
		login = <?php echo $login; ?>;
		if(login)
		{
			
			old_comp = <?php if(isset($old_comp)) echo $old_comp; else echo '"'.'0000000000000000000000000'.'"'; ?>;
			comp = <?php echo $comp; ?>;
			chkbox = document.getElementsByTagName('input');
			for (var i = 0; i < chkbox.length; i++) 
			{
				if(chkbox[i].type == "checkbox")
				{
					if(comp[i] == '1')
					{
						chkbox[i].checked = true;

						flag = 1;
					}
					else if (old_comp[i] == '1')
					{
						chkbox[i].checked = true;
						flag = 1;
					}
					else
					{
						chkbox[i].checked = false;
					}

				}
			}
			submit();
		}
		create_chart();
	}

	function submit() 
	{
		
		score = calculate();
		app = <?php echo $app;?>;
		vertical = <?php echo $vertical;?>;
		old_comp = "";
		chkbox = document.getElementsByTagName('input');
			for (var i = 0; i < chkbox.length; i++) 
			{
				if(chkbox[i].type == "checkbox")
				{
					if(chkbox[i].disabled)
						old_comp+="1";
					else
						old_comp+="0";
				}
			}
			app = <?php echo $app;?>;
			vertical = <?php echo $vertical;?>;
			//Make call to push to QB
			resp = confirm("Are you sure to lock in your score?");
			if(!resp)
				return;
			var gif = document.getElementById('loading_gif');
			gif.style.display = "block";
				$.ajax({
				url: 'submit.php?app='+app+'&vertical='+vertical+'&comp='+comp+'&score='+score,
				success: function (resp) 
				{
					gif.style.display = "none";
					var modal = document.getElementById('submit_notif');

					var span = document.getElementById('submitClose');

					modal.style.display = "block";

					span.onclick = function() {
					    modal.style.display = "none";
					    window.location = 'score.php?app='+app+'&vertical='+vertical;
					}

					window.onclick = function(event) {
					    if (event.target == modal) {
					        modal.style.display = "none";
					        window.location = 'score.php?app='+app+'&vertical='+vertical;
					    }
					}

					document.getElementById("submit_status").innerHTML = resp;
				}
			});

		// }
	}

function create_chart()
{   	
        $.ajax({
                url: 'get_data.php?app='+<?php echo $app; ?>+'&vertical='+<?php echo $vertical; ?>,
		success: function(resp)
		{
			arr = JSON.parse(resp);
			console.log(arr['scores']);
			labels = arr['labels'];
			values = arr['scores'];
			 var data = {
    				labels: labels,
    				datasets: [
        			{
         	   			label: "CICD Journey",
            				fill: false,
            				lineTension: 0.1,
            				backgroundColor: "rgba(75,192,192,0.4)",
            				borderColor: "rgba(75,192,192,1)",
           				borderCapStyle: 'butt',
            				borderDash: [],
            				borderDashOffset: 0.0,
            				borderJoinStyle: 'miter',
            				pointBorderColor: "rgba(75,192,192,1)",
            				pointBackgroundColor: "#fff",
            				pointBorderWidth: 1,
            				pointHoverRadius: 5,
       					pointHoverBackgroundColor: "rgba(75,192,192,1)",
            				pointHoverBorderColor: "rgba(220,220,220,1)",
            				pointHoverBorderWidth: 2,
            				pointRadius: 1,
            				pointHitRadius: 10,
            				data: values,
            				spanGaps: false,
       		 		}
    			]
		};
        	var ctx = document.getElementById("myChart");
        	var myLineChart = new Chart(ctx, {
   			type: 'line',
    			data: data,
			options: {
        scales: {
            yAxes: [{
                ticks: {
                    max: 110,
                    min: 0,
                    stepSize: 10
                }
            }]
        }
    }
			});

		}
        });
}
</script>
<body onload="init()">
<div align="center">
<h4>
What's <?php echo "'$app_disp'";?> CICD Score? &nbsp;&nbsp<a href="dashboard.php" target="_blank"><img src="img/dashboard.gif" height="40px" width="40px" />&nbsp;&nbspLive Dashboard</a></h4>
<table>
    <colgroup>
        <col style="width:5%">
        <col style="width:19%">
        <col style="width:19%">
        <col style="width:19%">
        <col style="width:19%">
    </colgroup>
    
    <tbody>
	<tr class="level" id = "factors" >
               <th></th>
		 <th style="text-align:center;">Continuous Integration <!--<span class="points">Earn 7 points--></th>
                <th style="text-align:center;">Test Automation <!--<span class="points">Earn 6 points</span>--></th>
                <th style="text-align:center;">Continuous Delivery <!--<span class="points">Earn 6 points--></th>
	        <th style="text-align:center;">Continuous Monitoring <!--<span class="points">Earn 5 points--></th>
	</tr>
	<tr class="level">
		<th class="level"></th>
                <th style="text-align:center;font-size:15px;">Build frequently, detect defects early...</th>
                <th style="text-align:center;font-size:15px;">Business risk assessment...</th>
                <th style="text-align:center;font-size:15px;">Release frequently and reliably...</th>
                <th style="text-align:center;font-size:15px;">Without running environments, there can be no CICD...</th> 
	</tr>
	<tr>
		<td class="level">Level 4</td>
		<td>&nbsp;<input type="checkbox" value="7">&nbsp;&nbsp;Code analysis for static(Sonar) and security(Checkmarx, Contrast, RASP etc) is integrated. </td>
		<td>&nbsp;<input type="checkbox" value="6">&nbsp;&nbsp;Code coverage is part of release criteria in SonarQube</td>
		<td>&nbsp;<input type="checkbox" value="6">&nbsp;&nbsp;One click roll back is possible in production </td>
		<td>&nbsp;<input type="checkbox" value="5">&nbsp;&nbsp;Auto-recovery of environmnets possible through Self-healing model  </td>
		
	</tr>
	<tr>
		<td class="level">Level 3</td>
		<td>&nbsp;<input type="checkbox" value="5">&nbsp;&nbsp;Completely adheres to the 'Continuous delivery principles'  <a href="info.html#CD_principles" target="_blank">(Read more)</a><img src="img/left_arrow.gif" height="20px" width="20px" /> </td>
		<td>&nbsp;<input type="checkbox" value="6">&nbsp;&nbsp;90% of the existing functional test cases are integrated with  automated deployments </td>
		<td>&nbsp;<input type="checkbox" value="6">&nbsp;&nbsp;Automated DB changes as part of the same release [DB CICD] </td>
		<td>&nbsp;<input type="checkbox" value="5">&nbsp;&nbsp;Log monitoring available for both Prod and Pre-Prod apps (e.g. Splunk)</td>
	</tr>
	<tr>
		<td class="level">Level 2</td>
		<td>&nbsp;<input type="checkbox" value="7">&nbsp;&nbsp;Each commit/merge in GitHub triggers a CI build which creates deployable artifact(s) on Nexus/Artifactory/AWS S3 </td>
		<td>&nbsp;<input type="checkbox" value="6">&nbsp;&nbsp;Automated regression test suites are run during E2E testing phase </td>
		<td>&nbsp;<input type="checkbox" value="6">&nbsp;&nbsp;Automated deployments for code, configs, IaC (all envs) </td>
		<td>&nbsp;<input type="checkbox" value="5">&nbsp;&nbsp;Pre-Prod envs has monitoring and alerting. </td>
	</tr>
	<tr>
		<td class="level">Level 1</td>
		<td>&nbsp;<input type="checkbox" value="7">&nbsp;&nbsp;Standard Branching strategy is followed.  <a href="info.html#git_strategy" target="_blank">(Read more)</a>&nbsp;&nbsp;<img src="img/left_arrow.gif" height="20px" width="20px" /> </td>
		<td>&nbsp;<input type="checkbox" value="6">&nbsp;&nbsp;Functional tests are developed and integrated with existing test suites for stories in each sprint (TDD) </td>
		<td>&nbsp;<input type="checkbox" value="6" onchange=uncheck_prev(event,'deploy')>&nbsp;&nbsp;Code deployment is automated through Jenkins(IBP), INTUChef, Spinnaker, IKS-Argo </td>
		<td>&nbsp;<input type="checkbox" value="5">&nbsp;&nbsp;Functional / performance monitoring is available in <b>production</b> (e.g. AppD)</td>
	</tr>
	<tr>
		<td class="level">Level 0</td>
		<td>&nbsp;<input type="checkbox" value="0">&nbsp;&nbsp;Centralized version control for code and configs in GitHub</td>
		<td>&nbsp;<input type="checkbox" value="6">&nbsp;&nbsp;Automated unit tests exists and exercised </td>
		<td>&nbsp;<input type="checkbox" value="0">&nbsp;&nbsp;We currently do a manual code deployment</td>
	<td>&nbsp;<input type="checkbox" value="0">&nbsp;&nbsp; <b>Production</b> health monitoring is available (e.g. Sitescope)</td>
	</tr>
    </tbody>
</table>
<table class="layout">
<tr class="tr_layout" style="border:0px;">
<td style="border:0px;text-align:center;" colspan="2">
	<label  style="font-weight:bold;font-size:18px;">Badge Categories</label>
	<label >&nbsp;&nbsp;<span style="display:inline-block;height:10px;width:10px;border:1px solid;background-color:#1abc9c;"></span>&nbsp;&nbsp;Fly (Above 90)</label>
	<label >&nbsp;&nbsp;<span style="display:inline-block;height:10px;width:10px;border:1px solid;background-color:#2980b9;"></span>&nbsp;&nbsp;Advanced (70-89)</label>
	<label >&nbsp;&nbsp;<span style="display:inline-block;height:10px;width:10px;border:1px solid;background-color:#f1c40f;"></span>&nbsp;&nbsp;Skilled (45-69)</label>
	<label>&nbsp;&nbsp;<span style="display:inline-block;height:10px;width:10px;border:1px solid;background-color:#e67e22;"></span>&nbsp;&nbsp;Ready to Fly (27-44)</label>
	<label>&nbsp;&nbsp;<span style="display:inline-block;height:10px;width:10px;border:1px solid;background-color:#c0392b;"></span>&nbsp;&nbsp;Newbie (Below 27)</label>
</td>

</tr>
</table>
<div>
<div class="col-md-6 col-sm-6 col-lg-6">
<div align="center">
<input type="button" name="calculate" value="Calculate Score!"  class = "button button1" onclick="calculate()">
<input type="button" name="reset" value="Reset"  class = "button button2" onclick="reset()">
<input type="button" name="submit" value="Submit Score!"   class = "button button3" onclick="submit()">
</div>
<br>
	<div style="text-align:left;border:1px solid black;width:90%;height:90%;font-size:14px;">
		<b style="position:relative;top:2%;font-size:20px;vertical-align:top;">&nbsp;&nbsp;What these badges mean to your org?</b>
		<ul>
		<img src="medals/cyan_medal.png" height="3%" width="3%"></img>&nbsp;&nbsp;<b>Fly:</b> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;You are practicing CICD. Hi 5! </li><br>
		<img src="medals/blue_medal.png" height="3%" width="3%"></img>&nbsp;&nbsp;<b>Advanced:</b> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;Solid foundation, Started practicing CICD to a great extent</li><br>
		<img src="medals/yellow_medal.png" height="3%" width="3%"></img>&nbsp;&nbsp;<b>Skilled: </b>&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You are halfway through adopting CICD practices</li><br>
		<img src="medals/orange_medal.png" height="3%" width="3%"></img>&nbsp;&nbsp;<b>Ready to Fly: </b>&nbsp;&nbsp;Your prerequisites to get into CICD is completed</li><br>
		<img src="medals/red_medal.png" height="3%" width="3%"></img>&nbsp;&nbsp;<b>Newbie:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You have realized the need for CICD</li><br>
		</ul>
		<div><b> &nbsp;&nbsp; &nbsp;&nbsp;**</b> For more information, refer <a href="info.html" target="_blank" style="text-decoration:none;color:#16a085;font-size:17px;">here</a></div>
		<br>
		</div>
	<br>
</div>

<div class="col-md-6 col-sm-6 col-lg-6" >
	<canvas id="myChart" width="50%" height="25%" style="vertical-align:middle;"></canvas>
</div>
</div>

<div class="col-md-12 col-sm-12 col-lg-12">
<div  id="result" style="text-align:center;"></div>
<div id = 'gif-div'></div>
</div>

</div>
<div id="submit_notif" class="modal">
    <div class="modal-content">
        <span class="close" id="submitClose">x</span>
        <h4 id="submit_status"></h4>
    </div>
</div>
<div id="loading_gif" class="modal">
    <div class="modal-content">
        <img src="img/loading.gif" height="120px" width="120px">
    </div>
</div>

</body>
</html>
