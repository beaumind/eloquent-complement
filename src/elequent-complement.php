<?php

namespace Beaumind\EloquentComplement;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait EloquentComplement
{
    /**
     * save model and its relative models in one action
     *
     * @param $data
     * @param array $associated
     * @return mixed
     */
    public function scopeSaveAssociated(Builder $builder, $data, $associated=[])
    {
        $res = DB::transaction(function() use ($data, $associated) {
            $done = true;
            $parents = $children = $relations = [];

            foreach ($associated as $relation)
            {
                $relationship = last(explode('\\', get_class($this->{$relation}())));

                if (in_array($relationship, ['BelongsTo']))
                    array_push($parents, $relation);
                elseif (in_array($relationship, ['HasMany', 'HasOne']))
                    array_push($children, $relation);
            }

            foreach ($parents as $parent)
            {
                if (!empty($data[$parent])) {
                    $related_model = $this->{$parent}()->getRelated();
                    if (!empty($related_model))
                    {
                        $related_model = $related_model->create($data[$parent]);

                        if ($related_model) {
                            $data[$related_model->getForeignKey()] = $related_model->id;
                            $relations[$parent] = $related_model;
                        } else
                            $done = false;

                        unset($data[$parent]);
                    }
                }
            }

            $created_model = $this->create($data);
            if (!$created_model)
                $done = false;

            foreach ($children as $child)
            {
                if (!empty($data[$child]))
                {
                    $related_model = $this->{$child}()->getRelated();

                    if (!empty($related_model))
                    {
                        $data[$child][$this->getForeignKey()] = $created_model->id;
                        $related_model = $related_model->create($data[$child]);

                        if ($related_model)
                            $relations[$child] = $related_model;
                        else
                            $done = false;
                    }
                }
            }

            $created_model->setRelations($relations);

            return $done ? $created_model : false;
        });

        return $res;
    }
}