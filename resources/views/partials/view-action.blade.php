@php($routeName = str_replace('_', '-', $model->getTable()))
<a class="mr-4" href="{{route("$routeName.show", $model)}}"><i class="material-icons">remove_red_eye</i></a>
