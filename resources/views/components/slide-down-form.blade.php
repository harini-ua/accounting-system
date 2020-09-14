<div id="{{ $id }}-slide-down" class="card slide-down-block">
    <div class="card-content">
        <div class="card-header display-flex pb-2">
            <h3 class="card-title contact-title-label">{{ $title }}</h3>
        </div>
        <form name="{{ $id }}" class="edit-contact-item" method="post" action="{{ route("$resource.$id", $model()) }}">
            @csrf
            {{ $slot }}
            <div class="row">
                <div class="col s12">
                    <div class="col s12 display-flex justify-content-end mt-3">
                        <a href="{{ url()->previous() }}" class="cancel-btn btn btn-light {{ __('slide-up-btn') }} mr-1">{{ __('Cancel') }}</a>
                        <button type="submit" class="btn waves-effect waves-light">{{ __('Save') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
