# Тестирование

## Создание ресурса с тестовым файлом

Добавив флаг --test к команде `moonshine:resource`, вы можете сгенерировать тестовый файл вместе с базовым набором тестов:

```php
php artisan moonshine:resource PostResource --test
```

Помимо создания ресурса, вышеуказанная команда сгенерирует следующий тестовый файл `tests/Feature/PostResourceTest.php`. Если вы используете Pest, вы можете указать опцию --pest:

```php
php artisan moonshine:resource PostResource --pest
```

Пример теста на успешный ответ от главной страницы ресурса:

```php
public function test_index_page_successful(): void
{
    $response = $this->get(
        $this->getResource()->indexPageUrl()
    )->assertSuccessful();
}
```

## Настройка аутентифицированного пользователя

Хотя тестирование ресурсов MoonShine ничем не отличается от стандартного тестирования вашего приложения, и настройка аутентифицированного пользователя для запроса не должна вызывать затруднений, мы все же приведем пример:

```php
protected function setUp(): void
{
    parent::setUp();

    $user = MoonshineUser::factory()->create();

    $this->be($user, 'moonshine');
}
```