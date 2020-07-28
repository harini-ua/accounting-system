<div class="faq row totals-list" data-source="{{ $relation }}">
    @if($title)
        <h6 class="center-align {{ $titleColor ?? '' }}">{{ $title }}</h6>
    @endif
    <div class="totals-content">
        @foreach ($options as $option)
            <div class="col s12 m6 xl3">
                <div class="black-text">
                    <div class="card z-depth-0 white lighten-3 faq-card">
                        <div class="card-content center-align">
                            {{ $option->name }}: {{ $option->$relation }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
