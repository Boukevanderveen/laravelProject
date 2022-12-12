<!DOCTYPE html>
<head>
</head>
<body>
            <form method="post" name="postform" action="finishregister">
              <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="{{old('name')}}" class="form-control" />
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{old('email')}}" class="form-control" />
                @csrf
              </div>
              <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" />
              </div>
              <div class="form-group">
                <label>Herhaal wachtwoord</label>
                <input type="password" name="confirm_password" class="form-control" />
              </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">registeren</button>
              </div>
    <a href="/login">Inloggen </a>

</body>
</html>