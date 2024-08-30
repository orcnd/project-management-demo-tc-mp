<div class="view-pages" id="loginAndRegisterView">
    <div class="contanier">
        <div class="row">
            <div class="col-6">
                <h1 class="text-center">Login</h1>
                <form action="" method="post">
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
            <div class="col-6">
                <h1 class="text-center">Sign in</h1>
                <form action="" method="post">
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                    </div>
                    <div class="form-group mb-3">
                        <label for="email2">Email</label>
                        <input type="email" class="form-control" id="email2" name="email" placeholder="Enter email">
                    </div>
                    <div class="form-group mb-3">
                        <label for="password2">Password</label>
                        <input type="password" class="form-control" id="password2" name="password" placeholder="Enter password">
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
</script>
