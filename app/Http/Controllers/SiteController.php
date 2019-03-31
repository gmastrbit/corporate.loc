<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;

use Corp\Http\Requests;

use Corp\Repositories\MenusRepository;

use Menu;

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

    public function __construct(MenusRepository $m_rep)
    {
        $this->m_rep = $m_rep;
    }

    protected function renderOutput(){
        $menu = $this->getMenu();
        $navigation = view(env('THEME').'.navigation')->with('menu', $menu)->render();
        $this->vars = array_add($this->vars, 'navigation', $navigation);

        if ($this->contentRightBar) {
            $rightBar = view(env('THEME').'.rightBar')->with('content_rightBar', $this->contentRightBar)->render();
            $this->vars = array_add($this->vars, 'rightBar', $rightBar);
        }

        return view($this->template)->with($this->vars);
    }

    protected function getMenu(){
        $menu = $this->m_rep->get();
        $mBuilder = Menu::make('MyNav', function($m) use ($menu){
            // функція колбек додасть у меню необхідні пункти
            foreach ($menu as $item) {
                if ($item->parent == 0) {
                    $m->add($item->title, $item->path)->id($item->id);
                } else {
                    if ($m->find($item->parent)) {
                        $m->find($item->parent)->add($item->title, $item->path)->id($item->id);
                    }
                }
            }
        });
        return $mBuilder;
    }
}
