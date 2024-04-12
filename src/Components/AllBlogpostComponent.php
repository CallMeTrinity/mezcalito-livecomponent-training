<?php

namespace App\Components;

use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('all_blogpost')]
class AllBlogpostComponent
{
    use DefaultActionTrait;
    private EntityManagerInterface $entityManager;
    private int $blogpostId;

    public function __construct(private BlogRepository $blogRepository)
    {
    }

    public function getAllBlogpost(): array
    {
        return $this->blogRepository->findAll();
    }


}