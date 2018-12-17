<?php
include 'connect_to_db.php';
date_default_timezone_set('UTC');

extract($_GET);
$date = date('m y');
$mon = (int)explode(" ", $date)[0];
$yr = (int)explode(" ", $date)[1];
if($mon >= 8 && $mon <= 10)
	$q = 1;
else if ($mon >= 2 && $mon <= 4)
	$q = 3;
else if ($mon >= 5 && $mon <= 7)
	$q = 4;
else 
	$q = 2;

if($mon >=8)
	$yr +=1;

if($score >= 90)
	{
		$badge = 'Fly';
		
	}
	else if($score >=70 && $score <=89)
	{
		$badge = 'Advanced';
	}
	else if($score >=45 && $score <=69)
	{
		$badge = 'Skilled';
	}
	else if($score >=27 && $score <=44)
	{
		$badge = 'Ready to Fly';
	}
	else
	{
		$badge = 'Newbie';
	}

$check_arr =  [];
$strlen = strlen( $comp );
for( $i = 0; $i <= $strlen; $i++ ) {
    $char = substr( $comp, $i, 1 );
    if($char == "1")
    	$check_arr[] = "checked disabled";
    else
    	$check_arr[]="disabled";
}

$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "REPLACE INTO scores VALUES ('$vertical', '$app', 'FY".$yr."Q".$q."','$score','$badge','$comp')";
$conn->query($sql);
$sql_comp = "REPLACE INTO score_composition VALUES ('$vertical', '$app', '$comp')";
$conn->query($sql_comp);
$conn->close();

echo "Score successfully submitted";
exit();
//Add the below module to send emails
$tab = "
<table style='border:1px solid black;'>
    <colgroup>
        <col style='width:5%'>
        <col style='width:19%'>
        <col style='width:19%'>
        <col style='width:19%'>
        <col style='width:19%'>
    </colgroup>
    
    <tbody>
	<tr id='factors'>
                <th style='background-color: black;color:white;font-weight:bold;text-align: center;'></th>
                <th style='background-color: black;color:white;font-weight:bold;text-align: center;'>Continuous Integration</th>
                <th style='background-color: black;color:white;font-weight:bold;text-align: center;'>Test Automation</th>
                <th style='background-color: black;color:white;font-weight:bold;text-align: center;'>Continuous Deployment</th>
                <th style='background-color: black;color:white;font-weight:bold;text-align: center;'>Monitoring</th>
        </tr>
	<tr style='background-color: #4376A8;color:white;font-weight:bold;text-align: center;' >
		<th>Levels &darr;</th>
		<th style='text-align:center;'>Build frequently, detect defects early...</th>
		<th style='text-align:center;'>Business risk assessment...</th>
		<th style='text-align:center;'>Release frequently and reliably...</th>
		<!-- <th style='text-align:center;'>6</th> -->
		<th style='text-align:center;'>Without running environments, there can be no CICD...</th>
	</tr>
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
		<td>&nbsp;<input type="checkbox" value="5">&nbsp;&nbsp;Auto-recovery of environmnets through 'IHP Self-Healing' and AWS Autoscaling groups  </td>
		
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
		<td>&nbsp;<input type="checkbox" value="0">&nbsp;&nbsp;We still do a manual code deployment</td>
	<td>&nbsp;<input type="checkbox" value="0">&nbsp;&nbsp; <b>Production</b> health monitoring is available (e.g. Sitescope)</td>
	</tr>
    </tbody>
</table>

";
$user = explode("+", $_COOKIE['User'])[0];
$mail_body = "<h2>Thank You for Completing the CICD assessment for ".$app." !</h2><br>"."Hi ".$user.",<br><br>
This score will give you an idea about  how your team  is maturing in the CICD and automation practices, and  help you to form a better understanding of the beauty and benefits of CI/CD.
 <br><br>
A low score does not mean we fail, but surface areas of potential improvements , which we can progressively work on , prioritize the objectives suitably, and celebrate the outcome of  this journey together.<br><br>
<span style='font-size:16px;'>Here is your score details:</span><br><br><br>
<br><br><br>
<br>";
//echo $mail_body;
$headers = "MIME-Version: 1.0" . "\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\n";
$headers .= "From: <cicdscore@example.com>" . "\n";
$headers .= "CC: email@example.com" . "\n";
$subject = "CICD Score submission confirmation for ".$app;
$to = $_COOKIE['email'];

$message = $mail_body;
mail($to,$subject,$message,$headers);
echo "Your score has been successfully updated!";
?>
