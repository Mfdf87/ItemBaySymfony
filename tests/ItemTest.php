<?php
namespace App\Tests\Entity;
use App\Entity\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testItemName()
    {
        $item = new Item();
        $item->setNom('item');
        $this->assertEquals('item', $item->getNom());
    }

    public function testItemStat()
    {
        $item = new Item();
        $item->setStat('force faiblesse defense');
        $this->assertEquals('force faiblesse defense', $item->getStat());
    }

    public function testItemDescription()
    {
        $item = new Item();
        $item->setDescription('Ceci est une super description de mon item');
        $this->assertEquals('Ceci est une super description de mon item', $item->getDescription());
    }

    public function testItemQte()
    {
        $item = new Item();
        $item->setQte(1);
        $this->assertEquals(1, $item->getQte());
    }

    public function testItemUrl()
    {
        $item = new Item();
        $item->setUrl('https://www.google.com');
        $this->assertEquals('https://www.google.com', $item->getUrl());
    }

    public function testCreatedAt()
    {
        $item = new Item();
        $createdAt = new \DateTimeImmutable();
        $item->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $item->getCreatedAt());
    }
}