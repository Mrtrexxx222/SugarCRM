<pre><?php
//Validation Class Example
include "validation.class.php";
$validation = new Validation();

echo "\n CHECK EMAIL ADDRESS:\n";	//check a email address
//TRUE
var_dump($validation->check_email("abc@abc.abc.com"));
var_dump($validation->check_email("abc.abc@abc.com"));
//FALSE
var_dump($validation->check_email("abc@abc..com"));

echo "\n CHECK IP ADDRESS:\n";	//check a IP address
//TRUE
var_dump($validation->check_ip("127.0.0.1"));
var_dump($validation->check_ip("255.255.255.255"));
//FALSE
var_dump($validation->check_ip("127.0.0.1.0"));
var_dump($validation->check_ip("256.0.0.1"));

echo "\n CHECK A DATE:\n";	//check a date in yy/mm/dd format
//TRUE
var_dump($validation->check_date("2010-1-20", "yyyy/mm/dd"));
var_dump($validation->check_date("1/20/10", "mm/dd/yy"));
var_dump($validation->check_date("2010-20-1", "yyyy/dd/mm"));
//FALSE
var_dump($validation->check_date("2010/2/29", "yyyy/mm/dd"));
var_dump($validation->check_date("2010/1/20", "yyyy/dd/mm"));
var_dump($validation->check_date("2010-20/1", "yyyy/dd/mm"));

echo "\n CHECK A URL:\n";	//check a URL
//TRUE
var_dump($validation->check_url("abc.com#top"));
var_dump($validation->check_url("https://abc.com:1234/abc/abc.php?a=1&b=2#"));
//FALSE
var_dump($validation->check_url("http://abc.com/abc.php??a=1"));

echo "\n CHECK A telephone number:\n";
//TRUE
var_dump($validation->check_local_phone("022874102"));
var_dump($validation->check_mobile_phone("91335604"));
//FALSE
var_dump($validation->check_local_phone("123"));
?>