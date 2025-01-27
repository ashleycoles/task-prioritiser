<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        $tasks = $this->taskService->getUsersPrioritisedTasks($user);

        return Inertia::render('Tasks/Index', [
            'today' => $tasks['today'] ?? [],
            'future' => $tasks['future'] ?? [],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Tasks/Create');
    }

    public function store(TaskCreateRequest $request): RedirectResponse
    {
        try {
            $this->taskService->createTask($request->validated(), $request->user());
            return redirect(route('tasks.index'));
        } catch (\Exception $e) {
            Log::error('Task creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create task. Try again later.');
        }
    }
}
