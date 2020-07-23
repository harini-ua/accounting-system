<div class="{{ $className }}" data-table="{{ $table }}" data-url="{{ $url }}" data-name="{{ $name }}">
    <!-- Dropdown Trigger -->
    <a class="dropdown-trigger btn waves-effect waves-light purple darken-1 border-round display-flex align-items-center justify-content-center full-width" href="#"
       data-target="btn-filter-{{ $table }}-{{ $id }}">
        <span>{{ $title }}</span>
        <i class="material-icons">keyboard_arrow_down</i>
    </a>
    <!-- Dropdown Structure -->
    <ul id="btn-filter-{{ $table }}-{{ $id }}" class="dropdown-content">
        <li><a class="option" data-id="" href="#!">All</a></li>
        @foreach($options as $option)
            <li><a class="option" data-id="{{ $option->id }}" href="#!">{{ $option->name }}</a></li>
        @endforeach
    </ul>
</div>

