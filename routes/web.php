<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('tasks', TaskController::class);

/* This single line creates:
   GET    /tasks              -> index()   (list all)
   GET    /tasks/create       -> create()  (show form)
   POST   /tasks              -> store()   (save new)
   GET    /tasks/{task}       -> show()    (view one)
   GET    /tasks/{task}/edit  -> edit()    (edit form)
   PUT    /tasks/{task}       -> update()  (save changes)
   DELETE /tasks/{task}       -> destroy() (delete)
*/
