<?php

namespace Glsv\SbisApi\vo;

enum SbisErrorCode: int
{
    case SERVER_ERROR = -1;
    case NO_LICENCE = 100;
    case PARAMS_NOT_SUPPORTED = 101;
    case FIELD_MUST_CONTENT_NUMBER = 102;
    case INCORRECT_DATE = 103;
    case LICENCE_TMP_NOT_AVAILABLE = 104;
    case REQUIRED_PARAMS_OMITTED = 105;
    case VALUE_NOT_SUPPORTED = 106;
    case VALUE_IS_EMPTY = 107;
    case NUMBER_SYMBOLS_EXCEEDED = 108;
    case FIELD_MUST_BE_STRING = 109;
    case FIELD_MUST_BE_INT_ARRAY = 110;
    case ALLOWED_RECEIVE_ONLY_N_TENDERS = 111;
    case INTERNAL_ERROR = 150;
    case LIMIT_DAY_TENDERS = 200;
    case LIMIT_DAY_TENDERS_REQUESTED = 201;
    case NO_SEARCH_REQUEST = 202;
    case NUMBER_TENDERS_EXCEEDED_REST = 203;
    case DIRECTORY_ABSENT = 204;
    case LIMIT_NUMBER_TENDERS_ONCE = 205;
    case LONG_TIME = 408;

    public function getLabel(): string
    {
        return match ($this) {
            self::SERVER_ERROR => 'Серверная ошибка',
            self::NO_LICENCE => 'Отсутствует лицензия на работу с API',
            self::PARAMS_NOT_SUPPORTED => 'Параметр не поддерживается',
            self::FIELD_MUST_CONTENT_NUMBER => 'Поле должно иметь тип «int»или «string» исодержатьчисло',
            self::INCORRECT_DATE => 'Некорректное значение даты. Дата должна быть в формате «YYYY-MM-DD HH:MM:SS»',
            self::LICENCE_TMP_NOT_AVAILABLE => 'Данные о лицензии временно недоступны',
            self::REQUIRED_PARAMS_OMITTED => 'Не передан обязательный параметр',
            self::VALUE_NOT_SUPPORTED => 'Параметр не поддерживает указанное значение',
            self::VALUE_IS_EMPTY => 'Значение параметра не может быть пустым',
            self::NUMBER_SYMBOLS_EXCEEDED => 'Количество символов в параметре не должно превышать указанного значения',
            self::FIELD_MUST_BE_STRING => 'Поле должно иметь тип string',
            self::FIELD_MUST_BE_INT_ARRAY => 'Поле должно иметь тип: массив int',
            self::ALLOWED_RECEIVE_ONLY_N_TENDERS => 'По запросу можно получить не более N торгов',
            self::INTERNAL_ERROR => 'Внутренняя ошибка сервиса ',
            self::LIMIT_DAY_TENDERS => 'Достигнут суточный лимит по получению торгов',
            self::LIMIT_DAY_TENDERS_REQUESTED => 'Запрашиваемый лимит по торгам превышает допустимый суточный лимит',
            self::NO_SEARCH_REQUEST => 'Отсутствует указанный поисковый запрос',
            self::NUMBER_TENDERS_EXCEEDED_REST => 'Запрошенное количество торгов превышает оставшееся доступное суточное количество торгов для выгрузки',
            self::DIRECTORY_ABSENT => 'Отсутствует папка с указанным именем',
            self::LIMIT_NUMBER_TENDERS_ONCE => 'Ограничение на количество получаемых торгов за один запрос',
            self::LONG_TIME => 'Долгое время выполнения запроса',
        };
    }
}