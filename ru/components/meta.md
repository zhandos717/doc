# Meta

Компонент **Meta** используется для размещения метаданных на html-странице.

```php
use MoonShine\UI\Components\Layout\Meta;

Meta::make('csrf-token')
    ->customAttributes([
        'content' => 'token',
    ]),
Meta::make()
    ->customAttributes([
        'name' => 'description',
        'content' => 'Описание страницы',
    ]),
```

> [!TIP]
> Родительский компонент: [Html](/docs/{{version}}/components/html)
