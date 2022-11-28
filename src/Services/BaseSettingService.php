<?php

namespace JalalLinuX\Setting\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use JalalLinuX\Setting\Models\Setting;

abstract class BaseSettingService implements ISettingStorage
{
    protected array $attributes = [
        'group' => Setting::DEFAULT_GROUP,
    ];

    public function group(string $group = null): self
    {
        $this->attributes['group'] = $group ?? Setting::DEFAULT_GROUP;

        return $this;
    }

    public function system(): self
    {
        $this->attributes['entity_id'] = null;

        return $this;
    }

    public function entity(Model $entity): self
    {
        $this->attributes['entity_type'] = get_class($entity);
        $this->attributes['entity_id'] = $entity->getKey();

        return $this;
    }

    public function model(string $class): self
    {
        if (! class_exists($class)) {
            throw new \Exception("Class or namespace \"{$class}\" does not exists");
        }

        $this->attributes['entity_type'] = $class;
        $this->attributes['entity_id'] = null;

        return $this;
    }

    protected function getAttributes(): Collection
    {
        return collect($this->attributes);
    }
}
