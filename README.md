### umeditor 集成 UPYUN 标准 API

基于 [umeditor 1.2.2 PHP 版](http://ueditor.baidu.com/)和 [UPYUN PHP 标准 SDK](https://github.com/upyun/php-sdk) 开发。

#### 功能

1. “图片－本地上传”同时上传到 UPYUN
2. 支持 log 记录

#### 使用

下载后解压

修改文件 `php/upyun.config.sample.php` 为 `php/upyun.config.php`，并配置：

```
<?php
$bucketname = '';   // 空间名
$username = '';     // 操作员账号
$password = '';     // 操作员密码
```

修改文件 `umeditor.config.sample.js` 为 `umeditor.config.js`，并配置：

```
var DOMAIN = ""; // UPYUN 域名配置，默认域名，如：http://空间名.b0.upaiyun.com/ 或绑定域名，如：http://xxxx.xxxx.xxxx/
```

说明：上传到 UPYUN 失败，可以查看 `php/log.txt` 文件里的详细错误信息。
