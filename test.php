<!DOCTYPE html>
<html>
<body>


<?php // content="text/plain; charset=utf-8"
 


 define('__ROOT__', dirname(dirname(__FILE__))); 
require_once ('../tools/jpgraph/src/jpgraph.php');
require_once ('../tools/jpgraph/src/jpgraph_line.php');
require_once ('../tools/jpgraph/src/jpgraph_error.php');
require_once ('../tools/jpgraph/src/jpgraph_date.php');
 
echo "hello!";
$x_axis = array();
$y_axis = array();
$i = 0;
 
$con=mysqli_connect("66.147.244.233","wattnoti_user","physics","wattnoti_plantbot");
// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
 
$result = mysqli_query($con,"SELECT * FROM sens_vals");

 
 
while($row = mysqli_fetch_array($result)) {
	$x_axis[$i] =  $row["date"];
	$y_axis[$i] =  $row["Light"];
	echo strtotime($x_axis[$i]),"<br />";
	$i++;
	
 
}


     
 
     
    mysqli_close($con);
?>

</body>
</html>