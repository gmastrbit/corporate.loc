<?php

namespace Corp\Repositories;

use Config;

abstract class Repository
{

    // буде зберігати об'єкт моделі для отримання певних даних
    protected $model = false;

    // select - список полів, які будуть вибиратися із БД для конкретного запису
    public function get($select = '*', $take = false, $pagination = false){
        $builder = $this->model->select($select);

        if ($take) {
            $builder->take($take);
        }

        if ($pagination) {
            return $builder->check(paginate(Config::get('settings.paginate')));
        }

        return $this->check($builder->get());
    }

    protected function check($result)
    {
        if ($result->isEmpty()) {
            return false;
        }

        // функція, яка буде викликана для кожного елемента колекції
        $result->transform(function ($item, $key){
            if (is_string($item->img) && is_object(json_decode($item->img)) && json_last_error() == JSON_ERROR_NONE) {
                $item->img = json_decode($item->img);
            }
            return $item;
        });

        return $result;
    }
}

?>