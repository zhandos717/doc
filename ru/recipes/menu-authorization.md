# "Видимость" элементов меню в соответствии с политиками

Предварительно необходимо создать политики для соответствующих моделей.

Через фасад Gate:

```php
use Illuminate\Support\Facades\Gate;
use MoonShine\Laravel\Enums\Ability;

protected function menu(): array
{
  return [
    MenuItem::make('Роли', MoonShineUserRoleResource::class)
      ->canSee(fn() => Gate::check(Ability::VIEW_ANY, MoonshineUserRole::class)),
  ];
}
```

Через ресурс:

```php
use MoonShine\Laravel\Enums\Ability;

protected function menu(): array
{
  return [
    MenuItem::make('Роли', MoonShineUserRoleResource::class)
      ->canSee(fn(MenuItem $item) => $item->getFiller()->can(Ability::VIEW_ANY))
  ];
}
```
