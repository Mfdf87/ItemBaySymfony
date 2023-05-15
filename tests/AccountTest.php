<?php
namespace App\Tests\Entity;
use App\Entity\Account;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    public function testAccountName()
    {
        $account = new Account();
        $account->setAccountName('admin');
        $this->assertEquals('admin', $account->getAccountName());
    }
}