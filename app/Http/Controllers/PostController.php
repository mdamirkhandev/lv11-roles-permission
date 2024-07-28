<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Middleware\PermissionMiddleware;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(PermissionMiddleware::using('Delete Post'), only: ['destroy']),
            new Middleware(PermissionMiddleware::using('Edit Post'), only: ['edit', 'update']),
            new Middleware(PermissionMiddleware::using('Add Post'), only: ['create', 'store']),
            new Middleware(PermissionMiddleware::using('View Post'), only: ['index', 'show']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate(7);
        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts|min:3',
            'slug' => 'required|unique:posts|min:3',
            'desc' => 'required|min:3',
            'excerpt' => 'required|min:3',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $post = new Post();
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->desc = $request->desc;
        $post->excerpt = $request->excerpt;
        $post->user_id = Auth::user()->id;
        $post->status = $request->status;

        if ($request->image != null) {
            $file = $request->image;
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move(public_path('uploads/posts/images'), $filename);
            $post->image = $filename;
        }

        $post->save();

        flash()->success('Post created successfully!');

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        return view('post.single', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //edit
        $post = Post::find($id);
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            // 'title' => 'required|unique:posts|min:3',
            // 'slug' => 'required|unique:posts|min:3',
            'desc' => 'required|min:3',
            'excerpt' => 'required|min:3',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        //update
        $post = Post::find($id);
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->desc = $request->desc;
        $post->user_id = Auth::user()->id;
        $post->excerpt = $request->excerpt;
        $post->status = $request->status;

        if ($request->image != null) {
            $file = $request->image;
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move(public_path('uploads/posts/images'), $filename);
            $post->image = $filename;
        }
        $post->save();
        flash()->success('Post updated successfully!');
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //delete
        $post = Post::find($id);
        $post->delete();
        flash()->error('Post deleted successfully!');
        return redirect()->route('posts.index');
    }
}
