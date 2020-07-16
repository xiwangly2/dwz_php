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
$x1 = "./dwz/";
//$x2定义显示的子文件夹，一般最短为根目录（如果这个网站绑定在子域中，你可以放心的改成根目录）
$x2 = "/dwz/";
//get传入url
$url = $_GET["url"];
//非默认端口$is_port请填true
$is_port = "false";
//追加开头文本，默认为空
$prefix = "";
$head = "http://";
//分配随机字符串
$sran = uniqid($prefix);
//分配更长的随机字符串
//$sran = uniqid($prefix,TRUE);
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
//判断是否输出显示非默认端口，取决于$is_port
if($is_port == "true")
{
	echo $head.$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$x2.$sran;
}
else
{
	echo $head.$_SERVER["SERVER_NAME"].$x2.$sran;
}
?>
