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

$mess="";
if($_POST){
	//Į citation lentelę:
$patnr = trim($_POST['patnr']);	
if (!preg_match("/^\d\d\d\d$/", $patnr)) {$mess="<br>Įveskite teisingą patento numerį";}
$cited_phase = trim($_POST['cited-phase']);	
$cited_by = trim($_POST['cited-by']);	
$rel_passage = trim($_POST['rel-passage']);	
		//if ((strlen($rel_passage)<3)) {$mess.="<br>Reikia įrašyti rel-passage";}
$category = trim($_POST['category']);	
$rel_claims = trim($_POST['rel-claims']);	
$irase = trim($_POST['irase']);	

//Į article lentelę:
$autoriai = trim($_POST['autoriai']);
if(strlen($autoriai)<2) {$mess.="<br>Reikia nurodyti autorių (-ius)";}	
$atl = trim($_POST['atl']);	
if(strlen($atl)<2) {$mess.="<br>Reikia nurodyti straipsnio pavadinimą";}
$refno = trim($_POST['refno']);	
if (strlen($refno)>20) {$mess.="<br>Neteisingas refno";}
$sertitle = trim($_POST['sertitle']);	
if(strlen($sertitle)<2) {$mess.="<br>Reikia nurodyti periodinio leidinio pavadinimą";}
$imprint = trim($_POST['imprint']);	
if (strlen($doc_number)>40) {$mess.="<br>Neteisingas imprint";}
$pubdate = trim($_POST['pubdate']);		
if (strlen($pubdate)>20) {$mess.="<br>Neteisinga leidimo data";}
$location = trim($_POST['location']);	
$notes = trim($_POST['notes']);	


if (strlen($mess)>4) {
	//echo "<p class='errors' id='klaidos'> $mess </p>\n" ;
} else {
include("dbstuff.inc");
$cxn = mysqli_connect($host,$user,$passwd,$dbname) or die("Klaida! Nepavyko prisijungti prie duomenų bazės");

//		$aprasymas = mysqli_real_escape_string($cxn, $aprasymas);
		
$query = "INSERT INTO citation ( patnr, cited_phase, cited_by, rel_passage, category, rel_claims, irase, data) VALUES".
" ('$patnr', '$cited_phase', '$cited_by', '$rel_passage', '$category', '$rel_claims', '$vardas', NOW() )";    
$result = mysqli_query($cxn, $query) or die ("Error: ".mysqli_error($cxn));

$citation_id = mysqli_insert_id($cxn);

$query2 = "INSERT INTO article (citation_id, autoriai, atl, refno, sertitle, imprint, pubdate, notes, location) VALUES".
" ('$citation_id', '$autoriai', '$atl', '$refno', '$sertitle', '$imprint', '$pubdate', '$notes', '$location' )";    
$result = mysqli_query($cxn, $query2) or die ("Error: ".mysqli_error($cxn));


mysqli_close($cxn); 
header("Location: info.php?in=$citation_id");die();

}//jei nera klaidu
}//if post
//else  echo "<p class='errors'>  </p>\n" ;
?>


<!DOCTYPE html>
<html>
<head><title>Article</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="./style/styles.css">
<link rel="shortcut icon" href="favicon.ico">
<style type="text/css"  media="screen">
</style>

<script type="text/javascript">
 function laisvastekstas() {
var freetxt = document.getElementById('frtxt');
      if (  document.getElementById('myCheck').checked ) {
  freetxt.disabled = false; 
freetxt.focus();  
document.getElementById('atr').disabled = 'disabled';
document.getElementById('atr').value = '';
   } else {
  freetxt.disabled = 'disabled';   
 freetxt.value=''; 
document.getElementById('atr').disabled = false;
document.getElementById('atr').focus();
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

 



<br /><br />

</div> <!-- nav --> 

<div id="content">


<?php
if (strlen($mess)>4) 
	echo "<p class='errors' id='klaidos'> $mess </p>\n" ;
?>

<div style='text-align: left'>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
<fieldset>
<legend>Straipsnio citavimas</legend>
<div id="pvz">Patentas</div>
<div id='field'>
	<label for='patnr' title='Cituojančio dokumento'>Patento numeris <span style='color:red;'>*</span> </label> 
	<input id="in" type="text" name="patnr" size="50" value="<?php if(isset($_POST['patnr']))  echo $_POST['patnr']; ?>"   />
	<span style='color:LightGray;'>5603</span>
</div>
<div id="pvz">&lt;citation&gt;</div>


<div id='field2'>
<label for='cited-phase'>cited-phase  </label> 
<select name="cited-phase" id="citedphase">
                <option value=""></option>
                <option value="description" <?php if(isset($_POST['cited-phase']) && $_POST['cited-phase']=='description')  echo 'selected'; if (!$_POST) echo 'selected';?>>description</option>
                <option value="search" <?php if(isset($_POST['cited-phase']) && $_POST['cited-phase']=='search')  echo 'selected';?>>search</option>
                <option value="international-search-report" <?php if(isset($_POST['cited-phase']) && $_POST['cited-phase']=='international-search-report')  echo 'selected';?>>international-search-report</option>
                <option value="supplementary-international-search-report" <?php if(isset($_POST['cited-phase']) && $_POST['cited-phase']=='supplementary-international-search-report')  echo 'selected';?>>supplementary-international-search-report</option>
                <option value="international-type-search-report" <?php if(isset($_POST['cited-phase']) && $_POST['cited-phase']=='international-type-search-report')  echo 'selected';?>>international-type-search-report</option>
                <option value="national-search-report" <?php if(isset($_POST['cited-phase']) && $_POST['cited-phase']=='national-search-report')  echo 'selected';?>>national-search-report</option>
                <option value="supplementary-national-search-report" <?php if(isset($_POST['cited-phase']) && $_POST['cited-phase']=='supplementary-national-search-report')  echo 'selected';?>>supplementary-national-search-report</option>
                <option value="examination" <?php if(isset($_POST['cited-phase']) && $_POST['cited-phase']=='examination')  echo 'selected';?>>examination</option>
                <option value="international-examination" <?php if(isset($_POST['cited-phase']) && $_POST['cited-phase']=='international-examination')  echo 'selected';?>>international-examination</option>
                <option value="national-examination" <?php if(isset($_POST['cited-phase']) && $_POST['cited-phase']=='national-examination')  echo 'selected';?>>national-examination</option>
                <option value="opposition" <?php if(isset($_POST['cited-phase']) && $_POST['cited-phase']=='opposition')  echo 'selected';?>>opposition</option>
                <option value="limitation" <?php if(isset($_POST['cited-phase']) && $_POST['cited-phase']=='limitation')  echo 'selected';?>>limitation</option>
                <option value="other" <?php if(isset($_POST['cited-phase']) && $_POST['cited-phase']=='other')  echo 'selected';?>>other</option>
                <option value="unknown" <?php if(isset($_POST['cited-phase']) && $_POST['cited-phase']=='unknown')  echo 'selected';?>>unknown</option>
            </select>
 </div>           

<div id='field3'>
<label for='cited-by'>cited-by  </label> 
<select name="cited-by" id="citedby">
                <option value=""></option>
                <option value="applicant" <?php if(isset($_POST['cited-by']) && $_POST['cited-by']=='applicant')  echo 'selected'; if (!$_POST) echo 'selected';?>> applicant</option>
                <option value="examiner" <?php if(isset($_POST['cited-by']) && $_POST['cited-by']=='examiner')  echo 'selected';?>>examiner</option>
                <option value="opponent" <?php if(isset($_POST['cited-by']) && $_POST['cited-by']=='opponent')  echo 'selected';?>>opponent</option>
                <option value="third-party" <?php if(isset($_POST['cited-by']) && $_POST['cited-by']=='third-party')  echo 'selected';?>>third-party</option>  
                <option value="other" <?php if(isset($_POST['cited-by']) && $_POST['cited-by']=='other')  echo 'selected';?>>other</option>
                <option value="unknown" <?php if(isset($_POST['cited-by']) && $_POST['cited-by']=='unknown')  echo 'selected';?>>unknown</option>
            </select>	
</div>
<div id='field4'>
	<label for='rel-passage'>rel-passage   </label> 
	<input type="text" name="rel-passage" size="50" value="<?php if(isset($_POST['rel-passage']))  echo $_POST['rel-passage']; ?>" />
	 <span style='color:LightGray;'>pages 34,67</span>
</div>

<div id='field5'>
	<label for='category'>category</label> 
	<select name="category" id="category">
		<option value="" <?php if(isset($_POST['category']) && $_POST['category']=='')  echo 'selected'; if (!$_POST) echo 'selected';?>></option>
                <option value="X" <?php if(isset($_POST['category']) && $_POST['category']=='X')  echo 'selected'; ?>>X</option>
                <option value="Y" <?php if(isset($_POST['category']) && $_POST['category']=='Y')  echo 'selected'; ?>>Y</option>
                <option value="A" <?php if(isset($_POST['category']) && $_POST['category']=='A')  echo 'selected'; ?>>A</option>
                <option value="O" <?php if(isset($_POST['category']) && $_POST['category']=='O')  echo 'selected'; ?>>O</option>  
                <option value="P" <?php if(isset($_POST['category']) && $_POST['category']=='P')  echo 'selected'; ?>>P</option>
                <option value="T" <?php if(isset($_POST['category']) && $_POST['category']=='T')  echo 'selected'; ?>>T</option>
                <option value="E" <?php if(isset($_POST['category']) && $_POST['category']=='E')  echo 'selected'; ?>>E</option>
                <option value="D" <?php if(isset($_POST['category']) && $_POST['category']=='D')  echo 'selected'; ?>>D</option>  
                <option value="L" <?php if(isset($_POST['category']) && $_POST['category']=='L')  echo 'selected'; ?>>L</option>
                <option value="&" <?php if(isset($_POST['category']) && $_POST['category']=='&')  echo 'selected'; ?>>&</option>
            </select>	
</div>
<div id='field6'>
	<label for='rel-claims'>rel-claims  </label> 
	<input type="text" name="rel-claims" size="50" value="<?php if(isset($_POST['rel-claims']))  echo $_POST['rel-claims']; ?>"   />
	<span style='color:LightGray;'>1,2,5-7</span>
</div>
<div id="pvz">&lt;nplcit&gt;</div>
<div>
	<label for='autoriai'>Autorius <span style='color:red;'>*</span></label> 
	<input id="atr" type="text" name="autoriai" size="50" value="<?php if(isset($_POST['autoriai']))  echo $_POST['autoriai']; ?>"   />
	<span style='color:LightGray;'>K. Kieu et al</span>
</div>
<div>   <label for='atl'>Straipsnio pav. <span style='color:red;'>*</span></label> 
	<input type="text" name="atl" size="50"  value="<?php if(isset($_POST['atl']))  echo $_POST['atl']; ?>"   />	
</div>
<div>   <label for='refno'>RefNo </label> 
	<input type="text" name="refno" size="50"  value="<?php if(isset($_POST['refno']))  echo $_POST['refno']; ?>"   />	
</div>
<div>   <label for='sertitle'>Leidinio pav.<span style='color:red;'>*</span></label> 
	<input type="text" name="sertitle" size="50"  value="<?php if(isset($_POST['sertitle']))  echo $_POST['sertitle']; ?>"   />
	<span style='color:LightGray;'>Ethylene production</span>
</div>
<div>   <label for='imprint'>Imprint</label> 
	<input type="text" name="imprint" size="50"  value="<?php if(isset($_POST['imprint']))  echo $_POST['imprint']; ?>"   />
<span style='color:LightGray;'>Philadelphia, PA, US</span>	
</div>

<div>   <label for='pubdate'>Leidimo data</label> 
	<input type="text" name="pubdate" size="50"  value="<?php if(isset($_POST['pubdate']))  echo $_POST['pubdate']; ?>"   />
<span style='color:LightGray;'>pubdate</span>	
</div>
<div>   <label for='location'>Location</label> 
	<input type="text" name="location" size="50"  value="<?php if(isset($_POST['location']))  echo $_POST['location']; ?>"   />
<span style='color:LightGray;'>cituojamame leidinyje</span>	
</div>
<div>   <label for='notes'>Pastabos</label> 
	<input type="text" name="notes" size="50"  value="<?php if(isset($_POST['notes']))  echo $_POST['notes']; ?>"   />
<span style='color:LightGray;'>notes</span>	
</div>




<!--
<div id="pvz">arba vietoj &lt;nplcit&gt;	<input id="myCheck" type="checkbox" name="frtxt" value="freetext" onclick="laisvastekstas();" > (nerekomenduojama)</div>
<div>
	<label for='text'>Laisvas tekstas  </label> 
	<input id="frtxt" type="text" name="text" size="70" value="<?php if(isset($_POST['text']))  echo $_POST['text']; ?>" disabled  />
	
</div>
-->
<?php
if (($_POST) &&  (strlen($mess)<2) )
echo  "<p style='text-align: center;'><input type='submit' name='Teikti'  value='Įrašyti' disabled  />";
else
echo  "<p style='text-align: center;'><input type='submit' name='Teikti'  value='Įrašyti'  />";
echo "&nbsp;&nbsp;<a href='article.php'>Išvalyti</a></p>\n";
//echo "&nbsp;&nbsp;<input type='button' name='clear' value='Išvalyti' onclick='clearForm(this.form);' /></p>\n";

?>
<p><span style='color:red;'>*</span> &#8211; privalomi laukai.</p>
</fieldset> </form>
</div>
<br />
</div> <!-- content --> 
<div id='footer'>

<?php

include("footer.inc");
?>
<script type="text/javascript">  
   document.getElementById("in").focus();
  </script>
</div>  <!-- footer -->
</div>  <!-- container -->
</body></html>
 
