<?php

declare(strict_types=1);

namespace App\Models\Traits\Attributes;

use Illuminate\Support\Str;

trait CamelCaseAttributes
{
    public function getAttribute($key)
    {
        if ($this->hasAttribute(Str::snake($key))) {
            return parent::getAttribute(Str::snake($key));
        }

        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        return parent::setAttribute(Str::snake($key), $value);
    }

    public function isFillable($key)
    {
        return parent::isFillable($key) || parent::isFillable(Str::camel($key));
    }

    public function getFillable()
    {
        $array = $this->fillable;

        foreach ($this->fillable as $fillable) {
            if (!in_array(Str::snake($fillable), $array)) {
                $array[] = Str::snake($fillable);
            }
            if (!in_array(Str::camel($fillable), $array)) {
                $array[] = Str::camel($fillable);
            }
        }

        return $array;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArrayCamel(): array
    {
        $array = $this->toArray();
        $return = [];

        foreach ($array as $key => $value) {
            $return[Str::camel($key)] = $value;
        }

        return $return;
    }
}
