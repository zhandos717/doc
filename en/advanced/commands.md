/docs/{{version}}/advanced/commands?_lang=en

------

# Commands

- [Install](#install)
- [Apply](#apply)
- [Component](#component)
- [Controller](#controller)
- [Field](#field)
- [Handler](#handler)
- [Page](#page)
- [Policy](#policy)
- [Resource](#resource)
- [Type cast](#type_cast)
- [User](#user)
- [Publish](#publish)

> [!WARNING]
> To select the appropriate item, you must use the `space` key.

<a name="install"></a>
## Install

Command to install the **MoonShine** package in your *Laravel* project:

```shell
php artisan moonshine:install
```

Available options:

- `-u`, `--without-user` - without creating a super user;
- `-m`, `--without-migrations` - without performing migrations.

> [!NOTE]
> For more detailed information, please refer to the section [Installation](/docs/{{version}}/installation).

<a name="apply"></a>
## Apply

The command to create the apply class is:

```shell
php artisan moonshine:apply
```

After executing the command, a file will be created in the `app/MoonShine/Applies` directory. The created class must be registered with the service provider.

<a name="component"></a>
## Component

The command creates a custom component:

```shell
php artisan moonshine:component
```

After executing the command, a class for the component will be created in the `app/MoonShine/Components` directory and *Blade* file in the `resources/views/admin/components` directory.

> [!NOTE]
> For more detailed information, please refer to the section [Components](/docs/{{version}}/components/index).

<a name="controller"></a>
# Controller

Command to create a controller:

```shell
php artisan moonshine:controller
```

After executing the command, a controller class will be created in the `app/MoonShine/Controllers` directory. Which can be used in admin panel routes.

> [!NOTE]
> For more detailed information, please refer to the section [Controllers](/docs/{{version}}/advanced/controller).

<a name="field"></a>
## Field

The command allows you to create a custom field:

```shell
php artisan moonshine:field
```

When executing the command, you can specify whether the field will extend the base class or another field.

After executing the command, a field class will be created in the `app/MoonShine/Fields` directory and *Blade* file in the directory `/resources/views/admin/fields`.

> [!NOTE]
> For more detailed information, please refer to the section [Field](/docs/{{version}}/fields/index).

<a name="handler"></a>
## Handler

The command creates a Handler class for its import and export implementations:

```shell
php artisan moonshine:handler
```

After executing the command, the handler class will be created in the directory `app/MoonShine/Handlers`.

> [!NOTE]
> For more detailed information, please refer to the section [Import/Export](/docs/{{version}}/resources/import_export).

<a name="page"></a>
## Page

The command creates a page for the admin panel:

- `--crud` - creates a group of pages: index, detail and form page;
- `--dir=` - the directory in which the files will be located relative to `app/MoonShine`, default Page;
- `--extends=` - a class that the page will extend, for example IndexPage, FormPage or DetailPage.

After executing the command, a default page (or group of pages) will be created in the directory `app/MoonShine/Pages`.

> [!NOTE]
> For more detailed information, please refer to the section [Page](/docs/{{version}}/page/class).

<a name="policy"></a>
## Policy

The command creates a *Policy* bound to the admin panel user:

```shell
php artisan moonshine:policy
```

After executing the command, a class will be created in the `app/Policies` directory.

> [!NOTE]
> For more detailed information, please refer to the section [Authorization](/docs/{{version}}/advanced/authorization).

<a name="resource"></a>
## Resource

Command to create resources:

```shell
php artisan moonshine:resource
```

Available options:

- `--m|model=` - Eloquent model for model resource;
- `--t|title=` - section title;
- `--test` or `--pest` - additionally generate a test class.

There are several options available when creating a *Resource*:

- **[Default model resource](/docs/{{version}}/resources/fields#default)** - model resource with common fields;
- **[Separate model resource](/docs/{{version}}/resources/fields#separate)** - model resource with field separation;
- **[Model resource with pages](/docs/{{version}}/resources/pages)** - model resource with pages;
-**Empty resource** - empty resource.

After executing the command, a resource file will be created in the `app/MoonShine/Resources/` directory.
If a model resource with pages is created, additional pages will be created in the directory `app/MoonShine/Pages`.

> [!NOTE]
> For more detailed information, please refer to the section [Models Resorces](/docs/{{version}}/resources/index).

<a name="type_cast"></a>
## Type Cast

The command creates a TypeCast class for working with data:

```shell
php artisan moonshine:type-cast
```

After executing the command, a file will be created in the `app/MoonShine/TypeCasts` directory.

> [!NOTE]
> For more detailed information, please refer to the section [TypeCasts](/docs/{{version}}/advanced/type_casts).

<a name="user"></a>
## User

The command that allows you to create a super user:

```shell
php artisan moonshine:user
```

Available options:

- `--u|username=` - user login/email;
- `--N|name=` - user name;
- `--p|password=` - password.

<a name="publish"></a>
## Publish

Command for publish:

```shell
php artisan moonshine:publish
```

There are several options available for publishing:

- **Assets** - **MoonShine** admin panel assets;
- **[Assets template](/docs/{{version}}/appearance/assets#vite)** - creates a template for adding your own styles to the **MoonShine** admin panel;
- **[Layout](/docs/{{version}}/appearance/layout_builder)** - MoonShineLayout class, responsible for the general appearance of the admin panel;
- **[Favicons](/docs/{{version}}/appearance/index#favicons)** - overrides the template for changing favicons;
- **System Resources** - system MoonShineUserResource, MoonShineUserRoleResource, which you can change.

#### You can immediately specify the publication type in the command.

```shell
php artisan moonshine:publish assets
```

Available types:
- assets
- assets-template
- layout
- favicons
- resources
