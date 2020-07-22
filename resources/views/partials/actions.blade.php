@php($routeName = $route ?? str_replace('_', '-', $model->getTable()))
<div>
    @includeWhen(in_array('view', $actions, true), 'partials.view-action', ['model' => $model, 'routeName' => $routeName])
    @includeWhen(in_array('edit', $actions, true), 'partials.edit-action', ['model' => $model, 'routeName' => $routeName])
    @includeWhen(in_array('delete', $actions, true), 'partials.delete-action', ['model' => $model, 'routeName' => $routeName])
</div>
