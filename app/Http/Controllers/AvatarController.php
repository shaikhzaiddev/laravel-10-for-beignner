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
        
        $path = $request->file('avatar')->store('avatars');

        auth()->user()->update([
            'avatar' => storage_path('app').'/'.$path,
        ]);
        
        //second way to upload image 
        //$path = Storage::putFile('avatars', $request->file('avatar'));

        return Redirect::route('profile.edit')->with('message', 'Avtar is Updated');
    }
    
}
