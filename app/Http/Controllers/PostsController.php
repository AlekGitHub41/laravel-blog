<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;
use PHPUnit\Exception;
use Throwable;

class PostsController extends Controller
{

    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    public function store()
    {
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image'],
        ]);
        $image = request()->file('image');
        $imageName = Str::random(10) . '_' . time() . '.' . $image->extension();
        $imageNameScale = Str::random(10) . '_' . time() . '.' . $image->extension();
        $destinationPathThumbnail = public_path('storage/uploads');
        $img = Image::read($image->path());
        $img->save($destinationPathThumbnail . '/' . $imageName);
        $img->scale(500, 500)->save($destinationPathThumbnail . '/' . $imageNameScale);
        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => "/storage/uploads/" . $imageName,
            "image_scale" => "/storage/uploads/" . $imageNameScale,
        ]);
        return Redirect::route('profile.show', ["user" => auth()->user()->id]);
    }

    public function PostsResponse(Request $request)
    {
        try {
            $user = User::find($request->input("user"));
            $posts = $user->posts()->paginate(9)->withQueryString();
            return response()->json($posts, 200);
        } catch (Throwable $exception) {
            return response()->json("User not found", 404);
        }
    }

    public function deletePost(Request $request)
    {
        try {
            $post = auth()->user()->posts()->find($request->input("post_id"));
            File::delete(str_replace('/', '\\', public_path() . $post->image));
            File::delete(str_replace('/', '\\', public_path() . $post->image_scale));
            $post->delete();
        } catch (Throwable $exception) {
            return response()->json("Error", 404);
        }
    }

    public function update(Request $request, Posts $posts)
    {
        return Inertia::render('Posts/Update', ["posts" => $posts]);
    }

    public function indexUpdate(Request $request)
    {
        $data = $request->validate([
            "caption" => [],
            "image" => "nullable|image",
        ]);
        try {
            $post = auth()->user()->posts()->find($request->input("id"));
        } catch (Throwable $exception) {
            return Redirect::route('profile.show', ["user" => auth()->user()->id]);
        }
        $image = $request->file('image');
        if (!($image === null)) {
            File::delete(str_replace('/', '\\', public_path() . $post->image));
            File::delete(str_replace('/', '\\', public_path() . $post->image_scale));
            $imageName = Str::random(10) . '_' . time() . '.' . $image->extension();
            $imageNameScale = Str::random(10) . '_' . time() . '.' . $image->extension();
            $destinationPathThumbnail = public_path('storage/uploads');
            $img = Image::read($image->path());
            $img->save($destinationPathThumbnail . '/' . $imageName);
            $img->scale(500, 500)->save($destinationPathThumbnail . '/' . $imageNameScale);
            $data["image"] = "/storage/uploads/" . $imageName;
            $data["image_scale"] = "/storage/uploads/" . $imageNameScale;
        } else {
            unset($data['image']);
        }
        $post->update($data);
        return Redirect::route('profile.show', ["user" => auth()->user()->id]);
    }

    public function getPost(Request $request)
    {
        try {
            $post = Posts::find($request->input("post_id"));
            return response()->json($post, 200);
        } catch (Throwable $exception) {
            return response()->json("Post error", 404);
        }
    }
}
