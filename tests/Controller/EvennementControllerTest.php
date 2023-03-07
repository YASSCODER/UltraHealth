<?php

namespace App\Test\Controller;

use App\Entity\Evennement;
use App\Repository\EvennementRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EvennementControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EvennementRepository $repository;
    private string $path = '/evennement/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Evennement::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Evennement index');

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
            'evennement[titre]' => 'Testing',
            'evennement[description]' => 'Testing',
            'evennement[dateDebut]' => 'Testing',
            'evennement[dateFin]' => 'Testing',
            'evennement[zone]' => 'Testing',
            'evennement[eventimg]' => 'Testing',
            'evennement[nbrPasse]' => 'Testing',
            'evennement[category]' => 'Testing',
            'evennement[passe]' => 'Testing',
        ]);

        self::assertResponseRedirects('/evennement/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Evennement();
        $fixture->setTitre('My Title');
        $fixture->setDescription('My Title');
        $fixture->setDateDebut('My Title');
        $fixture->setDateFin('My Title');
        $fixture->setZone('My Title');
        $fixture->setEventimg('My Title');
        $fixture->setNbrPasse('My Title');
        $fixture->setCategory('My Title');
        $fixture->setPasse('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Evennement');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Evennement();
        $fixture->setTitre('My Title');
        $fixture->setDescription('My Title');
        $fixture->setDateDebut('My Title');
        $fixture->setDateFin('My Title');
        $fixture->setZone('My Title');
        $fixture->setEventimg('My Title');
        $fixture->setNbrPasse('My Title');
        $fixture->setCategory('My Title');
        $fixture->setPasse('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'evennement[titre]' => 'Something New',
            'evennement[description]' => 'Something New',
            'evennement[dateDebut]' => 'Something New',
            'evennement[dateFin]' => 'Something New',
            'evennement[zone]' => 'Something New',
            'evennement[eventimg]' => 'Something New',
            'evennement[nbrPasse]' => 'Something New',
            'evennement[category]' => 'Something New',
            'evennement[passe]' => 'Something New',
        ]);

        self::assertResponseRedirects('/evennement/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getDateDebut());
        self::assertSame('Something New', $fixture[0]->getDateFin());
        self::assertSame('Something New', $fixture[0]->getZone());
        self::assertSame('Something New', $fixture[0]->getEventimg());
        self::assertSame('Something New', $fixture[0]->getNbrPasse());
        self::assertSame('Something New', $fixture[0]->getCategory());
        self::assertSame('Something New', $fixture[0]->getPasse());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Evennement();
        $fixture->setTitre('My Title');
        $fixture->setDescription('My Title');
        $fixture->setDateDebut('My Title');
        $fixture->setDateFin('My Title');
        $fixture->setZone('My Title');
        $fixture->setEventimg('My Title');
        $fixture->setNbrPasse('My Title');
        $fixture->setCategory('My Title');
        $fixture->setPasse('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/evennement/');
    }
}
