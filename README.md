# dwz_php
短网址生成

dwz.php<br>index.php

分支的标题mysql_8.7后面的8.7指代的是8月7日发布的代码版本，并非mysql版本，可能导致歧义，特此说明

用于生成短网址（当然，如果你的域名太长了，那可能就不叫短网址了）

这个数据库版的可以解决一个url生成重复推荐生成多个短网址的问题

这个是隐跳转的（可能更容易被举报，一般历史记录不会保存短链接），显（动态）跳转暂时就不写了……

这个有一个很显著的优点就是<b>不用配置伪静态</b>，直接作为API使用……

这是搞在数据库的，需要在dwz.php和index.php正确填写数据库信息，目前仅支持MySQL数据库，测试使用的MySQL版本是5.7，PHP版本需要大于7.0

懒……

格式：http\(s\)://域名\(:端口\)/dwz\.php\?url\=要生成短网址的url

......你还可以更改字符串的生成规则

最好提交前对要生成短网址的url进行转码，否则可能遗失get参数

对于QRSpeed词库，您可以尝试这样写（假设采用了①）：<br>
dwz (.*)|短网址 ?(.*)<br>
e:$URLEncoder %括号1%$<br>
h:$访问 http\(s\)://域名\(:端口\)/?url=%e%$<br>
短网址生成成功：\\r%h%

7.23更新(见分支)：增加了纯数字短网址，现有3种生成算法，我并不希望使用可能重复的算法，因此md5那类的算法就不用提了<br>
8.7更新（当前位置）：增加了数据库版的短网址，规则略有不同，见对应的markdown文档及文件内说明
——本文完——
