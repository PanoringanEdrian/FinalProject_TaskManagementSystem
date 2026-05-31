<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;

class TaskController extends Controller {
    public function index() {
        $pending = Task::with('category')->where('status', 'pending')->get();
        $completed = Task::with('category')->where('status', 'completed')->get();
        $categories = Category::all();
        $missing = Task::with('category')
            ->where('status', 'pending')
            ->where('due_date', '<', now()->toDateString())
            ->count();
        return view('tasks.index', compact('pending', 'completed', 'categories', 'missing'));
    }

    public function store(Request $request) {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'due_date'    => 'required|date|after_or_equal:today',
        ]);
        Task::create($request->only('title', 'description', 'category_id', 'due_date'));
        return back()->with('success', 'Task created successfully!');
    }

    public function toggle(Task $task) {
        $task->update([
            'status' => $task->status === 'pending' ? 'completed' : 'pending'
        ]);
        return back()->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task) {
        $task->delete();
        return back()->with('success', 'Task deleted successfully!');
    }
}