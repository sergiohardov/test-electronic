# Пользовательский виджет для плагина Elementor

## Задача

Разработать пользовательский виджет `Post list` для плагина Elementor. Виджет должен выводить на страницу список постов, отсортированных по заданному критерию.

### Требования

Параметры виджета:

1. Способ выбора постов
2. Вид сортировки
3. Колличество постов
4. Список постов

### Способ выбора постов

Должно быть предусмотрено два варианта выбора постов:

1. Автоматический - посты выбираются автоматически.
2. Ручной - список формируется вручную через репитер.

Если значение установлено в `Автоматический`, то в форме виджета нужно отобразить контрол `Колличество постов` типа `text` . Значение по умолчанию равно 5. Этот параметр должен ограничивать колличесто выбираемых постов.

Если значение способа выбора постов установлено в `Ручной` , то на странице нужно скрыть контрол `Колличество постов` и отобразить контрол `Список постов` типа `Repiter` . Внутри репитера должен быть контрол для выбора поста.

### Способ сортировки постов

Способ сортировки должен задаваться через контрол виджета. Тип контрола не принципиален. Может быть radio или select. Список возможных значений (По убыванию даты публикации | По убыванию кол-ва просмотров). Значение по умолчанию `По убыванию даты публикации`.

### Html верстка списка

Верстка рендерера произвольная, но должны присутствовать следующие параметры.

1. Title поста заголовочным тегом (H2-H4)
2. Ссылка на пост (Read more)
3. Миниатюра поста
4. Картинка поста
5. Дата публикации
6. Автор

### Стили и скрипты

CSS стили должны быть вынесены в отдельный стилевой файл и подключаться только в том случае, если виджет присутствует на странице.

## Решение
Папку `elementor-posts-list-widget` поместить в .zip архив, и установить на странице плагинов WP.