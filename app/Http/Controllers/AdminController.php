<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;

class AdminController extends Controller
{
        public function __construct()
    {
        $this->middleware('auth');
    }
    
    function index(){
      //$blogs=DB::table('blogs')->paginate(5);
        $blogs=Blog::paginate(5);
      return view('blog',compact('blogs'));
    }

    
    function create(){
        return view ('form');
    }

    function insert(Request $request){
        $request->validate(
            [
            'title'=>'required|max:50',
            'content'=>'required'
            ],
            [
                'title.required'=>'กรุณาป้อนชื่อบทความ',
                'title.max'=>'ชื่อบทความไม่ควรเกิน 50 ตัวอักษร',
                'content.required'=>'กรุณาป้อนเนื้อหาบทความของคุณ'
            ]
            );
            $data=[
                'title'=>$request->title,
                'content'=>$request->content

            ];
            Blog::insert($data);
            return redirect('/author/blog');
    }

    function delete($id){
        Blog::find($id)->delete();
        return redirect()->back();
    }

    function change($id){
       $blog=Blog::find($id);
       $data=[
        'status'=>!$blog->status
       ];
       //$blog=DB::table('blogs')->where('id',$id)->update($data);
       $blog=Blog::find($id)->update($data);
       return redirect()->back();
    }

    function edit($id){
        $blog=Blog::find($id);
        return view('edit',compact('blog'));
    }

    function update(Request $request,$id){
        $request->validate(
            [
            'title'=>'required|max:50',
            'content'=>'required'
            ],
            [
                'title.required'=>'กรุณาป้อนชื่อบทความ',
                'title.max'=>'ชื่อบทความไม่ควรเกิน 50 ตัวอักษร',
                'content.required'=>'กรุณาป้อนเนื้อหาบทความของคุณ'
            ]
            );
             $data=[
                'title'=>$request->title,
                'content'=>$request->content
             ];
             //DB::table('blogs')->where('id',$id)->update($data);
             Blog::find($id)->update($data);
             return redirect('/author/blog');
            
    }
}
