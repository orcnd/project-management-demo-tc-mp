<div class="view-pages" id="homeView">
    <div class="contanier">
       <h1>Welcome</h1>
    </div>
</div>
<script>
Router.set('home', function() {
    view(
        'Home',
        document.getElementById('homeView').innerHTML
    );
});
</script>
