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
include("dbstuff.inc");
$conn = new mysqli($host,$user,$passwd,$dbname);
if ($conn->connect_error) {     die("Nepavyko prisijungti: " . $conn->connect_error);  }


$sql = "SELECT distinct patnr from citation order by patnr ";

$result = $conn->query($sql);
$rc=mysqli_num_rows($result);
echo "<p>Patentų sąrašas ($rc)</p>";
if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
echo  $row["patnr"], "<br>";
}
}
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
 
