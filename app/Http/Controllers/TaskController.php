<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Tasks retrieved successfully',
            'data' => Task::all()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'is_completed' => 'boolean'
            ], [
                'title.required' => 'Title wajib diisi!',
                'title.string' => 'Title harus berupa teks!',
                'title.max' => 'Title maksimal 255 karakter!',
                'is_completed.boolean' => 'Status harus berupa true atau false!'
            ]);

            $validated['is_completed'] = $validated['is_completed'] ?? false;

            $task = Task::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Task created successfully',
                'data' => $task
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $task = Task::find($id);

            if (!$task) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Task not found'
                ], Response::HTTP_NOT_FOUND);
            }

            $validated = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'description' => 'nullable|string',
                'is_completed' => 'boolean'
            ], [
                'title.required' => 'Title wajib diisi!',
                'title.string' => 'Title harus berupa teks!',
                'title.max' => 'Title maksimal 255 karakter!',
                'is_completed.boolean' => 'Status harus berupa true atau false!'
            ]);

            $task->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Task updated successfully',
                'data' => $task
            ], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function destroy($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'status' => 'error',
                'message' => 'Task not found'
            ], Response::HTTP_NOT_FOUND);
        }

        $task->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Task deleted successfully'
        ], Response::HTTP_OK);
    }
}
