@if($model->$field)
    <span class="chip lighten-5 green green-text"><i class="material-icons">done</i></span>
@else
    <span class="chip lighten-5 red red-text"><i class="material-icons">clear</i></span>
@endif
