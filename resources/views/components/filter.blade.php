<div class="{{ $className }} custom-filter-btn input-field" data-table="{{ $table }}" data-url="{{ $url }}" data-name="{{ $name }}">
    <!-- Dropdown Trigger -->
    <a class="dropdown-trigger full-width" href="#"
       data-target="btn-filter-{{ $table }}-{{ $id }}">
        <input type="text" class="custom-filter-input" id="input-filter-{{ $table }}-{{ $id }}">
{{--        <span class="hide">{{ $title }}</span>--}}
{{--        <span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>--}}
        <svg class="caret" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"></path><path d="M0 0h24v24H0z" fill="none"></path></svg>
    </a>
    <label class="custom-filter-label"> {{ $title }}</label>
    <!-- Dropdown Structure -->
    <ul id="btn-filter-{{ $table }}-{{ $id }}" class="dropdown-content">
        @if($all)<li><a class="option" data-id="" href="#!">All</a></li>@endif
        @foreach($options as $option)
            <li><a class="option" data-id="{{ $option->id }}" href="#!">{{ $option->name }}</a></li>
        @endforeach
    </ul>
</div>

