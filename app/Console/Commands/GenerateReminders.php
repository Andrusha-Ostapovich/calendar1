<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reminder;
use Carbon\Carbon;

class GenerateReminders extends Command
{
    protected $signature = 'reminders:generate';
    protected $description = 'Generate recurring reminders';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Отримати всі нагадування з регулярністю 7 днів
        $reminders = Reminder::where('recurrence', 7)->get();

        foreach ($reminders as $reminder) {
            // Створити новий запис для нагадування
            $newReminder = new Reminder();
            $newReminder->title = $reminder->title;
            $newReminder->color = $reminder->color;
            $newReminder->time = Carbon::parse($reminder->time)->addDays(7);
            $newReminder->save();
        }

        $this->info('Recurring reminders generated successfully.');
    }
}
