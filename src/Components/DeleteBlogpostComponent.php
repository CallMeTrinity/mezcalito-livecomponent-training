<?php

namespace App\Components;

use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('delete_blogpost')]
final class DeleteBlogpostComponent
{

    use DefaultActionTrait;

    public int $blogpostId;

    public function __construct(private readonly EntityManagerInterface $entityManager, private readonly BlogRepository $blogRepository)
    {
    }

    #[LiveAction]
    public function delete(): void
    {
        $blogpost = $this->blogRepository->find($this->blogpostId);

        if ($blogpost) {
            $this->entityManager->remove($blogpost);
            $this->entityManager->flush();
        }

    }
}