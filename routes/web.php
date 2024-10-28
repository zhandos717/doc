<?php

use Illuminate\Support\Facades\Route;
use MoonShine\Http\Middleware\ChangeLocale;

Route::get('/', function () {
    return view("home-" . app()->getLocale());
})
    ->middleware(ChangeLocale::class)
    ->name('home');

Route::get('{local}', function ($local) {
    session()->put('change-moonshine-locale', $local);
    return redirect()->intended(route('home'));
})
    ->where('local', 'en|ru')
    ->name('locale');

Route::match(['get', 'post'], 'async', function (){
   return fake()->text();
})
    ->name('async');

$cachedPage = static function (string $alias) {
    if($html = cache()->get("page:$alias")) {
        return view('page', ['content' => $html]);
    }

    $content = file_get_contents("https://raw.githubusercontent.com/CutCodeRu/basic-site-information/refs/heads/main/$alias.md");

    if(!is_string($content)) {
        abort(500);
    }

    $html = str()->markdown($content);
    $html = str_replace(['{{host}}', '{{title}}'], [str_replace('https://', '', config('app.url')), config('app.name')], $html);

    cache()->forever("page:$alias", $html);

    return view('page', ['content' => $html]);
};

Route::get('/rules', static fn() => $cachedPage('rules'))->name('rules');
Route::get('/politics', static fn() => $cachedPage('politics'))->name('politics');
