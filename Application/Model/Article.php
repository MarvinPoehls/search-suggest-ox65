<?php

namespace Marvin\SearchSuggest\Model;

use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;

class Article extends Article_parent
{
    public function fcGetSuggestions($searchParam): array
    {
        $queryBuilder = ContainerFactory::getInstance()->getContainer()->get(QueryBuilderFactoryInterface::class)->create();

        $queryBuilder
            ->select('*')
            ->from('oxarticles')
            ->where($queryBuilder->expr()->like('oxtitle', $queryBuilder->createNamedParameter("%$searchParam%")))
            ->setMaxResults(5);

        return $queryBuilder->execute()->fetchAllAssociative();
    }
}
