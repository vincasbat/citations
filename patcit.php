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
if (!preg_match("/^\d\d\d\d$/", $patnr)) {$mess.="<br>Įveskite teisingą patento numerį";}
$cited_phase = trim($_POST['cited-phase']);	
$cited_by = trim($_POST['cited-by']);	
$rel_passage = trim($_POST['rel-passage']);	
 //   if ((strlen($rel_passage)<3)) {$mess.="<br>Reikia įrašyti rel-passage";}
$category = trim($_POST['category']);	
$rel_claims = trim($_POST['rel-claims']);	
$irase = trim($_POST['irase']);	

//Į patcit lentelę:
$dnum = trim($_POST['dnum']);	
$dnum_type = trim($_POST['dnum-type']);	
if((strlen($dnum)>2) && (strlen($dnum_type)<1)) {$mess.="<br>Jei įvedėte dnum, reikia įvesti ir dnum-type";}

$url = trim($_POST['url']);	
if ((strlen($url)>1)&& (!preg_match("/^http.*/", $url))) {$mess.="<br>Neteisingas url";}

$country = trim($_POST['country']);	
if (!preg_match("/\D\D/", $country)) {$mess.="<br>Įveskite teisingą šalies kodą";}

$doc_number = trim($_POST['doc-number']);	
if (strlen($doc_number)<4) {$mess.="<br>Įveskite teisingą dokumento numerį";}

$kind = trim($_POST['kind']);		
if ((strlen($kind)>0)&& (strlen($kind)>2)) {$mess.="<br>Neteisingai nurodyta dokumento rūšis (kind)";}
$date = trim($_POST['date']);	
if ((strlen($date)>0)&& (!preg_match("/^\d\d\d\d\d\d\d\d$/", $date))) {$mess.="<br>Neteisinga data";}
$name = trim($_POST['name']);	
$lang = trim($_POST['lang']);	
if ((strlen($lang)>0)&& (!preg_match("/^\D\D$/", $lang))) {$mess.="<br>Neteisingai nurodyta kalba (lang)";}


	

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

$query2 = "INSERT INTO patcit (citation_id, dnum, dnum_type, url, country, doc_number, kind, date, name, lang) VALUES".
" ('$citation_id', '$dnum','$dnum_type', '$url', '$country', '$doc_number', '$kind', '$date', '$name', '$lang' )";    
$result = mysqli_query($cxn, $query2) or die ("Error: ".mysqli_error($cxn));


mysqli_close($cxn); 
header("Location: info.php?in=$citation_id");die();  //į bendrą sarašą

}//jei nera klaidu
}//if post
//else  echo "<p class='errors'>  </p>\n" ;
?>

<!DOCTYPE html>
<html>
<head><title>Patento citavimas</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="./style/styles.css">
<link rel="shortcut icon" href="favicon.ico">
<style type="text/css"  media="screen">
</style>

<script type="text/javascript">

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
if (strlen($mess)>4)      echo "<p class='errors' id='klaidos'> $mess </p>\n" ;
?>
<div style='text-align: left'>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
<fieldset>
<legend>Patento citavimas</legend>
<div id="pvz">Patentas</div>
<div id='field'>
	<label for='patnr' title='Cituojančio dokumento'>Patento numeris <span style='color:red;'>*</span> </label> 
	<input id="in" type="text" name="patnr" size="50" value="<?php if(isset($_POST['patnr']))  echo $_POST['patnr']; ?>"   />
	<span style='color:LightGray;'>5603</span>
</div>
<div id="pvz">&lt;citation&gt;</div>

<!--cited-phase ( 	description | search | international-search-report | 
          						supplementary-international-search-report | 
          						international-type-search-report | national-search-report |  
          						supplementary-national-search-report | 
          						examination | international-examination | 
          						national-examination | opposition | limitation |
          						other | unknown)  #IMPLIED
 cited-by (	applicant | examiner | opponent | third-party | other | unknown) #IMPLIED
          						-->

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
	<label for='rel-passage'>rel-passage</label> 
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
<div id="pvz">&lt;patcit&gt;</div>
<div id='field7'>
	<label for='dnum'>dnum  </label> 
	<input type="text" name="dnum" size="50" value="<?php if(isset($_POST['dnum']))  echo $_POST['dnum']; ?>"   />
	<span style='color:LightGray;'>LT6001B</span>
</div>
<div id='field7a'>
	<label for='dnum-type'>dnum-type  </label> 
	<select name="dnum-type" id="dnumtype">
                <option value="" <?php if(isset($_POST['dnum-type']) && $_POST['dnum-type']=='')  echo 'selected'; if (!$_POST) echo 'selected';?>></option>
                <option value="appno" <?php if(isset($_POST['dnum-type']) && $_POST['dnum-type']=='appno')  echo 'selected'; ?>>appno</option>
                <option value="pubno" <?php if(isset($_POST['dnum-type']) && $_POST['dnum-type']=='pubno')  echo 'selected'; ?>>pubno</option>
            </select>
</div>
<div id='field8'>
	<label for='url'>url  </label> 
	<input type="text" name="url" size="50" value="<?php if(isset($_POST['url']))  echo $_POST['url']; ?>"   />
	<span style='color:LightGray;'>http://www...</span>
</div>
<div id='field9'>
	<label for='country'>country  <span style='color:red;'>*</span></label> 
	<input type="text" name="country" size="50" value="<?php if(isset($_POST['country']))  echo $_POST['country']; ?>"   /> 
	<span style='color:LightGray;'>LT</span>
</div>
<div id='field10'>
	<label for='doc-number'>doc-number  <span style='color:red;'>*</span></label> 
	<input type="text" name="doc-number" size="50" value="<?php if(isset($_POST['doc-number']))  echo $_POST['doc-number']; ?>"   /> 
	<span style='color:LightGray;'>6001</span>
</div>
<div id='field11'>
	<label for='kind'>kind</label> 
	<input type="text" name="kind" size="50" value="<?php if(isset($_POST['kind']))  echo $_POST['kind']; ?>"   /> 
	<span style='color:LightGray;'>B</span>
</div>
<div id='field12'>
	<label for='date'>date</label> 
	<input type="text" name="date" size="50" value="<?php if(isset($_POST['date']))  echo $_POST['date']; ?>"   /> 
	<span style='color:LightGray;'>YYYYMMDD</span>
</div>
<div id='field13'>
	<label for='name'>name</label> 
	<input type="text" name="name" size="50" value="<?php if(isset($_POST['name']))  echo $_POST['name']; ?>"   /> 
</div>
<div id='field14'>
	<label for='lang'>lang</label> 
	<input type="text" name="lang" size="50" value="<?php if(isset($_POST['lang']))  echo $_POST['lang']; ?>"   />
	<span style='color:LightGray;'>lt</span>
</div>


<?php
if (($_POST) &&  (strlen($mess)<2) )
echo  "<p style='text-align: center;'><input type='submit' name='Teikti'  value='Įrašyti' disabled  />";
else
echo  "<p style='text-align: center;'><input type='submit' name='Teikti'  value='Įrašyti'  />";
echo "&nbsp;&nbsp;<a href='patcit.php'>Išvalyti</a></p>\n";
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
 
