<div class="filter-btn" data-table="{{ $table }}" data-url="{{ $url }}" data-name="{{ $name }}">
    <!-- Dropdown Trigger -->
    <a class="dropdown-trigger btn waves-effect waves-light purple darken-1 border-round" href="#"
       data-target="btn-filter-{{ $table }}">
        <span class="hide-on-small-only">{{ $title }}</span>
        <i class="material-icons">keyboard_arrow_down</i>
    </a>
    <!-- Dropdown Structure -->
    <ul id="btn-filter-{{ $table }}" class="dropdown-content">
        <li><a class="option" data-id="all" href="#!">All</a></li>
        @foreach($options as $option)
            <li><a class="option" data-id="{{ $option->id }}" href="#!">{{ $option->name }}</a></li>
        @endforeach
    </ul>
</div>

@push('components-scripts')
    <script src="{{ asset('js/scripts/filter.js') }}"></script>
@endpush

