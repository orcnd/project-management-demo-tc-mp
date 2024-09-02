<div class="view-pages" id="projectView">
    <div class="contanier">
        <h1 class="projectView_name">Project</h1>
        <p class="projectView_description">
        <div class="row projectView_tasks">
        </div>
    </div>
<script>
Router.set('project', async function(projectId) {

    await fetch(apiUrl + '/projects/' + projectId, {
        method: 'GET',
        headers: getApiHeadersWithAuth(),
    }).then(response => response.json())
    .then(data => {
        console.log(data);
        if (data.status) {
            let project=data.data;
            document.querySelector('#projectView .projectView_name').innerHTML=project.name;
            document.querySelector('#projectView .projectView_description').innerHTML=project.description;

            let tasks=project.tasks;
            let html='';
            tasks.forEach(function (item) {
                html+='<div class="col-md-3">';
                html+='<div class="card">';
                html+='<div class="card-body">';
                html+='<div class="card-title">'+item.name+'</div>';
                html+='<div class="card-text">'+item.description+'</div>';
                html+='<a class="card-link" href="#" onclick="Router.go(\'task\',' + item.id +'); return false;">Go to task</a>';
                html+='</div>';
                html+='</div>';
                html+='</div>';
                html+='</div>';
            });
            document.querySelector('#projectView .projectView_tasks').innerHTML=html;
        }
    });
    view(
        'Project',
        document.getElementById('projectView').innerHTML
    );
});
</script>
