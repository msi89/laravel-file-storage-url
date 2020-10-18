<?php

function image(string $path, array $params = []): string
{
    return app(\App\Services\ImagePathGenerator::class)->generate($path, $params);
}
