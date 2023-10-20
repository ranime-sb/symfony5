<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public $authors = [
        [
            'id' => 1,
            'picture' => '/images/Victor-Hugo.jpg',
            'username' => 'Victor Hugo',
            'email' => 'victor.hugo@gmail.com',
            'nb_books' => 100,
        ],
        [
            'id' => 2,
            'picture' => '/images/william-shakespeare.jpg',
            'username' => 'William Shakespeare',
            'email' => 'william.shakespeare@gmail.com',
            'nb_books' => 200,
        ],
        [
            'id' => 3,
            'picture' => '/images/Taha_Hussein.jpg',
            'username' => 'Taha Hussein',
            'email' => 'taha.hussein@gmail.com',
            'nb_books' => 300,
        ],
    ];
    public function list(){
        $sumOfBooks = 0;
    foreach ($this->authors as $author) {
        $sumOfBooks += $author['nb_books'];
    }
    return $this->render('author/list.html.twig', [
        'authors' => $this->authors,
        'sumOfBooks' => $sumOfBooks,

    ]);
}

public function authorDetails(int $id)
{
    $id--;
    $author = $this->authors[$id];

    if (!$author) {
        throw new NotFoundHttpException('Auteur non trouvé');
    }
    
    return $this->render('author/showAuthor.html.twig', [
        'author' => $author,
        
    ]);
}

#[Route('/author/get/all', name:'app_get_all_author')]
public function getAll(AuthorRepository  $repo){
$authors=$repo->findAll();
return $this->render('author/list.html.twig',['a'=>$authors]);
}


#[Route('/author/add', name:'app_add_author')]
public function add(ManagerRegistry $manager){
    $author=new Author();
    $author->setName('author 1');
    $author->setEmail('author1@esprit.tn');
    $author->getManager()->persist($author);
    $manager->getManager->flush();
    return $this->redirectToRoute('app_get_all_author');
}


#[Route('/author/delete/{id}', name:'app_delete_author')]
public function delete($id,ManagerRegistry $manager ,AuthorRepository  $repo){
$author=$repo->find($id);
$manager->getManager()->remove($author);
$manager->getManager()->flush();
return $this->redirectToRoute('app_get_all_author');

}

}