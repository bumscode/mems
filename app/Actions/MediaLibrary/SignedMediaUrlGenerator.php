<?php

namespace App\Actions\MediaLibrary;

use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;
use URL;

class SignedMediaUrlGenerator extends DefaultUrlGenerator
{
    public function getUrl(): string
    {
        return URL::signedRoute('media', [
            'media' => $this->media->id,
            'conversion' => $this->conversion?->getName(),
        ]);
    }
}
