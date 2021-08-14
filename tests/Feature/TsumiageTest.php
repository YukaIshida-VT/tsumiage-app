<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tsumiage;
use Symfony\Component\HttpFoundation\Response;

class TsumiageTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/ 
    public function only_the_users_tsumiages_can_be_retrieved()
    {
        $user = User::factory()->create();
        $tsumiage = Tsumiage::factory()->create(['user_id' => $user->id]);
        $anotherUser = User::factory()->create();

        $response = $this->post('api/user-tsumiage',['api_token' => $anotherUser->api_token, 'date' => $tsumiage->date]);
        $response
            ->assertJson([
                'count' => 0,
                'links' => [
                    'self' => url('/tsumiage'),
                ]
            ]);
    }

    /** @test **/ 
    public function an_authenticated_user_should_redirected_to_login()
    {
        $response = $this->post('/api/tsumiage',
             ['api_token' => '', 'add_item1' => 'test_item', 'date' => '2021-08-15']);
        $response->assertRedirect('/');
        $this->assertCount(0, Tsumiage::all());
    }

    /** @test **/ 
    public function an_authenticated_user_can_add_a_tsumiage()
    {
        $user = User::factory()->create();
        $response = $this->post('/api/tsumiage', 
            ['api_token' => $user->api_token, 'add_item1' => 'item', 'date' => '2021-08-15']);

        $tsumiage = Tsumiage::first();

        $this->assertEquals($tsumiage->item, 'item');
        $this->assertEquals($tsumiage->user_id, $user->id);
 
        $response->assertStatus(Response::HTTP_CREATED);
        // print_r($response->getdata());

        $response
            ->assertJson([
                'data' => [
                    0 => [
                        'data' => [
                            'type' => 'tsumiage',
                            'tsumiage_id' => $tsumiage->id,
                            'attributes'=> [
                                'item' => $tsumiage->item,
                            ]
                        ],
                        'links' => [
                            'self' => '/tsumiage/' . $tsumiage->id . '/edit',
                        ]
                    ],
                ],
                'count' => 1,
                'links' => [
                    'self' => url('/tsumiage'),
                ]
            ]);
    }

    /** @test **/ 
    public function fields_are_required()
    {
        $user = User::factory()->create();

        $response = $this->post('/api/tsumiage', 
        ['api_token' => $user->api_token, 'add_item1' => '', 'date' => '2021-08-15']);

        $response->assertSessionHasErrors('add_item1');
        $this->assertCount(0, Tsumiage::all());
    }

    /** @test **/ 
    public function time_must_be_numeric()
    {
        $user = User::factory()->create();

        $response = $this->post('/api/tsumiage', 
        ['api_token' => $user->api_token, 'add_item1' => '', 'date' => '2021-08-15',
            'add_plan_time1' => 'not numeric', 'add_actual_time1' => 'not numeric']);

        $response->assertSessionHasErrors('add_plan_time1');
        $response->assertSessionHasErrors('add_actual_time1');
        $this->assertCount(0, Tsumiage::all());
    }
}
