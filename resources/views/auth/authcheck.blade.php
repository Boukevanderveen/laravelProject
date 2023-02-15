            <!-- Login controle -->
            @if(Auth::check())
            @else
           <script> window.location.href = 'http://127.0.0.1:8000/login'; </script>

            @endif