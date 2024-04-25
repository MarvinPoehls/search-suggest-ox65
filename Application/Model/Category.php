<?php

namespace Marvin\SearchSuggest\Model;

use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;

class Category extends Category_parent
{
    public function fcGetSuggestions($searchParam): array
    {
        $queryBuilder = ContainerFactory::getInstance()->getContainer()->get(QueryBuilderFactoryInterface::class)->create();

        $searchParam = str_replace(' ', '%', urldecode($searchParam));

        $queryBuilder
            ->select('*')
            ->from('oxcategories')
            ->where($queryBuilder->expr()->like('OXTITLE', $queryBuilder->createNamedParameter("%$searchParam%")))
            ->setMaxResults(5);

        $result = $queryBuilder->execute()->fetchAllAssociative();

        $categories = [];
        foreach ($result as $data) {
            $category = oxNew(self::class);
            $category->assign($data);
            $categories[] = $category;
        }
        return $categories;
    }
}