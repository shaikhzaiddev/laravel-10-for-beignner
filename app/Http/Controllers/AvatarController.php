<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvatarUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\RedirectResponse;


class AvatarController extends Controller
{
    
    public function update(AvatarUpdateRequest $request): RedirectResponse{  
        
        //First way to upload file
        //$path = $request->file('avatar')->store('avatars','public');

        $path = Storage::disk('public')->putFile('avatars', $request->file('avatar'));

        if($oldAvatar = $request->user()->avatar){
            Storage::disk('public')->delete($oldAvatar);
        }
        auth()->user()->update([
            'avatar' =>  $path,
        ]);
        
        //second way to upload image 
        //$path = Storage::putFile('avatars', $request->file('avatar'));

        return Redirect::route('profile.edit')->with('message', 'Avtar is Updated');
    }
    
}
