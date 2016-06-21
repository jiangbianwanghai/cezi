<?php
header("Content-type:text/html;charset=utf-8");
$words = '';
if (isset($_GET['words']) && !empty($_GET['words'])) {
    $words = $_GET['words'];
}

if (!$words) {
    exit(json_encode(array('status' => false, 'error' => '请输入要测的公司名称')));
}

if(!preg_match('/^[\x{4e00}-\x{9fa5}]+$/u',$words)){
    exit(json_encode(array('status' => false, 'error' => '输入必须为中文，不支持英文和数字。')));
}

require_once('../libs/bihua.class.php');
require_once('../libs/utf8_chinese.class.php');
require_once('../resource/pizhu.php');
require_once('../libs/chnnum.class.php');

$instance = new bihua();
$chinese = new utf8_chinese;
//$res = $instance->query($words);


$pytable = unserialize(file_get_contents('../resource/pytable_with_tune.txt'));
$str_arr = utf8_str_split($words);
$pinyinRes = array('');
foreach($str_arr as $key => $char){
    $res['list'][$key]['char'] = $char;
    if(preg_match('/^[\x{4e00}-\x{9fa5}]+$/u',$char)){
        $pinyin = $pytable[$char];
        $pinyinRes[$char] = $pinyin[0];
    }
}
$pinyinRes = array_filter($pinyinRes);
$bihua_total = 0;
foreach ($res['list'] as $key => $value) {
    $res['list'][$key]['pinyin'] = $pinyinRes[$value['char']];
    $res['list'][$key]['big5'] = $chinese->gb2312_big5($value['char']);
    $res['list'][$key]['bihua'] = $bihua = get_chnnum($chinese->gb2312_big5($value['char']));
    $bihua_total += $bihua;
}
$res['bihua'] = $bihua_total;
$res['shuli'] = $res['bihua']%81;
$res['pizhu'] = $pizhu[$res['shuli']];
exit(json_encode(array('status' => true, 'content' => $res)));


function utf8_str_split($str,$split_len=1){
    if(!preg_match('/^[0-9]+$/', $split_len) || $split_len < 1){
        return FALSE;
    }
    $len = mb_strlen($str, 'UTF-8');
    if ($len <= $split_len){
        return array($str);
    }
    preg_match_all('/.{'.$split_len.'}|[^\x00]{1,'.$split_len.'}$/us', $str, $ar);
    return $ar[0];
}