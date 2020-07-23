<?php
/**
dwz.php
用于生成短网址（当然，如果你的域名太长了，那可能就不叫短网址了）
这个是隐性跳转的（可能更容易被举报），显性（动态）跳转暂时就不写了……
搞在数据库的我就先不写了……
懒……
格式：http(s)://域名(:端口)/dwz.php?url=要生成短网址的url
@xiwangly
*/
//定义编码为utf-8
header("content-type:text/html;charset=utf-8");
//$x1定义保存的子文件夹，一般最短为根目录（如果这个网站绑定在子域中，你可以放心的改成根目录）
$x1 = "";
//$x2定义显示的子文件夹，一般最短为根目录（如果这个网站绑定在子域中，你可以放心的改成根目录）
$x2 = "/";
//计数文件位置及文件名
$x3 = "number.txt";
//计数的起始数字（保留短网址范围）
$number_s = "1000";
//get传入url
$url = $_GET["url"];
//获取端口
$port = $_SERVER["SERVER_PORT"];
//追加开头文本，默认为空
$prefix = "";
$head = "http://";

//分配字符串，方法①
//$sran = uniqid($prefix);

//分配更长的字符串，方法②
//$sran = uniqid($prefix,TRUE);

//分配数字，方法③
$number = file_get_contents($x3);
if($number == "")
{
	file_put_contents($x3,$number_s);
	$number = file_get_contents($x3);
}
//移量（可以带浮点数）
$number1 = $number+"1";
$sran = $number1;
//写入计数
file_put_contents($x3,$number1);

//核心部分，通过index默认文件+Location实现跳转（避免配置伪静态，但是更耗存储空间）
$index_file = $x1.$sran."/index.php";
$text = '<?php'."\n"."header(\"Location: $url\");"."\n".'?>';
if($url == "")
{
	die("Error!Please visit https://github.com/xiwangly2/dwz_php/blob/master/README.md");
}
mkdir($x1);
mkdir($x1.$sran);
file_put_contents($index_file,$text);
//判断是否输出显示非默认端口
if($port == "80")
{
	echo $head.$_SERVER["SERVER_NAME"].$x2.$sran;
}
else
{
	echo $head.$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$x2.$sran;
}
?>