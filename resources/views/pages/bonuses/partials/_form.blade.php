<!-- form start -->
{{--<form id="bonus" method="POST" action="{{ isset($bonus) ? route('bonuses.update', $bonus) : route('bonuses.store') }}">--}}
{{--    @if(isset($bonus)) @method('PUT') @endif--}}
{{--    @csrf--}}
{{--    @php($model = $bonus ?? null)--}}
{{--    <x-input name="type" :model="$model" type="hidden" default="{{ \App\Enums\BonusType::PERCENT }}" field="type"></x-input>--}}
{{--    <div class="row">--}}
{{--        @if(isset($bonus))--}}
{{--            <x-input name="person_id" :model="$model" type="hidden" field="person_id"></x-input>--}}
{{--        @endif--}}
{{--        <x-select name="person_id" :options="$people" disabled="{{ isset($bonus) }}" @endif :model="$model" firstTitle="Person" :search="true"></x-select>--}}
{{--    </div>--}}
{{--    <div class="row">--}}
{{--        <x-input name="value" title="{{ __('Value') }}" :model="$model" field="value"></x-input>--}}
{{--    </div>--}}
{{--    <div class="row">--}}
{{--        <div class="col s12">--}}
{{--            <div class="pl-0 pr-0 right-align">--}}
{{--                <button class="btn-small waves-effect waves-light submit" type="submit">--}}
{{--                    <span>{{ isset($bonus) ? __('Update') : __('Add Bonus') }}</span>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</form>--}}
<!-- form end -->