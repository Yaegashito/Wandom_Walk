<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Belonging;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class BelongingTest extends TestCase
{
    use RefreshDatabase;

    public function test_belonging_can_be_stored(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'user_id' => $user->id,
            'belonging' => 'リード',
        ];

        $response = $this->postJson('/belonging', $data);

        $response->assertStatus(JsonResponse::HTTP_OK);

        $this->assertDatabaseHas('belongings', [
            'user_id' => $user->id,
            'belonging' => 'リード',
        ]);

        $response->assertJsonStructure(['id']);
    }

    public function test_belonging_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $belonging = Belonging::factory()->create([
            'user_id' => $user->id,
            'belonging' => 'リード',
        ]);

        $response = $this->deleteJson('/belonging/' . $belonging->id);

        $this->assertDatabaseMissing('belongings', [
            'id' => $belonging->id,
        ]);
    }
}
