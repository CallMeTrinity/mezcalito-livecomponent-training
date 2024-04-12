<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Entity\Comment;
use App\Entity\Image;
use App\Form\CommentType;
use App\Form\ImageFormType;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use PHPUnit\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    #[Route('/search', name: 'app_search')]
    public function search(): Response
    {
        return $this->render('blog/search.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    #[Route('/edit/{id}', name: 'app_edit')]
    public function edit(Blog $blogpost): Response

    {
        return $this->render('blog/edit.html.twig', [
            'controller_name' => 'BlogController',
            'blogpost' => $blogpost,
        ]);

    }

    #[Route('/generate', name: 'app_generate')]
    public function generate(EntityManagerInterface $entityManagerInterface): Response
    {
        $faker = Factory::create('fr_FR');
        $blogpost = new Blog();
        $blogpost
            ->setTitle($faker->word())
            ->setContent($faker->paragraph(100))
            ->setDate(date('Y-m-d'));

        $entityManagerInterface->persist($blogpost);
        $entityManagerInterface->flush();

        dd('Blog post created');
    }

    #[Route('/postView/{id}', name: 'app_postView')]
    public function post(Blog $blogpost, Request $request, EntityManagerInterface $em): Response
    {
        $comment = (new Comment)
            ->setDate(date('Y-m-d H:i'))
            ->setBlog($blogpost);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('app_postView', ['id' => $blogpost->getId()]);
        }

        return $this->render('blog/postView.html.twig', [
            'controller_name' => 'BlogController',
            'blogpost' => $blogpost,
            'comments' => $blogpost->getComments(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/image', name: 'app_image')]
    public function image(Image $currentImage, Request $request, EntityManagerInterface $em): Response
    {
        $image = (new Image);
        $form = $this->createForm(ImageFormType::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $directory = '../public/build/Images/';
            $file = $form->get('file')->getData();
            if ($file) {
                // Sécurise le nom du fichier ici si nécessaire
                $newFilename = $form->get('name')->getData('name').'-'.uniqid().'.'.$file->guessExtension();

                // Déplace le fichier
                try {

                    $file->move($directory, $newFilename);
                }catch (FileException){
                    dd("error");
                }


                // Met à jour l'entité avec le nom du fichier
                $image->setName($newFilename);

                $em->persist($image);
                $em->flush();

                return $this->redirectToRoute('app_image');
            }
        }

        return $this->render('blog/image.html.twig', [
            'controller_name' => 'BlogController',
            'imageForm' => $form->createView(),
            'name' => $currentImage->getName(),
        ]);
    }

}
