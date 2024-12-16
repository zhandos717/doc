# ActionButton

- [Basics](#basics)
- [Open in new window](#blank)
- [Icon](#icon)
- [Color](#color)
- [Badge](#badge)
- [onClick](#onclick)
- [Modal window](#modal)
- [Confirmation](#confirm)
- [Off canvas](#offcanvas)
- [Grouping](#group)
- [Bulk actions](#bulk)
- [Async mode](#async)
    - [Method calls](#method)
- [Sending events](#event)
- [Filling with data](#fill)

---

Inherits [MoonShineComponent](/docs/{{version}}/components/index).

\* has the same capabilities.


<a name="basics"></a>
## Basics

When you need to add a button with a specific action, `ActionButton` comes to the rescue.
In `MoonShine`, they are already being used - in forms, tables, on pages.

```php
ActionButton::make(
    Closure|string $label,
    Closure|string $url = '#',
    ?DataWrapperContract $data = null,
)
```

- `label` - button text,
- `url` - URL link of the button,
- `data` - optional button data available in closures.

```php
use MoonShine\UI\Components\ActionButton;

protected function components(): iterable
{
    return [
        ActionButton::make(
            label: 'Button title',
            url: 'https://moonshine-laravel.com',
        )
    ];
}
```

<a name="blank"></a>
## Open in new window

The `blank()` method allows you to open a URL in a new window. The attribute `target="_blank"` will be added.

```php
ActionButton::make(
    label: 'Click me',
    url: '/',
)->blank()
```

<a name="icon"></a>
## Icon

The `icon()` method allows you to specify an icon for the button.

```php
ActionButton::make(
    label: fn() => 'Click me',
    url: 'https://moonshine-laravel.com',
)->icon('pencil')
```

> [!NOTE]
> For more detailed information, refer to the [Icons](/docs/{{version}}/appearance/icons) section.

<a name="color"></a>
## Color

For *ActionButton* there is a set of methods that allow you to set the button color: 
`primary()`, `secondary()`, `warning()`, `success()`, and `error()`.

```php
ActionButton::make(
    label: 'Click me',
    url: fn() => 'https://moonshine-laravel.com',
)->primary()
```

<a name="badge"></a>
## Badge

The `badge()` method allows you to add a badge to the button.

```php
badge(Closure|string|int|float|null $value)
```

```php
ActionButton::make('Button')->badge(fn() => Comment::count())
//...
```

<a name="onclick"></a>
## onClick

The `onClick` method allows you to execute JS code when clicked:

```php
ActionButton::make(
    label: 'Click me',
    url: 'https://moonshine-laravel.com',
)->onClick(fn() => "alert('Example')", 'prevent')
```

If you need to get data in the `onClick` method, use the `onAfterSet` method:

```php
ActionButton::make('Alert')
  ->onAfterSet(function (?DataWrapperContract $data, ActionButton $button) {
    return $button->onClick(fn() => 'alert('.$data?->getKey().')');
  })
```

<a name="modal"></a>
## Modal window

### Basics

To call a modal window when clicking on the button, use the `inModal()` method.

> [!NOTE]
> For more detailed information on modal window methods, refer to the [Modal](/docs/{{version}}/components/modal) section.

```php
use MoonShine\UI\Components\Modal;

ActionButton::make(
    label: 'Click me',
    url: 'https://moonshine-laravel.com',
)
    ->inModal(
        title: fn() => 'Modal window title',
        content: fn() => 'Modal window content',
        name: 'my-modal',
        builder: fn(Modal $modal, ActionButton $ctx) => $modal->buttons([
          ActionButton::make('Click me in modal window', 'https://moonshine-laravel.com')
        ])
    )
```

- `title` - modal window title,
- `content` - modal window content,
- `name` - modal window name for event calls,
- `builder` - closure with access to the `Modal` component.

You can also open the modal window using the `toggleModal` method, and if the `ActionButton` is inside the modal window, just use `openModal`.

```php
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\Modal;

protected function components(): iterable
{
    return [
        Modal::make(
            'Title',
            fn() => 'Content',
        )->name('my-modal'),

        ActionButton::make(
            label: 'Open modal window',
        )->toggleModal('my-modal')
    ];
}
```

### Async mode

If you need to load content into the modal window asynchronously, enable the `async` mode on the `ActionButton`.

```php
protected function components(): iterable
{
    return [
        ActionButton::make(
            label: 'Click me',
            url: to_page('action_button', fragment: 'doc-content'),
        )
            ->async()
            ->inModal(
                title: fn() => 'Modal window title',
            )
    ];
}
```

> [!NOTE]
> You can learn about [Fragment](/docs/{{version}}/components/fragment) in the "Components" section.

<a name="confirm"></a>
## Confirmation

The `withConfirm()` method allows you to create a button with a confirmation action.

```php
ActionButton::make(
    label: 'Click me',
    url: 'https://moonshine-laravel.com',
)
    ->withConfirm(
        title: 'Confirmation modal window title',
        content: 'Confirmation modal window content',
        button: 'Confirmation modal window button',
        // optionally - additional form fields
        fields: null,
        method: HttpMethod::POST,
        // optionally - closure with FormBuilder
        formBuilder: null,
        // optionally - closure with Modal
        modalBuilder: null,
        // optionally - name of the Modal component
        name: null,
    )
```

<a name="offcanvas"></a>
## Off canvas

To trigger an off canvas when clicking the button, use the `inOffCanvas()` method.

```php
use MoonShine\UI\Components\OffCanvas;

protected function components(): iterable
{
    return [
        ActionButton::make(
            label: 'Click me',
            url: 'https://moonshine-laravel.com',
        )
            ->inOffCanvas(
                title: fn() => 'Off canvas title',
                content: fn() => 'Content',
                name: false,
                builder: fn(OffCanvas $offCanvas, ActionButton $ctx) => $offCanvas->left()
                // optionally - need to ensure components are available for search in the system, since content is just HTML
                components: []
            )
    ];
}
```

<a name="group"></a>
## Grouping

If you need to organize logic with multiple `ActionButton`, where some of them should be hidden or displayed in a dropdown menu, use the `ActionGroup` component.

```php
use MoonShine\UI\Components\ActionGroup;

protected function components(): iterable
{
    return [
        ActionGroup::make([
            ActionButton::make('Button 1', '/')->canSee(fn() => false),
            ActionButton::make('Button 2', '/', $model)->canSee(fn($model) => $model->active)
        ])
    ];
}
```

### Display

Thanks to `ActionGroup`, you can also change the display of buttons, showing them inline or in a dropdown menu to save space.

```php
use MoonShine\UI\Components\ActionGroup;

protected function components(): iterable
{
    return [
        ActionGroup::make([
            ActionButton::make('Button 1', '/')->showInLine(),
            ActionButton::make('Button 2', '/')->showInDropdown()
        ])
    ];
}
```

<a name="bulk"></a>
## Bulk actions

The `bulk()` method allows you to create a bulk action button for `ModelResource`.

```php
protected function indexButtons(): ListOf
{
    return parent::indexButtons()->add(ActionButton::make('Link', '/endpoint')->bulk());
}
```

> [!TIP]
> The `bulk()` method is used only inside `ModelResource`.

<a name="async"></a>
## Async mode

The `async()` method allows you to implement asynchronous operation for `ActionButton`.

```php
async(
    HttpMethod $method = HttpMethod::GET,
    ?string $selector = null,
    array $events = [],
    ?AsyncCallback $callback = null
)
```

- `$method` - method of the asynchronous request,
- `$selector` - selector of the element, the content of which will change according to the response,
- `$events` - events that will be triggered after a successful request,
- `$callback` - JS callback function after receiving the response.

> [!NOTE]
> You can learn about [Events](/docs/{{version}}/frontend/js#events) in the "Frontend" section.
>
> [!NOTE]
> You can learn about [Callback](/docs/{{version}}/frontend/js#response-calback) in the "Frontend" section.

```php
protected function components(): iterable
{
    return [
        ActionButton::make(
            'Click me',
            '/endpoint'
        )
            ->async()
    ];
}
```

### Notifications

If you need to display a notification or perform a redirect after clicking, simply implement a JSON response according to the structure:

```php
{message: 'Toast', messageType: 'success', redirect: '/url'}
```

> [!TIP]
> The `redirect` parameter is optional.

### HTML content

If you need to replace an HTML area upon clicking, you can return HTML content or JSON with the key html in the response:

```php
{html: 'Html content'}
```

```php
protected function components(): iterable
{
    return [
        ActionButton::make(
            'Click me',
            '/endpoint'
        )
            ->async(selector: '#my-selector')
    ];
}
```

### Events

After a successful request, you can trigger events:

```php
protected function components(): iterable
{
    return [
        ActionButton::make(
            'Click me',
            '/endpoint'
        )
            ->async(events: [AlpineJs::event(JsEvent::TABLE_UPDATED, $this->getListComponentName())])
    ];
}
```
> [!TIP]
> For the `JsEvent::TABLE_UPDATED` event to work, the table must have [async mode](/docs/{{version}}/model-resource/table#async) enabled.

### Callback

If you need to handle the response in a different way, you need to implement a handler function and specify it in the `async()` method.

```php
protected function components(): iterable
{
    return [
        ActionButton::make(
            'Click me',
            '/endpoint'
        )
            ->async(callback: 'myFunction')
    ];
}
```

```javascript
document.addEventListener("moonshine:init", () => {
    MoonShine.onCallback('myFunction', function(response, element, events, component) {
        if(response.confirmed === true) {
            component.$dispatch('toast', {type: 'success', text: 'Success'})
        } else {
            component.$dispatch('toast', {type: 'error', text: 'Error'})
        }
    })
})
```

<a name="method"></a>
### Method calls

`method()` allows you to specify the name of a method in the resource and call it asynchronously when clicking on the `ActionButton` without the need to create additional controllers.

```php
method(
    string $method,
    array|Closure $params = [],
    ?string $message = null,
    ?string $selector = null,
    array $events = [],
    ?AsyncCallback $callback = null,
    ?PageContract $page = null,
    ?ResourceContract $resource = null
)
```

- `$method` - method name,
- `$params` - optionally - parameters for the request,
- `$message` - optionally - message upon successful execution,
- `$selector` - optionally - selector of the element whose content will change,
- `$events` - optionally - events that will be triggered after a successful request,
- `$callback` - optionally - JS callback function after receiving a response,
- `$page` - optionally - page containing the method (if the button is outside the page and resource),
- `$resource` - optionally - resource containing the method (if the button is outside the resource).

```php
protected function components(): iterable
{
    return [
        ActionButton::make('Click me')
            ->method('updateSomething'),
    ];
}
```
```php
// With notification
public function updateSomething(MoonShineRequest $request): MoonShineJsonResponse
{
    // $request->getResource();
    // $request->getResource()->getItem();
    // $request->getPage();

    return MoonShineJsonResponse::make()->toast('My message', ToastType::SUCCESS);
}

// Redirect
public function updateSomething(MoonShineRequest $request): MoonShineJsonResponse
{
    return MoonShineJsonResponse::make()->redirect('/');
}

// Redirect
public function updateSomething(MoonShineRequest $request): RedirectResponse
{
    return back();
}

// Exception
public function updateSomething(MoonShineRequest $request): void
{
    throw new \Exception('My message');
}

// Custom JSON response
public function updateSomething(MoonShineRequest $request)
{
    return MoonShineJsonResponse::make()->html('Content');
}
```
> [!WARNING]
> Methods called via `ActionButton` in the resource must be public!

> [!CAUTION]
> To access data from the request, you must pass it as parameters.

#### Passing the current item

If the request contains `resourceItem`, you can access the current item in the resource through the `getItem()` method.

- When the data contains a model, and the button is created in the `indexButtons()` or `detailButtons` or `formButtons` method of [TableBuilder](/docs/{{version}}/components/table-builder#buttons), [CardsBuilder](/docs/{{version}}/components/cards-builder#buttons) or [FormBuilder](/docs/{{version}}/components/form-builder#buttons), it is automatically populated with data, and the parameters will contain `resourceItem`.
- When the button is on the form page of `ModelResource`, you can pass the id of the current item.

```php
ActionButton::make('Click me')
    ->method(
        'updateSomething',
        params: ['resourceItem' => $this->getResource()->getItemID()]
    )
```

- When the button is in the index table of `ModelResource`, you need to use a closure.

```php
ActionButton::make('Click me')
    ->method(
        'updateSomething',
        params: fn(Model $item) => ['resourceItem' => $item->getKey()]
    )
```

#### Field values

The `withSelectorsParams()` method allows you to pass field values with the request using element selectors.

```php
ActionButton::make('Async method')
    ->method('updateSomething')
    ->withSelectorsParams([
        'alias' => '[data-column="title"]',
        'slug' => '#slug'
    ]),
```

```php
use MoonShine\Laravel\Http\Responses\MoonShineJsonResponse;
use MoonShine\Laravel\MoonShineRequest;

public function updateSomething(MoonShineRequest $request): MoonShineJsonResponse
{
    return MoonShineJsonResponse::make()
        ->toast($request->get('slug', 'Error'));
}
```

> [!WARNING]
> When using the `withSelectorsParams()` method, requests will be sent via `POST`.

#### Downloading

The called method can return `BinaryFileResponse`, allowing you to download a file.

```php
ActionButton::make('Download')->method('download')
```

```php
public function download(): BinaryFileResponse
{
    // ...

    return response()->download($file);
}
```

<a name="event"></a>
## Sending events

To send JavaScript events, you can use the `dispatchEvent()` method.

```php
dispatchEvent(array|string $events)
```

```php
ActionButton::make('Update')
    ->dispatchEvent(AlpineJs::event(JsEvent::TABLE_UPDATED, 'index-table')),
```

By default, when triggering events with a request, all query parameters (e.g., `?param=value`) from the `url` (specified when creating the `ActionButton`) will be sent.

You can exclude unnecessary ones via the `exclude` parameter:

```php
->dispatchEvent(
    AlpineJs::event(JsEvent::TABLE_UPDATED, 'index-table'),
    exclude: ['something']
)
```

You can also completely exclude sending with `withoutPayload`:

```php
->dispatchEvent(
    AlpineJs::event(JsEvent::TABLE_UPDATED, 'index-table'),
    withoutPayload: true
)
```

### URL query parameters

You can include the parameters of the current URL request (e.g., `?param=value`) in the request:

```php
->withQueryParams()
```

<a name="fill"></a>
## Filling with data

When working with `ModelResource`, action buttons `ActionButton` are usually automatically filled with the necessary data. This process happens "under the hood" using the `setData` method. Let's take a closer look at this mechanism.

```php
ActionButton::make('Button')->setData(?DataWrapperContract $data = null)
```

> [!NOTE]
> Read more about DataWrapperContract in the [TypeCasts](/docs/{{version}}/advanced/type-casts) section.

Methods with callbacks before and after filling the button are also available.

```php
ActionButton::make('Button')->onBeforeSet(fn(?DataWrapperContract $data, ActionButton $ctx) => $data)
```

```php
ActionButton::make('Button')->onAfterSet(function(?DataWrapperContract $data, ActionButton $ctx): void {
    // logic
})
```