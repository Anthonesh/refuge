<?php

namespace App\Controller;

use App\Repository\PensionnairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Dons;
use App\Form\DonsType;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class DonsController extends AbstractController
{
    #[Route('/dons', name: 'app_dons', methods: ['GET', 'POST'])]
    public function submitForm(Request $request, EntityManagerInterface $entityManager, PensionnairesRepository $pensionnairesRepository): Response
    {
        // Création d'une nouvelle instance de l'entité Dons.
        $dons = new Dons();
        // Création du formulaire 
        $form = $this->createForm(DonsType::class, $dons);
        // Requête pour remplir le formulaire avec les données envoyées par l'utilisateur.
        $form->handleRequest($request);
    
        // Vérification si le formulaire a été soumis et est valide.
        if ($form->isSubmitted() && $form->isValid()) {
            // Stocker les données du formulaire dans la session.
            $request->getSession()->set('donsFormData', $form->getData());
    
            // Redirection vers la page de paiement.
            return $this->redirectToRoute('app_paiement');
        } else if ($form->isSubmitted() && !$form->isValid()) {
            // Si le formulaire a été soumis mais n'est pas valide, stocker un message d'erreur dans la session.
            $request->getSession()->getFlashBag()->add('error', 'Il y a des erreurs dans le formulaire, veuillez les corriger.');
        }
    
        $pensionnaires = $pensionnairesRepository->findAll();
        // Si le formulaire n'est pas soumis ou n'est pas valide, afficher la page avec le formulaire.
        // Rendu du template 'dons/index.html.twig' en passant le formulaire à la vue pour être affiché.
        return $this->render('dons/index.html.twig', [
            'form' => $form->createView(),
            'pensionnaires' => $pensionnaires
        ]);
    }
    #[Route('/dons/paiement', name: 'app_paiement', methods: ['GET'])]
    public function paiement(Request $request, EntityManagerInterface $entityManager, PensionnairesRepository $pensionnairesRepository): Response
    {
        // Récupérer les données du formulaire depuis la session
        $donsFormData = $request->getSession()->get('donsFormData');

        if (!$donsFormData) {
            // Gérer le cas où les données du formulaire ne sont pas trouvées dans la session
            return $this->redirectToRoute('app_dons');
        }

        // Configuration Stripe
        $stripePublicKey = $this->getParameter('stripe.public_key');
        $stripeSecretKey = $this->getParameter('stripe.secret_key');
        Stripe::setApiKey($stripeSecretKey);

        // Créer un PaymentIntent avec Stripe
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $donsFormData->getMontantDon() * 100, // Montant en centimes
                'currency' => $donsFormData->getMonnaieDon(),
                'payment_method_types' => ['card'],
            ]);

            $clientSecret = $paymentIntent->client_secret;
            $pensionnaires = $pensionnairesRepository->findAll();

            return $this->render('dons/paiement.html.twig', [
                'stripePublicKey' => $stripePublicKey,
                'clientSecret' => $clientSecret,
                'pensionnaires' => $pensionnaires
            ]);

        } catch (ApiErrorException $e) {
            // En cas d'erreur
            $this->addFlash('error', 'Erreur de paiement : ' . $e->getMessage());
            return $this->redirectToRoute('app_dons');
        }
    }

    #[Route('/dons/succes', name: 'app_dons_succes', methods: ['GET']) ]
    public function paiementSucces(Request $request, EntityManagerInterface $entityManager): Response
    
    {
        // Récupérer les données du formulaire depuis la session
        $donsFormData = $request->getSession()->get('donsFormData');

        if (!$donsFormData) {
            // Gérer le cas où les données du formulaire ne sont pas trouvées dans la session
            return $this->redirectToRoute('app_dons');
        }

        // Insérer les données dans la base de données
        $entityManager->persist($donsFormData);
        $entityManager->flush();

        // Supprimer les données de la session après les avoir insérées dans la base de données
        $request->getSession()->remove('donsFormData');

        // Afficher la page de succès
        return $this->render('dons/succes.html.twig');
    }
}