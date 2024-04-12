<?php

namespace App\Components;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('image')]
class ImageComponent
{
    use DefaultActionTrait;


    public function __construct(private ImageRepository $imageRepository)
    {
    }

    public function getRandomImageName(): string
    {
        $randomImage = $this->getRandomImage();
        if ($randomImage) {
            return $randomImage->getName();
        }
        return 'Aucune image disponible';
    }

    public function getRandomImage(): ?Image
    {
        return $this->imageRepository->findRandom();
    }

    public function getName(): string
    {
        $lastImage = $this->getLastImage();
        if ($lastImage) {
            return $lastImage->getName();
        }

        return 'Aucune image disponible';
    }

    public function getLastImage(): ?Image
    {
        return $this->imageRepository->findLast();
    }

}