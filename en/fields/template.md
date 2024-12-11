# Template

*Template* does not have any ready-made implementation and allows you to construct a field using *fluent interface* during the declaration process.

```php
use MoonShine\Fields\Template;
use MoonShine\Fields\Text;

//...

public function fields(): array
{
    return [
        Template::make('MyField')
            ->setLabel('My Field')
            ->fields([
                Text::make('Title')
            ])
    ];
}

//...
```

> [!TIP]
> Recipe: [HasOne relationship through the Template field](/docs/{{version}}/recipes#hasone-through-template).
