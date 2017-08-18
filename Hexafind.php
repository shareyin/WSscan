<?php

/*

	Hexafind is a script to find Admin Pages in a site.
	
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
	
$Hexafind_Version = "v1.0.1";

echo 
'
<title>
Hexafind -- Admin Page Finder 
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
	
if(isset($_POST['admsubmit']))
{
include("Con_Adm_WD.php");
$url = $_POST['url'];

$test = file_get_contents("Admin.txt");

$split = preg_split("/[\s,]+/",$test); 



foreach($split as $adp)
{
	if(preg_match("/!h3xtension!/",$adp))
		{
		
		$code = array(1=>"php",2=>"asp",3=>"aspx",4=>"jsp",5=>"cfm");
		for($start=1;$start<=5;$start++)
		{
		$admin = str_replace("!h3xtension!",$code[$start],$adp);
		
		$adminpage = $url.$admin;
	
		$admpg = admgeturlx($adminpage);
		
		
		}
		}
	else
	{
    $adminpage = $url.$adp;

	$admpg = admgeturlx($adminpage);
	
	
    }
}

	
echo "<br \>","Hexafind Search Finished";


}
//}

?>