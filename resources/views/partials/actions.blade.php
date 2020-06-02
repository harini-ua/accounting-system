<div>
    @includeWhen(in_array('view', $actions, true), 'partials.view-action', ['model' => $model])
    @includeWhen(in_array('edit', $actions, true), 'partials.edit-action', ['model' => $model])
    @includeWhen(in_array('delete', $actions, true), 'partials.delete-action', ['model' => $model])
</div>
