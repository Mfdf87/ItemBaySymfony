<?php
namespace App\Tests\Entity;
use App\Entity\Compte;
use PHPUnit\Framework\TestCase;

class CompteTest extends TestCase
{
    public function testNom()
    {
        $compte = new Compte();
        $compte->setNom('admin');
        $this->assertEquals('admin', $compte->getNom());
    }

    public function testPrenom()
    {
        $compte = new Compte();
        $compte->setPrenom('admin');
        $this->assertEquals('admin', $compte->getPrenom());
    }

    public function testMonnaie()
    {
        $compte = new Compte();
        $compte->setMonnaie(100.61);
        $this->assertEquals(100.61, $compte->getMonnaie());
    }

    public function testIsAdmin()
    {
        $compte = new Compte();
        $compte->setIsAdmin(true);
        $this->assertEquals(true, $compte->isIsAdmin());
    }

    public function testPassword()
    {
        $compte = new Compte();
        $compte->setPassword('admin');
        $this->assertEquals('admin', $compte->getPassword());
    }

    public function testEmail()
    {
        $compte = new Compte();
        $compte->setEmail('admin.admin@test.com');
        $this->assertEquals('admin.admin@test.com', $compte->getEmail());
    }
}