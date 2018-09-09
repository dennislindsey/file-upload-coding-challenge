<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MainPageTest extends TestCase
{
    /**
     * @test
     */
    function can_load_home_page()
    {
        /** @var TestResponse $response */
        $response = $this->get(route('web.home'));

        $response->assertOk();
        $response->assertViewIs('welcome');
    }

    /**
     * @test
     */
    function react_is_mounted()
    {
        /** @var TestResponse $response */
        $response = $this->get(route('web.home'));

        $response->assertSee('<div id="main">');
        $response->assertSee('js/app.js');
    }
}
