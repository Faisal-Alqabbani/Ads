<?php

namespace App\Models;

use App\Helpers\helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Ad extends Model
{
    use HasFactory;
    protected $fillable= ['title','slug','text','price','user_id','category_id','country_id','currency_id'];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function setSlugAttribute($value){
        $slug = helper::slug($value);
        $uniqueslug = helper::uniqueslug($slug, 'ads');
        $this->attributes['slug'] = $uniqueslug;
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    // comments model 
    public function comments(){
        // herical model
        return $this->hasMany(Comment::class)->where('parent_id', null);
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function scopeFilter($query, Request $request){
        if($request->country){
            $query->whereCountry_id($request->country);
        }
        if($request->category){
            $query->whereCategory_id($request->category);
        }
        
        if($request->keyword){
            $query->where('title', 'LIKE','%'.$request->keyword.'%');
        }
        
        return $query->with('images')->get();
    }

}
