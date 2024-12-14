# Форма и события

При успешном запросе форма обновляет таблицу и сбрасывает значения.

```php
FormBuilder::make(route('form-table.store'))
    ->fields([
        Text::make('Title')
    ])
    ->name('main-form')
    ->async(events: [
        AlpineJs::event(JsEvent::TABLE_UPDATED, 'main-table'),
        AlpineJs::event(JsEvent::FORM_RESET, 'main-form')
    ]),

TableBuilder::make()
    ->fields([
        ID::make(),
        Text::make('Title'),
        Textarea::make('Body'),
    ])
    ->name('main-table')
    ->async()
```