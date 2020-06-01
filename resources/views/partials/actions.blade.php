<div>
    @includeWhen(in_array('view', $actions), 'partials.view-action', ['model'=>$model])
    @includeWhen(in_array('edit', $actions), 'partials.edit-action', ['model'=>$model])
    @includeWhen(in_array('delete', $actions), 'partials.delete-action', ['model'=>$model])
</div>
