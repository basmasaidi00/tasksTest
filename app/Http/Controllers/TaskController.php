<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Afficher toutes les tâches de l'utilisateur authentifié
    public function index(Request $request)
    {
        // Récupérer uniquement les tâches de l'utilisateur authentifié
        return response()->json($request->user()->tasks);
    }

    // Créer une nouvelle tâche pour l'utilisateur authentifié
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'title' => 'required|unique:tasks,title',
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in_progress,completed',
            'due_date' => 'required|date',
        ]);

        // Créer la tâche et l'associer à l'utilisateur authentifié
        $task = $request->user()->tasks()->create($validated);

        // Retourner la tâche créée
        return response()->json($task, 201);
    }

    // Afficher une tâche spécifique de l'utilisateur authentifié
    public function show(Request $request, $id)
    {
        // Récupérer la tâche de l'utilisateur authentifié
        $task = $request->user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Tâche non trouvée'], 404);
        }

        return response()->json($task);
    }

    // Mettre à jour une tâche spécifique de l'utilisateur authentifié
    public function update(Request $request, $id)
    {
        // Récupérer la tâche de l'utilisateur authentifié
        $task = $request->user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Tâche non trouvée'], 404);
        }

        // Validation des données
        $validated = $request->validate([
            'title' => 'sometimes|required|unique:tasks,title,' . $id,
            'description' => 'nullable|string',
            'status' => 'nullable|in:pending,in_progress,completed',
            'due_date' => 'sometimes|required|date',
        ]);

        // Mise à jour de la tâche
        $task->update($validated);

        return response()->json($task);
    }

    // Supprimer une tâche spécifique de l'utilisateur authentifié
    public function destroy(Request $request, $id)
    {
        // Récupérer la tâche de l'utilisateur authentifié
        $task = $request->user()->tasks()->find($id);

        if (!$task) {
            return response()->json(['message' => 'Tâche non trouvée'], 404);
        }

        // Suppression de la tâche
        $task->delete();

        return response()->json(['message' => 'Tâche supprimée']);
    }
}
