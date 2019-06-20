
## Описание/структура компонентов ##

[News (Комплексный компонент)](https://dev.1c-bitrix.ru/user_help/components/content/articles_and_news/news.php)  
├── News.List   - [Список записей инфоблока](https://dev.1c-bitrix.ru/user_help/components/content/articles_and_news/news_list.php)  
├── News.Detail - [Детальное представление записи](https://dev.1c-bitrix.ru/user_help/components/content/articles_and_news/news_detail.php)  
├── Search.Page - [Страница с результатами поиска](https://dev.1c-bitrix.ru/user_help/components/sluzhebnie/search/search_page.php)  
└── Search.Form - [Форма ввода поисковой фразы](https://dev.1c-bitrix.ru/user_help/components/sluzhebnie/search/search_form.php)  

[Catalog (Комплексный компонент)](//dev.1c-bitrix.ru/user_help/components/content/catalog/catalog.php)  
├── Catalog.Section.List - [Список разделов](https://dev.1c-bitrix.ru/user_help/components/content/catalog/catalog_section_list.php)  
├── Catalog.Section      - [Список товаров](//dev.1c-bitrix.ru/user_help/components/content/catalog/catalog_section.php)  
├── Catalog.Item         - Товар (Представление в списке)  
├── Catalog.Element      - [Товар (Представление товара с детальной/подробной информацией)](https://dev.1c-bitrix.ru/user_help/components/content/catalog/catalog_element.php)  
└── Catalog.Filter       - [Фильтр по элементам](https://dev.1c-bitrix.ru/user_help/components/content/catalog/catalog_filter.php)  

Sale.Basket.Basket       - [Корзина](https://dev.1c-bitrix.ru/user_help/components/magazin/basket/sale_basket_basket.php) ([Отличная статья по D7 от mr.cappuccino](https://mrcappuccino.ru/blog/post/work-with-basket-bitrix-d7))  

Sale.Order.Ajax          - [Подтверждение заказа](https://dev.1c-bitrix.ru/user_help/components/magazin/zakaz/sale_order_ajax.php) ([Кастомизация нового шаблона компонента от OlegPro](https://www.olegpro.ru/post/1c_bitriks_kastomizaciya_novogo_shablona_komponenta_saleorderajax.html))  

Sale.Personal.Order:      - [Персональная информация (/personal/order/)](https://dev.1c-bitrix.ru/user_help/components/magazin/profiles/sale_personal_order.php)
Sale.Personal.Order.List: - [Список заказов](https://dev.1c-bitrix.ru/user_help/components/magazin/profiles/sale_personal_order_list.php)  

* - Комплексный компонент (Обертка запускающая/связывающая под-компоненты)
