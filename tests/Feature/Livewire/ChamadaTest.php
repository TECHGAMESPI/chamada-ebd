<?php

namespace Tests\Feature\Livewire;

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Tests\TestCase;

class ChamadaTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_tela_de_chamada_deve_ser_carregada()
    {
        $response = $this->get('/user/chamada');
        $response->assertStatus(302);
    }
}
