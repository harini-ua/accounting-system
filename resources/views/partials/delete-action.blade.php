@php($routeName = str_replace('_', '-', $model->getTable()))
<a class="delete-link" href="#" onclick="return false;" data-remove="{{ route("{$model->getTable()}.destroy", $model) }}"><i class="material-icons">delete</i></a>
