<?php
echo "<a href='patcit.php'>Patento citavimas</a><br />";
echo "<a href='article.php'>Straipsnio citavimas</a><br />";
echo "<a href='book.php'>Knygos citavimas</a><br />";
echo "<a href='online.php'>Online citavimas</a><br />";
echo "<hr>";
if(($vardas=='VINCAS') || ($vardas=='ZENONAS')) {
echo "<a href='sarasas.php'>Sąrašas</a><br />";
echo "<a href='sarasas2.php?cit=p'>Patentų citavimai</a><br />";
echo "<a href='sarasas2.php?cit=a'>Straipsnių citavimai</a><br />";
echo "<a href='sarasas2.php?cit=b'>Knygų citavimai</a><br />";
echo "<a href='sarasas2.php?cit=o'>Online citavimai</a><br />";
} else {
echo "<a href='sarasas2.php?cit=p'>Mano patentų citavimai</a><br />";
echo "<a href='sarasas2.php?cit=a'>Mano straipsnių citavimai</a><br />";
echo "<a href='sarasas2.php?cit=b'>Mano knygų citavimai</a><br />";
echo "<a href='sarasas2.php?cit=o'>Mano online citavimai</a><br />";
}

echo "<br /><br /><br />";
   
echo "<span style='color:green;'>$vardas</span><br />\n";
echo "<a href='index.php'>Atsijungti</a><br />\n";

