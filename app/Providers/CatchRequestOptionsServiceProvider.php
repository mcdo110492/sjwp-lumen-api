<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class CatchRequestOptionsServiceProvider
 * @package App\Providers
 *
 * If the incoming request is an OPTIONS request
 * we will register a handler for the requested route
 *
 * https://gist.github.com/danharper/06d2386f0b826b669552
 */
class CatchRequestOptionsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $request = app('request');
        if ($request->isMethod('OPTIONS'))
        {
            app()->options($request->path(), function() { return response('', 200); });
        }
    }
}
