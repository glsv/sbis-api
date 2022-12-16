<?php

namespace Glsv\SbisApi\dto\factory;

use Glsv\SbisApi\exceptions\SbisApiRuntimeException;
use Glsv\SbisApi\interfaces\DtoFactoryInterface;

abstract class BaseDtoFactory implements DtoFactoryInterface
{
    /**
     * @var string[] Список атрибутов, которые исключить из автоматической обработки
     */
    protected static $excludeAttrs = [];

    /**
     * @var string[] Список атрибутов, которые в которые хранится DateTime в формате Y-m-d H:i:s
     */
    protected static $dateTimeAttrs = [];

    abstract protected static function getDto(): mixed;

    abstract protected static function getDtoFactoriesForGrouping(): array;

    abstract protected static function getDtoFactoriesForList(): array;

    abstract static function create(array $data): object;

    protected static function createInternal(array $data): mixed
    {
        $m = static::getDto();
        self::initAttrs($data, $m);

        return $m;
    }

    protected static function initAttrs(array $data, $dto): void
    {
        $classAttrs = get_class_vars(get_class($dto));

        $prefix4Grouping = static::getDtoFactoriesForGrouping();
        $factoryForLists = static::getDtoFactoriesForList();

        $grouping = [];

        foreach ($data as $attr => $value) {
            if (in_array($attr, static::$excludeAttrs)) {
                continue;
            }

            $itemListFactory = $factoryForLists[$attr] ?? null;
            if ($itemListFactory && is_array($value)) {
                foreach ($value as $itemValue) {
                    $dto->$attr[] = $itemListFactory::create($itemValue);
                }
                continue;
            }

            try {
                if (array_key_exists($attr, $classAttrs)) {
                    if (in_array($attr, static::$dateTimeAttrs)) {
                        $dto->$attr = \DateTime::createFromFormat("Y-m-d H:i:s", $value);
                    } else {
                        $dto->$attr = $value;
                    }
                    continue;
                }
            } catch (\TypeError $exc) {
                throw new SbisApiRuntimeException(
                    'Error in ' . static::class . '. ' . $exc->getMessage(),
                    $exc->getCode(),
                    $exc
                );
            }

            foreach ($prefix4Grouping as $prefix => $className) {
                $pos = strpos($attr, $prefix);
                if ($pos !== false) {
                    $grouping[$prefix][substr($attr, strlen($prefix))] = $value;
                }
            }
        }

        foreach ($grouping as $key => $data) {
            $factoryClassName = $prefix4Grouping[$key] ?? null;
            if ($factoryClassName) {
                $attr = substr($key, 0, -1);
                $dto->$attr = $factoryClassName::create($data);
            }
        }
    }
}