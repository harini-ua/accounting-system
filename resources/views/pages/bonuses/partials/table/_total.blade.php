@switch($positionId)

    @case(\App\Enums\Position::SalesManager)

        <div class="internal-table">
            @foreach($data as $code => $values)
                <div class="tr">
                    @php
                        $query = ['year' => $year, 'currency' => $code];
                        $personUrl = route("bonuses.person.show", $model->id).'?'.Arr::query($query);
                        $reseived = \App\Services\Formatter::currency($values[0], $currency[$code]);
                        $bonuses = \App\Services\Formatter::currency($values[1], $currency[$code]);
                    @endphp
                    <div class="td {{ ((int) $values[1]) ? 'tooltipped' : '' }}"
                         @if((int) $values[1]) data-position="left" @endif
                         @if((int) $values[1])  data-tooltip="{{__("Reseived").': '.$reseived.'<br>'.__("Bonuses").': '.$bonuses}}" @endif
                    >
                        <a href="{{$personUrl}}">{{ \App\Services\Formatter::currency($values[1], $currency[$code]) }}</a>
                    </div>
                </div>
            @endforeach
        </div>
        @break

    @case(\App\Enums\Position::Recruiter)
        <div class="internal-table">
            @foreach($data as $code => $values)
                <div class="tr">
                    <div class="td">
                        @php
                            $query = ['year' => $year, 'currency' => $code];
                            $personUrl = route("bonuses.person.show", $model->id).'?'.Arr::query($query);
                        @endphp
                        <a href="{{$personUrl}}">{{ \App\Services\Formatter::currency(array_sum($values), $currency[$code]) }}</a>
                    </div>
                </div>
            @endforeach
        </div>
        @break

    @default

@endswitch