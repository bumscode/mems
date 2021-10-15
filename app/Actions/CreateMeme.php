<?php

namespace App\Actions;

use App\Models\TempMeme;
use Illuminate\Support\Facades\Validator;


class CreateMeme
{
    public function create($user, array $input)
    {
        Validator::make($input, [
            'title' => 'required|max:255',
            'description' => 'required',
            'id' => 'required|uuid',
            'filename' => 'required',
        ])->validateWithBag('createMeme');

        $tempMemeId = $input['id'];

        $meme = $user->currentTeam->memes()->create([
            'title' => $input['title'],
            'description' => $input['description'],
            'user_id' => $user->id
        ]);

        $tempMeme = TempMeme::where('folder', $tempMemeId)->first();

        if($tempMeme) {
            $meme
                ->addMedia(storage_path('app/memes/tmp/' . $tempMemeId . '/' . $input['filename']))
                ->toMediaCollection('images');
        }
    }
}
