<div id="{{ $id }}-slide-down" class="card slide-down-block">
    <div class="float-right mr-1 mt-1 close-slide-down cursor-pointer"><i class="material-icons">close</i></div>
    <div class="card-content">
        <div class="card-header display-flex pb-2">
            <h3 class="card-title contact-title-label">{{ $title }}</h3>
        </div>
        <form name="{{ $id }}" class="edit-contact-item person-handle-submit" method="post" action="{{ route("$resource.$id", $model()) }}">
            @csrf
            {{ $slot }}
            <div class="row">
                <div class="col s12">
                    <div class="col s12 display-flex justify-content-end mt-3">
                        <button type="button"class="person-submit-btn btn waves-effect waves-light" disabled>{{ __('Save') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
