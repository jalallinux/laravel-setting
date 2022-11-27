<?php

namespace JalalLinuX\Setting\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Setting extends Model
{
    public const UNIQUE_COLUMNS = ['key', 'group', 'entity_type', 'entity_id'];
    public const DEFAULT_GROUP = 'group';

    protected $guarded = ['updated_at', 'id'];
    protected $table = 'settings';

    /**
     * Relation to Entity
     * @return MorphTo
     * @author JalalLinuX
     */
    public function entity(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * value getter
     * @return mixed
     * @author JalalLinuX
     */
    public function getValueAttribute(): mixed
    {
        return is_json($this->attributes['value']) ? json_decode($this->attributes['value'], true) : $this->attributes['value'];
    }

    /**
     * value setter
     * @param $value
     * @return void
     * @author JalalLinuX
     */
    public function setValueAttribute($value): void
    {
        $this->attributes['value'] = is_iterable($value) || is_array($value) || is_object($value) ? json_encode($value) : $value;
    }

    /**
     * Scope for get with Group
     * @param $query
     * @param $groupName
     * @return Builder
     * @author JalalLinuX
     */
    public function scopeGroup($query, $groupName): Builder
    {
        return $query->where('group', $groupName);
    }

    /**
     * Scope for get only System setting
     * @param Builder $query
     * @return Builder
     * @author JalalLinuX
     */
    public function scopeSystem(Builder $query): Builder
    {
        return $query->whereNull('entity_id');//->whereNull('entity_type'));
    }

    /**
     * Scope for get with Entity
     * @param Builder $query
     * @param Model $entity
     * @return Builder
     * @author JalalLinuX
     */
    public function scopeEntity(Builder $query, Model $entity): Builder
    {
        return $query->where(fn($q) => $q->where('entity_type', get_class($entity))->where('entity_id', $entity->getKey()));
    }
}
