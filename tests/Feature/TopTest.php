<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\Models\Belonging;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class TopTest extends TestCase
{
    use RefreshDatabase;

    public function test_top_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $belonging = Belonging::factory()->create([
            'user_id' => $user->id,
            'belonging' => 'リード',
        ]);

        Config::set('services.googlemaps.api_key', 'test-api-key');

        $this->actingAs($user);

        $response = $this->get('/top');

        $response->assertStatus(200);

        $response->assertViewHas('key', 'test-api-key');
        $response->assertViewHas('belongings', function($belongings) use ($belonging) {
            return $belongings->contains($belonging);
        });
        $response->assertViewHas('userName', $user->name);
    }
}
