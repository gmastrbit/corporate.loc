<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;

use Corp\Http\Requests;

class SiteController extends Controller
{
    // властивість для збереження об'єкту класу Portfolio репозиторій
    // даний клас буде використовуватися для збереження логіки по роботі з портфоліо
    protected $p_rep;

    // буде зберігатися об'єкт класу Slider репозиторій
    // буде збережена логіка роботи зі слайдером
    protected $s_rep;

    // логіка по роботі зі статтями
    protected $a_rep;

    // необхідний для роботи з пунктами меню
    protected $m_rep;

    protected $template;

    // масив передаваних змінних у шаблон
    protected $vars = [];

    // інформація про сайдбари
    protected $contentRightBar = false;
    protected $contentLeftBar = false;

    // сайдбар
    protected $bar = false;

    public function __construct()
    {
        
    }

    protected function renderOutput(){
        return view($this->template)->with($this->vars);
    }
}
