# Метрики

На странице индекса модели ресурса вы можете отображать информационные блоки со статистикой - метрики. Для этого в методе `metrics()` верните массив из `Metric`.

```php
namespace App\MoonShine\Resources;

use App\Models\Post;
use App\Models\Comments;
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
            Column::make([
                ValueMetric::make('Articles')->value(fn() => Post::count()),
            ])->columnSpan(6),
            Column::make([
                ValueMetric::make('Comments')->value(fn() => Comments::count()),
            ])->columnSpan(6),
        ];
    }

    //...
}
```
![metrics](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/metrics.png)
![metrics_dark](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/metrics_dark.png)

> [!NOTE]
> Для более подробной информации, пожалуйста, обратитесь к разделам [Metrics](/docs/{{version}}/components/metrics)
