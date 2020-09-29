<div class="{{ $className }} custom-filter-btn input-field" data-table="{{ $table }}" data-url="{{ $url }}"
     data-name="{{ $name }}">
    <!-- Dropdown Trigger -->
    <a class="full-width custom-filter-trigger" href="#"
       data-target="btn-filter-{{ $table }}-{{ $id }}">
        <input type="text" class="custom-filter-input" id="input-filter-{{ $table }}-{{ $id }}">
        <svg class="caret" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 10l5 5 5-5z"></path>
            <path d="M0 0h24v24H0z" fill="none"></path>
        </svg>
    </a>
    <label class="custom-filter-label"> {{ $title }}</label>
    <select id="filter-{{ $table }}-{{ $id }}" class="position-absolute opacity-0 select-filters select2 browser-default">
        @if($all)<option class="first_default" value="">All</option>@endif
        @foreach($options as $option)
            <option value="{{ $option->id }}" @if($default !== null && $default == $option->id) selected @endif>{{ $option->name }}</option>
        @endforeach
    </select>
</div>

