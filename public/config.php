<?php
function get_env($data)
{
    $result = "";
    $env = file_get_contents(dirname(__FILE__).'/../.env');
    foreach(explode("\n",$env) as $new){
        $new_x = explode("=",$new);
        if(isset($new_x[1]) && isset($new_x[0])){
            if($new_x[0]==$data){
                $result = $new_x[1];
            }
        }
    }

    return $result;
}
 

define("BASEPATH", "");
define('API_URL', str_replace(" ","",trim(get_env('APP_URL'))) );
define('MYSQL_DEFAULT_SERVER', get_env('DB_HOST_FOR_CRON'));
define('MYSQL_DEFAULT_USERNAME', trim(get_env('DB_USERNAME_FOR_CRON')) );
define('MYSQL_DEFAULT_PASSWORD', str_replace(" ","",trim(get_env('DB_PASSWORD_FOR_CRON'))) );
define('MYSQL_DEFAULT_NAME', str_replace(" ","",trim(get_env('DB_DATABASE_FOR_CRON'))) );
define('MYSQL_DEFAULT_NAME_PREFIX', '');
define('MYSQL_DEFAULT_DRIVER', 'mysql');
define('MYSQL_DEFAULT_DSN', MYSQL_DEFAULT_DRIVER.':host='.MYSQL_DEFAULT_SERVER.';dbname='.MYSQL_DEFAULT_NAME);

define('REDIS_HOST', env('REDIS_HOST'));
define('REDIS_PORT', env('REDIS_PORT'));
define('REDIS_PASSWORD', env('REDIS_PASSWORD'));
define('REDIS_DB', env('REDIS_CACHE_DB'));
?>