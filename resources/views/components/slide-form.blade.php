<div class="card slide-down-block">
    <div class="card-content">
        <form name="{{ $id }}" class="edit-contact-item mb-5 mt-5" method="post" action="{{ route("$resource.$id", $model()) }}">
            @csrf
            {{ $slot }}
        </form>
    </div>
</div>