<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdRequest;
use App\Models\Ad;
use App\Models\Category;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Favorite;
use App\Models\Image;
use App\Repositories\Ads\AdInterface;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    use ImageUploadTrait;
    //
    protected $ad;
    protected $fav;
    public function __construct(Ad $ad, FavoriteController $fav){
        $this->middleware('auth', ['only' => ['create','store','edit']]);
        $this->ad=$ad;
        $this->fav = $fav;
    }
    public function all(){
        $ads = $this->ad->all();
    }

    public function show($id){
        $ad = $this->ad::with(['comments' => function($query){
            $query->with(['user:id,name']);
        }])->findOrFail($id);
        if(\Auth::check())
            $fav = $this->fav->show($id);   
        return view('ads.show', compact(['ad', 'fav']));
    }

    public function store(AdRequest $request){
        $ad = $request->user()->ads()->create($request->all()+['slug' => $request->title]);
        if($request->file('images')){
            $this->storageImage($ad, $request->file("images"));
        }
        return back()->with("success",'تم اضافة اعلان');
    }

    public function create(){
        return view('ads.create');
    }


    public function storageImage($ad, $imgArray){
        foreach($imgArray as $img){
            $image_name = $this->saveImages($img);
            $image = new Image(); 
            $image->image = $image_name;
            $ad->images()->save($image);
        }
    }


    public function UserAds(){
        $userAds = $this->ad::select('id', 'title', 'price','currency_id', 'slug', 'created_at')
        ->whereUser_id(\Auth::user()->id)->get();
        return view('ads.userAds', compact('userAds'));
    }

    public function edit($id){
        $ad = $this->ad::findOrFail($id);
        $categories = Category::all(); 
        $countries = Country::all();
        $currencies = Currency::all();
        if(\Gate::allows('edit-ad', $ad)){
           return view('ads.edit', compact('ad','categories','countries','currencies'));   
        }
     
          
    }
    
    public function update(Request $request, $id){   
      $this->ad->find($id)->update($request->all());
      return back()->with("success", "تم التعديل بنجاح");
    }

    public function destroy($id){
        $this->ad->find($id)->delete();
        return back()->with("success", "تم الحذف بنجاح");
    }

    public function AdsByCategory($cateId){
        $ads = $this->ad::with('images')->where('category_id', $cateId)->get(); 
        return view("ads.adsByCategory", compact('ads'));
    }

    public function search(Request $request){
        $ads=$this->ad->Filter($request);

        return view('ads.showResults',compact('ads')); 
    }
    // Helper function to get favs ads 
    public function getFavAds(){
            return $this->ad::with('images')->select('id','title','slug','price','currency_id')->whereIn('id',
                Favorite::select('ad_id')
                    ->groupBy('ad_id')
                    ->orderByRaw('COUNT(*) DESC')
                    ->limit(8)->get()
                )->get();
    }
    // index page
    public function getCommonAds(){
        $ads = $this->getFavAds();
        return view('index', compact('ads'));
    }

    public function userFavorite(){
        $userAds = \Auth::user()->favAds; 
        return view('ads.userFavorites', compact('userAds')); 
    }
    

    // get 

}
