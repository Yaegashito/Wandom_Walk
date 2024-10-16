<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Belonging;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class OpinionTest extends TestCase
{
    use RefreshDatabase;

    public function test_opinion_can_be_stored(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'user_id' => $user->id,
            'opinion' => '非常に使いにくい。',
        ];

        $response = $this->postJson('/submitOpinion', $data);

        $response->assertStatus(JsonResponse::HTTP_OK);

        $this->assertDatabaseHas('opinions', [
            'user_id' => $user->id,
            'opinion' => '非常に使いにくい。',
        ]);
    }
}
