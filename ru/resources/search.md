# Поиск

  - [Основы](#basics)
  - [Полнотекстовый поиск](#fulltext)
  - [Поиск по ключам json](#json)
  - [Поиск по связям](#relation)
  - [Глобальный поиск](#global)

---

<a name="basics"></a>
## Основы

Для поиска необходимо указать, какие поля модели будут участвовать в поиске. Для этого нужно перечислить их в возвращаемом массиве в методе `search()`.

> [!TIP] 
> Если метод возвращает пустой массив, то строка поиска не будет отображаться.

```php
namespace App\MoonShine\Resources;

use App\Models\Post;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;

class PostResource extends ModelResource
{
    protected string $model = Post::class;

    protected string $title = 'Posts';

    //...

    public function search(): array
    {
        return ['id', 'title', 'text'];
    }

    //...
}
```

![MoonShine Search Dark](https://raw.githubusercontent.com/moonshine-software/doc/2.x/resources/screenshots/search_dark.png)

<a name="fulltext"></a>
## Полнотекстовый поиск

Если требуется полнотекстовый поиск, то необходимо использовать атрибут `MoonShine\Attributes\SearchUsingFullText`.

```php
namespace App\MoonShine\Resources;

use App\Models\Post;
use MoonShine\Attributes\SearchUsingFullText;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;

class PostResource extends ModelResource
{
    protected string $model = Post::class;

    protected string $title = 'Posts';

    //...

    #[SearchUsingFullText(['title', 'text'])]
    public function search(): array
    {
        return ['id'];
    }

    //...
}
```

> [!TIP] 
> Не забудьте добавить полнотекстовый индекс

<a name="json"></a>
## Поиск по ключам json

Для Json полей, которые используются в качестве ключ-значение `keyValue()`, можно указать, какой ключ поля участвует в поиске.

```php
namespace App\MoonShine\Resources;

use App\Models\Post;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;

class PostResource extends ModelResource
{
    protected string $model = Post::class;

    protected string $title = 'Posts';

    //...

    public function search(): array
    {
        return ['data->title'];
    }

    //...
}
```

Для многомерных Json, которые формируются через поля `fields()`, ключ поиска нужно указывать следующим образом:

```php
namespace App\MoonShine\Resources;

use App\Models\Post;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;

class PostResource extends ModelResource
{
    protected string $model = Post::class;

    protected string $title = 'Posts';

    //...

    public function search(): array
    {
        return ['data->[*]->title'];
    }

    //...
}
```

<a name="relation"></a>
## Поиск по связям

Вы можете осуществлять поиск по связям; для этого нужно указать, по какому полю связи осуществлять поиск.

```php
namespace App\MoonShine\Resources;

use App\Models\Post;
use MoonShine\Fields\Text;
use MoonShine\Resources\ModelResource;

class PostResource extends ModelResource
{
    protected string $model = Post::class;

    protected string $title = 'Posts';

    //...

    public function search(): array
    {
        return ['category.title'];
    }

    //...
}
```

<a name="global"></a>
## Глобальный поиск

В админ-панели MoonShine можно реализовать глобальный поиск на основе интеграции
[Laravel Scout](https://laravel.com/docs/scout).

Для реализации глобального поиска необходимо:

1. Указать список моделей для поиска в конфигурационном файле `config/moonshine.php`.

```php
'global_search' => [
    Article::class,
    User::class
],
```

2. Реализовать интерфейс в моделях.

```php
use MoonShine\Scout\HasGlobalSearch;
use MoonShine\Scout\SearchableResponse;
use Laravel\Scout\Searchable;
use Laravel\Scout\Builder;

class Article extends Model implements HasGlobalSearch
{
    use Searchable;

    public function searchableQuery(Builder $builder): Builder
    {
        return $builder->take(4);
    }

    public function toSearchableResponse(): SearchableResponse
    {
        return new SearchableResponse(
            group: 'Articles',
            title: $this->title,
            url: '/',
            preview: $this->text,
            image: $this->thumbnail
        );
    }
}
```