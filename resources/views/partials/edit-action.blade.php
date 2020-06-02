@php($routeName = str_replace('_', '-', $model->getTable()))
<a class="mr-4" href="{{route("$routeName.edit", $model)}}"><i class="material-icons">edit</i></a>
