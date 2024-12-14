# Logo

Компонент `Logo` отображает логотип вашей админ-панели.

Вы можете создать `Logo`, используя статический метод `make()`.

```php
make(
    string $href,
    string $logo,
    ?string $logoSmall = null,
    ?string $title = null,
    bool $minimized = false,
)
```

 - $href - ссылка на ресурс по клику на логотип,
 - $logo - ссылка на изображения логотипа,
 - $logoSmall - ссылка на уменьшенную версию логотипа,
 - $title - подсказа при наведении,
 - $minimized - применение специальных стилей для отображения лого в меню.

Лого используется в `BaseLayout` и создается в методе `getLogoComponent`.

```php
abstract class BaseLayout extends AbstractLayout
{
    //...
    
    protected function getLogoComponent(): Logo
    {
        return Logo::make(
            $this->getHomeUrl(),
            $this->getLogo(),
            $this->getLogo(small: true),
        );
    }
}
```

~~~tabs
tab: Class
```php
use MoonShine\UI\Components\Layout\Logo;

Logo::make(
    '/admin',
    '/vendor/moonshine/logo.svg',
    '/vendor/moonshine/logo-small.svg'
),
```
tab: Blade
```blade
<x-moonshine::layout.logo
    :href="'/admin'"
    :logo="'/vendor/moonshine/logo.svg'"
    :logoSmall="'/vendor/moonshine/logo-small.svg'"
/>
```
~~~