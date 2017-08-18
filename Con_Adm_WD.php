<?php

echo 
'
<div >
	<label id="automizer">URL:</label> 
</div>
';

function admgeturlx($url)
{
$init = curl_init();
curl_setopt($init,CURLOPT_URL,$url);
curl_setopt($init,CURLOPT_RETURNTRANSFER,1);
curl_setopt($init,CURLOPT_BINARYTRANSFER,true);
curl_setopt($init,CURLOPT_MAXREDIRS,0);
curl_setopt($init,CURLOPT_FOLLOWLOCATION,false);
curl_setopt($init,CURLOPT_FRESH_CONNECT,True);
curl_setopt($init,CURLOPT_FORBID_REUSE,True);
/*curl_setopt($init,CURLOPT_CONNECTTIMEOUT,40);
curl_setopt($init,CURLOPT_TIMEOUT,40);*/
if($exec = curl_exec($init))
{


$header = curl_getinfo($init);

if(preg_match("/200|300|301|302|403/",$header['http_code']))
		{
		echo "<b>Admin Page Found</b> = " , "<a href=", htmlspecialchars($url,ENT_QUOTES),">",htmlspecialchars($url,ENT_QUOTES),"</a>" , "<br />";
        flush();
		}
		else if(preg_match("/400|404/",$header['http_code']))
		{
		echo "<script type='text/javascript'>document.getElementById('automizer').innerHTML = 'Now Checking: <b>".htmlspecialchars($url,ENT_QUOTES)."</b>';</script>";
		flush();
		}
		else if(preg_match("/406|500|501|502|503/",$header['http_code']))
		{
		echo $url," Failed" , "<br />";
		}
		else
		{}

if(curl_errno($init))
{
echo 'Curl error: ' . curl_error($init) . '<br />';
}
}
$close = curl_close($init);
}

?>