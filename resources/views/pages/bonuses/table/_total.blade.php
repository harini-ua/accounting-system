<div class="internal-table">
    @foreach($data as $code => $values)
        <div class="tr">
           <div class="td">
               <a href="{{ route('people.show', $model) }}"
                  title="{{ \App\Services\Formatter::currency($values[0], $currency[$code]) }} / {{ \App\Services\Formatter::currency($values[1], $currency[$code]) }}"
               >{{ \App\Services\Formatter::currency($values[1], $currency[$code]) }}</a>
           </div>
        </div>
    @endforeach
</div>