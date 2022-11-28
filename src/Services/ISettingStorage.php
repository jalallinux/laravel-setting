<?php

namespace JalalLinuX\Setting\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use JalalLinuX\Setting\Models\Setting;

interface ISettingStorage
{
    /**
     * Set setting group
     *
     * @param string|null $group
     *
     * @return self
     * @author JalalLinuX
     */
    public function group(string $group = null): self;

    /**
     * Set setting systematic
     *
     * @return self
     * @author JalalLinuX
     */
    public function system(): self;

    /**
     * Set setting entity
     *
     * @param Model $entity
     *
     * @return self
     * @author JalalLinuX
     */
    public function entity(Model $entity): self;

    /**
     * Set setting model
     *
     * @param string $class
     *
     * @return self
     * @author JalalLinuX
     */
    public function model(string $class): self;

    /**
     * Fetch list of setting with current attributes/config
     *
     * @return array{array{
     *      group: string,
     *      key: string,
     *      entity_id: string,
     *      entity_type: string,
     *      value: mixed
     * }}
     * @author JalalLinuX
     */
    public function fetch(): array;

    /**
     * Get value of specific setting
     *
     * @param string $key
     * @param bool $throw
     *
     * @return mixed
     * @author JalalLinuX
     */
    public function get(string $key, bool $throw = false): mixed;

    /**
     * Set new setting or update exists setting
     *
     * @param string $key
     * @param $value
     *
     * @return Setting
     * @author JalalLinuX
     */
    public function set(string $key, $value): Setting;
}
