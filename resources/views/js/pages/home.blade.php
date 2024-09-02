<div class="view-pages" id="homeView">
    <div class="contanier">
        <h1>Welcome<span id="homeView_userName"></span></h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newModalProject">New
            Project</button>
        <div class="row homeView_projects"></div>
    </div>
</div>

<script>
    Router.set('home', drawProjects);

    async function drawProjects() {
        console.log('drawProjects');
        if (Auth.user) {
            document.getElementById('homeView_userName').innerHTML = ' ' + Auth.user.name;
        }

        await fetch(apiUrl + '/projects', {
                method: 'GET',
                headers: getApiHeadersWithAuth(),
            }).then(response => response.json())
            .then(data => {
                console.log('pll', data);
                if (data.status) {
                    let projects = data.data;
                    let html = '';
                    projects.forEach(function(item) {
                        html += '<div class="col-md-3 mb-3 ">';
                        html += '<div class="card">';
                        html += '<div class="card-body">';
                        html += '<div class="card-title">' + item.name + '</div>';
                        html += '<div class="card-text">' + item.description + '</div>';
                        html += '<a class="card-link" href="#" onclick="Router.go(\'project\',' + item
                            .id + '); return false;">Go to project</a>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                    });
                    document.querySelector('#homeView .homeView_projects').innerHTML = html;
                }
            });
        view(
            'Home',
            document.getElementById('homeView').innerHTML
        );
    }

    function createProject() {
        let name = document.querySelector('#newProjectName').value;
        let description = document.querySelector('#newProjectDescription').value;
        fetch(apiUrl + '/projects', {
                method: 'POST',
                headers: getApiHeadersWithAuth(),
                body: JSON.stringify({
                    name: name,
                    description: description,
                })
            }).then(response => response.json())
            .then(data => {
                console.log(data);
                drawProjects();
            });
    }
</script>

<div class="modal" tabindex="-1" id="newModalProject">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label>Name
                    <input type="text" class="form-control" id="newProjectName">
                </label>
                <label>Description
                    <input type="text" class="form-control" id="newProjectDescription">
                </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal"
                    onclick="createProject(); return true;">Save changes</button>
            </div>
        </div>
    </div>
</div>
