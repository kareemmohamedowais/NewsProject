<?php

namespace App\Http\Controllers\Api\Setting;

use App\Models\Setting;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use App\Models\RelatedNewsSite;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Http\Resources\SettingResource;

class SettingController extends Controller
{
    public function getSettings(){
        $settings = Setting::first();
        $related_sites = $this->relatedsites();
        if(!$settings){
            return apiResponse(404,'not found');
        }
        $data = [
            'related_sites'=>$related_sites,
            'settings'=>SettingResource::make($settings)
        ];
        return apiResponse( 200,'site settings and related sites',$data);
    }
    public function relatedSites(){
        $related_sites = RelatedNewsSite::select('name','url')->get();
        if(!$related_sites){
            return apiResponse(404,'not found');
        }
        return $related_sites;
    }

// public function update(Request $request)
// {
//     return $request;
// }
}

