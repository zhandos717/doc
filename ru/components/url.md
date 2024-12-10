# Url

Компонент `Url` позволяет вам быстро создать и кастомизировать текстовую ссылку вида <a href="#"></a>.

```php
make(
    string $href,
    string $value,
    ?string $icon = 'link',
    bool $withoutIcon = false,
    bool $blank = false,
)
```

- $href - ссылка на ресурс,
- $value - название ссылки,
- $$icon - иконка,
- $withoutIcon - флаг без иконки,
- $blank - открывать в новой вкладке.

~~~tabs
tab: Class
```php
use MoonShine\UI\Components\Url;

Url::make('https://moonshine-laravel.com', 'Moonshine'),
```
tab: Blade
```blade
<x-moonshine::url href="https://moonshine-laravel.com" value='Moonshine'/>
```
~~~