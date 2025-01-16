<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function index(): Response
    {
        $tasks = Task::all();

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks
        ]);
    }
}
