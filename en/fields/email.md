# E-mail

Extends [Text](/docs/{{version}}/fields/text)  
* has the same features  

The Email field is an extension of *Text*, which by default sets `type=email`.

```php
use MoonShine\Fields\Email;

//...

public function fields(): array
{
    return [
        Email::make('Email')
    ];
}

//...
```
