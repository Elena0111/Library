<!DOCTYPE html>
<htm>
    <head>
        <meta charset="UTF-8">
        <title>User authentication</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <!-- Fogli di stile -->
        <link rel="stylesheet" href="{{ url('/') }}/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ url('/') }}/css/style.css">
        <!-- Icone Bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <!-- jQuery e plugin JavaScript -->
        <script src="https://code.jquery.com/jquery.js"></script>
        <script src="{{ url('/') }}/js/bootstrap.bundle.min.js"></script>
        <script src="{{ url('/') }}/js/myScript.js"></script>
    </head>

    <body>
        <div class="container">
            <div class="row" style="margin-top: 4em">
                <div>
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-login-tab" data-bs-toggle="pill" data-bs-target="#pills-login" type="button" role="tab" aria-controls="pills-login" aria-selected="true">Login</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-register-tab" data-bs-toggle="pill" data-bs-target="#pills-register" type="button" role="tab" aria-controls="pills-register" aria-selected="false">Register</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab" tabindex="0">
                            <form id="login-form" action="{{ route('user.login') }}" method="post" style="margin-top: 2em">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="username" class="form-control" placeholder="Username"/>
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Password"/>
                                </div>

                                <a href="{{ route('home') }}" class="btn btn-secondary"><i class="bi-box-arrow-left"></i> Back</a>
                                <label for="Login" class="btn btn-primary"><i class="bi-check-lg"></i> Login</label>
                                <input id="Login" type="submit" value="Login" class="hidden"/>

                        
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="pills-register-tab" tabindex="0">
                            <form id="register-form" action="{{ route('user.register') }}" method="post" style="margin-top: 2em">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="name" class="form-control" placeholder="Name" value=""/>
                                    <span class="invalid-input" id="invalid-registrationName"></span>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="email" class="form-control" placeholder="Email" value=""/>
                                    <span class="invalid-input" id="invalid-registrationEmail"></span>
                                </div>

                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Password" value=""/>
                                    <span class="invalid-input" id="invalid-registrationPasswd"></span>
                                </div>

                                <div class="form-group">
                                    <input type="password" name="confirm-password" class="form-control" placeholder="Confirm password" value=""/>
                                    <span class="invalid-input" id="invalid-passwdConfirm"></span>
                                </div>

                                <a href="{{ route('home') }}" class="btn btn-secondary"><i class="bi-box-arrow-left"></i> Back</a>
                                <label for="Register" class="btn btn-primary"><i class="bi-check-lg"></i> Register</label>
                                <input id="Register" type="submit" value="Register" class="hidden" onclick="event.preventDefault(); checkRegistrationData();"/>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </body>
</htm>