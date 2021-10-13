<?php

namespace App\Http\Controllers;

use App\Models\TempMeme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TempMemeController extends Controller
{
    /*
     * Creating temp-meme upload for filepond and preview.
     */
    public function create(Request $request): string
    {
        if ($request->has('meme')) {
            $file = $request->file('meme');
            $fileName = $file->getClientOriginalName();
            $folder = Str::uuid();

            $file->storeAs('memes/tmp/' . $folder, $fileName);

            TempMeme::create([
                'folder' => $folder,
                'filename' => $fileName
            ]);

            return $folder;
        }

        return '';
    }

    /*
     * Filepond sends a delete request to /temp-meme/delete with an uuid as payload but nothing else.
     */
    public function destroy(Request $request)
    {
        $tempMemeUuid = $request->getContent();

        if (Str::isUuid($tempMemeUuid)) {
            $deleted = TempMeme::where('folder', $tempMemeUuid)->delete();
            if ($deleted) Storage::disk('local')->deleteDirectory('memes/tmp/' . $tempMemeUuid);
        }
    }
}
