# FlexibleRender

Декоратор `FlexibleRender` позволяет быстро отрендерить простой текст, html или blade представления.

Вы можете создать `FlexibleRender`, используя статический метод `make()`.

```php
make(Closure|Renderable|string $content, Closure|array $additionalData = [])
```

```php
use MoonShine\UI\Components\FlexibleRender;

public function components(): array
{
    return [
        FlexibleRender::make('HTML'),
        // или
        FlexibleRender::make(view('path_to_blade')),
        // или
        FlexibleRender::make(view('path_to_blade', ['data' => 'что-то'])),
        // или
        FlexibleRender::make(view('path_to_blade'), ['data' => 'что-то']),
        FlexibleRender::make(view('path_to_blade', ['var1' => 'что-то 1']), ['var2' => 'что-то 2']),
        // или
        FlexibleRender::make(fn($data) => view('path_to_blade', $data), fn() => ['data' => 'что-то']),
    ];
}
```