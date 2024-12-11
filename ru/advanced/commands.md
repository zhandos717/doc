# Команды

- [Установка](#install)
- [Apply](#apply)
- [Компонент](#component)
- [Контроллер](#controller)
- [Поле](#field)
- [Обработчик](#handler)
- [Страница](#page)
- [Политика](#policy)
- [Ресурс](#resource)
- [Приведение типов](#type_cast)
- [Пользователь](#user)
- [Публикация](#publish)

---

> [!WARNING]
> Для выбора соответствующего пункта необходимо использовать клавишу `пробел`.

<a name="install"></a>
## Установка

Команда для установки пакета **MoonShine** в ваш проект *Laravel*:

```shell
php artisan moonshine:install
```

Доступные опции:

- `-u`, `--without-user` - без создания супер-пользователя;
- `-m`, `--without-migrations` - без выполнения миграций.

> [!NOTE]
> Для более подробной информации обратитесь к разделу [Установка](/docs/{{version}}/installation).

<a name="apply"></a>
## Apply

Команда для создания класса apply:

```shell
php artisan moonshine:apply
```

После выполнения команды в директории `app/MoonShine/Applies` будет создан файл. Созданный класс необходимо зарегистрировать в сервис-провайдере.

<a name="component"></a>
## Компонент

Команда создает пользовательский компонент:

```shell
php artisan moonshine:component
```

После выполнения команды в директории `app/MoonShine/Components` будет создан класс для компонента, а в директории `resources/views/admin/components` - файл *Blade*.

> [!NOTE]
> Для более подробной информации обратитесь к разделу [Компоненты](/docs/{{version}}/components/index).

<a name="controller"></a>
# Контроллер

Команда для создания контроллера:

```shell
php artisan moonshine:controller
```

После выполнения команды в директории `app/MoonShine/Controllers` будет создан класс контроллера, который можно использовать в маршрутах админ-панели.

> [!NOTE]
> Для более подробной информации обратитесь к разделу [Контроллеры](/docs/{{version}}/advanced/controller).

<a name="field"></a>
## Поле

Команда позволяет создать пользовательское поле:

```shell
php artisan moonshine:field
```

При выполнении команды можно указать, будет ли поле расширять базовый класс или другое поле.

После выполнения команды в директории `app/MoonShine/Fields` будет создан класс поля, а в директории `/resources/views/admin/fields` - файл *Blade*.

> [!NOTE]
> Для более подробной информации обратитесь к разделу [Поле](/docs/{{version}}/fields/index).

<a name="handler"></a>
## Обработчик

Команда создает класс Handler для собственных реализаций импорта и экспорта:

```shell
php artisan moonshine:handler
```

После выполнения команды в директории `app/MoonShine/Handlers` будет создан класс обработчика.

> [!NOTE]
> Для более подробной информации обратитесь к разделу [Импорт/Экспорт](/docs/{{version}}/resources/import_export).

<a name="page"></a>
## Страница

Команда создает страницу для админ-панели:

- `--crud` - создает группу страниц: индексную, детальную и форму;
- `--dir=` - директория, в которой будут располагаться файлы относительно `app/MoonShine`, по умолчанию Page;
- `--extends=` - класс, который будет расширять страница, например IndexPage, FormPage или DetailPage.

После выполнения команды в директории `app/MoonShine/Pages` будет создана страница по умолчанию (или группа страниц).

> [!NOTE]
> Для более подробной информации обратитесь к разделу [Страница](/docs/{{version}}/page/class).

<a name="policy"></a>
## Политика

Команда создает *Policy*, привязанную к пользователю админ-панели:

```shell
php artisan moonshine:policy
```

После выполнения команды в директории `app/Policies` будет создан класс.

> [!NOTE]
> Для более подробной информации обратитесь к разделу [Авторизация](/docs/{{version}}/advanced/authorization).

<a name="resource"></a>
## Ресурс

Команда для создания ресурсов:

```shell
php artisan moonshine:resource
```

Доступные опции:

- `--m|model=` - Eloquent модель для модельного ресурса;
- `--t|title=` - заголовок раздела;
- `--test` или `--pest` - дополнительно сгенерировать тестовый класс.

При создании *Resource* доступно несколько вариантов:

- **[Модельный ресурс по умолчанию](/docs/{{version}}/resources/fields#default)** - модельный ресурс с общими полями;
- **[Отдельный модельный ресурс](/docs/{{version}}/resources/fields#separate)** - модельный ресурс с разделением полей;
- **[Модельный ресурс со страницами](/docs/{{version}}/resources/pages)** - модельный ресурс со страницами;
- **Пустой ресурс** - пустой ресурс.

После выполнения команды в директории `app/MoonShine/Resources/` будет создан файл ресурса.
Если создается модельный ресурс со страницами, в директории `app/MoonShine/Pages` будут созданы дополнительные страницы.

> [!NOTE]
> Для более подробной информации обратитесь к разделу [Модельные ресурсы](/docs/{{version}}/resources/index).

<a name="type_cast"></a>
## Приведение типов

Команда создает класс TypeCast для работы с данными:

```shell
php artisan moonshine:type-cast
```

После выполнения команды в директории `app/MoonShine/TypeCasts` будет создан файл.

> [!NOTE]
> Для более подробной информации обратитесь к разделу [TypeCasts](/docs/{{version}}/advanced/type_casts).

<a name="user"></a>
## Пользователь

Команда, позволяющая создать супер-пользователя:

```shell
php artisan moonshine:user
```

Доступные опции:

- `--u|username=` - логин/email пользователя;
- `--N|name=` - имя пользователя;
- `--p|password=` - пароль.

<a name="publish"></a>
## Публикация

Команда для публикации:

```shell
php artisan moonshine:publish
```

Для публикации доступно несколько вариантов:

- **Assets** - ассеты админ-панели **MoonShine**;
- **[Assets template](/docs/{{version}}/appearance/assets#vite)** - создает шаблон для добавления собственных стилей в админ-панель **MoonShine**;
- **[Layout](/docs/{{version}}/appearance/layout_builder)** - класс MoonShineLayout, отвечающий за общий внешний вид админ-панели;
- **[Favicons](/docs/{{version}}/appearance/index#favicons)** - переопределяет шаблон для изменения фавиконок;
- **System Resources** - системные MoonShineUserResource, MoonShineUserRoleResource, которые вы можете изменить.

#### Вы можете сразу указать тип публикации в команде.

```shell
php artisan moonshine:publish assets
```

Доступные типы:
- assets
- assets-template
- layout
- favicons
- resources
