@if($model->$field)
    <span class="chip green-text"><i class="material-icons">done</i></span>
@else
    <span class="chip red-text"><i class="material-icons">clear</i></span>
@endif
