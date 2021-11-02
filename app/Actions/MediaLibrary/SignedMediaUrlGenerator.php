<?php

namespace App\Actions\MediaLibrary;

use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;
use URL;

class SignedMediaUrlGenerator extends DefaultUrlGenerator
{
    public function getUrl(): string
    {
        return URL::temporarySignedRoute('media', now()->addHours(12), [
            'media' => $this->media->uuid,
            'conversion' => $this->conversion?->getName(),
        ]);
    }
}
