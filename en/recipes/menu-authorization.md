# "Visibility" of menu items according to policies

First, it is necessary to create policies for the corresponding models.

Through the Gate facade:

```php
use Illuminate\Support\Facades\Gate;
use MoonShine\Laravel\Enums\Ability;

protected function menu(): array
{
  return [
    MenuItem::make('Roles', MoonShineUserRoleResource::class)
      ->canSee(fn() => Gate::check(Ability::VIEW_ANY, MoonshineUserRole::class)),
  ];
}
```

Through the resource:

```php
use MoonShine\Laravel\Enums\Ability;

protected function menu(): array
{
  return [
    MenuItem::make('Roles', MoonShineUserRoleResource::class)
      ->canSee(fn(MenuItem $item) => $item->getFiller()->can(Ability::VIEW_ANY))
  ];
}
```