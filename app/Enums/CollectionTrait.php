<?php

namespace App\Enums;

use Illuminate\Support\Collection;

trait CollectionTrait
{
    /**
     * Get the enum as an collection formatted.
     *
     * @return Collection
     */
    public static function toCollection()
    {
        $values = new Collection();
        foreach (self::toSelectArray() as $key => $value) {
            $values->push((object) [
                'id' => $key,
                'name' => $value,
            ]);
        }

        return $values;
    }
}
