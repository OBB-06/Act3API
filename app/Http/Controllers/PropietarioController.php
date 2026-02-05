<?php

namespace App\Http\Controllers;

use App\Models\Propietario;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class PropietarioController extends Controller
{
    /**
     * Listar todos los propietarios
     */
    public function index()
    {
        try {
            $propietarios = Propietario::with('animales')->get();
            return response()->json([
                'success' => true,
                'data' => $propietarios
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los propietarios',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo propietario
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nombre' => 'required|string|max:255',
                'apellido' => 'required|string|max:255',
            ]);

            $propietario = Propietario::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Propietario creado exitosamente',
                'data' => $propietario
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
                'message' => 'Error al crear el propietario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar un propietario específico
     */
    public function show($id)
    {
        try {
            $propietario = Propietario::with('animales')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $propietario
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Propietario no encontrado'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener el propietario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un propietario
     */
    public function update(Request $request, $id)
    {
        try {
            $propietario = Propietario::findOrFail($id);

            $validated = $request->validate([
                'nombre' => 'sometimes|required|string|max:255',
                'apellido' => 'sometimes|required|string|max:255',
            ]);

            $propietario->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Propietario actualizado exitosamente',
                'data' => $propietario
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Propietario no encontrado'
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
                'message' => 'Error al actualizar el propietario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un propietario (y sus animales en cascada)
     */
    public function destroy($id)
    {
        try {
            $propietario = Propietario::findOrFail($id);
            $propietario->delete();

            return response()->json([
                'success' => true,
                'message' => 'Propietario y sus animales eliminados exitosamente'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Propietario no encontrado'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el propietario',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
