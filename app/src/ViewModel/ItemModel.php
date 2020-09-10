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

    public function jsonSerialize(): string
    {
        return json_encode($this->asArray());
    }

    public function asArray(): array
    {
        return array_filter((array) $this);
    }
}
