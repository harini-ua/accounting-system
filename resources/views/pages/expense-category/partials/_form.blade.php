<form class="handle-submit-form" id="accountForm" name="user-form" method="POST"
      data-created-item="expense category"
      action="{{ route('expense-categories.store') }}">
    @csrf
    <div class="row">
        <div class="col s12 m6">
            <div class="input-field col s12">
                <input id="name" name="name" title="Category name" type="text">
                <label for="name">Name</label>
                <span class="error-span"></span>
            </div>
        </div>
        <div class="col s12 m6">
            <div class="input-field col s12">
                                    <textarea id="comment" name="comment" class="materialize-textarea"
                                              title="Comments"></textarea>
                <label for="comment">Comment</label>
                <span class="error-span"></span>
            </div>
        </div>
        <div class="col s12 display-flex justify-content-end mt-3">
            <button type="button" class="btn btn-light mr-1 cancel-btn slide-up-btn">Cancel</button>

            <button type="submit" class="btn waves-effect waves-light">
                Save changes
            </button>
        </div>
    </div>
</form>