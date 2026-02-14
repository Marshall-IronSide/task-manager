# Task Manager

A clean, modern task management application built with **Laravel 12**, **Vite**, and **Tailwind CSS**. Create, organize, and track your tasks with a simple resource-based REST API.

## Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & npm
- SQLite (included by default)

### Setup

```bash
# Clone the repo
git clone <repo-url>
cd task-manager

# Install and configure everything
composer run setup
```

This command will:
- Install PHP dependencies via Composer
- Generate `.env` from `.env.example`
- Create SQLite database
- Generate APP_KEY
- Run migrations
- Install npm packages
- Build assets

### Development

```bash
composer run dev
```

Starts the development environment with:
- **PHP Server:** http://localhost:8000
- **Vite Dev Server:** Hot module reloading for CSS/JS
- **Queue Listener:** Background job processing
- **Log Viewer:** Real-time app logs via pail

### Testing

```bash
composer run test
```

Runs PHPUnit test suite with in-memory SQLite database.

---

## Architecture

### Resource-Based Design
The app uses Laravel's **resource controller pattern** for clean CRUD routing:

| Method | Route | Handler |
|--------|-------|---------|
| GET | `/tasks` | index() - List all tasks |
| GET | `/tasks/{task}` | show() - View single task |
| GET | `/tasks/create` | create() - Show create form |
| POST | `/tasks` | store() - Save new task |
| GET | `/tasks/{task}/edit` | edit() - Show edit form |
| PUT | `/tasks/{task}` | update() - Save changes |
| DELETE | `/tasks/{task}` | destroy() - Delete task |

### Data Model

**Task** ([app/Models/Task.php](app/Models/Task.php)):
```php
- id          (primary key)
- title       (string, required)
- description (text, nullable)
- completed   (boolean, default: false)
- created_at, updated_at
```

Mass-assignable fields: `['title', 'description', 'completed']`  
Auto-casts: `completed` → boolean

### Project Structure

```
app/
  Http/Controllers/TaskController.php    # All CRUD logic & validation
  Models/Task.php                        # Task model with casts

database/
  migrations/...create_tasks_table.php   # Schema definition

routes/
  web.php                                # Resource routing

resources/
  views/tasks/                           # Blade templates
    - index.blade.php
    - create.blade.php
    - edit.blade.php
    - show.blade.php
  css/app.css                            # Tailwind styles
  js/app.js                              # JavaScript entry

tests/
  Feature/                               # HTTP/integration tests
  Unit/                                  # Logic tests
```

---

## Development Patterns

### Validation
Inline validation in controller methods using `$request->validate()`:
```php
$validated = $request->validate([
    'title' => 'required|max:225',
    'description' => 'nullable',
    'completed' => 'boolean'
]);
Task::create($validated);
```

### Model Binding
Route parameters automatically resolve to model instances:
```php
// Route: /tasks/{task}
public function show(Task $task) {
    return view('tasks.show', compact('task')); // $task is auto-injected
}
```

### Flash Messages
Redirect with user feedback:
```php
return redirect()->route('tasks.index')
    ->with('success', 'Task created successfully.');
```

### Eloquent Queries
```php
Task::all()                              # All tasks
Task::orderBy('created_at', 'desc')     # Newest first
Task::where('completed', true)->get()   # Filtered
$task->update(['completed' => true])    # Update instance
$task->delete()                         # Delete instance
```

---

## Configuration

### Environment Variables
Key `.env` settings:
```
APP_ENV=local
APP_DEBUG=true
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Switch to MySQL by updating `DB_*` variables.

### Asset Pipeline
- **CSS:** Tailwind v4 via `@tailwindcss/vite` plugin
- **JS:** ES modules with Vite
- **Build:** `npm run build` (production), `npm run dev` (dev with HMR)

---

## Known Issues & Roadmap

### Current Limitations
- [ ] Task views (index, create, edit, show) not yet implemented
- [ ] Route name typos in redirects: `task.index` → should be `tasks.index`
- [ ] No user-task relationship (single-tenant only)
- [ ] No authentication middleware on routes

### Planned Features
- [ ] Multi-user support with task assignment
- [ ] Task priorities and due dates
- [ ] Categories/tags for organization
- [ ] Task filtering and search

---

## Testing

Write feature tests in `tests/Feature/`:
```php
public function test_can_create_task()
{
    $response = $this->post('/tasks', [
        'title' => 'My Task',
        'description' => 'Do something'
    ]);
    
    $this->assertDatabaseHas('tasks', ['title' => 'My Task']);
}
```

Test database is in-memory SQLite—no separate config needed.

---

## License

MIT License. See LICENSE file for details.
