@php($routeName = str_replace('_', '-', $model->getTable()))
<a href="{{route("$routeName.show", $model->id)}}">{{ $model->name }}</a>