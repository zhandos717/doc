# CrudResource

- [Основы](#basics)
- [Создание собственного ресурса](#custom-resource)
- [Пример REST-ресурса](#rest-example)
- [Полная кастомизация](#full-customization)

---

<a name="basics"></a>
## Основы

`CrudResource` является фундаментальной частью `MoonShine для Laravel`. 
Важно понимать, что ядро `MoonShine` не зависит от `Laravel` и тем более от моделей `Eloquent`. 
Но в реализации для `Laravel` мы предоставляем готовый `ModelResource` для работы с моделями и соответствующие `type-casts`.
`MoonShine` очень гибкий и вы можете создать собственный ресурс для работы с любыми источниками данных.

`CrudResource` предоставляет базовую структуру для работы с данными, не привязываясь к конкретной реализации. Это позволяет:

- Работать с любыми источниками данных (базы данных, `API`, файлы и т.д.)
- Создавать собственные реализации для специфических задач
- Использовать единый интерфейс независимо от источника данных

<a name="custom-resource"></a>
## Создание собственного ресурса

Для создания собственного ресурса достаточно расширить `CrudResource` и реализовать абстрактные методы:

```php
<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use MoonShine\Contracts\Core\DependencyInjection\FieldsContract;
use MoonShine\Laravel\Resources\CrudResource;

final class RestCrudResource extends CrudResource
{
    public function findItem(bool $orFail = false): mixed
    {
        // TODO: Implement findItem() method.
    }

    public function getItems(): mixed
    {
        // TODO: Implement getItems() method.
    }

    public function massDelete(array $ids): void
    {
        // TODO: Implement massDelete() method.
    }

    public function delete(mixed $item, ?FieldsContract $fields = null): bool
    {
        // TODO: Implement delete() method.
    }

    public function save(mixed $item, ?FieldsContract $fields = null): mixed
    {
        // TODO: Implement save() method.
    }
}
```

<a name="rest-example"></a>
## Пример REST-ресурса

Вот пример реализации ресурса для работы с `REST API`:

```php
<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use MoonShine\Contracts\Core\DependencyInjection\FieldsContract;
use MoonShine\Laravel\Resources\CrudResource;

final class RestCrudResource extends CrudResource
{
    public function getItems(): iterable
    {
        yield from Http::get('https://jsonplaceholder.typicode.com/todos')->json();
    }

    public function findItem(bool $orFail = false): array
    {
        yield from Http::get('https://jsonplaceholder.typicode.com/todos/' . $this->getItemID())->json();
    }

    public function massDelete(array $ids): void
    {
        $this->beforeMassDeleting($ids);

        foreach ($ids as $id) {
            $this->delete(['id' => $id]);
        }

        $this->afterMassDeleted($ids);
    }

    public function delete(mixed $item, ?FieldsContract $fields = null): bool
    {
        return Http::delete('https://jsonplaceholder.typicode.com/todos/' . $item['id'])->successful();
    }

    public function save(mixed $item, ?FieldsContract $fields = null): mixed
    {
        $data = request()->all();

        if ($item['id'] ?? false) {
            return Http::put('https://jsonplaceholder.typicode.com/todos/' . $item['id'], $data)->json();
        }

        $this->isRecentlyCreated = true;

        return Http::post('https://jsonplaceholder.typicode.com/todos', $data)->json();
    }
}
```

<a name="full-customization"></a>
# Полная кастомизация

Если вам требуется полный контроль над ресурсом, вместо наследования от `CrudResource` вы можете реализовать интерфейс `MoonShine\Contracts\Core\CrudResourceContract`. 
Это даст вам максимальную гибкость в реализации всех необходимых методов.