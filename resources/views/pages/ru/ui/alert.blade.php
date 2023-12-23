<x-page title="Alert" :sectionMenu="[
    'Разделы' => [
        ['url' => '#basics', 'label' => 'Основы'],
        ['url' => '#type', 'label' => 'Тип уведомления'],
        ['url' => '#icon', 'label' => 'Иконка'],
        ['url' => '#removable', 'label' => 'Удаление уведомлений'],
    ]
]">

<x-sub-title id="basics">Основы</x-sub-title>

<x-p>
    Если вам необходимо уведомление на странице,
    можно воспользоваться компонентом <code>moonshine::alert</code>.
</x-p>

<x-code language="blade" file="resources/views/examples/components/alert.blade.php"></x-code>

@include("examples/components/alert")

<x-sub-title id="type">Тип уведомления</x-sub-title>

<x-p>
    Изменить тип уведомления можно указав у компонента <code>type</code>.
</x-p>

@include('pages.ru.ui.shared.type')

<x-code language="blade" file="resources/views/examples/components/alert-type.blade.php"></x-code>

@include("examples/components/alert-type")

<x-sub-title id="icon">Иконка</x-sub-title>

<x-p>
    Есть возможность у уведомления изменить иконку, для этого необходимо передать её в параметр <code>icon</code>.
</x-p>

<x-code language="blade" file="resources/views/examples/components/alert-icon.blade.php"></x-code>

@include("examples/components/alert-icon")

<x-moonshine::alert type="default" icon="heroicons.book-open">
    За более подробной информацией, обратитесь к разделу
    <x-link link="{{ route('moonshine.page', 'icons') }}">Icons</x-link>.
</x-moonshine::alert>

<x-sub-title id="removable">Удаление уведомлений</x-sub-title>

<x-p>
    Чтобы удалять уведомления через некоторое время, необходимо передать параметр <code>removable</code>
    со значением <code>TRUE</code>.
</x-p>

<x-code language="blade" file="resources/views/examples/components/alert-removable.blade.php"></x-code>

@include("examples/components/alert-removable")

</x-page>
