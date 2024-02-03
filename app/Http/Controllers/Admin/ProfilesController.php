<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $userDetails = Auth::guard('admin')->user();
        // dd($userDetails);
        return view('admin.profile.edit', compact('userDetails'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $user = Auth::guard('admin')->user();
        $required = "nullable|mimes:jpeg,png,jpg,webp|max:5120";
        // if (!empty($request->profile_picture)) {
        //     $required = "nullable|mimes:jpeg,png,jpg,webp|max:5120";
        // } else {
        //     if (!empty($request->hidden_profile_picture)) {
        //         $required = "nullable|mimes:jpg,jpeg,gif,png,webp|max:5120";
        //     } else {
        //         $required = "nullable|mimes:jpg,jpeg,gif,png,webp|max:5120";
        //     }
        // }
        $rules = [
            'name' => 'required|string|min:3',
            // 'username' => 'string|min:3|unique:users,username,' . $user->id,
            // 'username' => 'unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'contact_number' => 'required|string|max:12|min:10',
            'profile_picture' => $required,
        ];
        $user = User::find($user->id);
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()
                ->route('profile.edit')
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('profile_picture')) {
            // dd('adsa');
            if ($user->profile_picture) {
                Storage::disk('admin_user')->delete($user->profile_picture);
            }

            $profileImage = $request->file('profile_picture');
            $imageName = renameFile($profileImage->getClientOriginalName());

            Storage::disk('admin_user')->put("/{$imageName}", file_get_contents($profileImage->getRealPath()));
            $user->profile_picture = $imageName;
        }

        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->contact_number = $request->input('contact_number');
        

        $user->save();
        if (Auth::guard('admin')->user()) {
            $jsonCompanyHistory = 'Updated profile information';
            $moduleid = 30;
            $userId = Auth::guard('admin')->user()->id;
            $action = "Updated";
            userHistoryManage($jsonCompanyHistory, $moduleid, $userId, $action);
        }
        return redirect('admin/dashboard')->with('success', 'Profile is successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
