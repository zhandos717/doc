# Иконки

- [Solid](#solid)
- [Outline](#outline)
- [Пользовательские иконки](#custom)

---

Для всех сущностей, которые имеют метод `icon()`, вы можете использовать один из предустановленных наборов из коллекции [Heroicons](https://heroicons.com) (по умолчанию наборы **Solid** и **Outline**) или создать свой собственный набор.

<a name="solid"></a>
## Solid

```php
->icon('heroicons.academic-cap') 
```

<x-docs.icon-list prefix="s" legacy_prefix="heroicons"></x-docs.icon-list>

<a name="outline"></a>
## Outline

```php
->icon('heroicons.outline.academic-cap') 
```

<x-docs.icon-list prefix="" legacy_prefix="heroicons.outline"></x-docs.icon-list>

<a name="custom"></a>
## Пользовательские иконки

Также возможно создать blade-файл с вашей пользовательской иконкой. Для этого вам нужно перейти в `resources/views/vendor/moonshine/ui/icons`, создать blade-файл (например, `my-icon.blade.php`) с отображаемой внутри иконкой (например, код svg-файла), а затем указать `icon('my-icon')`.
