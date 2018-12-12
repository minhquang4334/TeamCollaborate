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

      function setNameAndEmail() {
          var checkExist = setInterval(function() {
              if (document.getElementById('inputName') != null) {
                  console.log("Exists!");
                  let url = window.location.href;
                  let x = url.split('?');
                  if(x.length < 2){
                     clearInterval(checkExist);
                     return;
                  }
                  let data = x[x.length-1].split('---');
                  document.getElementById('inputEmail').value = atob(data[0]);
                  document.getElementById('inputName').value = atob(data[1]);
                  document.getElementById('inputEmail').readOnly = true;
                  clearInterval(checkExist);
              }
          }, 100);
      }
    </script>
@endif
