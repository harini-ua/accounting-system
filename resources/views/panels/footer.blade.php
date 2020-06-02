<!-- BEGIN: Footer-->
<footer
  class="{{$configData['mainFooterClass']}} @if($configData['isFooterFixed']=== true){{'footer-fixed'}}@else {{'footer-static'}} @endif @if($configData['isFooterDark']=== true) {{'footer-dark'}} @elseif($configData['isFooterDark']=== false) {{'footer-light'}} @else {{$configData['mainFooterColor']}} @endif">
  <div class="footer-copyright">
    <div class="container">
      <span><a href="https://resqdev.com/" target="_blank">Resqdev</a> &copy; {{ date('Y') }} | All rights reserved.
      </span>
      <span class="right hide-on-small-only">
        Developed by <a href="https://resqdev.com/">Resqdev</a>
      </span>
    </div>
  </div>
</footer>
<!-- END: Footer-->
