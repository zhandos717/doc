# FlexibleRender

The `FlexibleRender` decorator allows you to quickly render simple text, HTML, or Blade views.

You can create a `FlexibleRender` using the static method `make()`.

```php
make(Closure|Renderable|string $content, Closure|array $additionalData = [])
```

```php
use MoonShine\UI\Components\FlexibleRender;

FlexibleRender::make('HTML'),
// or
FlexibleRender::make(view('path_to_blade')),
// or
FlexibleRender::make(view('path_to_blade', ['data' => 'something'])),
// or
FlexibleRender::make(view('path_to_blade'), ['data' => 'something']),
FlexibleRender::make(view('path_to_blade', ['var1' => 'something 1']), ['var2' => 'something 2']),
// or
FlexibleRender::make(fn($data) => view('path_to_blade', $data), fn() => ['data' => 'something']),
```