<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reminder;

class ReminderController extends Controller
{
    public function create(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'rem_title' => 'required|string|max:255',
            'rem_color' => 'required|string|max:7',
            'rem_datetime' => 'required|date',

        ]);

        // Опрацьовувати дані форми та зберегти подію в базі даних
        $user = auth()->user();

        $reminder = new Reminder([
            'rem_title' => $request->rem_title,
            'rem_datetime' => $request->rem_datetime,
            'rem_color' => $request->rem_color,
            'user_id' => $user->id, // Додайте цей рядок
        ]);
        $reminder->save();

        return redirect()->back()->with('success', 'Подія успішно створена.');

        // Вивести повідомлення про помилку

    }

    
}
