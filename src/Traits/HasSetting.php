<?php

namespace JalalLinuX\Setting\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use JalalLinuX\Setting\Models\Setting;
use Throwable;

trait HasSetting
{
    /**
     * Set setting for model
     *
     * @param  string  $key
     * @param  string  $group
     * @param $value
     * @return Model
     *
     * @author JalalLinuX
     */
    public function setSetting(string $key, $value, string $group = Setting::DEFAULT_GROUP): Model
    {
        $value = is_iterable($value) || is_array($value) || is_object($value) ? json_encode($value) : $value;

        $setting = \setting()->entity($this)->group($group);

        return $setting->set($key, $value);
    }

    /**
     * Fetch setting of model
     *
     * @param  string|null  $key
     * @param  string  $group
     * @return ?Setting|Collection
     *
     * @author JalalLinuX
     */
    public function getSetting(string $key = null, string $group = Setting::DEFAULT_GROUP)
    {
        $setting = \setting()->entity($this)->group($group);

        if (! is_null($key)) {
            return $setting->get($key);
        }

        return $setting->all();
    }

    /**
     * Set model setting
     *
     * @param  string  $key
     * @param  string  $group
     * @param $value
     * @return Model
     *
     * @throws Throwable
     *
     * @author JalalLinuX
     */
    public static function setModelSetting(string $key, $value, string $group = Setting::DEFAULT_GROUP): Model
    {
        $value = is_iterable($value) || is_array($value) || is_object($value) ? json_encode($value) : $value;

        $setting = \setting()->model(static::class)->group($group);

        return $setting->set($key, $value);
    }

    /**
     * Get model setting
     *
     * @param  string  $key
     * @param  string  $group
     * @return Setting|null
     *
     * @throws Throwable
     *
     * @author JalalLinuX
     */
    public static function getModelSetting(string $key, string $group = Setting::DEFAULT_GROUP): ?Setting
    {
        $setting = \setting()->model(static::class)->group($group);

        return $setting->get($key, true);
    }

    /**
     * Relation with setting model
     *
     * @return MorphMany
     *
     * @author JalalLinuX
     */
    public function settings(): MorphMany
    {
        return $this->morphMany(Setting::class, 'entity');
    }
}
