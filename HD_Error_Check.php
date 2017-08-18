<?php

/*

Error Based SQL Injection Check

*/

function Error_Check($urlerr)
{
$mysql=array('/You have an error in your SQL/',
'/Division by zero in/',
'/supplied argument is not a valid MySQL result resource in/',
'/Incorrect syntax near/',
'/Error  Invalid Input Detected /',
'/You have an error in your SQL syntax /',
'/supplied argument is not a valid MySQL result resource in /',
'/Warning mysql_fetch_array /',

'/MySQL Error 1064 /' ,
'/Warning: mysql_numrows /' ,
'/supplied argument is not a valid MySQL result resource in / ', 
'/mysql_fetch_row/ ',
'/Mysql Error/',
'/ncorrect syntax near/',
'/Error  Invalid Input Detected /',
'/Could not successfully run query /',
'/Warning supplied argument is not a valid MySQL result/'

);

$mssql=array(
'/Call to a member function/',
'/Microsoft JET Database/',
'/Microsoft OLE DB Provider for SQL Server/',
'/Unclosed quotation mark/',
'/[Macromedia][SQLServer JDBC Driver][SQLServer]Incorrect/',
'/Microsoft OLE DB Provider for SQL Server/',
'/Microsoft ODBC Microsoft Access Driver/',
'/Microsoft OLE DB Provider for ODBC Drivers.[Microsoft][ODBC SQL Server Driver]/',



);
$informix=array(
"/Informix Informix ODBC Driver Informix/",
"/Character host variable is too short for the data. in FETCH/",
'/SQL statement error /',

);
$DB2=array(
"/SQL error: SQLCODE: -803, SQLSTATE: 23505/"

);
$ingres=array(
"/SELECT statement cannot be a target of this command/"
);
$oracle=array(
'/Microsoft OLE DB Provider for Oracle/',
'/Warning: oci_execute():/',
'/Warning: ociparse():/',
'/Warning: ocifetch():/',
'/Warning: ocifreestatement()/',
'/Warning: ociexecute():/',
'/Warning: ocilogon():/',
'/Warning: ocifetchinto():/',
'/Warning: oci_statement_type():/',
'/Warning: odbc_num_fields():/',
'/Warning: odbc_free_result():/',
'/Warning: odbc_fetch_row():/',
'/Warning: odbc_exec():/',
"/Microsoft OLE DB Provider for Oracle error '80040e14' /",
'/ORA-00933: SQL command not properly ended /',
"/OraOLEDB error '80004005'/" 
);
$postgresql=array(
"/pg_exec() [function.pg exec]:/",
"/Query failed: ERROR: invalid input syntax for integer: /"
);
$msaccess=array(
'/ODBC Microsoft Access Driver/',
'/Microsoft OLE DB Provider for [ODBC Drivers Microsoft] [ODBC Access Driver]/',
'/Microsoft JET Database Engine/',
'/[Microsoft][ODBC Microsoft Access Driver] Syntax error in FROM clause./' 
);

echo "<b>SQL Injection Vulnerability Detection</b>","<br />";

$error = array("","1337",'"omghexjectorishere',"%20and%201337=1337","'%20and%20'hexon'='hexjector","'%20and%20'hexon'='hexon","%20and%201337=31337");
for($err=0;$err<7;$err++)
{
$urlerror = $url2 . $error[$err];
//echo $urlerror , "<br />";
/*echo htmlspecialchars($urlerror,ENT_QUOTES) , "<br />";*/
$init = curl_init();
curl_setopt($init,CURLOPT_URL,$urlerror);
curl_setopt($init,CURLOPT_FRESH_CONNECT,True);
curl_setopt($init,CURLOPT_FORBID_REUSE,True);
curl_setopt($init,CURLOPT_RETURNTRANSFER,1);
if($exec = curl_exec($init))
{
if($err==0)
{
$data = curl_getinfo($init);
$http0 = $data["size_download"];
//echo "http0 = ",$http0,"<br />";
}

if($err==1)
{
$info = curl_getinfo($init);
$http1 = $info["size_download"];
//echo "http1 = ",$http1,"<br />";
}

if($err==2)
{
$info = curl_getinfo($init);
$http2 = $info["size_download"];
//echo "http2 = ",$http2,"<br />";
}

if($err==3)
{
$info = curl_getinfo($init);
$http3 = $info["size_download"];
//echo "http3 = ",$http3,"<br />";
if($http3==$http0)
{
$num_sqlt = true;
//echo "numsqlt = true","<br />";
}
else
{
$num_sqlt = false;
}
}
if($err==4)
{
$info = curl_getinfo($init);
$http4 = $info["size_download"];
//echo "http4 = ",$http4,"<br />";
if($http4 == $http1 or $http4 == $http2)
{
$str_sqli_f = true;
}
else
{
$str_sqli_f = false;
}
}
if($err==5)
{
$info = curl_getinfo($init);
$http5 = $info["size_download"];
//echo "http5 = ",$http5,"<br />";
if($http5 == $http0)
{
$str_sqli_t = true;
}
else
{
$str_sqli = false;
}
if($err==6)
{
$info = curl_getinfo($init);
$http6 = $info["size_download"];
//echo "http6 = ",$http6, "<br />";
if($http6 == $http1 or $http6 ==  $http2)
{
$num_sqlf = true;
}
else
{
$num_sqlf = false;
}
}
// Cannot echo or return
}
else if(!$exec)
{}
/*else
{
echo "Connection to site Failed2","<br />";
$str_sqli = false;
}*/
curl_close($init);
}
}
//echo "str_sqli_f = ",$str_sqli_f;
//echo "str_sqli_t = ",$str_sqli_t;
if($str_sqli_f == true && $str_sqli_t == true)
{
$str_sqli = true;
}
else if($num_sqlf == true && $num_sqlt == true)
{}
else
{}

$urlerror2 = $urlerr."'[]";
$init = curl_init();
curl_setopt($init,CURLOPT_URL,$urlerror2);
curl_setopt($init,CURLOPT_FRESH_CONNECT,True);
curl_setopt($init,CURLOPT_FORBID_REUSE,True);
curl_setopt($init,CURLOPT_RETURNTRANSFER,1);
if($exec = curl_exec($init))
{
return $exec;

foreach($mysql as $merr)
{
if(preg_match($merr,$exec,$mysqlstr))
{
echo "<b>Error String Detection</b> = < " .$merr. " >" . '<br \>';
echo "<b>Vulnerability Detection</b> = < Mysql Injection Vulnerable >".'<br \>';
$mysqli = true;
/*echo $mysqli;*/
if($mysqlstr==null)
{
$mysqlv=false;
}
else
{
}

}

else 
{

}
}
foreach($mssql as $merr)
{
if(preg_match($merr,$exec,$mssqlstr))
{
echo "<b>Error String Detection</b> = < " .$merr. " >" . '<br \>';
echo "<b>Vulnerability Detection</b> = < Mssql Injection Vulnerable >".'<br \>';
$mssqlv=true;
if($mssqlstr=null)
{
$mssqlv=false;
}
else
{
$mssqlv=true;
print_r($mssqlstr);
}
}

else 
{

}
}
foreach($informix as $merr)
{
if(preg_match($merr,$exec,$informixstr))
{
echo "<b>Error String Detection</b> = < " .$merr. " >" . '<br \>';
echo "<b>Vulnerability Detection</b> = < Informix Database Injection Vulnerable >".'<br \>';
if($informixstr=null)
{
$informixv=false;
}
else
{
$informixv=true;
print_r($informixstr);
}
}

else 
{

}
}
foreach($DB2 as $merr)
{
if(preg_match($merr,$exec,$DB2str))
{
echo "<b>Error String Detection</b> = < " .$merr. " >" . '<br \>';
echo "<b>Vulnerability Detection</b> = < DB2 Injection Vulnerable >".'<br \>';
if($DB2str=null)
{
$DB2v=false;
}
else
{
$DB2v=true;
print_r($DB2str);
}
}

else 
{

}
}
foreach($oracle as $merr)
{
if(preg_match($merr,$exec,$oraclestr))
{
echo "<b>Error String Detection</b> = < " .$merr. " >" . '<br \>';
echo "<b>Vulnerability Detection</b> = < Oracle SQL Injection Vulnerable >".'<br \>';
if($oracle=null)
{
$oraclev=false;
}
else
{
$oraclev=true;
print_r($oraclestr);
}
}

else 
{

}
}

foreach($postgresql as $merr)
{
if(preg_match($merr,$exec,$postgresqlstr))
{
echo "<b>Error String Detection</b> = < " .$merr. " >" . '<br \>';
echo "<b>Vulnerability Detection</b> = < Postgresql Injection Vulnerable >".'<br \>';
if($postgresqlstr=null)
{
$postgresqlv=false;
}
else
{
$postgresqlv=true;
print_r($postgresqlstr);
}
}

else 
{

}
}

foreach($msaccess as $merr)
{
if(preg_match($merr,$exec,$msaccessstr))
{
echo "<b>Error String Detection</b> = < " .$merr. " >" . '<br \>';
echo "<b>Vulnerability Detection</b> = < MsAccess SQL Injection Vulnerable >".'<br \>';
if($msaccessstr=null)
{
$msaccessv=false;
}
else
{
$msaccessv = true;
print_r($msaccessstr);
}
}

else 
{

}
}

/*

Blind Detection Section


*/
}

}










?>
