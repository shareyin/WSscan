<?php

if(isset($_POST['hexsubmit']))
{
$code = $_POST['code'];
$hex = bin2hex($code);
echo "<b>Hexadecimal</b> : ","<br />";
echo "<textarea cols=100 row = 3 />";
echo "0x",$hex;
echo "</textarea>";
}

?>