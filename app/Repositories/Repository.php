<?php

namespace Corp\Repositories;

use Config;

abstract class Repository
{

    // буде зберігати об'єкт моделі для отримання певних даних
    protected $model = false;

    public function get(){
        $builder = $this->model->select('*');
        return $builder->get();
    }
}

?>