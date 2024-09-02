<div class="view-pages" id="projectView">
    <div class="contanier">
        <h1 class="projectView_name">Project</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newModalTask">New Task</button>
        <p class="projectView_description">
        <div class="row projectView_tasks">
            <div class="col-md-4 todo">
                <h3>To Do</h3>
                <div class="list"></div>
            </div>
            <div class="col-md-4 in-progress">
                <h3>In Progress</h3>
                <div class="list"></div>
            </div>
            <div class="col-md-4 done">
                <h3>Done</h3>
                <div class="list"></div>
            </div>
        </div>
    </div>
<script>
var activeProjectId;
Router.set('project', drawProjects);

async function drawProjects(projectId) {
    activeProjectId=projectId;
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

            document.querySelector('#projectView .projectView_tasks > .todo > .list').innerHTML='';
            document.querySelector('#projectView .projectView_tasks > .in-progress > .list').innerHTML='';
            document.querySelector('#projectView .projectView_tasks > .done > .list').innerHTML='';

            let tasks=project.tasks;
            tasks.forEach(function (item) {
                let html='';
                html+='<div class="card" id="projectView_task_'+item.id+'">';
                html+='<div class="card-body">';
                html+='<div class="card-title">'+item.name+'</div>';
                html+='<div class="card-text">'+item.description+'</div>';
                html+='<div class="card-status">'+item.status+'</div>';
                html+='<a class="card-link edit-btn" href="#" onclick="editProjectTask(' + item.id +'); return false;">Edit</a>';
                html+='<a class="card-link text-danger" href="#" onclick="deleteProjectTask('+ item.id +'); return false;">Delete</a>';
                html+='</div>';
                html+='</div>';
                document.querySelector('#projectView .projectView_tasks > .' + item.status + " > .list").innerHTML+=html;
            });
        }
    });
    view(
        'Project',
        document.getElementById('projectView').innerHTML
    );
}

function editProjectTask(itemId) {
    document.querySelector('#projectView_task_' + itemId + " .card-title").innerHTML='<input type="text" class="form-control" id="projectView_task_name_' + itemId + '" value="' + document.querySelector('#projectView_task_' + itemId + " .card-title").innerHTML + '">';
    document.querySelector('#projectView_task_' + itemId + " .card-text").innerHTML='<input type="text" class="form-control" id="projectView_task_name_' + itemId + '" value="' + document.querySelector('#projectView_task_' + itemId + " .card-text").innerHTML + '">';
    document.querySelector('#projectView_task_' + itemId + " .card-status").innerHTML=drawEditTaskStatus(itemId, document.querySelector('#projectView_task_' + itemId + " .card-status").innerHTML);
    document.querySelector('#projectView_task_' + itemId + " .edit-btn").innerHTML='Save';
    document.querySelector('#projectView_task_' + itemId + " .edit-btn").onclick=function () {
        console.log(itemId);
        let name=document.querySelector('#projectView_task_' + itemId + " #projectView_task_name_" + itemId).value;
        let description=document.querySelector('#projectView_task_' + itemId + " #projectView_task_name_" + itemId).value;
        let status=document.querySelector('#projectView_task_' + itemId + " #projectView_task_status_" + itemId).value;
        editTask(itemId, name, description, status);
    };
}

function drawEditTaskStatus(itemId,selected) {
    let html='';
    html+='<select class="form-select" id="projectView_task_status_' + itemId + '">';
    let options=['todo', 'in-progress', 'done'];
    options.forEach(function (item) {
        html+='<option value="' + item + '"';
        if (item==selected) {
            html+=' selected';
        }
        html+='>' + item + '</option>';
    });
    html+='</select>';
    return html;
}

function editTask(itemId, name, description, status) {
    fetch(apiUrl + '/tasks/' + itemId, {
        method: 'PUT',
        headers: getApiHeadersWithAuth(),
        body : JSON.stringify({
            name: name,
            description: description,
            project_id: activeProjectId,
            status: status
        })
    }).then(response => response.json())
    .then(data => {
        drawProjects(activeProjectId);
    });
}
function hideModal(id) {
    const modalDom = document.querySelector('#' + id);
    const modal = new bootstrap.Modal(modalDom, {
        backdrop: 'static'
    });
    modal.hide();
    modal.close();
}
function createTask() {
    hideModal('newModalTask');

    let name=document.querySelector('#newTaskName').value;
    let description=document.querySelector('#newTaskDescription').value;
    let status=document.querySelector('#newTaskStatus').value;
    fetch(apiUrl + '/tasks', {
        method: 'POST',
        headers: getApiHeadersWithAuth(),
        body : JSON.stringify({
            name: name,
            description: description,
            project_id: activeProjectId,
            status: status
        })
    }).then(response => response.json())
    .then(data => {
        drawProjects(activeProjectId);
    });
}

function deleteProjectTask(itemId) {

    let st=confirm('Are you sure you want to delete this task?');
    if (!st) {
        return;
    }
    fetch(apiUrl + '/tasks/' + itemId, {
        method: 'DELETE',
        headers: getApiHeadersWithAuth(),
    }).then(response => response.json())
    .then(data => {
        drawProjects(activeProjectId);
    });
}
</script>

<div class="modal" tabindex="-1" id="newModalTask">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Task</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label>Name
        <input type="text" class="form-control" id="newTaskName">
        </label>
        <label>Description
        <input type="text" class="form-control" id="newTaskDescription">
        </label>
        <label>Status
        <select class="form-select" id="newTaskStatus">
            <option value="todo">To Do</option>
            <option value="in-progress">In Progress</option>
            <option value="done">Done</option>
        </select>
        </label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal"  onclick="createTask(); return true;">Save changes</button>
      </div>
    </div>
  </div>
</div>
