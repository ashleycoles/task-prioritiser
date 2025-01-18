<?php

namespace Feature\Tasks;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddTaskTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private array $validData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->validData = [
            'title' => 'test',
            'description' => 'test',
            'estimate' => 1,
            'priority' => 1,
            'deadline' => '2025-01-01',
        ];
    }

    public function test_store_rejects_unauthorised_user(): void
    {
        $response = $this->post(route('tasks.store'), $this->validData);

        $response->assertRedirect(route('login'));
    }

    public function test_store_validation_missing_data(): void
    {

        $response = $this->actingAs($this->user)
            ->post(route('tasks.store'), []);

        $response->assertStatus(302)
            ->assertInvalid([
                'title',
                'description',
                'estimate',
                'priority',
                'deadline',
            ]);
    }

    public function test_store_validation_invalid_data(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('tasks.store'), [
                'title' => str_repeat('a', 256),
                'description' => '',
                'estimate' => -1,
                'priority' => 10,
                'deadline' => 'not-date',
            ]);

        $response->assertStatus(302)
            ->assertInvalid([
                'title',
                'description',
                'estimate',
                'priority',
                'deadline',
            ]);
    }

    public function test_store_returns_correct_response(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('tasks.store'), $this->validData);

        $response->assertRedirect(route('tasks.index'));
    }

    public function test_store_stores_in_database(): void
    {
        $this->actingAs($this->user)
            ->post(route('tasks.store'), $this->validData);

        $this->assertDatabaseHas(Task::class, $this->validData);
    }
}
