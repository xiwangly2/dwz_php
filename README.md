# dwz_php
短网址生成

dwz.php

用于生成短网址（当然，如果你的域名太长了，那可能就不叫短网址了）

这个是隐性跳转的（可能更容易被举报），显性（动态）跳转暂时就不写了……

搞在数据库的我就先不写了……

懒……

格式：http\(s\)://域名\(:端口\)/dwz\.php\?url\=要生成短网址的url

①当然，如果你有时候要为了方便，可以将dwz.php重命名为index.php（根据情况，可能您还需要修改一些东西，例如$x1的值改成""，$x2的值改成"/"）。此时的url可以缩短到http\(s\)://域名\(:端口\)/字符串

你甚至还可以更改字符串的生成规则

最好提交前对要生成短网址的url进行转码，否则可能遗失get参数

对于QRSpeed词库，您可以尝试这样写（假设采用了①）：<br>
dwz (.*)|短网址 ?(.*)<br>
e:$URLEncoder %括号1%$<br>
h:$访问 http\(s\)://域名\(:端口\)/?url=%e%$<br>
短网址生成成功：\\r%h%

——本文完——
