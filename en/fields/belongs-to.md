# BelongsTo

- [Basics](#basics)
- [Default Value](#default)
- [Nullable](#nullable)
- [Placeholder](#placeholder)
- [Creatable Relationship](#creatable)
- [Searchable Values](#searchable)
- [Change Value Query](#values-query)
- [Async Search](#async-search)
- [Associated Fields](#associated)
- [Values with Image](#with-image)
- [Options](#options)
- [Native Mode](#native)
- [Reactivity](#reactive)
- [Link](#link)

---

<a name="basics"></a>
## Basics

The _BelongsTo_ field is designed to work with the corresponding relationship in Laravel and contains all [Basic methods](/docs/{{version}}/fields/basic-methods).

To create this field use the static method `make()`.

```php
BelongsTo::make(
    Closure|string $label,
    ?string $relationName = null,
    Closure|string|null $formatted = null,
    ModelResource|string|null $resource = null,
)
```

- `$label` - label, header of the field,
- `$relationName` - name of the relationship,
- `$formatted` - closure or field in the related table to display values,
- `$resource` - model resource that the relationship refers to.

> [!WARNING]
> It is mandatory to have a model resource that the relationship refers to!  
> The resource also needs to be registered in the _MoonShineServiceProvider_ service provider in the `$core->resources()` method. Otherwise, a 500 error will occur (Resource is required for MoonShine\Laravel\Fields\Relationships\BelongsTo...).


```php
use MoonShine\Laravel\Fields\Relationships\BelongsTo;

BelongsTo::make('Country', 'country', resource: CountryResource::class)
```

![belongs_to](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/belongs_to.png)

![belongs_to_dark](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/belongs_to_dark.png)

> [!NOTE]
> If you do not specify `$relationName`, the name of the relationship will be determined automatically based on `$label`.

```php
BelongsTo::make('Country', resource: CountryResource::class)
```

You can omit `$resource` if the model resource matches the relationship name.

```php
class CountryResource extends ModelResource
{
    //...
}
//...
BelongsTo::make('Country', 'country')
```

If you do not specify `$relationName`, the name of the relationship will be determined automatically based on `$label` (according to camelCase rules).

```php
class CountryResource extends ModelResource
{
    //...
}
//...
BelongsTo::make('Country')
```

> [!NOTE]
> By default, the value is displayed using the field in the related table that is specified by the `$column` property in the model resource.  
> The `$formatted` argument allows you to override the `$column` property.

```php
namespace App\MoonShine\Resources;

use MoonShine\Resources\ModelResource;

class CountryResource extends ModelResource
{
    public string $column = 'title';
}
//..
BelongsTo::make(
    'Country',
    'country',
    formatted: 'name'
)
```

If a more complex value for display is required, you can pass a callback function to the `$formatted` argument.

```php
BelongsTo::make(
    'Country',
    'country',
    fn($item) => "$item->id. $item->title"
)
```

If you need to change the column when working with models, use the `onAfterFill` method.

```php
BelongsTo::make(
    'Category',
    resource: CategoryResource::class
)->afterFill(fn($field) => $field->setColumn('changed_category_id'))
```

<a name="default"></a>
## Default Value

You can use the `default()` method if you need to specify a default value for the field.

```php
default(mixed $default)
```

You must pass a model object as the default value.

```php
use App\Models\Country;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;

BelongsTo::make('Country', resource: CategoryResource::class)
    ->default(Country::find(1))
```

<a name="nullable"></a>
## Nullable

As with all fields, if you need to store NULL, you must add the `nullable()` method.

```php
nullable(Closure|bool|null $condition = null)
```

```php
BelongsTo::make('Country', resource: CategoryResource::class)
    ->nullable()
```

![select_nullable](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/select_nullable.png)

![select_nullable_dark](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/select_nullable_dark.png)

> [!TIP]
> MoonShine is a very convenient and functional tool. However, to use it, you need to be confident in the basics of Laravel.

Don't forget to specify in the database table that the field can accept `Nullable` values.

<a name="placeholder"></a>
## Placeholder

The `placeholder()` method allows you to set the _placeholder_ attribute for the field.

```php
placeholder(string $value)
```

```php
BelongsTo::make('Country', 'country')
    ->nullable()
    ->placeholder('Country')
```

<a name="searchable"></a>
## Searchable Values

If you need to search among the values, you should add the `searchable()` method.

```php
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use App\MoonShine\Resources\CountryResource;

BelongsTo::make('Country', 'country', resource: CountryResource::class)
    ->searchable()
```

<a name="creatable"></a>
## Creatable Relationship

The `creatable()` method allows creating a new relationship object through a modal window.

```php
creatable(
    Closure|bool|null $condition = null,
    ?ActionButton $button = null,
)
```

```php
BelongsTo::make('Author', resource: new AuthorResource())
    ->creatable()
```

![belongs_to_creatable](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/belongs_to_creatable.png)

![belongs_to_creatable_dark](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/belongs_to_creatable_dark.png)

You can customize the create button by passing the _button_ parameter to the method.

```php
BelongsTo::make('Author', resource: new AuthorResource())
    ->creatable(
        button: ActionButton::make('Custom button', '')
    )
```

<a name="values-query"></a>
## Change Value Query

The `valuesQuery()` method allows you to change the query for fetching values.

```php
valuesQuery(Closure $callback)
```

```php
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;

BelongsTo::make('Category', 'category', resource: CategoryResource::class)
    ->valuesQuery(fn(Builder $query, Field $field) => $query->where('active', true))
```

<a name="async-search"></a>
## Async Search

To implement async value searching, use the `asyncSearch()` method.

```php
asyncSearch(
    string $column = null,
    ?Closure $searchQuery = null,
    ?Closure $formatted = null,
    ?string $associatedWith = null,
    int $limit = 15,
    ?string $url = null,
)
```

```php
BelongsTo::make('Country', 'country', resource: CategoryResource::class)
    ->asyncSearch()
```

> [!TIP]
> The search will be performed based on the resource's relationship field `column`. By default, `column=id`.

You can pass parameters to the `asyncSearch()` method:
*   `$column` - the field to search by,
*   `$searchQuery` - callback function for filtering values,
*   `$formatted` - callback function for customizing output,
*   `$associatedWith` - the field to establish a relationship with,
*   `$limit` - the number of elements in the search results,
*   `$url` - URL for handling the async request,

```php
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;

BelongsTo::make('Country', 'country', resource: CategoryResource::class)
    ->asyncSearch(
        'title',
        searchQuery: function (Builder $query, Request $request, Field $field) {
            return $query->where('id', '!=', 2);
        },
        formatted: function ($country, Field $field) {
            return $country->id . ' | ' . $country->title;
        },
        limit: 10,
        url: 'https://moonshine-laravel.com/async'
    )
```

> [!NOTE]
> When building the query in `asyncSearchQuery()`, you can use the current form values. To do this, you need to pass `Request` to the callback function.

```php
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\UI\Fields\Select;

Select::make('Country', 'country_id'),
BelongsTo::make('City', 'city',  resource: CityResource::class)
    ->asyncSearch(
        'title',
        searchQuery: function (Builder $query, Request $request, Field $field): Builder {
            return $query->where('country_id', $request->get('country_id'));
        }
    )
```

> [!NOTE]
> When building the query in `asyncSearchQuery()`, the original state of the builder is preserved.  
If you need to replace it with your builder, use the `replaceQuery` flag.

```php
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\UI\Fields\Select;

Select::make('Country', 'country_id'),
BelongsTo::make('City', 'city',  resource: CityResource::class)
    ->asyncSearch(
        'title',
        asyncSearchQuery: function (Builder $query, Request $request, Field $field): Builder {
            return $query->where('country_id', $request->get('country_id'));
        },
        replaceQuery: true
    )
```

<a name="associated"></a>
## Associated Fields

To establish a relationship between selection values in fields, you can use the `associatedWith()` method.

```php
associatedWith(string $column, ?Closure $searchQuery = null)
```

- `$column` - the field to establish the relationship with,
- `$searchQuery` - callback function for filtering values.

```php
BelongsTo::make('City', 'city', resource: CityResource::class)
    ->associatedWith('country_id')
```

> [!NOTE]
> For more complex configurations, you can use `asyncSearch()`.

<a name="with-image"></a>
## Values with Image

> [!NOTE]
> The `withImage()` method allows adding an image to the value.

```php
withImage(
    string $column,
    string $disk = 'public',
    string $dir = ''
)
```

- `$column` - the field containing the image,
- `$disk` - the file system disk,
- `$dir` - the directory relative to the disk root.

```php
BelongsTo::make('Country', resource: CountryResource::class)
    ->withImage('thumb', 'public', 'countries')
```

![belongs_to_image](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/belongs_to_image.png) 

![belongs_to_image_dark](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/belongs_to_image_dark.png)

<a name="options"></a>
## Options

All selection options are available for modification through *data attributes*:

```php
BelongsTo::make('Country', resource: CountryResource::class)
    ->searchable()
    ->customAttributes([
        'data-search-result-limit' => 5
    ])
```

> [!NOTE]
> For more detailed information, please refer to [Choices](https://choices-js.github.io/Choices/).

<a name="native"></a>
## Native Mode

The `native()` method disables the Choices.js library and displays the selection in native mode.

```php
BelongsTo::make('Type')->native()
```

<a name="reactive"></a>
## Reactivity

This field supports [reactivity](/docs/{{version}}/fields/basic-methods#reactive)

<a name="link"></a>
## Link

By default, *BelongsTo* links to the edit page, using the `link` method under the hood. If necessary, you can override `link`:

```php
BelongsTo::make(
    __('moonshine::ui.resource.role'),
    'moonshineUserRole',
    resource: MoonShineUserRoleResource::class,
)
->link(
    link: fn(string $value, BelongsTo $ctx) => $ctx->getResource()->getDetailPageUrl($ctx->getData()->getKey()),
    name: fn(string $value) => $value,
    icon: 'users',
    blank: true,
)
```