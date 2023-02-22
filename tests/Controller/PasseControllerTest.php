<?php

namespace App\Test\Controller;

use App\Entity\Passe;
use App\Repository\PasseRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PasseControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PasseRepository $repository;
    private string $path = '/passe/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Passe::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Passe index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'passe[code]' => 'Testing',
            'passe[prix]' => 'Testing',
            'passe[evennement]' => 'Testing',
            'passe[PasseOwner]' => 'Testing',
        ]);

        self::assertResponseRedirects('/passe/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Passe();
        $fixture->setCode('My Title');
        $fixture->setPrix('My Title');
        $fixture->setEvennement('My Title');
        $fixture->setPasseOwner('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Passe');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Passe();
        $fixture->setCode('My Title');
        $fixture->setPrix('My Title');
        $fixture->setEvennement('My Title');
        $fixture->setPasseOwner('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'passe[code]' => 'Something New',
            'passe[prix]' => 'Something New',
            'passe[evennement]' => 'Something New',
            'passe[PasseOwner]' => 'Something New',
        ]);

        self::assertResponseRedirects('/passe/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCode());
        self::assertSame('Something New', $fixture[0]->getPrix());
        self::assertSame('Something New', $fixture[0]->getEvennement());
        self::assertSame('Something New', $fixture[0]->getPasseOwner());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Passe();
        $fixture->setCode('My Title');
        $fixture->setPrix('My Title');
        $fixture->setEvennement('My Title');
        $fixture->setPasseOwner('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/passe/');
    }
}
