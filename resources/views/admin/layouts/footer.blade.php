<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-center py-2 flex-md-row flex-column">
      <div class="mb-2 mb-md-0">
        ©
        <script>
          document.write(new Date().getFullYear());
        </script>
      {{env('APP_NAME','Bitall X Coin')}}
      </div>
    </div>
  </footer>
  <!-- / Footer -->

  <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

<script src="{{asset('admin_assets/assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('admin_assets/assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('admin_assets/assets/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('admin_assets/assets/js/dataTables.js')}}"></script>
<script src="{{asset('admin_assets/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

<script src="{{asset('admin_assets/assets/js/toastr.js')}}"></script>

<script src="{{asset('admin_assets/assets/vendor/js/menu.js')}}"></script>
<!-- endbuild -->
<script src="{{asset('admin_assets/assets/js/form-validation-jquery.js')}}"></script>
<!-- Vendors JS -->
<script src="{{asset('admin_assets/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

<!-- Main JS -->
<script src="{{asset('admin_assets/assets/js/main.js')}}"></script>

<!-- Page JS -->
<script src="{{asset('admin_assets/assets/js/dashboards-analytics.js')}}"></script>

<script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
@yield('script')
<script>
    $(document).ready(function(){
        $('.validate-form').validate();
        $('#myTable').DataTable();

    });
    // CKEDITOR.replace( 'content' );
    //     CKEDITOR.replace( 'coupon_details' );
    //   CKEDITOR.config.allowedContent = true;
</script>

@if (Session::has('success'))
<script>
    toastr.success('{{session::get("success")}}');
</script>
 @endif
 @if (Session::has('error'))
<script>
    toastr.error('{{session::get("error")}}');
</script>
 @endif

</body>
</html>
