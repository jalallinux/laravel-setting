<?php

namespace JalalLinuX\Setting\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use JalalLinuX\Setting\Models\Setting;

class SettingService extends BaseSettingService
{
    private Builder $query;

    public function __construct()
    {
        $this->query = Setting::query();
    }

    public function get(string $key, bool $throw = false): mixed
    {
        $this->attributes['key'] = $key;

        return @$this->makeQuery()->{$throw ? 'firstOrFail' : 'first'}()->value;
    }

    public function set(string $key, $value): Setting
    {
        $this->attributes['key'] = $key;
        $this->attributes['value'] = $value;

        return $this->query->updateOrCreate(
            $this->getAttributes()->only(Setting::UNIQUE_COLUMNS)->toArray(),
            $this->getAttributes()->toArray()
        );
    }

    protected function makeQuery(): Builder
    {
        foreach ($this->getAttributes()->map(fn ($v, $k) => [$k, $v])->values() as $condition) {
            is_null($condition[1])
                ? $this->query->whereNull($condition[0])
                : $this->query->where(...$condition);
        }

        return $this->query;
    }

    public function fetch(): Collection
    {
        return $this->makeQuery()->get();
    }

    public function getValue(string $key, $default = null): mixed
    {
        return @$this->get($key)['value'] ?? $default;
    }
}
