@if($profile)<a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown">@endif
    <span class="avatar-status {{ $online ? 'avatar-online' : '' }}">
        <img src="{{ $image }}" alt="avatar">
        @if($online)
        <i></i>
        @endif
    </span>
@if($profile)</a>@endif