<div class="view-pages" id="homeView">
    <div class="contanier">
       <h1>Welcome<span id="homeView_userName"></span></h1>
    </div>
</div>
<script>
Router.set('home', function() {
    if (Auth.user) {
        document.getElementById('homeView_userName').innerHTML=' '+Auth.user.name;
    }
    view(
        'Home',
        document.getElementById('homeView').innerHTML
    );
});
</script>
