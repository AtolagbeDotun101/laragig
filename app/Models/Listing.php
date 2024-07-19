<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    //model-unguard
    // protected $fillable = ['title', 'description', 'tags', 'company', 'website', 'email', 'location'];

    public function scopeFilter($query,array $filter){
        if($filter['tag'] ?? false){
            $query->where('tags', 'like','%'. request('tag'). '%')
            ->where('title', 'like','%'. request('search'). '%')
            ->where('description', 'like','%'. request('search'). '%')
            ->where('tags', 'like','%'. request('search'). '%');
        }
    }

      // connect user to listing
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}

