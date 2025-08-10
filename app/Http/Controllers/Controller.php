<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

abstract class Controller
{
    protected array $locales = ['en', 'ko'];
    protected string $default_locale = 'ko';

    protected function to_route(string $route, $parameters = [], int $status = 302, array $headers = [])
    {
        if (Route::has(App::getLocale() . '.' . $route)) {
            return to_route(App::getLocale() . '.' . $route, $parameters, $status, $headers);
        }

        return to_route($route, $parameters, $status, $headers);
    }

    protected function get_locale()
    {
        $locale = App::getLocale();

        return in_array($locale, $this->locales) ? $locale : $this->default_locale;
    }

    protected function get_admin_locale()
    {
        $locale = request()->query('locale', 'ko');

        return in_array($locale, $this->locales) ? $locale : $this->default_locale;
    }

    protected function get_admin_locale_params()
    {
        if ($this->default_locale !== $this->get_admin_locale()) {
            return ['locale' => $this->get_admin_locale()];
        }

        return [];
    }

    protected function is_dev()
    {
        return config('app.env', 'production') !== 'production';
    }
}
