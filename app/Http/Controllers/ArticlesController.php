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

    public function index($cat_alias = FALSE)
    {
        $this->title = 'Блог';
        $this->keywords = 'String';
        $this->meta_desc = 'String';

        $articles = $this->getArticles($cat_alias);

        $content = view(env('THEME').'.articles_content')->with('articles',$articles)->render();
        $this->vars = array_add($this->vars,'content',$content);

        $comments = $this->getComments(config('settings.recent_comments'));
        $portfolios = $this->getPortfolios(config('settings.recent_portfolios'));

        $this->contentRightBar = view(env('THEME').'.articlesBar')->with(['comments' => $comments,'portfolios' => $portfolios]);

        return $this->renderOutput();
    }

    public function getArticles($alias = false)
    {
        $articles = $this->a_rep->get(['id', 'title', 'alias', 'created_at', 'img', 'desc', 'user_id', 'category_id'], false, true);
        if ($articles) {
            // дозволяє підвантажити записи із пов'язаних зв'язками таблиць
//            $articles->load('user', 'category', 'comments');
        }
        return $articles;
    }
}
