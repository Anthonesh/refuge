<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CalendrierControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/calendrier/');
    
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('.calendrier-container', 'La liste des événements est affichée.');
    }

    public function testNew()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/calendrier/new');
    
        $this->assertResponseIsSuccessful();
    
        $form = $crawler->selectButton('Enregistrer')->form([
            'calendrier[titre_calendrier]' => 'Journée blanche',
            'calendrier[debut_calendrier]' => '2024-01-26 01:00:00',
            'calendrier[fin_calendrier]' => '2024-01-25 18:00:00',
            'calendrier[description_calendrier]' => 'test',
            'calendrier[couleur_fond_calendrier]' => '#8000ff',
            'calendrier[couleur_bordure_calendrier]' => '#00ff00',
            'calendrier[couleur_texte_calendrier]' => '#000000',
            'calendrier[places_disponibles_calendrier]' => '40',
        ]);

        $client->submit($form);
        $this->assertResponseRedirects('/calendrier/', null, 'Le formulaire de création redirige vers la liste des événements.');
    }

    public function testShow()
    {
        $client = static::createClient();
        // Remplacez `1` par un ID valide dans votre base de données de test
        $client->request('GET', '/calendrier/2');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('.calendrier-title', 'Événement Test');
    }

    public function testDelete()
    {
        $client = static::createClient();
        $csrfToken = $client->getContainer()->get('security.csrf.token_manager')->getToken('delete2');

        $client->request('POST', '/calendrier/2', [
            '_token' => $csrfToken,
        ]);

        $this->assertResponseRedirects('/calendrier/', null, 'La suppression redirige vers la liste des événements.');
    }
}