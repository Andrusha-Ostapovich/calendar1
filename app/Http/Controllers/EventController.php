<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
class EventController extends Controller
{
    public function create(Request $request)
    {     
       
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'color' => 'required|string|max:7',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
        ]);

        // Опрацьовувати дані форми та зберегти подію в базі даних
        $user = auth()->user();
        
        $event = new Event([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'color' => $request->color,
            'user_id' => $user->id, // Додайте цей рядок
        ]);
        $event->save();
    
        return redirect()->back()->with('success', 'Подія успішно створена.');

         // Вивести повідомлення про помилку
    
    }
}
