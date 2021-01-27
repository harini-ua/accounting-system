<div class="faq row totals-list" data-source="{{ $relation }}">
    @if($title)
        <h6 class="center-align {{ $titleColor ?? '' }}">{{ $title }}</h6>
    @endif
    <div class="totals-content">
        @foreach ($options as $option)
            <div class="col totals-item s12 m6 xl3 mb-0 ">
                <div class="black-text">
                    <div class="card z-depth-0 white lighten-3 faq-card m-0">
                        <div class="card-content center-align">
                            {{ $option->name }}: {{ $option->$relation }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
