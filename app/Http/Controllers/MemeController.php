<?php

namespace App\Http\Controllers;

use App\Actions\CreateMeme;
use App\Models\Meme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MemeController extends Controller
{
    private CreateMeme $createMeme;

    public function __construct(CreateMeme $createMeme)
    {
        $this->createMeme = $createMeme;
        $this->authorizeResource(Meme::class);
    }

    public function index(Request $request)
    {
        $memes = $request->user()->currentTeam->memes()->orderBy('id', 'desc')->get();

        $user = Auth::user();
        ray($user);

        $mappedMemes = $memes->map(fn (Meme $meme) => [
            'id' => $meme->id,
            'title' => $meme->title,
            'description' => $meme->description,
            'created_at' => $meme->created_at,
            'image' => $meme->getFirstMedia('images')->toHtml(),
            'imageUrl' => $meme->getFirstMediaUrl('images')
        ]);

        return Inertia::render('Meme/Index', [
            'memes' => $mappedMemes
        ]);
    }

    public function create()
    {
        /*
         * This is currently unused until inertia.js releases the dialog functionality.
         * Current upload is shown temp and submitted via api request
         */
    }

    public function store(Request $request)
    {
        $this->createMeme->create($request->user(), $request->all());

        return redirect('/memes');
    }

    public function show(Meme $meme)
    {
        return Inertia::render('Meme/Detail', [
            'meme' => $meme,
            'owner' => $meme->load('owner', 'team'),
            'media' => $meme->getFirstMedia('images')->toHtml()
        ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
