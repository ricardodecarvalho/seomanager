<?php

namespace SeoManager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;

class SeoManager
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager, $checkIfTablesExist = true)
    {
        $this->entityManager = $entityManager;

        if ($checkIfTablesExist) {
            $this->checkIfTablesExist();
        }

    }

    private function checkIfTablesExist()
    {
        $schemaManager = $this->entityManager->getConnection()->getSchemaManager();

        if ($schemaManager->tablesExist(array('SeoManager')) != true) {
            $tool = new SchemaTool($this->entityManager);
            $classes = array(
                $this->entityManager->getClassMetadata('SeoManager\Entity\SeoManager'),
            );
            $tool->createSchema($classes);
        }
    }

    public function getMetaTags($basePath)
    {
        $seoManagerRepository = $this->entityManager->getRepository('SeoManager\Entity\SeoManager');
        $seoManager = $seoManagerRepository->findOneBy(array('url' => $basePath));
        if ($seoManager) {
            return [
                'title'=> $seoManager->getTitle(),
                    'description'=> $seoManager->getDescription(),
                    'keywords'=> $seoManager->getKeywords(),
                ];
        }
    }
}
