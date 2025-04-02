<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);
session_start();

if(!$_POST) 
if (isset($_COOKIE[session_name()])) {
  setcookie(session_name(), '', time()-86400, '/');
  }
  



$mess="";
if($_POST){
	
$vardas = trim($_POST['vardas']);	
$pass = trim($_POST['pass']);	

if(
	((strtoupper($vardas)=='ZENONAS') && ($pass=='zen491')) ||
	((strtoupper($vardas)=='VINCAS') && ($pass=='vincas654')) ||
	((strtoupper($vardas)=='ARTŪRAS') && ($pass=='art374')) ||
	((strtoupper($vardas)=='JURGITA') && ($pass=='jurg127')) ||
	((strtoupper($vardas)=='DAIVA') && ($pass=='da9234')) ||
       ((strtoupper($vardas)=='ZILVINAS') && ($pass=='zilvinas')) ||
       ((strtoupper($vardas)=='ELENA') && ($pass=='elena')) ||
((strtoupper($vardas)=='RAIMONDA') && ($pass=='raim88')) ||
	((strtoupper($vardas)=='VIDA') && ($pass=='vi57da')) 
	
	
	)
{
	$_SESSION['auth'] = "yes";
	$_SESSION['vardas']=strtoupper($vardas);
	
header("Location: patcit.php");
die();	
} else {
$mess="Neteisingas vardas arba slaptažodis";
}
}//if post

?>

<!DOCTYPE html>
<html>
<head><title>Prisijungti</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="./style/styles.css">
<link rel="shortcut icon" href="favicon.ico">
<style type="text/css"  media="screen">
</style>

<script type="text/javascript">


function clearForm(oForm)
{  
var elements = oForm.elements;

   
  oForm.reset();


  for(i=0; i<elements.length; i++) {
     
  field_type = elements[i].type.toLowerCase();
 
  switch(field_type) {
 
    case "text":
    case "textarea":
    elements[i].value = "";
      break;
       
      default:
      break;
  }
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







<br /><br />

</div> <!-- nav --> 

<div id="content">






<div style='text-align: left; font-size: small; '>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">


<div id='field_1'>
	<label for='vardas'>Vardas </label> 
	<input id='in' type="text" name="vardas" size="20" value=""   />
</div>

<div id='field'>
	<label for='pass' >Slaptažodis </label> 
	<input type="password" name="pass" size="20" value=""   />



<?php

echo  "<input type='submit' name='Teikti'  value='Prisijungti'   />";
if(strlen($mess)>4){echo "<p class='errors'> $mess </p>\n" ; }

?>
</div>
 </form>
</div>
<br />




</div> <!-- content --> 
<div id='footer'>

<?php

include("footer.inc");
?>

</div>  <!-- footer -->
</div>  <!-- container -->
<script type="text/javascript">  
   document.getElementById("in").focus();
  </script>
</body></html>
 
