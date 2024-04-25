<?php

namespace Marvin\SearchSuggest\Controller;

use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Application\Model\Category;
use OxidEsales\Eshop\Core\Request;

class FcSuggestionsController extends FrontendController
{
    public function render()
    {
        $requestObject = oxNew(Request::class);
        $searchParam = $requestObject->getRequestParameter('searchParam');

        $article = oxNew(Article::class);
        $articles = $article->fcGetSuggestions($searchParam);
        $category = oxNew(Category::class);
        $categories = $category->fcGetSuggestions($searchParam);

        $data = [];
        foreach ($articles as $article) {
            $data['articles'][] = [
                'title' => $article->oxarticles__oxtitle->value,
                'image' => $article->fcGetMainPic(),
                'href' => $article->getLink()
            ];
        }

        foreach ($categories as $category) {
            $data['categories'][] = [
                'title' => $category->oxcategories__oxtitle->value,
                'href' => $category->getLink()
            ];
        }

        echo json_encode($data);
        exit;
    }
}
