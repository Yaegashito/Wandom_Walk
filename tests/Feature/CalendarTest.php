<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Calendar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    use RefreshDatabase;

    public function test_calendar_records_can_be_fetched()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $user->calendars()->create(['date' => Carbon::create(2024, 9, 16)]);
        $user->calendars()->create(['date' => Carbon::create(2024, 9, 20)]);
        $user->calendars()->create(['date' => Carbon::create(2024, 8, 10)]); // このデータは返されない

        $data = [
            'year' => 2024,
            'month' => 9,
            'date' => 16,
        ];

        $response = $this->postJson('/changeCalendar', $data);

        $response->assertStatus(JsonResponse::HTTP_OK);

        $response->assertJsonStructure(['records']);

        $this->assertCount(2, $response->json('records'));
        $this->assertEquals('2024-09-16', $response->json('records.0.date'));
        $this->assertEquals('2024-09-20', $response->json('records.1.date'));
    }

    public function test_calendar_can_be_stored(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $today = Carbon::today()->toDateString();
        $response = $this->postJson('/storeCalendar');

        $response->assertStatus(JsonResponse::HTTP_OK);

        $this->assertDatabaseHas('calendar', [
            'user_id' => $user->id,
            'date' => $today,
        ]);

        $response->assertJsonStructure(['success', 'date']);
        $response->assertJson(['success' => true, 'date' => $today]);
    }
}
