<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tsumiage;

class TsumiageTest extends TestCase
{
    use RefreshDatabase;

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
        $response = $this->post('/api/tsumiage', ['api_token' => '', 'item1' => 'test_item']);
        $response->assertRedirect('/');
        $this->assertCount(0, Tsumiage::all());
    }
}
