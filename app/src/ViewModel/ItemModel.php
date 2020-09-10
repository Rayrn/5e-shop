<?php

namespace App\ViewModel;

use JsonSerializable;

class ItemModel implements JsonSerializable
{
    public string $name;
    public string $cost;
    public string $weight;
    public string $core;
    public string $notes = '';

    public function asArray()
    {
        return array_filter((array) $this);
    }

    public function jsonSerialize()
    {
        return json_encode($this->asArray());
    }
}
