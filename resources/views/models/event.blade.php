@section('event')

<div class="modal" id="newEvent" tabindex="-1" aria-labelledby="newEventLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newEventLabel">Додайте Подію</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('events.create') }}" enctype="multipart/form-data">

                    @csrf
                    <label for="title">Введіть назву події:</label>
                    <input type="text" id="title" name="title">
                    <br>
                    <br>
                    <label for="color">Виберіть колір:</label>
                    <input type="color" id="color" name="color">
                    <br>
                    <br>
                    <label for="start">Дата та час початку</label>
                    <input type="datetime-local" id="start" name="start">
                    <label for="end">Дата та час закінчення</label>
                    <input type="datetime-local" id="end" name="end">
                    <br>
                    @if(auth()->check())
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                    @endif
                    <button type="submit" class="btn btn-primary">Готово</button>
            </div>

            </form>