<div id="{{ $id }}-sidebar" class="contact-compose-sidebar">
    <div class="card quill-wrapper">
        <div class="card-content pt-0">
            <div class="card-header display-flex pb-2">
                <h3 class="card-title contact-title-label">{{ $title }}</h3>
                <div class="close close-icon">
                    <i class="material-icons">close</i>
                </div>
            </div>
            <div class="divider"></div>
            <!-- form start -->
            <form name="{{ $id }}" class="edit-contact-item mb-5 mt-5" method="post" action="{{ route("$resource.$id", $model()) }}">
                @csrf
                <div class="row">
                    {{ $slot }}
                </div>
            </form>
            <!-- form start end-->
            <div class="card-action pl-0 pr-0 right-align">
                <button class="btn-small waves-effect waves-light add-contact">
                    <span>{{ $button }}</span>
                </button>
            </div>
        </div>
    </div>
</div>
