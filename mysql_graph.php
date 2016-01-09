<?php // content="text/plain; charset=utf-8"

define('__ROOT__', dirname(dirname(__FILE__))); 
require_once ('../tools/jpgraph/src/jpgraph.php');
require_once ('../tools/jpgraph/src/jpgraph_line.php');
require_once ('../tools/jpgraph/src/jpgraph_error.php');
require_once ('../tools/jpgraph/src/jpgraph_date.php');


$dates= array();
$light = array();
$pressure = array();
$moisture = array();
$i = 0;

 
$con=mysqli_connect("66.147.244.233","wattnoti_user","physics","wattnoti_plantbot");
 //Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
 
$result = mysqli_query($con,"(SELECT * FROM sens_vals ORDER BY id DESC LIMIT 25) ORDER BY id ASC");

while($row = mysqli_fetch_array($result)) {
	$dates[$i] = strtotime($row["date"]);
	$light[$i] =  $row["Light"];
	$pressure[$i] =  $row["Pressure"];
	$moisture[$i] =  $row["Moisture"];
	$i++;
	
}


/*
$length = count($x_axis);
for ($i = 0; $i < $length; $i++) {
	echo gettype($x_axis[$i]),"<br />";
}
*/


     
 
mysqli_close($con);



$graph = new Graph(800,500);
$graph->img->SetMargin(40,40,40,40);	
$graph->img->SetAntiAliasing();
$graph->SetScale("datlin");
$graph->SetShadow();
$graph->title->Set("PlantBot Sensor Readings");
$graph->title->SetFont(FF_FONT1,FS_BOLD);
// Ensure anti-aliasing is off. If it is not, you can SetWeight() all day and nothing will change.
$graph->img->SetAntiAliasing(false);
$graph->xaxis->SetLabelAngle(45);
$graph->xaxis->scale->SetDateFormat('Y:M:d:D:H:i');
$graph->legend->SetPos(0.37,0.07,'right','center');
$graph->legend->SetFrameWeight(2);
$graph->legend->SetColor('black','black');
$graph->xgrid->Show(true,false);
// Use 20% "grace" to get slightly larger scale then min/max of
// data
$graph->yscale->SetGrace(0);
$p1 = new LinePlot($light,$dates);
$p1->SetColor("blue");
$p1->SetCenter();
$p1->SetLegend("light");


$p2 = new lineplot($pressure,$dates);
$p2->setColor("orange");
$p2->SetLegend("pressure");

$p3 = new lineplot($moisture,$dates);
$p3->setColor("yellow");
$p3->SetLegend("moisture");

$graph->Add($p1);
$graph->Add($p2);
$graph->Add($p3);

$p1->SetWeight(3);
$p2->SetWeight(3);
$p3->SetWeight(3);

$graph->Stroke();


?>