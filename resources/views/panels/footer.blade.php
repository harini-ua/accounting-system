<!-- BEGIN: Footer-->
<footer
  class="{{$configData['mainFooterClass']}} @if($configData['isFooterFixed']=== true){{'footer-fixed'}}@else {{'footer-static'}} @endif @if($configData['isFooterDark']=== true) {{'footer-dark'}} @elseif($configData['isFooterDark']=== false) {{'footer-light'}} @else {{$configData['mainFooterColor']}} @endif">
  <div class="footer-copyright">
    <div class="container">
      <span><a href="http://dreamdev.solutions/" target="_blank">Dream Dev Solutions</a> &copy; {{ date('Y') }} | All rights reserved.
      </span>
      <span class="right hide-on-small-only">
        Developed by <a href="http://dreamdev.solutions/">Dream Dev Solutions</a>
      </span>
    </div>
  </div>
</footer>
<!-- END: Footer-->
