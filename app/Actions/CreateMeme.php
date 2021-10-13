<?php

namespace App\Actions;

use App\Models\TempMeme;
use Illuminate\Support\Facades\Validator;
use Spatie\MediaLibrary\MediaCollections\File;


class CreateMeme
{
    public function create($user, array $input)
    {
        Validator::make($input, [
            'meme.title' => 'required|max:255',
            'meme.description' => 'required',
            'meme.id' => 'required|uuid',
            'meme.name' => 'required',
        ])->validateWithBag('createMeme');

        $tempMemeId = $input['meme']['id'];

        $meme = $user->currentTeam->memes()->create([
            'title' => $input['meme']['title'],
            'description' => $input['meme']['description'],
            'user_id' => $user->id
        ]);

        $tempMeme = TempMeme::where('folder', $tempMemeId)->first();

        if($tempMeme) {
            $meme
                ->addMedia(storage_path('app/memes/tmp/' . $tempMemeId . '/' . $input['meme']['name']))
                ->toMediaCollection('images');
        }
    }
}
