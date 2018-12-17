@if(\Illuminate\Support\Facades\Auth::guard('api')->user())
    <script>


      var meta = {
        isGuest: false,
      };

      var preload = {};

    </script>
@else
    <script>
      var clientsideSettings = {};

      var meta = {
        isGuest: true,
      };

      var preload = {};

      var auth = {};

      function setNameAndEmail() {

      }
    </script>
@endif
