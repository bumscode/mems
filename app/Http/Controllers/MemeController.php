<?php

namespace App\Http\Controllers;

use App\Actions\CreateMeme;
use App\Models\Meme;
use App\Http\Resources\Meme as MemeResource;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MemeController extends Controller
{
    private CreateMeme $createMeme;

    public function __construct(private CreateMeme $memeService)
    {
        $this->authorizeResource(Meme::class);
    }

    public function index(Request $request)
    {
        $memes = $request->user()->currentTeam->memes()->orderBy('id', 'desc')->get();

        return Inertia::render('Meme/Index', [
            'memes' => MemeResource::collection($memes)
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
        $this->memeService->create($request->user(), $request->all());

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
