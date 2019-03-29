<?php

namespace Corp;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    public function filter()
    {
        // портфоліо зсилається на певний запис із таблиці filter
        return $this->belongsTo('Corp\Filter', 'filter_alias', 'alias');
    }
}
