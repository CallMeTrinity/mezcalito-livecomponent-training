<?php

namespace App\Components;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('comment')]
class CommentComponent
{
    public int $id;

    public ?Comment $comment = null;

    public function __construct(private CommentRepository $commentRepository)
    {
    }

  /*  public function getComment(): Comment
    {
        return $this->commentRepository->find($this->id);
    }*/
}