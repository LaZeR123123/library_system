<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BookController extends AbstractController
{
    #[Route('/books', name: 'app_book_list')]
    public function list(): Response
    {
        // Список книг для відображення в шаблоні
        $books = ['книгаlab2', 'книгаlab2', 'книгаlab2'];
        
        return $this->render('book/list.html.twig', [
            'items' => $books,
        ]);
    }

    #[Route('/book/new', name: 'app_book_new')]
    public function new(Request $request): Response
    {
        // Створення форми через FormBuilder [cite: 104-106]
        $form = $this->createFormBuilder()
            ->add('title', TextType::class, ['label' => 'Назва книги'])
            ->add('author', TextType::class, ['label' => 'Автор'])
            ->add('save', SubmitType::class, ['label' => 'Додати книгу'])
            ->getForm();

        // Обробка запиту [cite: 117]
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            // Додавання повідомлення про успіх [cite: 147]
            $this->addFlash('success', 'Книгу "' . $data['title'] . '" успішно додано!');
            
            return $this->redirectToRoute('app_book_list');
        }

        return $this->render('book/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
