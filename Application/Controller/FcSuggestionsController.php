<?php

namespace Marvin\SearchSuggest\Controller;

use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Core\Request;

class FcSuggestionsController extends FrontendController
{
    public function render()
    {
        $requestObject = oxNew(Request::class);
        $searchParam = $requestObject->getRequestParameter('searchParam');

        $article = oxNew(Article::class);
        $articles = $article->fcGetSuggestions($searchParam);

        if (count($articles) < 5) {
            $articles = array_merge($articles, $article->fcGetAdditionalSuggestions($searchParam, 5 - count($articles)));
        }

        $data = [];
        foreach ($articles as $article) {
            $data[] = [
                'title' => $article->oxarticles__oxtitle->value,
                'image' => $article->fcGetMainPic(),
                'href' => $article->getLink()
            ];
        }

        echo json_encode($data);
        exit;
    }
}
