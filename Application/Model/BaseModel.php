<?php

namespace Marvin\SearchSuggest\Model;

use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;

class BaseModel extends BaseModel_parent
{
    /**public function fcGetSuggestions(string $searchParam, string $column): array
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

        if (count($suggestions) < 5 && self::class == \OxidEsales\Eshop\Application\Model\Article::class) {
            $suggestions = array_merge($suggestions, $this->fcGetAdditionalSuggestions($searchParam, 5 - count($suggestions)));
        }

        return $suggestions;
    }*/
}