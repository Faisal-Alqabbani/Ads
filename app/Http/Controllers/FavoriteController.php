<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    //
    protected $favorite;
    public function __construct(Favorite $favorite){
        $this->favorite = $favorite;
    }

    public function store(Request $request){
        $request->user()->favAds()->toggle($request->id);
    }
    

    public function show($id){
        $favorited = \Auth::user()->favAds()->whereAd_id($id)->first();
        return $favorited ? true:false;
    }
}
