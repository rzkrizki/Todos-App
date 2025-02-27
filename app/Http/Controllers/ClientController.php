<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\CommonController;
use App\Http\Models\Client;
use Helpers;

class ClientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function UpdateClient(Request $request, $slug)
    {
        $content = Client::search_data($slug);
        
        if($content == null){
            return response()->json(
                ['message' => 'Client not found'], 404);
        }
        
        $content->name = $request->name;
        $content->slug = str_slug($request->name);
        $content->is_project = $request->is_project;
        $content->self_capture = $request->self_capture;
        $content->client_prefix = $request->client_prefix;
        $content->client_logo = $request->client_logo;
        $content->address = $request->address;
        $content->phone_number = $request->phone_number;
        $content->city = $request->name;
        $content->updated_at =date('Y-m-d H:i:s');
        if($content->save()){
            CommonController::deleteToRedis("client:".$content->slug); 
            CommonController::setToRedis("client:".$content->slug, json_encode($content, true), CommonController::redisTTL()['longest']);
            return "success";
        }else{
            return null;
        }

        return response()->json($content);
    }
    
    public function postClient(Request $request)
    {
        $content = Client::addContent($request);
        if($content == null){
            return response()->json(
                ['message' => 'Error Create Client'], 500);
        }
        return response()->json($content);
    }

    public function getClient(Request $request, $slug)
    {
        $content = Client::detail($slug);
        if($content == null){
            return response()->json(
                ['message' => 'Client not found'], 404);
        }
        return response()->json($content);
    }

    public function deleteClient(Request $request, $slug)
    {
        $content = Client::search_data($slug);
        
        if($content == null){
            return response()->json(
                ['message' => 'Client not found'], 404);
        }

        $content->deleted_at =date('Y-m-d H:i:s');
        if($content->save()){
            CommonController::deleteToRedis("client:".$content->slug); 
            return "success";
        }else{
            return null;
        }
        return response()->json($content);
    }
    
}
