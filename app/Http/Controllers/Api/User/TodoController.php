<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Api\Todo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\TodoRequest;

/**
 * @group Todos management
 * @authenticated
 * APIs for managing todos
 */

class TodoController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api');
    }

    /**
     * Display all todos of an authenticated user
     * @response 201
     * {
     *"current_page": 1,
     *"data":[
     *{
     *id": 2,
     *"user_id": 6,
     *"todo": "Play football",
     *"due": "2021-10-25",
     *"is_done": 0,
     *"created_at": "2021-10-24T06:40:05.000000Z",
     *"updated_at": "2021-10-24T06:41:31.000000Z"
     *},
     *{
     *   "id": 3,
     *  "user_id": 6,
     *  "todo": "Take a outside",
     *  "due": "2021-10-25",
     * "is_done": 0,
     * "created_at": "2021-10-24T07:39:03.000000Z",
     *"updated_at": "2021-10-24T07:39:03.000000Z"
     *  },
     *],
     *"first_page_url": "http://localhost:8000/api/todos?page=1",
     *"from": 1,
     *"last_page": 1,
     *"last_page_url": "http://localhost:8000/api/todos?page=1",
     *"links": [
     *{
     *    "url": null,
     *     "label": "&laquo; Previous",
     *     "active": false
     * },
     * {
     *"url": "http://localhost:8000/api/todos?page=1",
     *"label": "1",
     * "active": true
     * },
     * {
     *  "url": null,
     *  "label": "Next &raquo;",
     * "active": false
     *}
     *],
     *"next_page_url": null,
     *"path": "http://localhost:8000/api/todos",
     *"per_page": 10,
     *"prev_page_url": null,
     *"to": 6,
     * "total": 6
     *}
     */
    public function index()
    {
        return Todo::where('user_id', auth()->id())->paginate(10);
    }

    /**
     * Create a Todo
     * @response 201
     * 
     * {
     *"message": "Task Added Successfully",
     *"result": {
     *   "todo": "Take a shower",
     *   "due": "2021-10-25",
     *   "user_id": 6,
     *   "updated_at": "2021-10-24T07:50:43.000000Z",
     *   "created_at": "2021-10-24T07:50:43.000000Z",
     *  "id": 8
     *}
     *}
     */
    public function store(TodoRequest $request)
    {
        $todo = Todo::create($request->validated() + ['user_id' => auth()->id()]);

        return $this->response(['message' => 'Task Added Successfully', 'result' => $todo]);
    }

    /**
     * Update a specific Todo
      * @response 201
     * 
     * {
     *"message": "Task Updated Successfully",
     *"result": {
     *   "todo": "Take a shower but not on the afternoon",
     *   "due": "2021-10-25",
     *   "user_id": 6,
     *   "updated_at": "2021-10-24T07:50:60.000000Z",
     *   "created_at": "2021-10-24T07:50:60.000000Z",
     *  "id": 8
     *}
     *}
     */
    public function update(TodoRequest $request, Todo $todo)
    {
        $todo->update($request->validated());

        return $this->response(['message' => 'Task Updated Successfully', 'result' => $todo]);
    }

    /**
     * Delete a specific Todo
     * @response 201
     * {
     *"message": "Task Deleted Successfully"
     *}
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return $this->response(['message' => 'Task Deleted Successfully']);
    }
}
