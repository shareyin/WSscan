<?php

echo '<body background="Hex1.jpg"></body>';

if(isset($_POST['urlencodesubmit']))
{
$enurl = urlencode($_POST['enurl']);
echo "<b>Url Encoded</b> :","<br />";
echo "<textarea cols=100 row = 3 />";
echo $enurl;
echo "</textarea>";
}

?>