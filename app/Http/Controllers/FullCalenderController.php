<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Jobs\StartEventNotification;
use App\Jobs\CompleteEventNotification;
use App\Models\Reminder;
class FullCalenderController extends Controller
{
    public function index(Request $request)
{
    $user = auth()->user();
    $data = [];

    if ($request->ajax()) {
        $reminders = Reminder::where('user_id', $user->id)
            ->whereDate('rem_datetime', '>=', $request->start)
            ->whereDate('rem_datetime', '<=', $request->end)
            ->get(['id', 'rem_title as title', 'rem_datetime as start', 'rem_datetime as end', 'rem_color as color']);

        $events = Event::where('user_id', $user->id)
            ->whereDate('start', '>=', $request->start)
            ->whereDate('end', '<=', $request->end)
            ->get(['id', 'title', 'start', 'end', 'color']);

        $data = $reminders->concat($events);
    }

    return response()->json($data);
}


    public function action(Request $request)
    {
        if ($request->ajax()) {

            if ($request->type == 'add') {
                $user = Auth::user();
                $event = Event::create([
                    'user_id'   =>  $user->id,
                    'title'     =>  $request->title,
                    'start'     =>  $request->start,
                    'end'       =>  $request->end,
                    'color'     =>  $request->color // Додайте поле 'color'
                ]);

                return response()->json($event);
            }

            if ($request->type == 'update') {
                $event = Event::find($request->id)->update([
                    'title'     =>  $request->title,
                    'start'     =>  $request->start,
                    'end'       =>  $request->end,
                    'color'     =>  $request->color // Додайте поле 'color'
                ]);

                return response()->json($event);
            }

            if ($request->type == 'delete') {
                $event = Event::find($request->id)->delete();

                return response()->json($event);
            }
        }
    }
    public function updateEvents(Request $request)
    {
        if ($request->ajax()) {
            $event = Event::find($request->id);

            if ($event) {
                $event->update(['title' => $request->title]);
                $event->update(['color' => $request->color]);
                return response()->json($event);
            } else {
                return response()->json(['error' => 'Event not found'], 404);
            }
        }
    }
    public function updateEvent(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        // Оновлення події за допомогою даних з $request
        $event->title = $request->title;
        $event->start = $request->start;
        $event->end = $request->end;
        // Перевірка, чи подія була завершена або почалася
        if ($event->is_completed) {
            // Відправка повідомлення про завершення події через чергу
            StartEventNotification::dispatch($event);
        } elseif ($event->is_started) {
            // Відправка повідомлення про початок події через чергу
            CompleteEventNotification::dispatch($event);
        }

        // Збереження оновленої події
        $event->save();

        return response()->json($event);
    }
    public function updateEventCompleted(Request $request)
    {
        $event = Event::find($request->id);

        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        $event->is_completed = $request->is_completed;
        $event->save();

        return response()->json($event);
    }
}
