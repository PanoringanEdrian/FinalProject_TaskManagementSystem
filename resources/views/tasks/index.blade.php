<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<div class="container">
    <h1>📋 Task Manager</h1>


    <div class="summary-cards">
        <div class="summary-card pending-card">
            <div class="summary-icon-box">
                <i class="fas fa-clock"></i>
            </div>
            <div class="summary-info">
                <span class="summary-count">{{ $pending->count() }}</span>
                <span class="summary-label">Pending</span>
            </div>
        </div>
        <div class="summary-card completed-card">
            <div class="summary-icon-box">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="summary-info">
                <span class="summary-count">{{ $completed->count() }}</span>
                <span class="summary-label">Completed</span>
            </div>
        </div>
        <div class="summary-card missing-card">
            <div class="summary-icon-box">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="summary-info">
                <span class="summary-count">{{ $missing }}</span>
                <span class="summary-label">Overdue</span>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

  
    <div class="form-card">
        <h5>Add New Task</h5>
        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf
            <input name="title" placeholder="Task title" required>
            @error('title') <p class="error-text">{{ $message }}</p> @enderror

            <textarea name="description" placeholder="Description (optional)" rows="2"></textarea>

            <select name="category_id" required>
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="error-text">{{ $message }}</p> @enderror

            <input type="date" name="due_date" required>
            @error('due_date') <p class="error-text">{{ $message }}</p> @enderror

            <button type="submit" class="btn-add">Add Task</button>
        </form>
    </div>

  
    <h4>⏳ Pending</h4>
    @forelse($pending as $task)
        <div class="task-card {{ $task->due_date < now()->toDateString() ? 'overdue' : '' }}">
            <div>
                <span class="task-title">{{ $task->title }}</span>
                <span class="badge">{{ $task->category->name }}</span>
                @if($task->description)
                    <p class="task-meta">{{ $task->description }}</p>
                @endif
                <p class="task-meta">Due: {{ $task->due_date }}
                    @if($task->due_date < now()->toDateString())
                        <span class="overdue-text">⚠ Overdue</span>
                    @endif
                </p>
            </div>
            <div class="task-actions">
                <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                    @csrf @method('PATCH')
                    <button class="btn-done">Done</button>
                </form>
                <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                    @csrf @method('DELETE')
                    <button class="btn-delete">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <p class="empty-text">No pending tasks!</p>
    @endforelse


    <h4>✅ Completed</h4>
    @forelse($completed as $task)
        <div class="task-card completed">
            <div>
                <span class="task-title done">{{ $task->title }}</span>
                <span class="badge badge-done">{{ $task->category->name }}</span>
            </div>
            <div class="task-actions">
                <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                    @csrf @method('PATCH')
                    <button class="btn-undo">Undo</button>
                </form>
                <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                    @csrf @method('DELETE')
                    <button class="btn-delete">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <p class="empty-text">No completed tasks yet.</p>
    @endforelse
</div>
</body>
</html>