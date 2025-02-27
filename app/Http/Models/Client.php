<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\CommonController;
use Helpers;

class Client extends Model
{
    protected $connection = 'mysql';
    protected $table = 'myclient';
    protected $primaryKey = 'id';

    public static function addContent($request){
        $data = new Client();
        $data->name = $request->name;
        $data->slug = str_slug($request->name);
        $data->is_project = $request->is_project;
        $data->self_capture = $request->self_capture;
        $data->client_prefix = $request->client_prefix;
        $data->client_logo = $request->client_logo;
        $data->address = $request->address;
        $data->phone_number = $request->phone_number;
        $data->city = $request->name;
        $data->created_at =date('Y-m-d H:i:s');
        if($data->save()){
            CommonController::setToRedis("client:".$data->slug, json_encode($data, true), CommonController::redisTTL()['longest']);
            return "success";
        }else{
            return null;
        }
    }

    public static function editContent($request){
        $data = new Client();
        $data->name = $request->name;
        $data->slug = str_slug($request->name);
        $data->is_project = $request->is_project;
        $data->self_capture = $request->self_capture;
        $data->client_prefix = $request->client_prefix;
        $data->client_logo = $request->client_logo;
        $data->address = $request->address;
        $data->phone_number = $request->phone_number;
        $data->city = $request->name;
        $data->created_at =date('Y-m-d H:i:s');
        if($data->save()){
            CommonController::setToRedis("client:".$data->slug, json_encode($data, true), CommonController::redisTTL()['longest']);
            return "success";
        }else{
            return null;
        }
    }

    public static function detail($slug)
    {
        if(config('constant.CACHE')){
            $cache_name = env('REDIS_KEYPREFIX').":client:".$slug;
            $redis_data = CommonController::getFromRedis($cache_name);
            if (!empty($redis_data)) {
                $data = json_decode($redis_data);
            }
            else{
                $data = Self::detail_data($slug);
            }
        }
        else{
            $data = Self::detail_data($slug);
        }

        return json_decode(json_encode($data));
    }

    public static function detail_data($slug)
    {
        $data = Client::select('*')->where('deleted_at', null)->where('slug',$slug);
        $content_count = $data->count();
        $content = $data->first();

        if($content_count == 0){
            return null;
        }
        
        $content = CommonController::check($content,true);
        return CommonController::prepareData($content,$content_count);
        
    }

    public static function search_data($slug)
    {
        $data = Client::select('*')->where('deleted_at', null)->where('slug',$slug);
        $content_count = $data->count();
        $content = $data->first();

        if($content_count == 0){
            return null;
        }
        
        return $content;
        
    }
}