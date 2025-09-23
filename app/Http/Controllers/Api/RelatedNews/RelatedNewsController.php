<?php

namespace App\Http\Controllers\Api\RelatedNews;

use Illuminate\Http\Request;
use App\Models\RelatedNewsSite;
use App\Http\Controllers\Controller;
use App\Http\Resources\RelatedNewsResource;

class RelatedNewsController extends Controller
{
    public function RelatedSites(){
        $related_news = RelatedNewsSite::get();

        if(!$related_news){
            return apiResponse(404 , 'Related News Is Empty');
        }
        return apiResponse(200 , 'this is related news' ,
        ['related_news'=>RelatedNewsResource::collection($related_news)]);


    }
}
