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
