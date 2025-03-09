<?php

namespace App\Test\Controller;

use App\Entity\ErabiltzaileZigorra;
use App\Repository\ErabiltzaileZigorraRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ErabiltzaileZigorraControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ErabiltzaileZigorraRepository $repository;
    private string $path = '/erabiltzaile/zigorra/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(ErabiltzaileZigorra::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ErabiltzaileZigorra index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'erabiltzaile_zigorra[dateStart]' => 'Testing',
            'erabiltzaile_zigorra[dateEnd]' => 'Testing',
            'erabiltzaile_zigorra[createdAt]' => 'Testing',
            'erabiltzaile_zigorra[updatedAt]' => 'Testing',
            'erabiltzaile_zigorra[erabiltzailea]' => 'Testing',
            'erabiltzaile_zigorra[zigorra]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new ErabiltzaileZigorra();
        $fixture->setDateStart('My Title');
        $fixture->setDateEnd('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setErabiltzailea('My Title');
        $fixture->setZigorra('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('ErabiltzaileZigorra');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new ErabiltzaileZigorra();
        $fixture->setDateStart('My Title');
        $fixture->setDateEnd('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setErabiltzailea('My Title');
        $fixture->setZigorra('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'erabiltzaile_zigorra[dateStart]' => 'Something New',
            'erabiltzaile_zigorra[dateEnd]' => 'Something New',
            'erabiltzaile_zigorra[createdAt]' => 'Something New',
            'erabiltzaile_zigorra[updatedAt]' => 'Something New',
            'erabiltzaile_zigorra[erabiltzailea]' => 'Something New',
            'erabiltzaile_zigorra[zigorra]' => 'Something New',
        ]);

        self::assertResponseRedirects('/erabiltzaile/zigorra/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDateStart());
        self::assertSame('Something New', $fixture[0]->getDateEnd());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getErabiltzailea());
        self::assertSame('Something New', $fixture[0]->getZigorra());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new ErabiltzaileZigorra();
        $fixture->setDateStart('My Title');
        $fixture->setDateEnd('My Title');
        $fixture->setCreatedAt('My Title');
        $fixture->setUpdatedAt('My Title');
        $fixture->setErabiltzailea('My Title');
        $fixture->setZigorra('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/erabiltzaile/zigorra/');
        self::assertSame(0, $this->repository->count([]));
    }
}
