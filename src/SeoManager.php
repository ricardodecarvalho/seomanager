<?php

namespace SeoManager;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Doctrine\ORM\EntityManager,
    Doctrine\ORM\Tools\SchemaTool;

class SeoManager
{
    protected $entityManager;

    protected $isDevMode;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Execute the middleware
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $this->checkIfTablesExist();
        return $next($request, $response);
    }

    private function checkIfTablesExist()
    {
        $schemaManager = $this->entityManager->getConnection()->getSchemaManager();

        if ($schemaManager->tablesExist(array('SeoManager')) != true) {
            $tool = new SchemaTool($this->entityManager);
            $classes = array(
                $this->entityManager->getClassMetadata('SeoManager\Entity'),
            );
            $tool->createSchema($classes);
        }
    }

    public function getMetaTags($container)
    {
        $basePath = $container['request']->getUri()->getPath();

        $entityManager = $container['em'];
        $seoManagerRepository = $entityManager->getRepository('SeoManager\Model\Entity\SeoManager');
        $seoManager = $seoManagerRepository->findOneBy(array('url' => $basePath));

        if ($seoManager) {
            $container['view']->offsetSet('title', $seoManager->getTitle());
            $container['view']->offsetSet('description', $seoManager->getDescription());
            $container['view']->offsetSet('keywords', $seoManager->getKeywords());
        }
    }
}
