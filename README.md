# CloudXNS-DDNS-client-php
## 简介
基于php的CloudXNS DDNS客户端  
可以看作是 [CloudXNS-DDNS-with-PowerShell](https://github.com/kkkgo/CloudXNS-DDNS-with-PowerShell) 的php版本，实现思路也是借鉴于这个项目的  
开发这个php版本是因为我使用上述脚本时[莫名报错，而且似乎还找不到原因](https://github.com/kkkgo/CloudXNS-DDNS-with-PowerShell/issues/3)  
本着“一个轮子解决不了的问题就再造个轮子来解决”的码农精神，本项目诞生了  

## 使用说明
首先需要你本地安装好php且可以执行php程序  
其次，把`CloudXNS-DDNS.php`文件搞到本地，`clone`或者`Download ZIP`都可以  
使用**记事本以外**的文本编辑器打开它，根据实际情况编辑配置项：

- 到[CloudXNS API管理](https://www.cloudxns.net/AccountManage/apimanage.html)获取自己的`api_key`和`secret_key`
- 填到文件内的第4、5行
- 在CloudXNS内添加自己需要DDNS的域名
- 将这个域名填到第6行内

执行这个php文件，不出意外的话就可以啦
你还可以用`crontab`(Linux)或`任务计划`(Windows)来实现每隔5分钟自动执行一次之类的

## 碎碎念
写完了这个项目才发现CloudXNS官方提供了PHP SDK的我真是个屑