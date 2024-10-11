<?php

uses(Tests\TestCase::class)->in('Feature');

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
