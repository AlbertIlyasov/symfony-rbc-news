<?php


namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class NewsService
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var ResourceInterface[] */
    private $resources;

    /**
     * NewsService constructor.
     * @param RbcService $rbcService
     */
    public function __construct(
        EntityManagerInterface $em,
        RbcResource $rbcService
    ) {
        $this->em = $em;
        $this->resources = array_slice(func_get_args(), 1);//skip EntityManagerInterface
    }

    public function parseLastNews()
    {
        foreach ($this->resources as $resource) {
            $this->parseLastNewsOfResource($resource);
        }
        $this->em->flush();
    }

    public function parseLastNewsOfResource(ResourceInterface $resource)
    {
        foreach ($resource->getLastNews() as $news) {
            if ($news->getImg()) {
                //todo: save image
            }
            $this->em->persist($news);
        }
    }
}
