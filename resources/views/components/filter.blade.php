<div class="{{ $className }} custom-filter-btn" data-table="{{ $table }}" data-url="{{ $url }}" data-name="{{ $name }}">
    <!-- Dropdown Trigger -->
    <a class="dropdown-trigger btn waves-effect waves-light purple darken-1 full-width" href="#"
       data-target="btn-filter-{{ $table }}-{{ $id }}">
        <span>{{ $title }}</span>
        <i class="material-icons">keyboard_arrow_down</i>
    </a>
    <!-- Dropdown Structure -->
    <ul id="btn-filter-{{ $table }}-{{ $id }}" class="dropdown-content">
        @if($all)<li><a class="option" data-id="" href="#!">All</a></li>@endif
        @foreach($options as $option)
            <li><a class="option" data-id="{{ $option->id }}" href="#!">{{ $option->name }}</a></li>
        @endforeach
    </ul>
</div>

