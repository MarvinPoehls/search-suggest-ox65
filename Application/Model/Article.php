<?php

namespace Marvin\SearchSuggest\Model;

use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;

class Article extends Article_parent
{
    public function fcGetSuggestions($searchParam): array
    {
        $queryBuilder = ContainerFactory::getInstance()->getContainer()->get(QueryBuilderFactoryInterface::class)->create();

        $searchParam = str_replace(' ', '%', urldecode($searchParam));

        $queryBuilder
            ->select('*')
            ->from('oxarticles')
            ->where($queryBuilder->expr()->like('OXTITLE', $queryBuilder->createNamedParameter("%$searchParam%")))
            ->setMaxResults(5);

        $result = $queryBuilder->execute()->fetchAllAssociative();

        $articles = [];
        foreach ($result as $data) {
            $article = oxNew(self::class);
            $article->assign($data);
            $articles[] = $article;
        }
        return $articles;
    }

    public function fcGetAdditionalSuggestions($searchParam, $amount): array
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