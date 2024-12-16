# Menu

- [Basics](#basics)
- [Groups](#groups)
- [Divider](#divider)
- [Icon](#icon)
- [Badge](#badge)
- [Translation](#translation)
- [Open in a new tab](#target-blank)
- [Display condition](#condition)
- [Active item](#active)
- [Attributes](#attributes)
- [Change button](#change-button)
- [Custom view](#custom-view)

---

<a name="basics"></a>
## Basics

**Menu** is the foundation for navigation in the admin panel, so we have tried to create a flexible system that allows you to fully customize the menu for different pages and users.

The navigation menu is configured in a class that extends `MoonShine\Laravel\Layouts\AppLayout` through the `menu()` method.

During the installation of the admin panel, based on the configurations you choose, a class **App\MoonShine\Layouts\MoonShineLayout** will be created that already contains the `menu()` method.

In the future, if you need to, you can create other ***Layouts*** for specific pages.

To add a menu item, you need to use the class **MoonShine\Menu\MenuItem** and its static method `make()`.

```php
MenuItem::make(Closure|string $label, Closure|MenuFillerContract|string $filler, string $icon = null, Closure|bool $blank = false)
```

- `$label` - the name of the menu item,
- `$filler` - the element for forming the url,
- `$icon` - the icon for the menu item,
- `$blank` - open in a new tab.

> [!TIP]
> The second parameter can accept [ModelResource](), [Page]() or [Resource]().

```php
namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\Laravel\Resources\MoonShineUserResource;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{

    //...

    protected function menu(): array
    {
        return [
            MenuItem::make('Admins', new MoonShineUserResource()),
            MenuItem::make('Home', fn() => route('home')),
            MenuItem::make('Docs', 'https://moonshine-laravel.com/docs'),
            MenuItem::make('Laravel Docs', 'https://laravel.com/docs', blank: true)
        ];
    }
}
```

> [!TIP]
> If the menu is created for [ModelResource](/docs/{{version}}/model-resource/index) or [CrudResource](/docs/{{version}}/advanced/crud-resource), the first page declared in the `pages()` method will be used for the menu item.

<a name="groups"></a>
## Groups

Menu items can be grouped together. To do this, use the class `MoonShine\MenuManager\MenuGroup` with the static method `make()`.

```php
MenuGroup::make(Closure|string $label, iterable $items, string|null $icon = null)
```

- `$label` - the name of the group,
- `$items` - an array of menu components,
- `$icon` - an icon for the group.

```php
namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\Laravel\Resources\MoonShineUserResource;
use MoonShine\Laravel\Resources\MoonShineUserRoleResource;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{

    //...

    protected function menu(): array
    {
        return [
            MenuGroup::make('System', [
                MenuItem::make('Admins', new MoonShineUserResource()),
                MenuItem::make('Roles', new MoonShineUserRoleResource()),
            ])
        ];
    }
}
```

You can also add items to the group using the `setItems()` method.

```php
setItems(iterable $items)
```

```php
namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\Laravel\Resources\MoonShineUserResource;
use MoonShine\Laravel\Resources\MoonShineUserRoleResource;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{

    //...

    protected function menu(): array
    {
        return [
            MenuGroup::make('System')->setItems([
                MenuItem::make('Admins', new MoonShineUserResource()),
                MenuItem::make('Roles', new MoonShineUserRoleResource()),
            ])
        ];
    }
}
```

> [!TIP]
> To create a multi-level menu, groups can be nested.

<a name="divider"></a>
## Divider

Menu items can be visually separated with `MenuDivider`.

```php
/**
 * @param  (Closure(MenuElementContract $context): string)|string  $label
 */
MenuDivider::make(Closure|string $label = '')
```

```php
namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\Laravel\Resources\MoonShineUserResource;
use MoonShine\Laravel\Resources\MoonShineUserRoleResource;
use MoonShine\MenuManager\MenuDivider;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{

    //...

    protected function menu(): array
    {
        return [
            MenuItem::make('Admins', new MoonShineUserResource()),
            MenuDivider::make(),
            MenuItem::make('Roles', new MoonShineUserRoleResource())
        ];
    }
}
```

<a name="icon"></a>
## Icon

A menu item and group can have an icon specified. This can be done in several ways.

### Through parameter
You can set the icon by passing the name as the third parameter in the static method `make()`.

```php
namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\Laravel\Resources\MoonShineUserResource;
use MoonShine\Laravel\Resources\MoonShineUserRoleResource;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{

    //...

    protected function menu(): array
    {
        return [
            MenuItem::make('Admins', new MoonShineUserResource(), 'users'),
            MenuItem::make('Roles', new MoonShineUserRoleResource(), 'hashtag')
        ];
    }
}
```

### Through method

Use the `icon()` method.

```php
icon(string $icon, bool $custom = false, ?string $path = null)
```

- `$icon` - the name of the icon or HTML (if custom mode is used),
- `$custom` - custom mode,
- `$path` - the path to the directory where the **blade** templates for icons are located.

```php
namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\Laravel\Resources\MoonShineUserResource;
use MoonShine\Laravel\Resources\MoonShineUserRoleResource;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{

    //...

    protected function menu(): array
    {
        return [
            MenuGroup::make('System', [
                MenuItem::make('Admins', new MoonShineUserResource())
                    ->icon('users'),
                MenuItem::make('Roles', new MoonShineUserRoleResource())
                    ->icon(svg('path-to-icon-pack')->toHtml(), custom: true),
            ])
                ->icon('cog', path: 'icons')
        ];
    }
}
```

### Through attribute

An icon will be displayed for a menu item if the class **ModelResource**, **Page**, or **Resource** has the `Icon` attribute set and the icon is not overridden in other ways.

```php
namespace MoonShine\Resources;

#[Icon('users')]
class MoonShineUserResource extends ModelResource
{

    //...

}
```

> [!TIP]
> For more detailed information, refer to the section [Icons](/docs/{{version}}/appearance/icons).

<a name="badge"></a>
## Badge

There is also an option to add a badge to a menu item.

### Through menu item

To add a badge to the menu item, use the `badge()` method, which takes a closure as a parameter.

```php
/**
 * @param  Closure(MenuElementContract $context): string|int|float|null  $value
 */
badge(Closure|string|int|float|null $value)
```

```php
namespace App\MoonShine\Layouts;

use App\MoonShine\Resources\CommentResource;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{

    //...

    protected function menu(): array
    {
        return [
            MenuItem::make('Comments', new CommentResource())
                ->badge(fn() => Comment::count())
        ];
    }
}
```

<a name="translation"></a>
## Translation

To translate menu items, you need to pass a translation key as the name and add the `translatable()` method.

```php
translatable(string $key = '')
```

```php
namespace App\MoonShine\Layouts;

use App\MoonShine\Resources\CommentResource;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{

    //...

    protected function menu(): array
    {
        return [
            MenuItem::make('menu.Comments', new CommentResource())
                ->translatable()
            // or
            MenuItem::make('Comments', new CommentResource())
                ->translatable('menu')
        ];
    }
}
```

```php
// lang/ru/menu.php

return [
    'Comments' => 'Комментарии',
];
```

For translating menu badges, you can use the Laravel translation system.

```php
namespace App\MoonShine\Layouts;

use App\MoonShine\Resources\CommentResource;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{

    //...

    protected function menu(): array
    {
        return [
            MenuItem::make('Comments', new CommentResource())
                ->badge(fn() => __('menu.badge.new'))
        ];
    }
}
```

<a name="target-blank"></a>
## Open in a new tab

You can specify a flag for the menu item indicating whether to open the link in a new tab. This can be implemented in several ways.

### Through parameter

The flag can be set by passing the fourth parameter `true/false` or a closure in the static method `make()`.

```php
namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{

    //...

    protected function menu(): array
    {
        return [
            MenuItem::make('MoonShine Docs', 'https://moonshine-laravel.com/docs', 'heroicons.arrow-up', true),
            MenuItem::make('Laravel Docs', 'https://laravel.com/docs', blank: fn() => true),
        ];
    }
}
```

### Through method

Use the `blank()` method.

```php
/**
 * @param  (Closure(MenuElementContract $context): bool)|bool  $blankCondition
 */
blank(Closure|bool $blankCondition = true)
```

```php
namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{

    //...

    protected function menu(): array
    {
        return [
            MenuItem::make('MoonShine Docs', 'https://moonshine-laravel.com/docs', 'heroicons.arrow-up', true),
            MenuItem::make('Laravel Docs', 'https://laravel.com/docs', blank: fn() => true),
        ];
    }
}
```

<a name="condition"></a>
## Display condition

You can show menu items based on a condition by using the `canSee()` method.

```php
/**
 * @param  Closure(MenuElementContract $context): bool  $callback
 */
canSee(Closure $callback)
```

```php
namespace App\Providers;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\Laravel\Resources\MoonShineUserResource;
use MoonShine\Laravel\Resources\MoonShineUserRoleResource;
use MoonShine\MenuManager\MenuDivider;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{

    //...

    protected function menu(): array
    {
        return [
            MenuGroup::make('System', [
                MenuItem::make('Admins', new MoonShineUserResource()),
                MenuDivider::make()
                    ->canSee(fn() => true),
                MenuItem::make('Roles', new MoonShineUserRoleResource())
                    ->canSee(fn() => false)
            ])
                ->canSee(static fn(): bool => request()->user('moonshine')?->id === 1)
        ];
    }
}
```

<a name="active"></a>
## Active item

A menu item becomes active if it matches the ***url***, but the `forceActive()` method allows you to forcibly make an item active.

```php
/**
 * @param  Closure(string $path, string $host, MenuElementContract $context): bool  $when
 */
whenActive(Closure $when)
```

```php
namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{

    //...

    protected function menu(): array
    {
        return [
            MenuItem::make('Label', '/endpoint')
                ->whenActive(fn() => request()->fullUrlIs('*admin/endpoint/*')),
        ];
    }
}
```

<a name="attributes"></a>
## Attributes

Custom attributes can be assigned to groups and menu items, just like other components.

> [!TIP]
> For more detailed information, refer to the section [Component Attributes](/docs/{{version}}/components/attributes)

```php
namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\Laravel\Resources\MoonShineUserResource;
use MoonShine\Laravel\Resources\MoonShineUserRoleResource;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{

    //...

    protected function menu(): array
    {
        return [
            MenuGroup::make('System')->setItems([
                MenuItem::make('Admins', new MoonShineUserResource()),
                MenuItem::make('Roles', new MoonShineUserRoleResource())
                    ->customAttributes(['class' => 'group-li-custom-class'])
            ])
                ->setAttribute('data-id', '123')
                ->class('group-li-custom-class')
        ];
    }
}
```

<a name="change-button"></a>
## Change button

A menu item is an [ActionButton](#) and its attributes can be changed using the `changeButton` method.

```php
/**
 * @param  Closure(ActionButtonContract $button): ActionButtonContract  $callback
 */
changeButton(Closure $callback)
```

```php
namespace App\MoonShine\Layouts;

use MoonShine\UI\Components\ActionButton;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{

    //...

    protected function menu(): array
    {
        return [
            MenuItem::make('Label', '/endpoint')
                ->changeButton(static fn(ActionButton $button) => $button->class('new-item')),
        ];
    }
}
```

> [!WARNING]
> Some **ActionButton** parameters, such as `url`, `badge`, `icon`, and others, are systemically overridden. To change them, use the corresponding methods.

<a name="custom-view"></a>
## Change template

If you need to change the **view** using the *fluent interface*, you can use the `customView()` method.

```php
customView(string $path)
```

- `$path` - the path to the **blade** template.

```php
namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;

final class MoonShineLayout extends AppLayout
{

    //...

    protected function menu(): array
    {
        return [
            MenuGroup::make('Group', [
                MenuItem::make('Label', '/endpoint')
                    ->customView('admin.custom-menu-item'),
            ])
                ->customView('admin.custom-menu-group'),
        ];
    }
}
