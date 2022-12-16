# Назначение
Обертка для работы с API [online.sbis.ru](https://online.sbis.ru/).
- Валидирует http-коды ответа и правильность возвращаемой структуры;
- Формализует использование через работу с абстракциями команд и результатов выполнения оформленных в виде DTO;

## Установка

```shell
composer require glsv/sbis-api
```

## Зависимости
- PHP 8.1+
- [guzzlehttp/guzzle](https://github.com/guzzle/guzzle/)

## Использование
### 1. Получение списка тендеров по названию шаблона 
```
<?php

use Glsv\SbisApi\commands\GetTenderListCommand;
use Glsv\SbisApi\requests\GetTenderListRequest;
use Glsv\SbisApi\SbisClientApi;

$baseUrl = 'https://online.sbis.ru/tender-api/service/';
$token = '00d412f4-01365ff8-0bba-56bc140dca0XXXXX';

$api = new SbisClientApi($baseUrl, $token);

// Название шаблона поиска. Должно быть создано в ЛК Sbis
$templateName = 'Тест';

// Формируем запрос к команде через специальный DTO
$request = new GetTenderListRequest($templateName);

// Меняем кол-во запрашиваемых тендеров
$request->limit = 100;

// Формируем команду
$command = new GetTenderListCommand($api, $request);

// Выполняем команду и получаем формалированный response
$response = $command->execute();

var_dump($response);
```

### Результаты
Команда `GetTenderListCommand()` возвращает объект класса `GetTenderListResponse` 
с типизированными атрибутами
```
Glsv\SbisApi\responses\GetTenderListResponse Object
(
    [tenders] => Array
        (
            [0] => Glsv\SbisApi\dto\TenderDto Object
                (
                    [categories] => Array
                        (
                            [0] => Проектирование и документация
                            [1] => Строительство
                        )

                    [contact] => Glsv\SbisApi\dto\TenderContactDto Object
                        (
                            [email] => name@xyz.com
                            [person_name] => Фамилия Лариса Павловна
                            [phone] => 7-8888-21111
                        )

                    [initiator] => Glsv\SbisApi\dto\OrganizationDto Object
                        (
                            [inn] => 8817020024
                            [kpp] => 881701001
                            [full_name] => УПРАВЛЕНИЕ ПО МУНИЦИПАЛЬНОМУ ИМУЩЕСТВУ МЦЕНСКОГО РАЙОНА
                            [name] => УМИ Мценского Района
                            [ogrn] => 1025702656044
                        )

                    [organizer] => Glsv\SbisApi\dto\OrganizationDto Object
                        (
                            [inn] => 9917020024
                            [kpp] => 991701001
                            [full_name] => УПРАВЛЕНИЕ ПО МУНИЦИПАЛЬНОМУ ИМУЩЕСТВУ МЦЕНСКОГО РАЙОНА
                            [name] => УМИ Мценского Района
                            [ogrn] => 1025702656000
                        )

                    [tender] => Glsv\SbisApi\dto\TenderMetaDto Object
                        (
                            [platform_name] => ЕИС на бумаге (44)
                            [platform_type] => Закупка 44-ФЗ
                            [sbis_url] => https://online.sbis.ru/page/tender-card/158723800
                            [url] => https://zakupki.gov.ru/epz/pricereq/card/common-info.html?priceRequestId=1173300
                        )

                    [docs] => Array
                        (
                            [0] => Glsv\SbisApi\dto\DocumentDto Object
                                (
                                    [description] => Запрос КП ПСД плотина д. XXX
                                    [external_url] => https://zakupki.gov.ru/44fz/filestore/public/1.0/download/pricereq/file.html?uid=EF123AE5E9BF5539E05334548D0AF100
                                    [filename] => Запрос КП ПСД плотина д. XXX.pdf
                                    [sbis_url] => http://online.sbis.ru/fs-auth/tender_files/8f231b2e-6e84-41a1-9437-04b55688bf00
                                )

                        )

                    [id] => 158723876
                    [last_modified_date] => DateTime Object
                        (
                            [date] => 2022-12-06 02:57:10.000000
                            [timezone_type] => 3
                            [timezone] => Europe/Moscow
                        )

                    [lots] => Array
                        (
                            [0] => Array
                                (
                                    [items] => Array
                                        (
                                            [0] => Array
                                                (
                                                    [name] => Проектно-сметная документация на проведение капитального ремонта сооружения (плотина пруда), расположенного в д. XXX Мценского района...
                                                    [number] => 1
                                                    [okei_code] => 796
                                                    [okei_name] => Штука
                                                    [okpd2] => Array
                                                        (
                                                            [0] => Array
                                                                (
                                                                    [code] => 71.12.19.100
                                                                    [name] => Услуги по инженерно-техническому проектированию прочих объектов...
                                                                )

                                                        )

                                                    [quantity] => 1
                                                )

                                        )

                                    [name] => Разработка проектно-сметной документации на проведение капитального ремонта сооружения (плотина пруда), расположенного в д. XXX Мценского района...
                                )

                        )

                    [name] => Разработка проектно-сметной документации на проведение капитального ремонта сооружения (плотина пруда), расположенного в д. XXX Мценского района...
                    [number] => 9354300021322000001_1
                    [publish_date] => DateTime Object
                        (
                            [date] => 2022-12-05 13:37:01.000000
                            [timezone_type] => 3
                            [timezone] => Europe/Moscow
                        )

                    [sbis_publish_date] => DateTime Object
                        (
                            [date] => 2022-12-06 02:57:10.000000
                            [timezone_type] => 3
                            [timezone] => Europe/Moscow
                        )

                    [tender_date] => 
                    [request_receiving_date] => DateTime Object
                        (
                            [date] => 2022-12-06 08:00:00.000000
                            [timezone_type] => 3
                            [timezone] => Europe/Moscow
                        )

                    [request_receiving_end_date] => DateTime Object
                        (
                            [date] => 2022-12-12 10:00:00.000000
                            [timezone_type] => 3
                            [timezone] => Europe/Moscow
                        )

                    [region] => Орловская обл
                    [region_code] => 57
                    [status] => Glsv\SbisApi\vo\TenderStatus Enum:string
                        (
                            [name] => ACCEPTING_ORDERS
                            [value] => acceptingOrders
                        )

                    [type] => Запросы цен товаров, работ, услуг
                    [currency] => Glsv\SbisApi\vo\Currency Enum:string
                        (
                            [name] => RUB
                            [value] => RUB
                        )

                    [price] => 2340996
                    [prepayment_percent] => 
                )

        )

    [count] => 1
)
```