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

        echo json_encode($articles);
        exit;
    }
}
