<?php

extract($_GET);

include 'connect_to_db.php';
$conn = new mysqli($servername, $username, $password, $dbname);

// Org buttons
$all_orgs=[];
$org_buttons = "";
$sql = "SELECT DISTINCT(organisation) FROM scores ORDER BY organisation";
$result=$conn->query($sql);
if ($result->num_rows > 0) 
{
    while($row = $result->fetch_assoc()) 
    {
        $temp_org=$row["organisation"];
        $all_orgs[] = $temp_org;
        $org_buttons .= "<div class='radio'>&nbsp;<label><input type='radio' name='org' value='$temp_org'>$temp_org</label></div>";
    }
} 

// Quarter buttons

$quarter_buttons="";
$sql = "SELECT DISTINCT(quarter) AS quarter FROM scores ORDER BY quarter DESC;";
$result=$conn->query($sql);
if ($result->num_rows > 0) 
{
    while($row = $result->fetch_assoc()) 
    {
        $temp_qrt=$row["quarter"];
        $quarter_buttons .= "<div class='radio'>&nbsp;<label><input type='radio' name='quarter' value='$temp_qrt'>$temp_qrt</label></div>";
    }
}

function get_overall_stats()
{

  global $quarter, $conn;
  $res_str="";

  $badge='Newbie';
  $sql = "select COUNT(application) as count from scores where quarter='$quarter' and badge='$badge'";
  $result=$conn->query($sql);
  $row = $result->fetch_assoc();
  $temp_count=$row['count'];
  $res_str .= "<td>$temp_count</td>";

  $badge='Ready To Fly';
  $sql = "select COUNT(application) as count from scores where quarter='$quarter' and badge='$badge'";
  $result=$conn->query($sql);
  $row = $result->fetch_assoc();
  $temp_count=$row['count'];
  $res_str .= "<td>$temp_count</td>";

  $badge='Skilled';
  $sql = "select COUNT(application) as count from scores where quarter='$quarter' and badge='$badge'";
  $result=$conn->query($sql);
  $row = $result->fetch_assoc();
  $temp_count=$row['count'];
  $res_str .= "<td>$temp_count</td>";

  $badge='Advanced';
  $sql = "select COUNT(application) as count from scores where quarter='$quarter' and badge='$badge'";
  $result=$conn->query($sql);
  $row = $result->fetch_assoc();
  $temp_count=$row['count'];
  $res_str .= "<td>$temp_count</td>";

  $badge='Fly';
  $sql = "select COUNT(application) as count from scores where quarter='$quarter' and badge='$badge'";
  $result=$conn->query($sql);
  $row = $result->fetch_assoc();
  $temp_count=$row['count'];
  $res_str .= "<td>$temp_count</td>";

  $res_str .= "</tr>";
  return $res_str;
}

$overall_table = get_overall_stats();


// Main table
function get_org_stats($org_name)
{

  global $quarter, $conn;
  $res_str="<tr><td>$org_name</td>";

  $badge='Newbie';
  $sql = "select COUNT(application) as count from scores where quarter='$quarter' and badge='$badge' and organisation='$org_name'";
  $result=$conn->query($sql);
  $row = $result->fetch_assoc();
  $temp_count=$row['count'];
  $res_str .= "<td>$temp_count</td>";

  $badge='Ready To Fly';
  $sql = "select COUNT(application) as count from scores where quarter='$quarter' and badge='$badge' and organisation='$org_name'";
  $result=$conn->query($sql);
  $row = $result->fetch_assoc();
  $temp_count=$row['count'];
  $res_str .= "<td>$temp_count</td>";

  $badge='Skilled';
  $sql = "select COUNT(application) as count from scores where quarter='$quarter' and badge='$badge' and organisation='$org_name'";
  $result=$conn->query($sql);
  $row = $result->fetch_assoc();
  $temp_count=$row['count'];
  $res_str .= "<td>$temp_count</td>";

  $badge='Advanced';
  $sql = "select COUNT(application) as count from scores where quarter='$quarter' and badge='$badge' and organisation='$org_name'";
  $result=$conn->query($sql);
  $row = $result->fetch_assoc();
  $temp_count=$row['count'];
  $res_str .= "<td>$temp_count</td>";

  $badge='Fly';
  $sql = "select COUNT(application) as count from scores where quarter='$quarter' and badge='$badge' and organisation='$org_name'";
  $result=$conn->query($sql);
  $row = $result->fetch_assoc();
  $temp_count=$row['count'];
  $res_str .= "<td>$temp_count</td>";

  $res_str .= "</tr>";
  return $res_str;
}

$main_table="";
foreach ($all_orgs as $temp_org) 
{
  $main_table .= get_org_stats($temp_org);
}


// Chart

$sql = "SELECT application,score FROM scores WHERE organisation='$org' and quarter='$quarter' ORDER BY score DESC;";
$result=$conn->query($sql);

$chart_scores=[];
$chart_labels=[];

if ($result->num_rows > 0) 
{
    while($row = $result->fetch_assoc()) 
    {
        $chart_scores[]=$row['score'];
        $chart_labels[]=$row['application'];
    }
}

$resp = array(
    "chart_labels" => $chart_labels,
    "chart_scores" => $chart_scores
    );

$myJSONString = json_encode($resp);

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="node_modules/chart.js/dist/Chart.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 1000px}
    
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
</style>

<style type="text/css">
  table.table-style-two {
    font-family: verdana, arial, sans-serif;
    font-size: 11px;
    color: #333333;
    border-width: 1px;
    border-color: #3A3A3A;
    border-collapse: collapse;
  }
 
 
   table.table-style-two th {
    border-width: 1px;
    padding: 8px;
    border-style: solid;
    border-color: #d1a792;
    background-color: #ffcccc;
  }

  table.table-style-two tr:hover td {
    background-color: #ffe8e8;
  }
 
  table.table-style-two td {
    border-width: 1px;
    padding: 8px;
    border-style: solid;
    border-color: #eacbbb;
    background-color: #ffffff;
  }

    }
  </style>
  <script type="text/javascript">
    function refresh() 
    {
        var org=$('input[name=org]:checked').val();
        var quarter=$('input[name=quarter]:checked').val();
        // alert(org+quarter);

        window.location.href="dashboard.php?org="+org+"&quarter="+quarter;
    }

    function getParameterByName(name) 
    {
      var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
      return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
    }
    function init()
    {
      var sel_org=getParameterByName("org");
      var sel_qtr=getParameterByName("quarter");
      
      if ( sel_org == null || sel_qtr == null )
      {
        sel_org = $("input:radio[name=org]:first").val();
        sel_qtr = $("input:radio[name=quarter]:first").val();
        window.location.href="dashboard.php?org="+sel_org+"&quarter="+sel_qtr;
      }
      else
      {
        $("input[name=org][value='"+sel_org+"']").prop("checked",true);
        $("input[name=quarter][value='"+sel_qtr+"']").prop("checked",true);
      }
      create_chart();

    }

    function create_chart()
    {     
            $.ajax({
                    url: 'get_data.php?app=app1&vertical=CxT',
        success: function(resp)
        {
          arr = JSON.parse('<?php echo $myJSONString; ?>');
          labels = arr['chart_labels'];
          values = arr['chart_scores'];
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
            type: 'horizontalBar',
              data: data,
          options: {
            scales: {
                xAxes: [{
                   display: true,
                   position: 'top' ,
                    ticks: {
                        max: 110,
                        min: 0,
                        stepSize: 10
                    }
                }
                ]
            }
        }
          });

        }
            });
    }
  </script>
</head>
<body onload="init();">

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-2 sidenav">

    <br><br><br>
    <h4>Badges and scores</h4><br>
    <table>
      <tr><td><img src="medals/cyan_medal.png" height="20" width="20"></img>&nbsp;<b>Fly:</b></td><td align="left" >Above 90 </td></tr>
      <tr><td><img src="medals/blue_medal.png" height="20" width="20"></img>&nbsp;<b>Advanced:</b> </td> <td align="left" > 70-89 </td></tr>

    <tr><td><img src="medals/yellow_medal.png" height="20" width="20"></img>&nbsp;<b>Skilled: </b> </td> <td align="left" > 45-69 </td></tr>

    <tr><td><img src="medals/orange_medal.png" height="20" width="20"></img>&nbsp;<b>Ready to Fly: &nbsp;</b> </td> <td align="left" > 27-44 </td> </tr>

    <tr><td><img src="medals/red_medal.png" height="20" width="20"></img>&nbsp;<b>Newbie:</b> </td> <td align="left" > Below 27 </td> </tr>
    </table>

    <br><br><br>


      <h4>Organisations</h4>
      <div class="nav nav-pills nav-stacked" style="overflow: scroll;height: 100px;">
        <?php echo $org_buttons; ?>
      </div>
      <br>
      <h4>Quarters</h4>
      <div class="nav nav-pills nav-stacked" style="overflow: scroll;height: 100px;">
        <?php echo $quarter_buttons; ?>
      </div>
      <br>

      <div class="nav nav-pills nav-stacked">
        <button type="button" class="btn btn-primary" onclick="refresh()">Submit</button>
      </div>

    </div>

    <div class="col-sm-10">
      <h1 align='center'>CICD Score Dashboard</h1>
      <!-- Overall Table -->
      <h3> Overall stats for <?php echo $quarter; ?> </h3>
      <table class="table-style-two">
        <thead>
          <tr>
            <th>Newbie</th>
            <th>Ready to Fly</th>
            <th>Skilled</th>
            <th>Advanced</th>
            <th>Fly</th>
          </tr>
        </thead>
        <tbody>
          <?php echo $overall_table; ?>
        </tbody>
      </table>

      <!-- Main Table -->
      <h3><?php echo $org; ?> org stats for <?php echo $quarter; ?> </h3>
      <table class="table-style-two" >
        <thead>
          <tr>
            <th>Organisation</th>
            <th>Newbie</th>
            <th>Ready to Fly</th>
            <th>Skilled</th>
            <th>Advanced</th>
            <th>Fly</th>
          </tr>
        </thead>
        <tbody>
          <?php echo $main_table; ?>
        </tbody>
      </table>

      <h2 align='center'>CICD Stats</h2>
      <!-- Chart -->
      <div class="col-sm-10" >
        <canvas id="myChart" style="vertical-align:middle;height: 534px; width: 1068px;"></canvas>
      </div>

    </div>
  </div>
</div>

<!-- <footer class="container-fluid">
  <p>Footer Text</p>
</footer> -->

</body>
</html>
