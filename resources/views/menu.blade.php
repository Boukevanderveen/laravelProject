<html>
<body>

        @foreach($records as $record)
                {{ $record->name }}
                {{ $record->email }}
                
                <hr class="mt-2">
        @endforeach
    
</body>
</html>