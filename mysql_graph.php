<?php // content="text/plain; charset=utf-8"

define('__ROOT__', dirname(dirname(__FILE__))); 
require_once ('../tools/jpgraph/src/jpgraph.php');
require_once ('../tools/jpgraph/src/jpgraph_line.php');
require_once ('../tools/jpgraph/src/jpgraph_error.php');
require_once ('../tools/jpgraph/src/jpgraph_date.php');


$x_axis = array();
$y_axis = array();
$i = 0;

 
$con=mysqli_connect("66.147.244.233","wattnoti_user","physics","wattnoti_plantbot");
 //Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
 
$result = mysqli_query($con,"(SELECT * FROM sens_vals ORDER BY id DESC LIMIT 25) ORDER BY id ASC");

 
 
while($row = mysqli_fetch_array($result)) {
	$x_axis[$i] = strtotime($row["date"]);
	//echo gettype($x_axis[$i]),"<br />";
	$y_axis[$i] =  $row["Light"];
	//echo strtotime($x_axis[$i]),"<br />";
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
$graph->title->Set("Example of line centered plot");
$graph->xaxis->SetLabelAngle(45);
$graph->title->SetFont(FF_FONT1,FS_BOLD);


// Use 20% "grace" to get slightly larger scale then min/max of
// data
$graph->yscale->SetGrace(0);


$p1 = new LinePlot($y_axis,$x_axis);
$p1->mark->SetType(MARK_FILLEDCIRCLE);
$p1->mark->SetFillColor("red");
$p1->mark->SetWidth(4);
$p1->SetColor("blue");
$p1->SetCenter();
$graph->Add($p1);

$graph->Stroke();

?>