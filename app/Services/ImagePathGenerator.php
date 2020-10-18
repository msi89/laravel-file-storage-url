<?php

namespace App\Services;

use League\Glide\Urls\UrlBuilder;
use League\Glide\Urls\UrlBuilderFactory;

class ImagePathGenerator
{
    private UrlBuilder $urlBuilder;

    public function __construct(string $signature)
    {
        $this->urlBuilder = UrlBuilderFactory::create('/images/', $signature);
    }

    public function generate(string $path, array $params = []): string
    {
        return $this->urlBuilder->getUrl($path, $params);
    }
}
