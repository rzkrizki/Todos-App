<?php

namespace App\Http\Controllers;

use Helpers;
use Illuminate\Http\Request;
use App\Http\Models\Client;
use App\Http\Models\Provider;
use Illuminate\Support\Facades\Redis;

class CommonController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public static function check($results, $single = false)
    {
        if (!empty($results))
            if(is_array($results)){
                $check = count($results);
            }
            else{
                $check = count($results->toArray());
            }
        if (empty($check)) :
            return null;
        else :
            if (!$single) {
                if(is_array($results)){
                    $results = array_values($results);
                }
                else{
                    $results = array_values($results->toArray());
                }
                
            } else {
                $results = $results->toArray();
            }
        endif;
        return $results;
    }

    public static function prepareData($results, $count_data = 0)
    {
        if ($results) {
            $data['data'] = $results;
            $data['count_data'] = $count_data;
            $data['status']['code'] = 0;
            $data['status']['statusText'] = 'OK';
        } else {
            $data['data'] = [];
            $data['count_data'] = [];
            $data['status']['code'] = 404;
            $data['status']['statusText'] = 'Not Found';
        }
        return $data;
    }

    public static function redisTTL()
    {
        return [
            "superfast" => 30,      // 30detik
            "fastest" => 60,        // 1 menit
            "faster" => 120,        // 2 menit
            "fast" => 1800,         // 30 menit
            "slow" => 3600,         // 60 menit
            "slowly" => 10800,      // 3 jam
            "slowx" => 43200,       // 12 jam
            "slower" => 86400,      //  1 hari
            "slowest" => 259200,    //  3 hari
            "long" => 604800,       //  7 hari
            "longer" => 1209600,    //  14 hari
            "longest" => 2592000    //  30 hari
        ];
    }

    public static function getFromRedis($keys, $debug = false)
    {
        if ($debug)
            dd(Redis::get($keys));

        return Redis::get($keys);
    }
    
    public static function setToRedis($key, $value, $ttl = null)
    {
        if(isset($_GET['redis_key'])){
            $key = $_GET['redis_key'];
        }
        // elseif(isset($_SERVER['REQUEST_URI'])){
        //     $key = $_SERVER['REQUEST_URI'];
        // }

        if ($value) {
            if ($ttl == null) {
                $ttl = env('REDIS_TTL', 1);
            } else {
                $ttl = $ttl;
            }
            try {
                app('redis')->set($key, $value);
                app('redis')->expireat($key, time() + $ttl);
            } catch (\Exception $e) {
                return null;
            }
        } else {
            return null;
        }
    }

    public static function deleteToRedis($key)
    {
        if(isset($_GET['redis_key'])){
            $key = $_GET['redis_key'];
        }
        // elseif(isset($_SERVER['REQUEST_URI'])){
        //     $key = $_SERVER['REQUEST_URI'];
        // }

        Redis::pipeline(function ($pipe) use ($key) {
            $pipe->del($key);
        }); return null;
    }
}