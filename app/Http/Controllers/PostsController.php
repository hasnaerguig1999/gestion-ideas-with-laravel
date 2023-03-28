<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Str;
use App\Models\Post;


class PostsController extends Controller
{
    
    public function index()
    {
       
        return view('blog.index') ->with('posts',Post::orderBy('created_at','desc')->get());
    }

  
    public function create()
    {
        return view('blog.create');
    }
    
    
    public function store(Request $request)
    {
       
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png|max:5048',
        ]);
        $slug =Str::slug('$request->title', '-');

        $newImageName = uniqid() . '-' . $slug . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $newImageName);
        
        Post::create([
            'title' => $request->input('title'),
             'description' => $request->input('description'),
             'slug' => $slug,
             'image_path' => $newImageName,
             'user_id' => auth()->user()->id,

        ]);
        return redirect('/blog');
    }  

   
    public function show($id)
    {
          return view('blog.show')
          ->with('post',Post::where('id',$id)->first());
          //utilisée pour filtrer les articles qui est stocké dans la colonne id
          //first() est utilisée pour récupérer le premier article qui correspond au slug


    }

    
    public function edit($id)
    {
        return view('blog.edit')
        ->with('post',Post::where('id',$id)->first());
        
    }

   
    public function update(Request $request, $slug)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
          
        ]);
        if ($request->hasFile('image')) {

          
        }

         Post::where('id', $slug)
         ->update([
             'title' => $request->input('title'),
             'description' => $request->input('description'),
             'slug' => $slug,
            
             'user_id' => auth()->user()->id,
         ]);
            return redirect('/blog/' . $slug)
            ->with('message','Post updated successfully');
    }

    
    public function destroy($slug)
    {
        Post::where('id', $slug)->delete();
        return redirect('/blog')
        ->with('message','Post deleted successfully');
    }

    public function searchByTitle(Request $request)
    {
        $searchTerm = $request->input('title');

        $posts =Post::where('title', 'LIKE', "%{$searchTerm}%")->get();
        return view('blog.index', compact('posts'));

}
}
