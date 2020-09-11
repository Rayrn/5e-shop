<?php

namespace App\ViewModel;

use App\Helper\JsonStringable;

class ItemModel extends JsonStringable
{
    public string $name;
    public string $cost;
    public string $weight;
    public string $core;
    public string $notes = '';
}
