<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Todo;
use App\Form\Type\TodoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

/**
 * @Route("/todo")
 */
class TodoController extends AbstractController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/", name="app_todo_index")
     */
    public function __invoke(Request $request): Response
    {
        $todos = $this->getDoctrine()->getRepository(Todo::class)->findAll();

        $todo = new Todo();

        $form = $this->createForm(TodoType::class, $todo);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $todo = $form->getData();

            $this->getDoctrine()->getManager()->persist($todo);
            $this->getDoctrine()->getManager()->flush();

            $todos = $this->getDoctrine()->getRepository(Todo::class)->findAll();
        }

        return new Response($this->twig->render('todo.html.twig', [
            'todos' => $todos,
            'form' => $form->createView(),
        ]));
    }

    /**
     * @Route("/delete/{id}", name="app_todo_delete")
     */
    public function deleteAction(Request $request, Todo $todo): RedirectResponse
    {
        $this->getDoctrine()->getManager()->remove($todo);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('app_todo_index');
    }
}
