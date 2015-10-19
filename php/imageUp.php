<?php
    header("Content-Type:text/html;charset=utf-8");
    error_reporting( E_ERROR | E_WARNING );
    date_default_timezone_set("Asia/chongqing");
    include "Uploader.class.php";
    include "upyun.class.php";
    include "upyun.config.php";

    //上传配置
    $config = array(
        "savePath" => "upload/" ,             //存储文件夹
        "maxSize" => 1000 ,                   //允许的文件最大尺寸，单位KB
        "allowFiles" => array( ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp" )  //允许的文件格式
    );
    //上传文件目录
    $Path = "upload/";

    //背景保存在临时目录中
    $config[ "savePath" ] = $Path;
    $up = new Uploader( "upfile" , $config );
    $type = $_REQUEST['type'];
    $callback=$_GET['callback'];

    $info = $up->getFileInfo();

    // 将文件同步存储到 UPYUN
    $upyun = new UpYun($bucketname, $username, $password);

    try {
        $uri = $info["url"];

        $opts = array(
            UpYun::CONTENT_MD5 => md5(file_get_contents($uri))
        );
    
        $fh = fopen($uri, "rb");
        $rsp = $upyun->writeFile("/" . $uri, $fh, True, $opts);
        fclose($fh);
    }
    catch(Exception $e) {
        $log_file = "log.txt";
        $log = date("Y-m-d H:m:s") . " " . $e->getCode() . " " . $e->getMessage() . "\r\n";

        $handle = fopen($log_file, "a");
        fwrite($handle, $log);
        fclose($handle);
        exit;
    }

    /**
     * 返回数据
     */
    if($callback) {
        echo '<script>'.$callback.'('.json_encode($info).')</script>';
    } else {
        echo json_encode($info);
    }
