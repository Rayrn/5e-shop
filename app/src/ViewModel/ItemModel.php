<?php

namespace App\ViewModel;

use JsonSerializable;

class ItemModel implements JsonSerializable
{
    public string $name;
    public string $cost;
    public string $weight;

    public function asArray()
    {
        return (array) $this;
    }

    public function jsonSerialize()
    {
        return json_encode($this->asArray());
    }
}
