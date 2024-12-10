# Icons

- [Solid](#solid)
- [Outline](#outline)
- [Custom icons](#custom)

For all entities that have a `icon()` method, you can use one of the preset sets from the collection [Heroicons](https://heroicons.com) (default **Solid** and **Outline** set) or create your own set.

---

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
## Custom icons

It is also possible to create a blade file with your custom icon. To do this, you need to go to `resources/views/vendor/moonshine/ui/icons` create a blade file (for example `my-icon.blade.php`) with an icon displayed inside (for example, the code of an svg file) and then specify `icon('my-icon')`.
