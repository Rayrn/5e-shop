<?php

namespace App\Helper;

use JsonSerializable;

class JsonStringable implements JsonSerializable
{
    public function __toString(): string
    {
        return $this->jsonSerialize();
    }

    public function jsonSerialize()
    {
        return json_encode($this->asArray());
    }

    public function asArray()
    {
        $item = [];

        // Filter out * (private) and \u0000
        foreach ($this as $key => $value) {
            $matches = [];
            preg_match('/[\w]+/', $key, $matches);
            $item[$matches[0]] = $value;
        }

        return array_filter($item);
    }
}
