# Основы

Компоненты в **MoonShine** являются основой для построения интерфейса.  
В административной панели уже реализовано множество компонентов, которые можно разделить на несколько групп:
Системные, Декоративные и Метрики.

## Системные

Компоненты используются для создания основных блоков админ-панели:
- [Layout](/docs/{{version}}/components/system_layout)
- [Flash](/docs/{{version}}/components/system_flash)
- [Footer](/docs/{{version}}/components/system_footer)
- [Header](/docs/{{version}}/components/system_header)
- LayoutBlock, 
- LayoutBuilder, 
- Menu,
- [Profile](/docs/{{version}}/components/system_profile)
- [Search](/docs/{{version}}/components/system_search)
- [Sidebar](/docs/{{version}}/components/system_sidebar)
- [TopBar](/docs/{{version}}/components/system_top_bar).

## Декоративные

Компоненты используются для визуального оформления пользовательского интерфейса:
- [Block](/docs/{{version}}/components/decoration_block)
- [Collapse](/docs/{{version}}/components/decoration_collapse)
- [Divider](/docs/{{version}}/components/decoration_divider)
- [Flex](/docs/{{version}}/components/decoration_layout#flex)
- [FlexibleRender](/docs/{{version}}/components/decoration_flexible_render#FlexibleRender)
- [Fragment](/docs/{{version}}/components/decoration_fragment)
- [Grid](/docs/{{version}}/components/decoration_layout#grid-column)
- [Heading](/docs/{{version}}/components/decoration_heading)
- LineBreak,
- [Modal](/docs/{{version}}/components/decoration_modal)
- [Offcanvas](/docs/{{version}}/components/decoration_offcanvas)
- [Tabs](/docs/{{version}}/components/decoration_tabs)
- [When](/docs/{{version}}/components/decoration_when).

## Метрики

Компоненты используются для создания информационных блоков:
- [DonutChartMetric](/docs/{{version}}/components/metric_donut_chart)
- [LineChartMetric](/docs/{{version}}/components/metric_line_chart)
- [ValueMetric](/docs/{{version}}/components/metric_value).

Административная панель **MoonShine** не ограничивает вас в использовании других компонентов, которые могут быть реализованы с помощью
[**Livewire**](https://livewire.laravel.com/docs/quickstart),
а также компонентов [**Blade**](https://laravel.com/docs/10.x/blade#components).
