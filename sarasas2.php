<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
  
   if(@$_SESSION['auth'] != "yes")
   {
     header("Location: index.php");
     die();
   }
$vardas = $_SESSION['vardas'];
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
$cit = $_GET['cit'];

include("dbstuff.inc");
$conn = new mysqli($host,$user,$passwd,$dbname);
if ($conn->connect_error) {     die("Nepavyko prisijungti: " . $conn->connect_error);  }

 


if($cit=='p') { 
if(($vardas=='VINCAS') || ($vardas=='ZENONAS')) 
$sql = "SELECT * from citation, patcit WHERE citation.id = patcit.citation_id order by patnr";
else
$sql = "SELECT * from citation, patcit WHERE citation.id = patcit.citation_id and irase = '$vardas' order by patnr";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
 $rowcount=mysqli_num_rows($result);
echo "<h4>Patentų citavimai ($rowcount)</h4>\n";
    echo "<table><tr><th>Cit. Nr.</th><th>Pat. Nr.</th><th>Passage</th><th>Claims</th><th>Country</th><th>DocNo</th><th>Kind</th><th>Įrašė</th><th>Data</th><th></th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
	$id = $row["id"]; $patlink = "<a href='editpatcit.php?id=$id'>$id</a>"; 
	$trintilink = "<a style='color:red;text-decoration:none;' href=".'"'."javascript:confirmDelete('trinti.php?id=$id')".'"'." > <b>x</b> </a>";
        echo "<tr><td>$patlink</td><td>".$row["patnr"]."</td><td>".$row["rel_passage"]."</td><td>".$row["rel_claims"]."</td><td>".$row["country"]."</td><td>"
.$row["doc_number"]."</td><td>".$row["kind"]."</td><td>".$row["irase"]."</td><td>".$row["data"]."</td><td>$trintilink</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>Patentų citavimų nėra</p>";
}

}//if($cit=='p')





if($cit=='a') {
if(($vardas=='VINCAS') || ($vardas=='ZENONAS')) 
$sql = "SELECT * from citation, article WHERE citation.id = article.citation_id  order by patnr";
else
$sql = "SELECT * from citation, article WHERE citation.id = article.citation_id and irase = '$vardas' order by patnr";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
 $rowcount=mysqli_num_rows($result);
echo "<h4>Straipsnių citavimai ($rowcount)</h4>\n";
    echo "<table><tr><th>Cit. Nr.</th><th>Pat. Nr.</th><th>Passage</th><th>Autorius</th><th>Straipsnio pavadinimas</th><th>Leidinio pavadinimas</th><th>imprint</th><th>Įrašė</th><th>Data</th><th></th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
	$id = $row["id"]; $patlink = "<a href='editarticle.php?id=$id'>$id</a>"; 
$trintilink = "<a style='color:red;text-decoration:none;' href=".'"'."javascript:confirmDelete('trinti.php?id=$id')".'"'." > <b>x</b> </a>";
        echo "<tr><td>$patlink</td><td>".$row["patnr"]."</td><td>".$row["rel_passage"]."</td><td>".$row["autoriai"]."</td><td>".$row["atl"]."</td><td>"
.$row["sertitle"]."</td><td>".$row["imprint"]."</td><td>".$row["irase"]."</td><td>".$row["data"]."</td><td>$trintilink</td></tr>\n";
    }
    echo "</table>";
} else {
    echo "<p>Straipsnių citavimų nėra</p>";
}
}




if($cit=='b') { 
if(($vardas=='VINCAS') || ($vardas=='ZENONAS')) 
$sql = "SELECT * from citation, book WHERE citation.id = book.citation_id  order by patnr";
else
$sql = "SELECT * from citation, book WHERE citation.id = book.citation_id  and irase = '$vardas' order by patnr";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
 $rowcount=mysqli_num_rows($result);
echo "<h4>Knygų citavimai ($rowcount)</h4>\n";
    echo "<table><tr><th>Cit. Nr.</th><th>Pat. Nr.</th><th>Passage</th><th>Autorius</th><th>Knygos pavadinimas</th><th>RefNo</th><th>imprint</th><th>Įrašė</th><th>Data</th><th></th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
	$id = $row["id"]; $patlink = "<a href='editbook.php?id=$id'>$id</a>"; 
$trintilink = "<a style='color:red;text-decoration:none;' href=".'"'."javascript:confirmDelete('trinti.php?id=$id')".'"'." > <b>x</b> </a>";
        echo "<tr><td>$patlink</td><td>".$row["patnr"]."</td><td>".$row["rel_passage"]."</td><td>".$row["autoriai"]."</td><td>".$row["book_title"]."</td><td>"
.$row["refno"]."</td><td>".$row["imprint"]."</td><td>".$row["irase"]."</td><td>".$row["data"]."</td><td>$trintilink</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>Knygų citavimų nėra</p>";
    //citation_id, autoriai, book_title, imprint, refno, location
}
}


if($cit=='o') { 
if(($vardas=='VINCAS') || ($vardas=='ZENONAS'))
$sql = "SELECT * from citation, online WHERE citation.id = online.citation_id  order by patnr";
else
$sql = "SELECT * from citation, online WHERE citation.id = online.citation_id and irase = '$vardas' order by patnr";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
 $rowcount=mysqli_num_rows($result);
echo "<h4>Online citavimai ($rowcount)</h4>\n";
    echo "<table><tr><th>Cit. Nr.</th><th>Pat. Nr.</th><th>Passage</th><th>Tekstas</th><th>Įrašė</th><th>Data</th><th></th></tr>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
	$id = $row["id"]; $patlink = "<a href='editonline.php?id=$id'>$id</a>"; 
$trintilink = "<a style='color:red;text-decoration:none;' href=".'"'."javascript:confirmDelete('trinti.php?id=$id')".'"'." > <b>x</b> </a>";
        echo "<tr><td>$patlink</td><td>".$row["patnr"]."</td><td>".$row["rel_passage"]."</td><td>".$row["text"]."</td>"
."<td>".$row["irase"]."</td><td>".$row["data"]."</td><td>$trintilink</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>Online citavimų nėra</p>";
    //citation_id, autoriai, book_title, imprint, refno, location
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
 
