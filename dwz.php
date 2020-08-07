<?php
/**
dwz.php
用于生成短网址（当然，如果你的域名太长了，那可能就不叫短网址了）
这个是隐性跳转的（可能更容易被举报），显性（动态）跳转暂时就不写了
如果跳转的地址带有get参数，请先将地址转码
这是搞在数据库的
懒……
格式：http(s)://域名(:端口)/dwz.php?url=要生成短网址的url
@xiwangly
数据库编码推荐utf8mb4
配置信息要改
*/
header("content-type:text/html;charset=utf-8");
//配置信息
//$host = "host(:port)";
$host = "";
$username = "";
$password = "";
$dbname = "";
$tablename = "";
//get参数
$url = $_GET["url"];
//$x1定义显示的文件夹，一般最短为根目录
$x1 = "/";
//计数的起始数字（保留短网址范围）
$number_s = "1000";
//get传入url
$url = $_GET["url"];
if(!isset($url) || $url == "")
{
	die("Error!Please visit https://github.com/xiwangly2/dwz_php/blob/master/README.md");
}
//获取端口
$port = $_SERVER["SERVER_PORT"];
//判断协议，如果要兼容非https请使用http
$head = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
//$head = "http://";
//追加开头文本，默认为空
//$prefix = "";

//分配字符串，方法①
//$sran = uniqid($prefix);

//分配更长的字符串，方法②
//$sran = uniqid($prefix,TRUE);

//创建连接
$conn = new mysqli($host,$username,$password,$dbname);
//设置编码
$sql = "DEFAULT CHARSET=utf8mb4";
$conn->query($sql);
//使用sql创建数据表
$sql = "CREATE TABLE $tablename (id INT(64) UNSIGNED AUTO_INCREMENT PRIMARY KEY,url VARCHAR(128) NOT NULL,code VARCHAR(32) NOT NULL,reg_date TIMESTAMP)";
$conn->query($sql);
$sql = "SELECT id, url, code FROM $tablename";
$conn->query($sql);
$sql = "SELECT COUNT(*) FROM {$tablename}";
$result = $conn->query($sql);
$rowss = mysqli_fetch_row($result);

//分配数字，方法③
$number = $number_s+"0"+$rowss[0];
//移量（可以带浮点数）
$number1 = $number+"1";
$sran = $number1;
$code = $sran;

$sql = "SELECT * from $tablename WHERE url=\"{$url}\"";
$result = $conn->query($sql);
$rows = mysqli_fetch_array($result);
if($rows["code"] != "")
{
	if($port == "80")
	{
		echo $head.$_SERVER["SERVER_NAME"].$x1."?".$rows["code"];
	}
	else
	{
		echo $head.$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$x1."?".$rows["code"];
	}
	die();
}
if($url != "")
{
	$sql = "SELECT * from $tablename WHERE url=\"{$url}\"";
	$result = $conn->query($sql);
	$rows = mysqli_fetch_array($result);
	if($rows["code"] != "")
	{
		$sql = "DELETE FROM $tablename WHERE url=\"{$url}\"";
		$conn->query($sql);
		$code = $code-"1";
	}
	$sql = "INSERT INTO $tablename (url,code)VALUES (\"{$url}\",\"{$code}\")";
	$conn->query($sql);
	$sql = "SELECT * from $tablename WHERE url=\"{$url}\"";
	$result = $conn->query($sql);
	$rows = mysqli_fetch_array($result);
	if($port == "80")
	{
		echo $head.$_SERVER["SERVER_NAME"].$x1."?".$rows["code"];
	}
	else
	{
		echo $head.$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$x1."?".$rows["code"];
	}
}
$conn->close();
?>