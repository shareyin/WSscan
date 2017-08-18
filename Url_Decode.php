<?php

echo '<body background="Hex1.jpg"></body>';

if(isset($_POST['urldecodesubmit']))
{
$deurl = urldecode($_POST['deurl']);
echo "<b>Url Decoded</b> :","<br />";
echo "<textarea cols=100 row = 3 />";
echo $deurl;
echo "</textarea>";
}

?>