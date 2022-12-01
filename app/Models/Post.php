<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable=[
        'title',
        'content',
        'user_id',
        'path'
    ];

    public $directory = '/images/';

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function photos(){
        return $this->morphMany(Photo::class,'imageable');
    }

    public function tags(){
        return $this->morphToMany(Tag::class,'taggable');
    }

    public static function scopeUltimos($query){
        return $query->orderBy('id','asc')->get();
    }

    public function getPathAttribute($value){
        return $this->directory.$value;
    }

}
