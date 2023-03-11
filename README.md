# Тестовое задание

REST API на базе Yii 2

## Собственно API:

**POST /client/new** Создает нового клиента, JSON в запросе:
*{
	"firstname": "Иван",
	"lastname": "Иванов",
	"email": "aaa@yandex.ru",
	"birthdate": "1980-08-12"
}*

**GET /client/[id]** Возвращает данные по клиенту

**GET /client/[id]/ordered** Возвращает список всех продуктов из всех заказов клиента

**POST /product/new** Создает новый продукт, JSON в запросе:
{
	"name": "product1",
	"price": 100.23,
	"description": "asdadasdfsdfsdfgdg"
}

**GET /product/[id]** Возвращает данные по продукту (данные кэшируются в redis)

**POST /order/new** Создает новый заказ, JSON в запросе:
 {
	"clientId": 1,
	"products": [1, 2, 3]
}
