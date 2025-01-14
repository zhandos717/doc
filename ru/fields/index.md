# Основы

- [Концепция](#concept)
- [Режим по умолчанию](#default-mode)
- [Режим Preview](#preview-mode)
- [Режим Raw](#raw-mode)
- [Изменить preview](#change-preview)
- [Изменить наполнение](#change-fill)
- [Смена режима отображения](#change-mode)
- [Процесс применения полей](#apply)

---

<a name="concept"></a>
## Концепция
Полям отводится важнейшая роль в админ-панели **MoonShine**.
Они используются в `FormBuilder` для построения форм, в `TableBuilder` для создания таблиц, а также в формировании фильтра для `ModelResource` (CrudResource). Их можно использовать в ваших кастомных страницах и даже вне админ-панели как в виде объектов, так и непосредственно в blade.

Поля являются элементами формы, поэтому их состояние по умолчанию при рендере является просто html элементом формы.

Создать экземпляр поля очень просто, для этого есть удобный метод `make` и для базового использования достаточно указать label и name поля.

```php
Text::make('Title')
Text::make('Title', 'title')
```

Чаще всего поля используются внутри FormBuilder, где за счет самого FormBuilder они на основе реквеста могут изменять исходный объект.

Сложность понимания полей MoonShine обусловлена наличием нескольких визуальных состояний.

<a name="default-mode"></a>
## По умолчанию

Просто элемент формы, скажем если мы говорим о поле Text, то его визуальное состояние будет `input type="text"`.

<a name="preview-mode"></a>
## Режим Preview

Второй режим служит для отображения значения поля. При выводе поля через TableBuilder, нам не нужно его редактировать, мы просто хотим показать его содержимое. Давайте рассмотрим поле Image, его `preview` вид будет иметь `img` миниатюру или карусель изображений если режим multiple.

Тем самым каждое поле выглядит по разному как и разнообразие элементов формы, но также и выглядят по разному в режиме preview так как у них разные назначения.

Это имеет преимущество в том, что нам, разработчикам, не нужно беспокоиться о том, как отобразить, например, поле Date. Под капотом MoonShine выполнит форматирование, экранирует текстовые поля для обеспечения безопасности или просто сделает вывод более эстетичным.

<a name="raw-mode"></a>
## Режим Raw

Возможно при использовании панели вам и не доведется использовать этот режим, но суть его в том что он просто выведет значение поля, которое было ему присвоено изначально, без дополнительных модификаций.

Режим идеально подходит для экспорта, чтобы в итоге отобразить исходное содержимое для дальнейшего импорта.

В процессе объявления полей вы можете менять визуальные состояния каждого из них, но прежде чем мы взглянем на примеры, давайте кратко рассмотрим базовый цикл жизни поля.

**Цикл через FormBuilder**
- Поле объявлено в ресурсе
- Поле попадает в FormBuilder
- FormBuilder наполняет поле
- FormBuilder рендерит поле
- При реквесте FormBuilder вызывает поля и сохраняет за счет них исходный объект

**Цикл через TableBuilder**
- Поле объявлено в ресурсе
- Поле попадает в TableBuilder
- TableBuilder включает поле в режим Preview
- TableBuilder итерирует исходные данные и трансформирует их в TableRow предварительно наполнив каждое поле данными
- TableBuilder рендерит себя и каждый свой row вместе с полями

**Цикл через экспорт**
- Поле объявлено в ресурсе в методе для экспорта
- Поле попадает в Handler
- Handler включает поле в режим Raw
- Handler итерирует исходные данные, наполняет ими поля и генерирует таблицу для экспорта на основе сырых значений полей


Поля в **MoonShine** не привязаны к модели (за исключением поля Slug и полей отношений), поэтому спектр их применения ограничивается только вашей фантазией.

В процессе взаимодействия с полями вы можете столкнуться с рядом задач по их модификации, все они будут связаны с циклами и состояниями описанными выше, рассмотрим их.

<a name="change-preview"></a>
## Изменить preview

Вы используете поле Select c опциями ссылками на изображения и хотите в режиме preview выводить не ссылки а сразу рендерить изображения, ваш код будет выглядеть следующим образом, а результат будет достигнут за счет метода changePreview:

```php
Select::make('Links')->options([
    '/images/1.png' => 'Picture 1',
    '/images/2.png' => 'Picture 2',
])
    ->multiple() // Поле может иметь несколько значений
    ->fill(['/images/1.png', '/images/2.png']) // Мы наполнили поле, указали какие значения выбраны
    ->changePreview(
        fn(?array $values, Select $ctx) => Carousel::make($values)
    ) // изменили состояние preview
```

В итоге вы получите карусель изображений на основе значений Select, вы можете вернуть компонент или любую строку.

<a name="change-fill"></a>
## Изменить наполнение

В процессе мы также сталкнулись с методом fill и наполнили поле, но если мы используем его в готовом ModelResource или FormBuilder, то поле будет наполнено за нас и вызванный нами fill будет перезаписан, поэтому в ваших задачах может возникнуть ситуация когда вам потребуется изменить логику наполнения, интегрироваться в этот процесс, для этого вам помогут методы `changeFill` и `afterFill`.

Давайте рассмотрим всё тот же пример с Select и изображениями, но при этом преобразуем относительный путь в полный URL.

В данном случае наполнение происходит автоматически, эти действия сделает за нас FormBuilder и ModelResource, мы же только изменим процесс:

```php
Select::make('Images')->options([
    '/images/1.png' => 'Picture 1',
    '/images/2.png' => 'Picture 2',
])
    ->multiple()
    ->changeFill(
        fn(Article $data, Select $ctx) => $article->images
            ->map(fn($value) => "https://cutcode.dev$value")
            ->toArray()
    )
    ->changePreview(
        fn(?array $values, Select $ctx) => Carousel::make($values)
    ),
```

Данный метод принимает полный объект, который был передан FormBuilder в поля и поскольку мы рассматривали контекст с ModelResource, то исходные данные у нас были `Model` - `Article`.

В процессе мы вернули значения, необходимые для поля, но изменив содержимое, changePreview мы взяли из предыдущего шага для демонстрации результата.

Давайте рассмотрим ещё один пример наполнения. Допустим, нам с вами нужно при выводе Select в таблицу проверить его значение на определенное условие и добавить класс на ячейку, если оно выполнено, поэтому нам нужно с вами получить итоговое значение, которым наполнен Select, и нам важно, чтобы наполнение обязательно уже произошло (так как условный метод `when` вызывается до наполнения и нам не подходит).


```php
Select::make('Links')->options([
    '/images/1.png' => 'Picture 1',
    '/images/2.png' => 'Picture 2',
])
    ->multiple()
    ->afterFill(
        function(Select $ctx) {
            if(collect($ctx->toValue())->every(fn($value) => str_contains($value, 'cutcode.dev'))) {
                return $ctx->customWrapperAttributes(['class' => 'full-url']);
            }

            return $ctx;
        }
    )
    ->changePreview(
        fn(?array $values, Select $ctx) => Carousel::make($values)
    ),
```

Построитель полей обладает широкими возможностями и вы можете менять любые состояния прям на лету, давайте рассмотрим редкий случай изменения визуального состояния по умолчанию, хотя мы и не рекомендуем этого делать и лучше будет создать отдельный класс поля для этих задач, чтобы вынести логику и переиспользовать поле в дальнейшем.

Но всё же представим, что из поля Select по каким-то причинам мы хотим сделать поле Text:

```php
Select::make('Links')->options([
    '/images/1.png' => 'Picture 1',
    '/images/2.png' => 'Picture 2',
])
    ->multiple()
    ->changeRender(
        fn(?array $values, Select $ctx) => Text::make($ctx->getLabel())->fill(implode(',', $values))
    )
```

<a name="change-mode"></a>
## Смена режима отображения

Как мы уже поняли, поля имеют разные визуальные состояния и в FormBuilder по умолчанию это будет элемент формы, в TableBuilder различное отображение значения, а скажем в экспорте просто исходное значение.

Но давайте представим ситуацию, что нам необходимо в TableBuilder вывести поле не в preview режиме а в режиме по умолчанию или наоборот внутри FormBuilder вывести в preview режиме или вообще в исходном:

```php
Text::make('Title')->defaultMode()
```

Независимо от того где мы будем выводить это поле, оно всегда будет в режиме по умолчанию в виде элемента формы:

```php
Text::make('Title')->previewMode()
```

То же самое, только всегда будет в режиме preview.

Ну и режим с исходным состоянием напоследок:

```php
Text::make('Title')->rawMode()
```

Раз уж мы с вами затронули тему `rawMode` и уже обсуждали процесс изменения наполнения, давайте также взглянем на метод, который позволяет модифицировать исходное значение. Пример - мы используем поле для экспорта и нам не нужно выполнять последующий импорт, необходимо отобразить значение для менеджера в понятном формате:

```php
BelongsTo::make('User')->modifyRawValue(fn(int $rawUserId, Article $model, BelongsTo $ctx) => $model->user->name)
```

Давайте также представим ситуацию, что вам необходимо делать экспорт в понятном для менеджеров формате, но при этом также в дальнейшем импортировать этот файл и, каким бы MoonShine не был умным, он не поймет, что значение "Иван Иванов" нужно найти в таблице users по полю name и взять только id, но мы с вами можем решить эту задачу:

```php
BelongsTo::make('User')->fromRaw(fn(string $name) => User::where('name', $name)->value('id'))
```

<a name="apply"></a>
## Процесс применения полей

Мы уже сами знаем, что поля работают с любыми данными и это необязательно `Model`, но поля могут также модифицировать исходные поступающие в них данные, по простому это можно назвать `сохранением` но мы не используем изначально этот термин, так как не всегда поля сохраняют, скажем, исходными данными может быть QueryBuilder а поля будут выступать в роли фильтров и тогда они будут модифицировать запрос QueryBuilder или любой другой кейс, поэтому правильнее будет сказать "применяются" (apply).

**Цикл жизни применения поля (на примере сохранения модели)**

- FormBuilder принимает исходный объект, пусть это будет модель User
- Итерирует поля передавая в них объект User и вызывая метод поля apply
- Поля внутри apply берут значение из реквеста на основе своего свойства column
- Поля на основе своего свойства column модифицируют это поле модели User и возвращают её обратно
- После FormBuilder вызовет метод save модели
- Также до apply метода поля будет вызван метод beforeApply если требуется что-нибудь сделать с объектом до основного применения
- После метода save модели у полей будет вызван метод afterApply (что в данном кейсе хорошо подойдет для полей отношений, чтобы у них был исходный объект который уже сохранен в бд)

**Цикл жизни применения поля (на примере фильтрации)**

- FormBuilder принимает исходный объект QueryBuilder
- Итерирует поля передавая в них объект QueryBuilder и вызывая метод поля apply
- Поля на основе своего свойства column модифицируют QueryBuilder и возвращают его обратно
- После объект QueryBuilder будет использован при выводе данных

В результате полученных знаний и использования MoonShine в реальных условиях вы можете столкнуться с ситуацией когда вам будет необходимо изменить логику применения или добавить логику после или до основного применения поля.

Построитель полей позволяет легко достичь этих целей на лету:

```php
Text::make('Thumbnail by link', 'thumbnail')
	->onApply(function(Model $item, $value, Text $field) {
		$path = 'thumbnail.jpg';

		if ($value) {
			$item->thumbnail = Storage::put($path, file_get_contents($value));
		}

		return $item;
	}
)
```

Тем самым мы просто добавили ссылку в текстовое поле, но не сохранили её как есть, а загрузили и положили в storage и вернули итоговый путь.

Также нам доступны методы `onBeforeApply` и `onAfterApply`.

Далее давайте взглянем на интерфейс полей более детально, а также на каждое поле отдельно.
