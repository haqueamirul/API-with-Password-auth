<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::all();
    }

    public function store(Request $request)
    {
        try{
            $post = new Post();

            if($request->hasFile('photo')){
                $file = $request->file('photo');
                $allowedfileextension = ['pdf', 'png', 'jpg'];
                $extention = $file->getClientOriginalExtension();
                $check = in_array($extention, $allowedfileextension);

                if($check){
                    $name = time() . $file->getClientOriginalName();
                    $file->move('images', $name);
                    $post->image = $name;
                }
            }

            $post->title = $request->title;
            $post->body = $request->body;
            // $post->image = $request->image;

            if($post->save()) {
                return response()->json(['status' => 'success', 'message' => 'Post Created Successfully!']);
            }

        }catch (\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $post = Post::findOrFail($id);

            if($request->hasFile('photo')){
                $file = $request->file('photo');
                $allowedfileextension = ['pdf', 'png', 'jpg'];
                $extention = $file->getClientOriginalExtension();
                $check = in_array($extention, $allowedfileextension);

                if($check){
                    $name = time() . $file->getClientOriginalName();
                    $file->move('images', $name);
                    $post->image = $name;
                }
            }

            $post->title = $request->title;
            $post->body = $request->body;
            // $post->image = $request->image;

            if($post->save()) {
                return response()->json(['status' => 'success', 'message' => 'Post Updated Successfully!']);
            }

        }catch (\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function destroy($id){
        try{
            $post = Post::findOrFail($id);

            if($post->delete()) {
                return response()->json(['status' => 'success', 'message' => 'Post Deleted Successfully!']);
            }

        }catch (\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
