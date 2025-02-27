<?php

function LogData($base_url)
{
    writeLogBackend($base_url,date('Y-m-d H:i:s'),get_client_ip(),cekMobile(),(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
}

function get_client_ip() {
  $ipaddress = '';
  if (isset($_SERVER['HTTP_CLIENT_IP']))
      $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
  else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
      $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
  else if(isset($_SERVER['HTTP_X_FORWARDED']))
      $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
  else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
      $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
  else if(isset($_SERVER['HTTP_FORWARDED']))
      $ipaddress = $_SERVER['HTTP_FORWARDED'];
  else if(isset($_SERVER['REMOTE_ADDR']))
      $ipaddress = $_SERVER['REMOTE_ADDR'];
  else
      $ipaddress = 'UNKNOWN';
  return $ipaddress;
}

function writeLogBackend($base_url,$date,$ip,$computer,$url)
{
    $pecahIp = explode(",",$ip);
    if(isset($pecahIp[0])){
        $ipFInal = $pecahIp[0];
    }
    else{
        $ipFInal =  $ip;
    }
    $text = $date.'|'.gethostbyaddr($ipFInal).'|'.$computer.'|'.Auth::id().'|'.$url;
    if(!file_exists($base_url.'storage/logs/backend/'.date('Y')))
    {
        mkdir($base_url.'storage/logs/backend/'.date('Y'), 0777, true);
        chmod($base_url.'storage/logs/backend/'.date('Y'),0777);

        mkdir($base_url.'storage/logs/backend/'.date('Y').'/'.date('m'), 0777, true);
        chmod($base_url.'storage/logs/backend/'.date('Y').'/'.date('m'),0777);

        $fp = fopen($base_url.'storage/logs/backend/'.date('Y').'/'.date('m')."/".date('d').".txt","wb");
        fwrite($fp,$text);
        fclose($fp);
        chmod($base_url.'storage/logs/backend/'.date('Y').'/'.date('m').'/'.date('d').'.txt',0777);
    }
    else
    {
        if(!file_exists($base_url.'storage/logs/backend/'.date('Y').'/'.date('m')))
        {
            mkdir($base_url.'storage/logs/backend/'.date('Y').'/'.date('m'), 0777, true);
            chmod($base_url.'storage/logs/backend/'.date('Y').'/'.date('m'),0777);

            $fp = fopen($base_url.'storage/logs/backend/'.date('Y').'/'.date('m')."/".date('d').".txt","wb");
            fwrite($fp,$text);
            fclose($fp);
            chmod($base_url.'storage/logs/backend/'.date('Y').'/'.date('m').'/'.date('d').'.txt',0777);
        }
        else
        {
            if(!file_exists($base_url.'storage/logs/backend/'.date('Y').'/'.date('m').'/'.date('d').'.txt'))
            {
                $fp = fopen($base_url.'storage/logs/backend/'.date('Y').'/'.date('m')."/".date('d').".txt","wb");
                fwrite($fp,$text);
                fclose($fp);
                chmod($base_url.'storage/logs/backend/'.date('Y').'/'.date('m').'/'.date('d').'.txt',0777);
            }
            else
            {
                file_put_contents($base_url.'storage/logs/backend/'.date('Y').'/'.date('m').'/'.date('d').'.txt', $text.PHP_EOL , FILE_APPEND | LOCK_EX);
            }
        }
    }
}

