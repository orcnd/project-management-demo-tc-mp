<div class="view-pages" id="homeView">
    <div class="contanier">
       <h1>Welcome<span id="homeView_userName"></span></h1>
       <div id="homeView_projects" class="row"></div>
    </div>
</div>
<script>

Router.set('home', async function() {
    if (Auth.user) {
        document.getElementById('homeView_userName').innerHTML=' '+Auth.user.name;
    }

    await fetch(apiUrl + '/projects', {
        method: 'GET',
        headers: getApiHeadersWithAuth(),
    }).then(response => response.json())
    .then(data => {

        if (data.status) {
            let projects=data.data;
            let html='';
            projects.forEach(function (item) {
                html+='<div class="col-md-3">';
                html+='<div class="card">';
                html+='<div class="card-body">';
                html+='<div class="card-title">'+item.name+'</div>';
                html+='<div class="card-text">'+item.description+'</div>';
                html+='<a class="card-link" href="#" onclick="Router.go(\'project\',' + item.id +'); return false;">Go to project</a>';
                html+='</div>';
                html+='</div>';
                html+='</div>';
            });
            document.getElementById('homeView_projects').innerHTML=html;
        }
    });
    view(
        'Home',
        document.getElementById('homeView').innerHTML
    );
});

</script>
