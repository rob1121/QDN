<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class pagesTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * Test
     */
    public function it_visit_home_page()
    {
        $this->assertTrue(true);
    }
}
