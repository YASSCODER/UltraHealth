<?php

namespace App\Test\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ArticleRepository $repository;
    private string $path = '/article/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Article::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Article index');

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
            'article[titre]' => 'Testing',
            'article[description]' => 'Testing',
            'article[created_at]' => 'Testing',
            'article[updated_at]' => 'Testing',
            'article[author]' => 'Testing',
        ]);

        self::assertResponseRedirects('/article/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Article();
        $fixture->setTitre('My Title');
        $fixture->setDescription('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Article');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Article();
        $fixture->setTitre('My Title');
        $fixture->setDescription('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'article[titre]' => 'Something New',
            'article[description]' => 'Something New',
            'article[created_at]' => 'Something New',
            'article[updated_at]' => 'Something New',
            'article[author]' => 'Something New',
        ]);

        self::assertResponseRedirects('/article/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getAuthor());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Article();
        $fixture->setTitre('My Title');
        $fixture->setDescription('My Title');
        $fixture->setCreatedAt(new \DateTimeImmutable());
        $fixture->setUpdatedAt(new \DateTimeImmutable());
        

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/article/');
    }
}
