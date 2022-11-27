<?php

namespace JalalLinuX\Setting\Facades;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use JalalLinuX\Setting\Services\SettingService;

/**
 * @see SettingService
 * 
 * @method self group(string $group = null)
 * @method self system()
 * @method self entity(Model $entity)
 * @method self model(string $class)
 * @method Collection getAttributes()
 * @method Builder makeQuery()
 * @method Collection get()
 * @method ?Setting first(string $key, bool $throw = false)
 * @method mixed firstValue(string $key, $default = null)
 * @method Setting set(string $key, $value)
 */
class Setting extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'setting';
    }
}
