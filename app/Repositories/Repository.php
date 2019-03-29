<?php

namespace Corp\Repositories;

use Config;

abstract class Repository
{

    // буде зберігати об'єкт моделі для отримання певних даних
    protected $model = false;

    // select - список полів, які будуть вибиратися із БД для конкретного запису
    public function get($select = '*', $take = false){
        $builder = $this->model->select($select);

        if ($take) {
            $builder->take($take);
        }

        return $builder->get();
    }
}

?>