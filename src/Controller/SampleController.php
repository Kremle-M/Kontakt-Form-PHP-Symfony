<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SampleController extends abstractController
{
    #[Route('/', name: 'kontakt_endpoint', methods: ['GET', 'POST'])]
    public function kontakt(Request $request): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        $formData = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            $this->addFlash('success', 'Formulář byl úspěšně odeslán');
        }

        return $this->render('sample/contact.html.twig', [
            'form' => $form->createView(),
            'data' => $formData,
        ]);
    }
}