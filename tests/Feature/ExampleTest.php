<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /** @test **/ 
    public function a_contact_can_be_patched()
    {
        $this->withoutExceptionHandling();
        $contact = Contact::factory()->create(['user_id' => $this->user->id]);
        // factoryで作ったレコードを$this->data()で上書き
        $response = $this->patch('api/contacts/' . $contact->id, $this->data());
        $contact = $contact->fresh();

        $this->assertEquals('Test Name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('05/14/1988', $contact->birthday->format('m/d/Y'));
        $this->assertEquals('ABC String', $contact->company);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'data' => [
                'contact_id' => $contact->id
            ],
            'links' => [
                'self' => $contact->path(),
            ]
        ]);
    }  

    private function data()
    {
        return [
            'name' => 'Test Name',
            'email' => 'test@email.com',
            'birthday' => '05/14/1988',
            'company' => 'ABC String',
            'api_token' => $this->user->api_token,
        ];
    }
}