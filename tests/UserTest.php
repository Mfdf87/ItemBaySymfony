<?php
namespace App\Tests\Entity;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testNom()
    {
        $user = new User();
        $user->setNom('admin');
        $this->assertEquals('admin', $user->getNom());
    }

    public function testPrenom()
    {
        $user = new User();
        $user->setPrenom('admin');
        $this->assertEquals('admin', $user->getPrenom());
    }

    public function testMonnaie()
    {
        $user = new User();
        $user->setMonnaie(100.61);
        $this->assertEquals(100.61, $user->getMonnaie());
    }

    public function testPassword()
    {
        $user = new User();
        $user->setPassword('admin');
        $this->assertEquals('admin', $user->getPassword());
    }

    public function testEmail()
    {
        $user = new User();
        $user->setEmail('admin.admin@test.com');
        $this->assertEquals('admin.admin@test.com', $user->getEmail());
    }
}