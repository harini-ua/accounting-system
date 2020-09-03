@php($routeName = str_replace('_', '-', $model->getTable()))
@php($title = $title ?? $model->name)
<a href="{{ route("$routeName.show", $model->id) }}">{{ $title }}</a>