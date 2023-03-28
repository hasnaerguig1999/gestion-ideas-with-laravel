<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Redirect;


class LikesController extends Controller
{
    
    public function store(Request $request)
    {
        
       
        
        like::create([
            'comment_id' => $request->input('comment_id'),
             'user_id' => auth()->user()->id,

        ]);
        return Redirect::back();
    }  



  




     public function index()
    {
       
    }

    
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   

    /**
     * Display the specified resource.
     */
  
    public function show($id)
{
    $comment = Comment::find($id);
    $likes = $comment->likes->sum('like');

    return view('comments.show', compact('comment', 'likes' ));

    //utilisée pour créer un tableau associatif contenant les variables $comment et $likes to view
  

}
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Like::where('comment_id', $id)->delete();
        return redirect()->back();
    }
}
