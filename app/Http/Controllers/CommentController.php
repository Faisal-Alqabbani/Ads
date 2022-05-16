<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    protected $comment;
    public function __construct(Comment $comment){
        $this->comment = $comment;
    }

    public function store(Request $request){
        $request->user()->comments()->create($request->all());
    }

    public function reply(Request $request){
        $request->user()->comments()->create($request->all());
        return back();
    }    
    
}
