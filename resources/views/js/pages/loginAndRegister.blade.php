<div class="view-pages" id="loginAndRegisterView">
    <div class="contanier">
        <div class="row">
            <div class="col-6">
                <h1 class="text-center">Login</h1>
                <form onsubmit="return LoginAndRegister.login();">
                    <div class="message"></div>
                    <div class="form-group mb-3">
                        <label for="loginAndRegisterView_email">Email</label>
                        <input type="email" class="form-control" id="loginAndRegisterView_email" name="email" placeholder="Enter email">
                    </div>
                    <div class="form-group mb-3">
                        <label for="loginAndRegisterView_password">Password</label>
                        <input type="password" class="form-control" id="loginAndRegisterView_password" name="password" placeholder="Enter password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
            <div class="col-6">
                <h1 class="text-center">Sign in</h1>
                <form onsubmit="return LoginAndRegister.register();">
                    <div class="form-group mb-3">
                        <label for="loginAndRegisterView_name">Name</label>
                        <input type="text" class="form-control" id="loginAndRegisterView_name" name="name" placeholder="Enter name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="loginAndRegisterView_email2">Email</label>
                        <input type="email" class="form-control" id="loginAndRegisterView_email2" name="email" placeholder="Enter email">
                    </div>
                    <div class="form-group mb-3">
                        <label for="loginAndRegisterView_password2">Password</label>
                        <input type="password" class="form-control" id="loginAndRegisterView_password2" name="password" placeholder="Enter password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
            </div>
        </div>

    </div>
</div>
<script>
Router.set('loginAndRegister', function() {
    view(
        'Login or Sign in',
        document.getElementById('loginAndRegisterView').innerHTML
    );
});

Router.set('logout', function() {
    Auth.logout();
    Router.go('loginAndRegister');
});

class LoginAndRegister {
    static login() {
        let email=document.getElementById('loginAndRegisterView_email').value;
        let password=document.getElementById('loginAndRegisterView_password').value;

        var status=Auth.login(email, password, function (data) {
            if (data.success) {
                Router.go('home');
                return true;
            } else {
                document.querySelector('.message').innerHTML=data.message;
            }
        });
        return false;
    }
    static register(name, email, password) {
        Auth.register(name, email, password);
        return false;
    }
}
</script>
