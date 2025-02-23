# Grid

For positioning elements on the page, you can use the `Grid` component.

```php
make(iterable $components = [])
```

To position elements within the Grid, the `Column` component is used.

```php
make(
    iterable $components = [],
    int $colSpan = 12,
    int $adaptiveColSpan = 12,
)
```

 - $components - set of components,
 - $colSpan - number of columns that the block occupies for screen sizes 1280px and above,
 - $adaptiveColSpan - number of columns that the block occupies for screen sizes up to 1280px.

> [!NOTE]
> The grid consists of 12 columns.

~~~tabs
tab: Class
```php
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Text;

Grid::make([
    Column::make([
            Text::make(fake()->text())
        ],
        colSpan: 6,
        adaptiveColSpan: 6
    ),
    Column::make([
        Text::make(fake()->text())
    ],
        colSpan: 6,
        adaptiveColSpan: 6
    ),
])
```
tab: Blade
```blade
<x-moonshine::grid>
    <x-moonshine::column adaptiveColSpan="6" colSpan="6">
        {{ fake()->text() }}
    </x-moonshine::column>
    <x-moonshine::column adaptiveColSpan="6" colSpan="6">
        {{ fake()->text() }}
    </x-moonshine::column>
</x-moonshine::grid>
```
~~~