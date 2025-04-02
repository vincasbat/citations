<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
session_start();
  
   if(@$_SESSION['auth'] != "yes")
   {
     header("Location: index.php");
     die();
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
$vardas = $_SESSION['vardas'];
?>

</div>

<div id="nav">
<?php

include("menu.inc");
?>

</div> <!-- nav --> 
<div id="content">
<?php
$ms = $_GET['ms'];
$ed = $_GET['ed'];
$in = $_GET['in'];
if(is_numeric($ms)) echo "<p style='color:green;background-color:lightgreen;'>$ms citavimas ištrintas</p>";
if(is_numeric($ed)) echo "<p style='color:green;background-color:lightgreen;'>$ed citavimas pataisytas</p>";
if(is_numeric($in)) echo "<p style='color:green;background-color:lightgreen;'>$in citavimas įrašytas</p>";

?>
</div> <!-- content --> 
<div id='footer'>
<?php
include("footer.inc");
$conn->close();
?>
</div>  <!-- footer -->
</div>  <!-- container -->
</body></html>
 
