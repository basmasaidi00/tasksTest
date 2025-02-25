<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\tasks;
use Validator;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Auth;

class TaskController extends BaseController
{
    /**
     * Display a listing of the tasks of the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
   /* public function index()
    {
        $tasks = tasks::where('user_id', Auth::id())->get();
    
        return $this->sendResponse(TaskResource::collection($tasks), 'Tasks retrieved successfully.');
    }*/
    public function index(Request $request)
{
    $user = auth()->user();
    
    
    $status = $request->query('status');
    $dueDate = $request->query('due_date');

    
    $query = tasks::where('user_id', $user->id);

    if ($status) {
        $query->where('status', $status);
    }

    if ($dueDate) {
        $query->whereDate('due_date', $dueDate);
    }

    $tasks = $query->get();

    return $this->sendResponse(TaskResource::collection($tasks), 'Tasks retrieved successfully.');
}


    /**
     * Store a newly created task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   /* public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'required|date'
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input['user_id'] = Auth::id();
        $task = tasks::create($input);
   
        return $this->sendResponse(new TaskResource($task), 'Task created successfully.');
    } **/

public function store(Request $request)
{
    try {
        // Vérifier que l'utilisateur est authentifié
        if (!Auth::check()) {
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);
        }

        // Récupération des données de la requête
        $input = $request->all();

        // Validation des champs
        $validator = Validator::make($input, [
            'title' => 'required|string|unique:tasks,title',
            'description' => 'required|string',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'required|date'
        ]);

        // Vérification des erreurs de validation
        if ($validator->fails()) {
            return response()->json(['error' => 'Validation Error', 'details' => $validator->errors()], 422);
        }

        // Ajouter l'ID de l'utilisateur authentifié
        $input['user_id'] = Auth::id();

        // Création de la tâche
        $task = tasks::create($input);

        // Retourner une réponse JSON avec la tâche créée
        return $this->sendResponse(new TaskResource($task), 'Task created successfully.');

    } catch (\Exception $e) {
        // Gestion des erreurs
        return response()->json([
            'error' => 'Une erreur est survenue',
            'details' => $e->getMessage()
        ], 500);
    }
}

   
    /**
     * Update the specified task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = tasks::where('id', $id)->where('user_id', Auth::id())->first();
        
        if (!$task) {
            return $this->sendError('Task not found.');
        }
   
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'required|date'
        ]);
   
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $task->title = $input['title'];
        $task->description = $input['description'];
        $task->status = $input['status'];
        $task->due_date = $input['due_date'];
        $task->save();
   
        return $this->sendResponse(new TaskResource($task), 'Task updated successfully.');
    }
   
    /**
     * Remove the specified task from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = tasks::where('id', $id)->where('user_id', Auth::id())->first();
   
        if (!$task) {
            return $this->sendError('Task not found.');
        }
   
        $task->delete();
   
        return $this->sendResponse([], 'Task deleted successfully.');
    }
}
