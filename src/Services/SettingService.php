<?php

namespace JalalLinuX\Setting\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use JalalLinuX\Setting\Models\Setting;
use Throwable;

class SettingService
{
    private Builder $query;
    private array $attributes;

    /**
     * Class constructor
     * @author JalalLinuX
     */
    public function __construct()
    {
        $this->query = Setting::query();
        $this->attributes = ['group' => Setting::DEFAULT_GROUP];
    }

    /**
     * Set setting group name
     * @param string|null $group
     * @return self
     * @author JalalLinuX
     */
    public function group(string $group = null): self
    {
        $this->attributes['group'] = $group ?? Setting::DEFAULT_GROUP;
        return $this;
    }

    /**
     * Set setting systematic
     * @return self
     * @author JalalLinuX
     */
    public function system(): self
    {
        $this->attributes['entity_id'] = null;
        return $this;
    }

    /**
     * Set setting entity
     * @param Model $entity
     * @return self
     * @author JalalLinuX
     */
    public function entity(Model $entity): self
    {
        $this->attributes['entity_type'] = get_class($entity);
        $this->attributes['entity_id'] = $entity->getKey();
        return $this;
    }

    /**
     * Set setting class model
     * @param string $class
     * @return $this
     * @throws Throwable
     * @author JalalLinuX
     */
    public function model(string $class): SettingService
    {
        throw_unless(class_exists($class), new \Exception("Class or namespace \"{$class}\" does not exists"));
        $this->attributes['entity_type'] = $class;
        $this->attributes['entity_id'] = null;
        return $this;
    }

    /**
     * Get current attributes of setting query
     * @return Collection
     * @author JalalLinuX
     */
    public function getAttributes(): Collection
    {
        return collect($this->attributes);
    }

    /**
     * Make final query builder with current attributes
     * @return Builder
     * @author JalalLinuX
     */
    public function makeQuery(): Builder
    {
        foreach ($this->getAttributes()->map(fn($v, $k) => [$k, $v])->values() as $condition) {
            is_null($condition[1])
                ? $this->query->whereNull($condition[0])
                : $this->query->where(...$condition);
        }
        return $this->query;
    }

    /**
     * Get setting multiple or single of key
     * @return Collection
     * @author JalalLinuX
     */
    public function get(): Collection
    {
        return $this->makeQuery()->get();
    }

    /**
     * Get first of setting find with current attributes
     * @param string $key
     * @param bool $throw
     * @return Setting|null
     * @author JalalLinuX
     */
    public function first(string $key, bool $throw = false): ?Setting
    {
        $this->attributes['key'] = $key;
        return $this->makeQuery()->{$throw ? 'firstOrFail' : 'first'}();
    }

    /**
     * Get first value of specific setting key
     * @param string $key
     * @param null $default
     * @return mixed
     * @author JalalLinuX
     */
    public function firstValue(string $key, $default = null): mixed
    {
        return @$this->first($key)->value ?? $default;
    }

    /**
     * Set setting with current attributes and specific key and value
     * @param string $key
     * @param $value
     * @return Setting
     * @author JalalLinuX
     */
    public function set(string $key, $value): Setting
    {
        $this->attributes['key'] = $key;
        $this->attributes['value'] = $value;

        return $this->query->updateOrCreate(
            $this->getAttributes()->only(Setting::UNIQUE_COLUMNS)->toArray(),
            $this->getAttributes()->toArray()
        );
    }
}
