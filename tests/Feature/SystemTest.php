<?php

namespace Tests\Feature;

use Tests\TestCase;

class SystemTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testSubscribeToTopic()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/subscribe/topic1', [
            "url" => "https://webhook.site/09742acc-754e-41b8-922a-7300663604d3"
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                "url",
                "topic"
            ]);
    }

    public function testPublishToTopic()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/publish/topic1', [
            "fname" => "Salvation",
            "lname" => "Arinze"
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                "status"=>true
            ]);;
    }
}
