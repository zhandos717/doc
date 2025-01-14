# Metrics

On the resource model index page, you can display informational blocks with statistics - metrics. To do this, return an array of `Metric` in the `metrics()` method.

```php
namespace App\MoonShine\Resources;

use App\Models\Post;
use App\Models\Comment;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Metrics\Wrapped\Metric;
use MoonShine\UI\Components\Metrics\Wrapped\ValueMetric;
use MoonShine\Laravel\Resources\ModelResource;

class PostResource extends ModelResource
{
    protected string $model = Post::class;

    protected string $title = 'Posts';

    //...

    /**
     * @return list<Metric>
     */
    protected function metrics(): array
    {
        return [
            ValueMetric::make('Articles')->value(fn() => Post::count())->columnSpan(6),
            ValueMetric::make('Comments')->value(fn() => Comment::count())->columnSpan(6),
        ];
    }

    //...
}
```
![metrics](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/metrics.png)
![metrics_dark](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/metrics_dark.png)

> [!NOTE]
> For more detailed information, please refer to the sections [Metrics](/docs/{{version}}/components/metrics)

If you need to wrap the metrics in a *Fragment*:

```php
protected function fragmentMetrics(): ?Closure
{
    return static fn(array $components): Fragment => Fragment::make($components)->name('metrics');
}
```