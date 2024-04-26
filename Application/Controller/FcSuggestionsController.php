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

        $data['articles'] = $this->getArticleData($searchParam);
        $data['categories'] = $this->getCategoryData($searchParam);

        echo json_encode($data);
        exit;
    }

    protected function getArticleData($searchParam): array
    {
        $article = oxNew(Article::class);
        $articles = $article->fcGetSuggestions($searchParam, "oxtitle");

        $articleData = [];
        foreach ($articles as $article) {
            $articleData[] = [
                'title' => $article->oxarticles__oxtitle->value,
                'image' => $article->fcGetMainPic(),
                'href' => $article->getLink()
            ];
        }
        return $articleData;
    }

    protected function getCategoryData($searchParam): array
    {
        $category = oxNew(Category::class);
        $categories = $category->fcGetSuggestions($searchParam, "oxtitle");

        $categoryData = [];
        foreach ($categories as $category) {
            $categoryData[] = [
                'title' => $category->oxcategories__oxtitle->value,
                'href' => $category->getLink()
            ];
        }
        return $categoryData;
    }
}
