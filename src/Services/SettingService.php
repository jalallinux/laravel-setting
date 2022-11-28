<?php

namespace JalalLinuX\Setting\Services;

use Illuminate\Database\Eloquent\Builder;
use JalalLinuX\Setting\Models\Setting;

class SettingService extends BaseSettingService
{
    private Builder $query;

    public function __construct()
    {
        $this->query = Setting::query();
    }

    public function fetch(): array
    {
        return $this->makeQuery()->get(['group', 'key', 'entity_id', 'entity_type', 'value'])->toArray();
    }

    public function get(string $key, bool $throw = false): mixed
    {
        $this->setAttribute('key', $key);

        return @$this->makeQuery()->{$throw ? 'firstOrFail' : 'first'}()->value;
    }

    public function set(string $key, $value): Setting
    {
        $this->setAttribute('key', $key);
        $this->setAttribute('value', $value);

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

    public function getValue(string $key, $default = null): mixed
    {
        return @$this->get($key)['value'] ?? $default;
    }
}
