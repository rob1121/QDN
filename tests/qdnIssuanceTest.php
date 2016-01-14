
<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class qdnIssuanceTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * test qdn issuance form
     */
    public function testExample()
    {
        $this->assertTrue(true);
         $this->visit('/report');
    }
}
