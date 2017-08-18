<?php

function get_url_update($url)
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
return $exec;
}
else
{
/*die("Cannot Connect to the site");*/
}


if(curl_errno($init))
{
echo 'Curl error: ' . curl_error($init) . '<br />';
}

$info = curl_getinfo($init);
echo '<br />' ."HTTP Code : " . $info['http_code'] . '<br />';
$close = curl_close($init);
}

?>