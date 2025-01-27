<?php

namespace Tests\Unit\Services;


use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class TaskServiceTest extends TestCase
{

    private User $userMock;

    public function setUp(): void
    {
        parent::setUp();

        $userMock = Mockery::mock(User::class);

        $taskRelationshipMock = Mockery::mock(BelongsToMany::class);

        $taskRelationshipMock->shouldReceive('orderByPriority')
            ->andReturnSelf();

        $taskRelationshipMock->shouldReceive('get')->andReturn(collect([
            new Task(['title' => 'Task 1', 'deadline' => Carbon::yesterday(), 'estimate' => 2, 'priority' => 5]),
            new Task(['title' => 'Task 2', 'deadline' => Carbon::today(), 'estimate' => 1, 'priority' => 5]),
            new Task(['title' => 'Task 3', 'deadline' => Carbon::today(), 'estimate' => 4, 'priority' => 4]),
            new Task(['title' => 'Task 4', 'deadline' => Carbon::yesterday(), 'estimate' => 6, 'priority' => 2]),
            new Task(['title' => 'Task 5', 'deadline' => Carbon::tomorrow(), 'estimate' => 6, 'priority' => 1]),
        ]));

        $userMock->shouldReceive('tasks')->andReturn($taskRelationshipMock);

        $userMock->shouldReceive('getAttribute')
            ->with('hours')
            ->andReturn(8);

        $this->userMock = $userMock;
    }

    public function test_getUsersPrioritisedTasks_correctGrouping(): void
    {
        $taskService = new TaskService();

        $case = $taskService->getUsersPrioritisedTasks($this->userMock);

        $this->assertInstanceOf(Collection::class, $case);
        $this->assertArrayHasKey('today', $case->toArray());
        $this->assertArrayHasKey('future', $case->toArray());

        $this->assertCount(2, $case['today']);
        $this->assertCount(3, $case['future']);
    }

    public function test_getUsersPrioritisedTasks_correctSorting(): void
    {
        $taskService = new TaskService();

        $case = $taskService->getUsersPrioritisedTasks($this->userMock);

        $this->assertEquals('Task 1', $case['today'][0]->title);
        $this->assertEquals('Task 4', $case['today'][1]->title);
        $this->assertEquals('Task 2', $case['future'][0]->title);
        $this->assertEquals('Task 3', $case['future'][1]->title);
        $this->assertEquals('Task 5', $case['future'][2]->title);
    }
}
