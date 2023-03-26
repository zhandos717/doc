<x-page title="Button">

<x-p>
    To add a button with a link to a form
</x-p>

<x-code language="php">
use Leeto\MoonShine\Decorations\Button;

//...
public function fields(): array
{
    return [
        Button::make(
            'Link to article',
            $this->getItem() ? route('articles.show', $this->getItem()) : '/',
            true
        )->icon('clip'),
    ];
}
//...
</x-code>

</x-page>
