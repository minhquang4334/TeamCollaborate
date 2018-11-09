@if(\Illuminate\Support\Facades\Auth::guard('api')->user())
    <script>
      var clientsideSettings = {!! \Illuminate\Support\Facades\Auth::user()->clientsideSettings('Web') ?? '{}' !!};

      var meta = {
        isGuest: false,
      };

      var preload = {};

      var auth = {!! json_encode((new \App\Transformers\UserTransformer(auth()->user(), true, false, true))->resolve()) !!};
    </script>
@else
    <script>
      var clientsideSettings = {};

      var meta = {
        isGuest: true,
      };

      var preload = {};

      var auth = {};
    </script>
@endif