<?php
header("Content-type:text/html;charset=utf-8");
require_once('../libs/bihua.class.php');
$instance = new bihua();
$queryStr = '广州市一点通人才培训有限公司<br>';
echo $queryStr;
$res = $instance->query($queryStr);
print_r($res);