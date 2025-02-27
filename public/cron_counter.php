<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function redis_value($client,$redis)
{
    $result = json_decode($client->pipeline(function ($pipe) use ($redis) {
        $pipe->get($redis);
    })[0], true);

    return $result;
}

try 
{
    $database = new PDO('mysql:host='.MYSQL_DEFAULT_SERVER.';dbname='.MYSQL_DEFAULT_NAME.';port=3306',MYSQL_DEFAULT_USERNAME,MYSQL_DEFAULT_PASSWORD);
}
catch(PDOException $e)
{
    echo $e->getMessage();
}

try {
    date_default_timezone_set("Asia/Jakarta");
    $date = date('Y-m-d',strtotime("-1 day", strtotime(date("Y-m-d"))));
    $date = date('Y-m-d');
    $key = "counter_read:".$date.":";
    $client = new Predis\Client([
        'scheme' => 'tcp',
        'host'   => REDIS_HOST,
        'port'   => REDIS_PORT,
        'database' => REDIS_DB
    ]);
    
    $redis_data = $client->keys("*$key*");
    $data = array();
    foreach($redis_data as $redis_key => $redis_value){

        $redis_explode = explode(":",$redis_value);

        $data_detail = array();
        $data_detail['redis'] = $redis_value;
        $data_detail['posts_id'] = $redis_explode[count($redis_explode)-1];
        $data_detail['tag_id'] = getTagId($data_detail['posts_id'],$database);
        $data_detail['counter'] = redis_value($client,$redis_value);
        $data[] = $data_detail;
    }

    //save to mysql
    if(count($data) > 0){
        foreach($data as $data_key => $data_value){
            $query = "UPDATE posts SET pageviews=pageviews + ? WHERE id=?";
            $update = $database->prepare($query);
            $update->execute(array($data_value['counter'],$data_value['posts_id']));

            //update tagging
            foreach($data_value['tag_id'] as $tag_id){
                updateTagViews($database,$data_value['posts_id'],$data_value['counter'],$tag_id);
            }
        }
    }

    echo "success";
}
catch (Exception $e)
{
    die($e->getMessage());
}

function updateTagViews($database,$posts_id,$counter,$tag_id)
{
    $query = "UPDATE tag_post SET views=views + ? WHERE post_id=? and tag_id=?";
    $update = $database->prepare($query);
    if(!$update->execute(array($counter,$posts_id,$tag_id))){
        print_r($update->errorInfo());
        exit;
    }
}

function getTagId($post_id,$database)
{
    $result = array();
    $query = $database->prepare("SELECT tag_id FROM tag_post where post_id='$post_id'");
    $query->execute();
    while($row = $query->fetch())
    {
        $result[] = $row['tag_id'];
    }

    return $result;
}
?>