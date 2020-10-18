<?php

namespace App\Providers;

use League\Glide\Server;
use Illuminate\Http\Request;
use League\Glide\ServerFactory;
use App\Services\ImagePathGenerator;
use Illuminate\Foundation\Application;
use League\Glide\Signatures\Signature;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Filesystem\Filesystem;
use League\Glide\Responses\LaravelResponseFactory;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ImagePathGenerator::class,  fn () => new ImagePathGenerator(env('GLIDE_KEY')));
        $this->app->singleton(Signature::class, fn () => new Signature(env('GLIDE_KEY')));
        $this->app->singleton(Server::class,  function (Application $app) {
            $filesystem = $app->get(Filesystem::class);
            return ServerFactory::create([
                'response' => new LaravelResponseFactory($app->get(Request::class)),
                'source' => $filesystem->getDriver(),
                'cache' => $filesystem->getDriver(),
                'max_image_size' => 2000 * 2000,
                'cache_path_prefix' => 'images/.cache',
                'source_path_prefix' => 'images',
                'base_url' => 'images',
            ]);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
