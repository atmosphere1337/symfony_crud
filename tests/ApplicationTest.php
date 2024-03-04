<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\City;
class ApplicationTest extends WebTestCase
{
    public function testSomething(): void
    {

        //
        // 
        //
        $client = static::createClient();

        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $result = $em->getRepository(User::class)->findAll();
        foreach ($result as $element) {
            $em->remove($element);
        }
        $em->flush();
        $result = $em->getRepository(City::class)->findAll();
        foreach ($result as $element) {
            $em->remove($element);
        }
        $em->flush();
        


        
        $crawler = $client->request('GET', '/register');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Register');
        $form = $crawler->selectButton('Register')->form();
        $form['registration_form[username]']->setValue('atmosphere');
        $form['registration_form[plainPassword]']->setValue('atmosphere');
        $form['registration_form[agreeTerms]']->tick();
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Please sign in');
        $form = $crawler->selectButton('Sign in')->form();
        $form['_username']->setValue('atmosphere');
        $form['_password']->setValue('atmosphere');
        $client->submit($form);
        $crawler = $client->followRedirect();
        $crawler = $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'City Page');
        $form = $crawler->selectButton('Save')->form();
        $form['createForm[city]']->setValue('Moscow');
        $form['createForm[country]']->setValue('Russia');
        $form['createForm[population]']->setValue('1337');
        $client->submit($form);
        $crawler = $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertAnySelectorTextContains('td', 'Russia');  
        $id = $crawler->filter("td")->eq(0)->innerText();
        $form = $crawler->selectButton('Update')->form();
        $form['updateForm[id]']->setValue($id);
        $form['updateForm[city]']->setValue('Moscow');
        $form['updateForm[country]']->setValue('Russiaa');
        $form['updateForm[population]']->setValue('1337');
        $client->submit($form);
        $crawler = $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertAnySelectorTextContains('td', 'Russiaa');
        $this->assertAnySelectorTextContains('td', $id);
        $form = $crawler->selectButton('Delete')->form();
        $form['dropForm[id]']->setValue($id);
        $client->submit($form);
        $crawler = $client->followRedirect();

        $this->assertResponseIsSuccessful();
        $this->assertSelectorNotExists('td', 'Russiaa');

    }
}
