<?php

namespace App\Components;

use App\Repository\CommentRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('all_comments')]
class AllCommentsFromBlogpostComponent
{

    use DefaultActionTrait;

    #[LiveProp]
    public int $id;

    public function __construct(private CommentRepository $commentRepository)
    {
    }


    public function getComments(): array
    {
        return $this->commentRepository->findBy(['blog' => $this->id], ['date' => 'DESC']);
    }


}