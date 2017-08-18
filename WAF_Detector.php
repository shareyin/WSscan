<?php

/*

	Wafdetector is a script to detect WAF on websites by analysing http request.
	
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

$WAF_Detector_Version = "v1.0.2";


function wafdetect($injurlx)
{
if($header = get_headers($injurlx,1))
{
if(preg_match("/200/",$header[0]))
{
}
elseif(preg_match("/300|301|302|400|401|403|406|500|501|502|503/",$header[0],$wafdetected))
{
if(preg_match("/300|301|302/",$wafdetected[0]))
{
echo "Redirection Mode Detected","<br \>";
}
if(preg_match("/404/",$wafdetected[0]))
{
echo "File does not exist","<br \>";
}
elseif(preg_match("/400|401|403|406/",$wafdetected[0]))
{
echo "WAF Detected","<br \>";
}
elseif(preg_match("/500/",$wafdetected[0]))
{
echo "WAF - Mod_Security Detected","<br \>";
}
elseif(preg_match("/501|502|503/",$wafdetected[0]))
{
echo "WAF Detected","<br \>";
}

}

}
else
{
echo "Get_Headers() is not supported","<br />";
}

}

?>