<?php

function geturl($url)
{
$init = curl_init($url);
curl_setopt($init,CURLOPT_HEADER,TRUE);
curl_setopt($init,CURLOPT_BINARYTRANSFER,true);
curl_setopt($init,CURLOPT_CONNECTTIMEOUT,40);
curl_setopt($init,CURLOPT_TIMEOUT,40);
curl_setopt($init,CURLOPT_MAXREDIRS,0);
curl_setopt($init,CURLOPT_FOLLOWLOCATION,false);
curl_setopt($init,CURLOPT_RETURNTRANSFER,1);
curl_setopt($init,CURLOPT_FRESH_CONNECT,True);
curl_setopt($init,CURLOPT_FORBID_REUSE,True);
if($exec = curl_exec($init))
{
return $exec;

$header = curl_getinfo($init);

if(preg_match("/300|301|302/",$header['http_code']))
{
echo "Redirection Mode Detected","<br />";
}
else if(preg_match("/404/",$header['http_code']))
{
die("File Does Not Exist");
}
else if(preg_match("/400|402|403|406/",$header['http_code']))
{
echo "WAF Detected ","<br />";
}
else if(preg_match("/500|501|502|503/",$header['http_code']))
{
echo "WAF Detected ","<br />";
}
}
else
{
echo "Failed to connect to the site.";
}
if(curl_errno($init))
{
echo 'Curl error: ' . curl_error($init) . '<br />';
}

$close = curl_close($init);
}
?>