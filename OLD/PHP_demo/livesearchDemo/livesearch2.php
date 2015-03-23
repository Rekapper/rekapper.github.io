<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php
 $xmlDoc=new DOMDocument();
 $xmlDoc->load("apollo.xml");
 // get the table in the XML document
 $table=$xmlDoc->getElementsByTagName('apollo');

 //get the q parameter from URL
 $theQuery=$_GET["myQuery"];

 //lookup all links from the xml file if length of q>0
 if (strlen($theQuery)>0) {
   $hint="";
   for($i=0; $i<($table->length); $i++) {
     $theCrew=$table->item($i)->getElementsByTagName('Crew');
	 $theFlight=$table->item($i)->getElementsByTagName('Flight');
     $link=$table->item($i)->getElementsByTagName('thelink');
     if ($theCrew->item(0)->nodeType==1) {
       //find a link matching the search text
       if (stristr($theCrew->item(0)->childNodes->item(0)->nodeValue,$theQuery)) {
         if ($hint=="") {
           $hint="<a href='" . 
           $link->item(0)->childNodes->item(0)->nodeValue . 
           "' target='_blank'>" . 
		   $theFlight->item(0)->childNodes->item(0)->nodeValue . " --- ".
           $theCrew->item(0)->childNodes->item(0)->nodeValue . "</a>";
         } else {
           $hint=$hint . "<br /><a href='" . 
           $link->item(0)->childNodes->item(0)->nodeValue . 
           "' target='_blank'>" . 
		   $theFlight->item(0)->childNodes->item(0)->nodeValue . " --- ".
           $theCrew->item(0)->childNodes->item(0)->nodeValue . "</a>";
         }
       }
     }
   }
 }

 // Set output to "no suggestion" if no hint was found
 // or to the correct values
 if ($hint=="") {
   $response="no suggestion";
 } else {
   $response=$hint;
 }

 //output the response
 echo $response;
 ?> 
</body>
</html>