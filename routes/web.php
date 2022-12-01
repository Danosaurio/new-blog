<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\Photo;
use App\Models\User;
use App\Models\Role;
use App\Models\Country;
use App\Models\Tag;
use Carbon\Carbon;


/*
|--------------------------------------------------------------------------
| DATBASE Raw SQL Queries
|--------------------------------------------------------------------------
*/

/*Route::get('/insert',function(){

    DB::insert('insert into posts(title, content) values(?,?)',['PHP with Laravel','Laravel is the best ']);
});


Route::get('/read',function(){
    $results = DB::select('select * from posts where id= ?', [1]);
    foreach($results as $post ){
        return $post->title;
   }
    
});

Route::get('/update',function(){
    $updated= DB::update('update posts set title ="Updated titledd" where id= ?',[50]);
    return $updated;
});
Route::get('/delete', function(){
    $deleted= DB::delete('delete from posts where id = ?',[1]);
    return $deleted;
});

*/



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*Route::get('/', function () {
    return view('welcome');
});


Route::resource('posts', '\App\Http\Controllers\PostController');
Route::get('/contact','\App\Http\Controllers\PostController@contact');
Route::get('/contact{var1}','\App\Http\Controllers\PostController@contact');
Route::get('/post/{var1}','\App\Http\Controllers\PostController@show_post');
*/

//Route::get('/post/{var1}','\App\Http\Controllers\PostController@index');


/*Route::get('/contact', function () {
    return "Hi contact ";
});

Route::get('/about', function () {
    return "hi about";
});

Route::get('/post/{id}/{name}', function ($id,$name) {
    return "this is post number: ".$id." -- ".$name;
});

Route::get('/admin/posts/example',array('as'=>'admin.home', function () {
    $url1= route('admin.home'); 
    return 'the route is '.$url1;
}));*/
/*


|--------------------------------------------------------------------------
| ******************* ELOQUENT ********************* 
|--------------------------------------------------------------------------
*/

Route::get('/read',function(){
    $posts= Post::all();
    $todos='';
    //return $posts;
    foreach($posts as $post){
       $todos=$todos.' - '.$post->title;
    }
    return $todos;

});
Route::get('/find',function(){
    $post= Post::find(8);
    
    return $post->title;

});

Route::get('/findwhere',function(){
    $posts = Post::where('title','Updated titledd')->orderBy('id')->take(2)->get();
    return $posts;
});
Route::get('/findmore',function(){
    //$posts = Post::findOrFail(1);
    $posts = Post::where('id','<',2)->firstOrFail();
    return $posts;
});

//--------------------- INSERT ------------------------

Route::get('/basicInsert',function(){
    $post = new Post;

    $post->title = 'New Eloquent title insert';
    $post->content = 'woow Eloquent is really cool, look at this content';

    $post->save();

});

// To updated an existing record
Route::get('/basicUpdate',function(){
    $post = Post::find(8);

    $post->title = 'New Eloquent title insert updated2';
    $post->content = 'woow Eloquent is really cool, look at this content';

    $post->save();

});
//--------------------- INSERT mass------------------------
Route::get('/create',function(){

    Post::create(['title'=>'this is a created title','content'=>'this is a created content ']);
});
//---------------------- UPDATE ------------------------
Route::get('/update',function(){

    Post::where('id',3)->where('is_admin',0)->update(['title'=>'new php title','content'=>'I love php laravel']);

});
//---------------------- DELETE ------------------------

Route::get('/delete',function(){

    $post = Post::find(6);
    $post->delete();

});

Route::get('/delete2',function(){

    Post::destroy([4,5]);
    //Post::where('is_admin',1)->delete();

});

//---------------------- SOFT DELETE ------------------------

Route::get('/softDelete',function(){
    $post= Post::find(10)->delete();
});

//---------------------- READING SOFT DELETE ------------------------
Route::get('/readSoftDelete',function(){

    $post = Post::withTrashed()->where('id',7)->get();
    return $post;

    //$post = Post::onlyTrashed()->get();
    //return $post;

});
//---------------------- RESTORE SOFT DELETE ------------------------
Route::get('/restore',function(){

    //Post::withTrashed()->where('is_admin',6)->restore();
    Post::withTrashed()->find(10)->restore();

});
//---------------------- DELETE PERMANETELY ------------------------
Route::get('/forcedelete',function(){
    Post::withTrashed()->find(8)->forcedelete();

});

/*
|--------------------------------------------------------------------------
| ******************* ELOQUENT RELATIONSHIPS ********************* 
|--------------------------------------------------------------------------
*/

//  ----------- ONE TO ONE RELATIONSHIP -----------
Route::get('/user/{id}/post',function($id){
    return User::find($id)->post->title;
    // you acces the information as a property


});
//  ----------- INVERSE ONE TO ONE RELATIONSHIP -----------

Route::get('/post/{id}/user',function($id){

    return Post::find($id)->user->name;
});


//  ----------- ONE TO MANY RELATIONSHIP -----------

// Route::get('/posts',function(){
//     $user = User::find(1);
//     foreach($user->posts as $post){
//         echo $post->title.' <br>';
//     }
// });
//  ----------- MANY TO MANY RELATIONSHIP -----------
Route::get('/user/{id}/role',function($id){
    
    $user = User::find($id)->roles()->get();
    return $user[0]->name;

    /*$user = User::find($id);
    foreach ($user->roles as $role){
        echo $role->pivot->role_id.'<br>';
    }*/
    

});

//  ----------- ACCESING THE INTERMIDIATE TABLE (PIVOT) -----------
Route::get('user/pivot/{id}',function($id){
    $user = User::find($id);
    foreach($user->roles as $role){
        echo $role->pivot->created_at.'<br>';
    }
});

//  ----------- HAS MAY THROUGH RELATION -----------

Route::get('/user/country/{id}',function($id){
    $country = Country::find($id);
    foreach($country->posts as $post){
        return $post->title; 

    }
});
//  ----------- POLYMORPHIC RELATION -----------

Route::get('user/{id}/photos',function($id){

    $user = User::find($id);

    foreach($user->photos as $photo){
        echo $photo.'<br>';
    }

});

// When you have a table that can be shared with two different models

Route::get('post/{id}/photos',function($id){

    $post = Post::find($id);

    foreach($post->photos as $photo){
        echo $photo->path.'<br>';
    }

});
// Returns the owner of the photo
Route::get('/photo/{id}',function($id){

    $photo = Photo::findOrFail($id);
    $imageable = $photo->imageable_type;
    echo $imageable;

});

//  ----------- POLYMORPHIC MANY TO MANY RELATIONSHIP -----------
Route::get('/post/{id}/tag',function($id){
    $post = Post::find($id);
    foreach($post->tags as $tag){
        echo $tag->name.'<br>';
    }
});
// Returns the owner of the TAG 

Route::get('/tag/post/{id}',function($id){
    $tag = Tag::find($id);
    foreach($tag->posts as $post){
        return $post->title;
    }
});

//---------------------------------------- Forms --------------------------------------
//---------- CRUD APPLICATION ---------


Route::group(['middleware'=>'web'], function(){
    Route::resource('/posts','\App\Http\Controllers\PostController');
    Route::get('/dates',function(){
        $date = new DateTime('+1 week');
        echo $date->format('m-d-y');
        echo '<br>';
        echo Carbon::now()->addDays(130)->diffForHumans();
        echo '<br>';
        echo Carbon::now()->subMonths(121)->diffForHumans();
        echo '<br>';
        echo Carbon::now()->yesterday();
        echo '<br>';
    });
    Route::get('/getname',function(){
        $user = User:: find(1);
        echo $user->name;
    });

    Route::get('/setname',function(){
        $user = User:: find(1);
        $user->name = 'william';
        $user->save();
    });
});





    








