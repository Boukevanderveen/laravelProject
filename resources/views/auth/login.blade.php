<!DOCTYPE html>
<head>
<body>
            <form method="post" name="postform" action="finishlogin">
                <label>Email</label>
                <input type="email" name="email" value="{{old('email')}}"  class="form-control" />
                @csrf
                <label>Password</label>
                <input type="password" name="password"   class="form-control" />
                <button type="submit" class="btn btn-primary">LOGIN</button>
            </form>
    <a href="/register">Registreren </a>

</body>
</html>