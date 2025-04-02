<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
session_start();
  
   if(@$_SESSION['auth'] != "yes")
   {
     header("Location: index.php");
     die();
   }
$vardas = $_SESSION['vardas'];

if (true){  //($vardas=="VINCAS") {

include("dbstuff.inc");

$id = $_GET['id'];
if (isset($id)&&($id>0)){
$cxn = mysqli_connect($host,$user,$passwd,$dbname)
     or die("Klaida! Nepavyko prisijungti prie duomenų bazės");

$query = "DELETE FROM article WHERE citation_id = $id"; 
$result = mysqli_query($cxn, $query) or die ("Error: ".mysqli_error($cxn));

$query = "DELETE FROM book WHERE citation_id = $id"; 
$result = mysqli_query($cxn, $query) or die ("Error: ".mysqli_error($cxn));

$query = "DELETE FROM online WHERE citation_id = $id"; 
$result = mysqli_query($cxn, $query) or die ("Error: ".mysqli_error($cxn));

$query = "DELETE FROM patcit WHERE citation_id = $id"; 
$result = mysqli_query($cxn, $query) or die ("Error: ".mysqli_error($cxn));

$query = "DELETE FROM citation WHERE id = $id"; 
$result = mysqli_query($cxn, $query) or die ("Error: ".mysqli_error($cxn));
}
mysqli_close($cxn); 
header("Location: info.php?ms=$id");die();
} else {
$mess = "<h4 style='color:red;'>Jūs neturite teisių įrašams trinti!</h4>\n";
}
?>

<!DOCTYPE html>
<html>
<head><title>Sąrašas</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="./style/styles.css">
<link rel="shortcut icon" href="favicon.ico">
<style type="text/css"  media="screen">
</style>

<script>
function confirmDelete(delUrl) {
  if (confirm("Ar tikrai ištrinti?")) {
    document.location = delUrl;
  }
}
</script>

</head>
<body>
<div id="container">
   <div id="header">
<?php
include("header.inc");
?>
</div>

<div id="nav">
<?php
include "menu.inc";
?>
</div> <!-- nav --> 
<div id="content">
<?php
echo $mess;
?>


</div> <!-- content --> 
<div id='footer'>
<?php
include("footer.inc");
?>
</div>  <!-- footer -->
</div>  <!-- container -->
</body></html>
 
