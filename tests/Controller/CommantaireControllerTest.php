<?php

namespace App\Test\Controller;

use App\Entity\Commantaire;
use App\Repository\CommantaireRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommantaireControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CommantaireRepository $repository;
    private string $path = '/commantaire/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Commantaire::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Commantaire index');

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
            'commantaire[description]' => 'Testing',
            'commantaire[created_at]' => 'Testing',
            'commantaire[poste]' => 'Testing',
            'commantaire[author]' => 'Testing',
        ]);

        self::assertResponseRedirects('/commantaire/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Commantaire();
        $fixture->setDescription('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Commantaire');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Commantaire();
        $fixture->setDescription('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'commantaire[description]' => 'Something New',
            'commantaire[created_at]' => 'Something New',
            'commantaire[poste]' => 'Something New',
            'commantaire[author]' => 'Something New',
        ]);

        self::assertResponseRedirects('/commantaire/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getPoste());
        self::assertSame('Something New', $fixture[0]->getAuthor());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Commantaire();
        $fixture->setDescription('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/commantaire/');
    }
}
