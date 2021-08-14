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
}
