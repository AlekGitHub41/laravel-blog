<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Posts;
use App\Models\User;
use App\Models\Profiles;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Inertia\Response;

//use Intervention\Image\Colors\Profile;
use Intervention\Image\Laravel\Facades\Image;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(User $user)
    {
        $now_user = User::with("profile")->findOrFail($user->id);
        $posts = $user->posts()->paginate(9);
        $lastPage = $posts->lastPage();
        $status = (auth()->user()) ? auth()->user()->following->contains($user->profile->id) : false;

        $postsCount = $user->posts->count();
        $followersCount = $user->profile->followers->count();
        $followingCount = $user->following->count();

        return Inertia::render('Profile/Index', ["user" => $now_user, "status" => $status, "followersCount" => $followersCount,
            "followingCount" => $followingCount, "posts" => $posts, "lastPage" => $lastPage, "postsCount" => $postsCount]);
    }

    public function ProfileResponse(Request $request)
    {
        $keyword = $request->input("search");
        $results = DB::table('users')
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->select('users.name', 'profiles.image', "users.id")
            ->where('users.name', 'like', '%' . $keyword . '%')
            ->get();
        return response()->json($results, 200);
    }

    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'profile' => $request->user()->profile,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            "title" => [],
            "description" => [],
            "image" => "nullable|image",
        ]);
        $profile = auth()->user()->profile;
        $image = $request->file('image');
        if (!($image === null)) {
            $path = str_replace('/', '\\', public_path() . $profile->image);
            if (!($profile->image === "/default.jpg")) {
                File::delete($path);
            }
            $imageName = Str::random(10) . '_' . time() . '.' . $image->extension();
            $destinationPathThumbnail = public_path('storage/uploads');
            $img = Image::read($image->path());
            $img->scale(500, 500)->save($destinationPathThumbnail . '/' . $imageName);
            $data["image"] = "/storage/uploads/" . $imageName;
        } else {
            unset($data['image']);
        }
        $profile->update($data);
        return Redirect::route('profile.show', ["user" => auth()->user()->id]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
