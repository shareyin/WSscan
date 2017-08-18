<?php



function geturlx($url)
{
$init = curl_init();
curl_setopt($init,CURLOPT_URL,$url);
curl_setopt($init,CURLOPT_RETURNTRANSFER,1);
curl_setopt($init,CURLOPT_BINARYTRANSFER,true);
curl_setopt($init,CURLOPT_FOLLOWLOCATION,false);
curl_setopt($init,CURLOPT_MAXREDIRS,0);
curl_setopt($init,CURLOPT_CONNECTTIMEOUT,40);
curl_setopt($init,CURLOPT_TIMEOUT,40);
curl_setopt($init,CURLOPT_FRESH_CONNECT,True);
curl_setopt($init,CURLOPT_FORBID_REUSE,True);
if($exec = curl_exec($init))
{
echo "<b>Server Information</b> : " , "<br />";

if($header = get_headers($url,1))
{
echo "<textarea rows=5 cols = 70>";
foreach($header as $head)
{
echo htmlspecialchars($head,ENT_QUOTES) , "\n";
}
/*if(function_exists('apache_request_headers()')!=true)
{/*
if($headers = apache_request_headers())
{
foreach ($headers as $header => $value) 
{
echo $header,":",htmlspecialchars($value,ENT_QUOTES),"\n";
}*/

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
/**/
else
{
}/**/
echo "</textarea>";
if(preg_match("/404/",$header[0]))
{
exit("Connection to site Failed");
}
else
{}

/*else
{*/
/*if(function_exists('apache_request_headers()')==true)
{
if($headers = apache_request_headers())
{
echo "<textarea rows=5 cols = 70>";
foreach ($headers as $header => $value) 
{
echo $header,":",htmlspecialchars($value,ENT_QUOTES),"\n";
}
echo "</textarea>";
}
}
else
{
}*/
/*}*/

if(curl_errno($init))
{
echo "Curl error: " , curl_error($init) , "<br />";
}

$close = curl_close($init);
}
}

?>