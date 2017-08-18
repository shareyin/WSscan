<?php

	/*
	
	HexDorker is an Open-Source,Cross Platform PHP Script to search for websites by 
	using Google Dork and Scan them for SQL Injection Vulnerablities.  
	
	Copyright (C) 2010  Hexon

    This Program is free software: you can redistribute it and/or modify
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

$HexDorker_Version = "v1.0.1";

echo '
<title>
HexDorker ',$HexDorker_Version , ' - Dorker For All
</title>
';

echo '
<head>
<body background="Hex1.jpg"></body>

<style type="text/css">
<!--body {background-color: black}-->
<!-- body {color : gold} -->
<!--body {color : black}-->
body {color : white}
h2 {color : white}
</style>

</head>
';
	
ob_implicit_flush(true);

include("HD_Error_Check.php");

function get($url)
{
$init = curl_init();
curl_setopt($init,CURLOPT_URL,$url);
curl_setopt($init,CURLOPT_RETURNTRANSFER,1);
curl_setopt($init,CURLOPT_CONNECTTIMEOUT,40);
curl_setopt($init,CURLOPT_MAXREDIRS,0);
curl_setopt($init,CURLOPT_FOLLOWLOCATION,false);
curl_setopt($init,CURLOPT_FRESH_CONNECT,True);
curl_setopt($init,CURLOPT_FORBID_REUSE,True);
if($exec = curl_exec($init))
{
return $exec;
//echo $exec;
}
}

//error_reporting(-1);

echo 
'
<b>HexDorker</b> -- <b>Dorker For All</b>
<br />
<form action="" method="post" />
<b>Dork</b>
<br />
<input type="text" name="dork" size="127" value=inurl:".php?id=" />
<br />

<input type="submit" name="Dorksubmit" />
<br />
</form>
'
;

set_time_limit(0);

if(isset($_POST['Dorksubmit']))
{
$dork = $_POST['dork'];
$url = "http://www.google.com.my/search?hl=en&client=firefox-a&rls=org.mozilla%3Aen-US%3Aofficial&as_q=".$dork."&as_oq=&as_eq=&num=".$num."&lr=&as_filetype=&ft=i&as_sitesearch=&as_qdr=all&as_rights=&as_occt=any&cr=&as_nlo=&as_nhi=&safe=images";
//echo $url;
$num = 100;
$end = 900;
for($num;$num<=$end;$num+=100)
{
if(preg_match_all('/<li class=g><h3 class="r"><a href="(.*?)" class=l/',get($url),$match,PREG_PATTERN_ORDER))
{
/*echo count($match);*/
/*echo $match[1][8];*/
for($a=0;$a<=100;$a++)
{
if($match[1][$a] != null)
{
echo $match[1][$a],"<br />","<br />";
//$data = $match[1][$a];
Error_Check($match[1][$a]);
}
else
{}

}
}
else
{
echo "Cannot Find any Site","<br />";
}

}
}




?>
