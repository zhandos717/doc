# HasMany

- [Basics](#basics)
- [Fields](#fields)
- [Creating a relationship object](#creatable)
- [Limit of records](#limit)
- [Only link](#only-link)
- [Parent ID](#parent-id)
- [Edit button](#change-edit-button)
- [Modal window](#without-modals)
- [Modification](#modify)
- [Adding ActionButtons](#add-action-buttons)
- [Advanced usage](#advanced)

---

<a name="basics"></a>
## Basics

The *HasMany* field is designed to work with the relationship of the same name in Laravel and includes all [Basic methods](/docs/{{version}}/fields/basic-methods).

To create this field, use the static method `make()`.

```php
HasMany::make(
    Closure|string $label,
    ?string $relationName = null,
    Closure|string|null $formatted = null,
    ModelResource|string|null $resource = null,
)
```

- `$label` - the label, the title of the field,
- `$relationName` - the name of the relationship,
- `$resource` - the model resource that the relationship refers to.

> [!CAUTION]
> The `$formatted` parameter is not used in the `HasMany` field!

> [!WARNING]
> The presence of a model resource that the relationship refers to is mandatory. The resource must also be [registered](/docs/{{version}}/resources#define) in the service provider `MoonShineServiceProvider` in the `$core->resources()` method. Otherwise, a 500 error will occur (Resource is required for MoonShine\Laravel\Fields\Relationships\HasMany...).

```php
use MoonShine\Laravel\Fields\Relationships\HasMany;

HasMany::make('Comments', 'comments', resource: CommentResource::class)
```

![has_many](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/has_many.png)

![has_many_dark](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/has_many_dark.png)

You can omit `$resource` if the model resource matches the name of the relationship.

```php
class CommentResource extends ModelResource
{
    //...
}
//...
HasMany::make('Comments', 'comments')
```

If you do not specify `$relationName`, then the name of the relationship will be automatically determined based on `$label` (according to camelCase rules).

```php
class CommentResource extends ModelResource
{
    //...
}
//...
HasMany::make('Comments')
```

<a name="fields"></a>
## Fields

The `fields()` method allows you to set the fields that will be displayed in the *preview*.

```php
fields(FieldsContract|Closure|iterable $fields)
```

```php
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Relationships\HasMany;
use MoonShine\UI\Fields\Text;

HasMany::make('Comments', resource: CommentResource::class)
    ->fields([
        BelongsTo::make('User'),
        Text::make('Text'),
    ])
```

![has_many_fields](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/has_many_fields.png)

![has_many_fields_dark](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/has_many_fields_dark.png)

<a name="creatable"></a>
## Creating a relationship object

The `creatable()` method allows you to create a new relationship object through a modal window.

```php
creatable(
    Closure|bool|null $condition = null,
    ?ActionButtonContract $button = null,
)
```

```php
HasMany::make('Comments', resource: CommentResource::class)
    ->creatable()
```

![has_many_creatable](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/has_many_creatable.png)

![has_many_creatable_dark](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/has_many_creatable_dark.png)

You can customize the *creation button* by passing the button parameter to the method.

```php
HasMany::make('Comments', resource: CommentResource::class)
    ->creatable(
        button: ActionButton::make('Custom button', '')
    )
```

<a name="limit"></a>
## Limit of records

The `limit()` method allows you to limit the number of records displayed in the *preview*.

```php
limit(int $limit)
```

```php
HasMany::make('Comments', resource: CommentResource::class)
    ->limit(1)
```

<a name="only-link"></a>
## Only link

The `relatedLink()` method will display the relationship as a link with the number of elements. The link will lead to the IndexPage of the child resource from the HasMany relationship, where only those elements will be shown.

```php
relatedLink(?string $linkRelation = null, Closure|bool $condition = null)
```

You can pass optional parameters to the method:
- `linkRelation` - a link to the relationship,
- `condition` - a closure or boolean value that determines whether to display the relationship as a link.

> [!NOTE]
> Don’t forget to add the relationship to the *with* property of the resource.

```php
HasMany::make('Comments', resource: CommentResource::class)
    ->relatedLink()
```
![has_many_link](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/has_many_link.png)

![has_many_link_dark](https://raw.githubusercontent.com/moonshine-software/doc/3.x/resources/screenshots/has_many_link_dark.png)

The `linkRelation` parameter allows you to create a link to the relationship with the binding of the parent resource.

```php
HasMany::make('Comments', resource: CommentResource::class)
    ->relatedLink('comment')
```

The `condition` parameter through a closure allows you to change the display method depending on the conditions.

```php
HasMany::make('Comments', resource: CommentResource::class)
    ->relatedLink(condition: function (int $count, Field $field): bool {
        return $count > 10;
    })
```

<a name="parent-id"></a>
## Parent ID

If the relationship has a resource, and you want to get the ID of the parent element, you can use the *ResourceWithParent* trait.

```php
use MoonShine\Resources\ModelResource;
use MoonShine\Traits\Resource\ResourceWithParent;

class PostImageResource extends ModelResource
{
    use ResourceWithParent;

    //...
}
```

When using the trait, you need to define the following methods:

```php
protected function getParentResourceClassName(): string
{
    return PostResource::class;
}

protected function getParentRelationName(): string
{
    return 'post';
}
```

To get the parent ID, use the `getParentId()` method.

```php
$this->getParentId();
```

> [!TIP]
> Recipe: [saving files](/docs/{{version}}/recipes/hasmany-parent-id) of *HasMany* relationships in the directory with the parent ID.

<a name="change-edit-button"></a>
## Edit button

The `changeEditButton()` method allows you to completely override the edit button.

```php
HasMany::make('Comments', 'comments', resource: CommentResource::class)
    ->changeEditButton(
        ActionButton::make(
            'Edit',
            fn(Comment $comment) => (new CommentResource())->formPageUrl($comment)
        )
    )
```

<a name="without-modals"></a>
## Modal window

By default, creating and editing a record of the *HasMany* field occurs in a modal window, the `withoutModals()` method allows you to disable this behavior.

```php
HasMany::make('Comments', 'comments', resource: CommentResource::class)
    ->withoutModals()
```

<a name="modify"></a>
## Modification

The *HasMany* field has methods that can be used to modify buttons, change the *TableBuilder* for previews and forms, as well as change the *relatedLink* button.

### searchable()

By default, there is a search field available on the form page for the HasMany field; to disable it, you can use the `searchable` method.

```php
public function searchable(Closure|bool|null $condition = null): static
```

```php
HasMany::make('Comments', 'comments', resource: CommentResource::class)
    ->searchable(false) // disables the search field
```

### modifyItemButtons()

The `modifyItemButtons()` method allows you to change the view, edit, delete, and mass delete buttons.

```php
/**
 * @param  Closure(ActionButtonContract $detail, ActionButtonContract $edit, ActionButtonContract $delete, ActionButtonContract $massDelete, static $ctx): array  $callback
 */
modifyItemButtons(Closure $callback)
```

```php
HasMany::make('Comments', resource: CommentResource::class)
    ->modifyItemButtons(
        fn(ActionButton $detail, $edit, $delete, $massDelete, HasMany $ctx) => [$detail]
    )
```

### modifyRelatedLink()

The `modifyRelatedLink()` method allows you to change the *relatedLink* button.

```php
HasMany::make('Comments', resource: CommentResource::class)
    ->relatedLink()
    ->modifyRelatedLink(
        fn(ActionButton $button, bool $preview) => $button
            ->when($preview, fn(ActionButton $btn) => $btn->primary())
            ->unless($preview, fn(ActionButton $btn) => $btn->secondary())
    )
```

### modifyCreateButton() / modifyEditButton()

The `modifyCreateButton()` and `modifyEditButton()` methods allow you to change the create and edit buttons.

```php
HasMany::make('Comments', resource: CommentResource::class)
    ->modifyCreateButton(
        fn(ActionButton $button) => $button->setLabel('Custom create button')
    )
    ->modifyEditButton(
        fn(ActionButton $button) => $button->setLabel('Custom edit button')
    )
    ->creatable(true)
```

### modifyTable()

The `modifyTable()` method allows you to change the *TableBuilder* for previews and forms.

```php
HasMany::make('Comments', resource: CommentResource::class)
    ->modifyTable(
        fn(TableBuilder $table, bool $preview) => $table
            ->when($preview, fn(TableBuilder $tbl) => $tbl->customAttributes(['style' => 'background: blue']))
            ->unless($preview, fn(TableBuilder $tbl) => $tbl->customAttributes(['style' => 'background: green']))
    )
```

### Redirect after changing

The `redirectAfter()` method allows you to redirect after saving/adding/deleting.

```php
HasMany::make('Comments', resource: CommentResource::class)
    ->redirectAfter(fn(int $parentId) => route('home'))
```

### Modifying QueryBuilder

The `modifyBuilder()` method allows you to modify the query through *QueryBuilder*.

```php
HasMany::make('Comments', resource: CommentResource::class)
    ->modifyBuilder(fn(Relation $query, HasMany $ctx) => $query)
```

<a name="add-action-buttons"></a>
## Adding ActionButtons

### indexButtons()

The `indexButtons` method allows you to add additional ActionButtons for working with HasMany items.

```php
HasMany::make('Comments', 'comments', resource: CommentResource::class)
    ->indexButtons([
        ActionButton::make('Custom button')
    ])
```

### formButtons()

The `formButtons` method allows you to add additional ActionButtons inside the form when creating or editing a HasMany item.

```php
HasMany::make('Comments', 'comments', resource: CommentResource::class)
    ->formButtons([
        ActionButton::make('Custom form button')
    ])
```

<a name="advanced"></a>
## Advanced usage

### Relationship through JSON field

The *HasMany* field is displayed outside the main resource form by default. If you need to display relationship fields inside the main form, you can use the *JSON* field in `asRelation()` mode.

```php
Json::make('Comments', 'comments')
    ->asRelation(new CommentResource())
    //...
```

### Relationship through Template field

Using the *Template* field, you can build a field for *HasMany* relationships using a fluent interface during declaration.

> [!NOTE]
> For more information, refer to the [Template field](/docs/{{version}}/fields/template).