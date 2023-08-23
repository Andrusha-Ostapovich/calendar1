@section('reminder')
<div class="modal" id="newReminder" tabindex="-1" aria-labelledby="newReminderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newReminderLabel">Додайте Нагадування</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('reminders.create') }}" enctype="application/x-www-form-urlencoded">
                    @csrf
                    <label for="rem_title">Введіть назву нагадування:</label>
                    <input type="text" id="rem_title" name="rem_title">
                    <br>
                    <br>
                    <label for="rem_color">Виберіть колір:</label>
                    <input type="color" id="rem_color" name="rem_color">
                    <br>
                    <br>
                    <label for="datetime">Дата та час початку</label>
                    <input type="datetime-local" id="datetime" name="datetime">
                    @if(auth()->check())
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    @endif
                    <button type="submit" class="btn btn-primary">Готово</button>

            </div>

        </div>
        </form>