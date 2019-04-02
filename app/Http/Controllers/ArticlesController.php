<?php

namespace Corp\Http\Controllers;

use Corp\Repositories\ArticlesRepository;
use Corp\Repositories\PortfoliosRepository;
use Illuminate\Http\Request;
use Corp\Http\Requests;

class ArticlesController extends SiteController
{
    public function __construct(PortfoliosRepository $p_rep, ArticlesRepository $a_rep)
    {
        parent::__construct(new \Corp\Repositories\MenusRepository(new \Corp\Menu));

        $this->p_rep = $p_rep;
        $this->a_rep = $a_rep;

        // визначає, де буде сайдбар
        $this->bar = 'right';

        $this->template = env('THEME').'.articles';
    }

    public function index()
    {
        $articles = $this->getArticles();

        // формує вигляд, який буде доступний користувачу
        return $this->renderOutput();
    }

    public function getArticles($alias = false)
    {
        $articles = $this->a_rep->get(['title', 'alias', 'created_at', 'img', 'desc'], false, true);
        if ($articles) {
            // дозволяє підвантажити записи із пов'язаних зв'язками таблиць
//            $articles->load('user', 'category', 'comments');
        }
        return $articles;
    }
}
