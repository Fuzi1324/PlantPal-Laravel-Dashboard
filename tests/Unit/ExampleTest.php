<?php

namespace Tests\Unit;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testReturnsSuccessfulResponse()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
