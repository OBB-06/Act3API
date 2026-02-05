<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class AnimalController extends Controller
{
    /**
     * Listar todos los animales
     */
    public function index()
    {
        try {
            $animales = Animal::with('propietario')->get();
            return response()->json([
                'success' => true,
                'data' => $animales
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los animales',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo animal
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'tipo' => 'required|in:perro,gato,hamster,conejo',
                'peso' => 'nullable|numeric|min:0',
                'enfermedad' => 'nullable|string|max:255',
                'comentarios' => 'nullable|string',
                'id_persona' => 'nullable|exists:propietarios,id_persona',
            ]);

            $animal = Animal::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Animal creado exitosamente',
                'data' => $animal->load('propietario')
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el animal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un animal específico
     */
    public function show($id)
    {
        try {
            $animal = Animal::with('propietario')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $animal
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Animal no encontrado'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el animal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un animal
     */
    public function update(Request $request, $id)
    {
        try {
            $animal = Animal::findOrFail($id);

            $validated = $request->validate([
                'nombre' => 'sometimes|required|string|max:255',
                'tipo' => 'sometimes|required|in:perro,gato,hamster,conejo',
                'peso' => 'nullable|numeric|min:0',
                'enfermedad' => 'nullable|string|max:255',
                'comentarios' => 'nullable|string',
                'id_persona' => 'nullable|exists:propietarios,id_persona',
            ]);

            $animal->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Animal actualizado exitosamente',
                'data' => $animal->load('propietario')
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Animal no encontrado'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el animal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un animal
     */
    public function destroy($id)
    {
        try {
            $animal = Animal::findOrFail($id);
            $animal->delete();

            return response()->json([
                'success' => true,
                'message' => 'Animal eliminado exitosamente'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Animal no encontrado'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el animal',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
