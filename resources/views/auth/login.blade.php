<!DOCTYPE html>

<head>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<body>
    <form method="post" name="postform" action="finishlogin">
        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="form-control" />
        @csrf
        <label>Password</label>
        <input type="password" name="password" class="form-control" />
        <button type="submit" class="btn btn-primary">LOGIN</button>
    </form>
    <a href="/register">Registreren </a>

</body>
</head>

</html>
