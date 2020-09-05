<?php
/**
index.php
用于短网址跳转（当然，如果你的域名太长了，那可能就不叫短网址了）
这个是隐性跳转的（可能更容易被举报），显性（动态）跳转暂时就不写了
如果跳转的地址带有get参数，请先将地址转码
这是搞在数据库的
懒……
格式：http(s)://域名(:端口)/要短网址跳转的url
@xiwangly
数据库编码推荐utf8mb4
配置信息要改
*/
header("content-type:text/html;charset=utf-8");
$code = $_SERVER["QUERY_STRING"];
if(!isset($code) || $code == "")
{
	@header("Location: ./get.html");
	die;
}
//配置信息
//$host = "host(:port)";
$host = "";
$username = "";
$password = "";
$dbname = "";
$tablename = "";
$conn = new mysqli($host,$username,$password,$dbname);
//设置编码
$sql = "DEFAULT CHARSET=utf8mb4";
$conn->query($sql);
$sql = "SELECT id, url, code FROM $tablename";
$conn->query($sql);
$sql = "SELECT * from $tablename WHERE code=\"{$code}\"";
$result = $conn->query($sql);
$rows = mysqli_fetch_array($result);
$url = $rows["url"];
$conn->close();
@header("Location: {$url}");
?>
