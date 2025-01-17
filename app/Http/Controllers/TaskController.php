<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request): Response
    {
        $user = $request->user();

        $tasks = $this->taskService->getPrioritisedTasks($user);

        return Inertia::render('Tasks/Index', [
            'today' => $tasks['today'],
            'future' => $tasks['future']
        ]);
    }
}
