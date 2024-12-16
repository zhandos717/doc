# Filters

Filters are also created using [fields](/docs/{{version}}/fields/index): they are displayed only on the main page of the section.

To specify the fields to filter the data by, simply return an array with the necessary fields in the `filters()` method of your model resource.

> [!NOTE]
> If the method is absent or returns an empty array, the filters will not be displayed.

> [!NOTE]
> Some fields cannot participate in the construction of the filtering query, so they will be automatically excluded from the list of filters.

```php
namespace App\MoonShine\Resources;

use App\Models\Post;
use MoonShine\UI\Fields\Text;
use MoonShine\Laravel\Resources\ModelResource;

class PostResource extends ModelResource
{
    protected string $model = Post::class;

    protected string $title = 'Posts';

    //...

    protected function filters(): iterable
    {
        return [
            Text::make('Title', 'title'),
        ];
    }

    //...
}
```

![filters](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/filters.png)
![filters_dark](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/filters_dark.png)

> [!TIP]
> Fields are a key element in building forms in the `Moonshine` admin panel.
[Learn more about fields](/docs/{{version}}/fields/index)

If you need to cache the state of the filters, use the `saveQueryState` property in the resource.

```php
namespace App\MoonShine\Resources;

use App\Models\Post;
use MoonShine\Laravel\Resources\ModelResource;

class PostResource extends ModelResource
{
    protected string $model = Post::class;

    protected string $title = 'Posts';

    protected bool $saveQueryState = true;
//...
}
```