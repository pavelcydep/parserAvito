
# Парсер для авито  
## Требования заказчика
### требуется написать парсер объявлений на авито, который собирает следующие параметры

1) дата публикации обьявлений
2) кол-во просмотров объявлений на момент парсинга
3) тип обьяаления (часное, коммерческое и т.п)
4) если возможно - были ли применены платные услуги продвижения

таргеты
1) ГЕО
2) категория
3) подкатегория

и далее по итогам парсинга выдает отчет с фильтрами и ссылками на объявления

Чтоб задача была более ясной опишу сценарий использования

1) выбираем город, категорию, подкатегорию и запускаем парсер
2) парсер сканирует всю подкатегорию в рамках заданного гео и выдает отчет (возможно в виде таблицы xls)
3) Таблица отсортирована по релевантности/ индексу - соотношения даты публикации к кол-ву просмотров
4) в таблице отминусованы объявлений поданные ранее 2х дней с момента парсинга
5) так же можно выбрать показ строк только:
- с частными
- коммерческими
### ПАРСЕР ЕЩЕ НЕ ДОРАБОТАН