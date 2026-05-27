<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TareaController extends Controller
{
    public function index()
    {
        $tareas = Tarea::delUsuario(Auth::id())
                        ->orderByDesc('created_at')
                        ->get();

        return view('tareas.index', [
            'tareas'  => $tareas,
            'estados' => Tarea::ESTADOS,
        ]);
    }

    public function create()
    {
        return view('tareas.crear', [
            'estados' => Tarea::ESTADOS,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'       => 'required|string|max:200',
            'descripcion'  => 'nullable|string',
            'estado'       => 'required|in:pendiente,en_progreso,completada,cancelada',
            'fecha_limite' => 'nullable|date',
        ], [
            'titulo.required'   => 'El título es obligatorio.',
            'titulo.max'        => 'El título no puede superar 200 caracteres.',
            'estado.in'         => 'El estado seleccionado no es válido.',
            'fecha_limite.date' => 'La fecha límite no tiene un formato válido.',
        ]);

        $data['user_id'] = Auth::id();
        Tarea::create($data);

        return redirect('/tareas')->with('success', 'Tarea creada correctamente.');
    }

    public function edit(string $id)
    {
        $tarea = Tarea::delUsuario(Auth::id())->findOrFail($id);

        return view('tareas.editar', [
            'tarea'   => $tarea,
            'estados' => Tarea::ESTADOS,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $tarea = Tarea::delUsuario(Auth::id())->findOrFail($id);

        $data = $request->validate([
            'titulo'       => 'required|string|max:200',
            'descripcion'  => 'nullable|string',
            'estado'       => 'required|in:pendiente,en_progreso,completada,cancelada',
            'fecha_limite' => 'nullable|date',
        ], [
            'titulo.required'   => 'El título es obligatorio.',
            'titulo.max'        => 'El título no puede superar 200 caracteres.',
            'estado.in'         => 'El estado seleccionado no es válido.',
            'fecha_limite.date' => 'La fecha límite no tiene un formato válido.',
        ]);

        $tarea->update($data);

        return redirect('/tareas')->with('success', 'Tarea actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $tarea = Tarea::delUsuario(Auth::id())->findOrFail($id);
        $tarea->delete();

        return redirect('/tareas')->with('success', 'Tarea eliminada correctamente.');
    }

    public function cambiarEstado(Request $request, string $id)
    {
        $tarea = Tarea::delUsuario(Auth::id())->findOrFail($id);

        $request->validate([
            'estado' => 'required|in:pendiente,en_progreso,completada,cancelada',
        ]);

        $tarea->update(['estado' => $request->estado]);

        return response()->json([
            'ok'          => true,
            'estadoLabel' => Tarea::ESTADOS[$request->estado],
        ]);
    }
}