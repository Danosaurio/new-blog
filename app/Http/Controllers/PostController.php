<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::Ultimos();
        
        return view('posts.index',compact('posts'));
    }  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        
        $input = $request->all();
        
        if($file = $request->file('file')){
            $name = $file->getClientOriginalName();
            $file->move('images',$name);
            $input['path'] = $name;
        }
        Post::create($input);
        
        // ---------- Store files 
        // $file = $request->file('file');
        // echo "<br>";
        // echo $file->getClientOriginalName();
        // echo "<br>";
        // echo $file->getSize();

        // Post::create($request->all());
        // return redirect('/posts');
        
        // $this->validate($request,[
        //     'title'=>'required|max:5',

        // ]);
        //return $request->all();
        
        //*************/
        //  $input = $request->all();
        //  $input['title']= $request->title;
        // Post::create($request->all());

        //*************/
        // $post = new Post;
        // $post->title = $request->title;
        // $post->save();



    }

    /**
     * Display the specified resource.s
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::findOrFail($id);
        return view('posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::findOrFail($id);
        return view('posts.edit',compact('post'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $post = Post::findOrFail($id);
        $post->update($request->all());
        return redirect('/posts');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::findOrFail($id);
        $post->delete();
      }

    public function contact(){
        $people =['Daniel','Jesus','Edwin','Pax','Nadio Ivonne'];
        return view('contact',compact('people'));

    }
    public function show_post($var1){
       // return view('post')->with('var1',$var1);
       $example = "jajajaajajaja";
       return view('post',compact('var1','example'));
    }
    
}
