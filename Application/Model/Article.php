<?php

namespace Marvin\SearchSuggest\Model;

use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;

class Article extends Article_parent
{
    public function fcGetSuggestions(string $searchParam, string $column): array
    {
        $queryBuilder = ContainerFactory::getInstance()->getContainer()->get(QueryBuilderFactoryInterface::class)->create();

        $searchParam = str_replace(' ', '%', urldecode($searchParam));

        $queryBuilder
            ->select('*')
            ->from($this->getCoreTableName())
            ->where($queryBuilder->expr()->like($column, $queryBuilder->createNamedParameter("%$searchParam%")))
            ->setMaxResults(5);

        $result = $queryBuilder->execute()->fetchAllAssociative();

        $suggestions = [];
        foreach ($result as $data) {
            $model = oxNew(self::class);
            $model->assign($data);
            $suggestions[] = $model;
        }

        if (count($suggestions) < 5) {
            $suggestions = array_merge($suggestions, $this->fcGetAdditionalSuggestions($searchParam, 5 - count($articles)));
        }

        return $suggestions;
    }

    protected function fcGetAdditionalSuggestions(string $searchParam, int $amount): array
    {
        $queryBuilder = ContainerFactory::getInstance()->getContainer()->get(QueryBuilderFactoryInterface::class)->create();

        $searchParam = str_replace(' ', '%', urldecode($searchParam));

        $queryBuilder
            ->select('*')
            ->from('oxarticles')
            ->leftJoin(
                'oxarticles',
                'oxartextends',
                'oxartextends',
                'oxartextends.oxid = oxarticles.oxid'
            )
            ->where(
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->like('OXLONGDESC', $queryBuilder->createNamedParameter("%$searchParam%")),
                    $queryBuilder->expr()->notLike('OXTITLE', $queryBuilder->createNamedParameter("%$searchParam%"))
                )
            )
            ->setMaxResults($amount);

        $result = $queryBuilder->execute()->fetchAllAssociative();

        $articles = [];
        foreach ($result as $data) {
            $article = oxNew(self::class);
            $article->assign($data);
            $articles[] = $article;
        }
        return $articles;
    }

    public function fcGetMainPic(): string
    {
        $mainImageFilename = $this->oxarticles__oxpic1->value;
        $baseUrl = \OxidEsales\Eshop\Core\Registry::getConfig()->getShopUrl();
        $imagePath = \OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('sArticlePicDir');

        if (empty($imagePath)) {
            $imagePath = 'out/pictures/master/product/1/';
        }

        return $baseUrl . $imagePath . $mainImageFilename;
    }
}