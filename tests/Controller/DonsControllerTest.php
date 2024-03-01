<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DonsControllerTest extends WebTestCase
{
    public function testShowForm()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/dons');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form'); // Vérifie que le formulaire est bien affiché
    }

    public function testSubmitForm()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/dons');
    
        // Assurez-vous d'avoir sélectionné le bon bouton de soumission si votre formulaire en a plusieurs.
        $form = $crawler->selectButton('Continuer vers le paiement')->form();
    
        // Remplissez le formulaire en fonction des champs définis dans DonsType.
        // Note : Assurez-vous que les noms des champs correspondent à ceux attendus par le serveur.
        $formData = [
            'dons[nom_don]' => 'Doe',
            'dons[prenom_don]' => 'John',
            'dons[numero_rue_don]' => '123',
            'dons[libelle_rue_don]' => 'Rue de la Paix',
            'dons[code_postal_don]' => '75000',
            'dons[ville_don]' => 'Paris',
            'dons[pays_don]' => 'France',
            'dons[telephone_don]' => '0102030405',
            'dons[email_don]' => 'john.doe@example.com',
            'dons[montant_don]' => 50,
            'dons[monnaie_don]' => 'EUR',
        ];
    
        $client->submit($form, $formData);
    
        // Après la soumission, nous nous attendons à être redirigés vers la page de paiement.
        // Cette assertion peut échouer si la redirection n'est pas configurée comme attendu ou si le formulaire n'est pas valide.
        $this->assertResponseRedirects('/dons/paiement', 302); // Le code 302 indique une redirection.
    }

    public function testPaiementWithoutFormData()
    {
        $client = static::createClient();
        $client->request('GET', '/dons/paiement');

        // Vérifiez que l'utilisateur est redirigé vers la page du formulaire de dons si aucune donnée de formulaire n'est présente dans la session
        $this->assertResponseRedirects('/dons');
    }
}