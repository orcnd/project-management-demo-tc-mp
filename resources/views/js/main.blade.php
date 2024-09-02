<script>
var baseUrl = '{{ url('/') }}';
var apiUrl = '{{ url('/api') }}';
var bearerToken;
var mainContainer=document.getElementById('mainContainer');

function getApiHeaders(bearerToken, extraHeaders) {
    let apiHeaders= {
    'X-CSRF-TOKEN' : '{{ csrf_token() }}',
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    };
    if (bearerToken) {
        apiHeaders['Authorization'] = 'Bearer ' + bearerToken;
    }
    if (extraHeaders) {
        apiHeaders = {...apiHeaders, ...extraHeaders};
    }
    return apiHeaders;
}

function getApiHeadersWithAuth() {
    return getApiHeaders(bearerToken);
}


class Auth {
    static user;

    static setToken(data) {
        bearerToken=data.token;
        Auth.user=data.user;
        localStorage.setItem('bearerToken', bearerToken);
        localStorage.setItem('user', JSON.stringify(Auth.user));
    }

    static clearToken() {
        bearerToken=null;
        Auth.user=null;
        localStorage.removeItem('bearerToken');
        localStorage.removeItem('user');
    }

    static init() {
        bearerToken=localStorage.getItem('bearerToken');
        Auth.user=JSON.parse(localStorage.getItem('user'));
    }

    static login(email, password, callback) {
        fetch (apiUrl + '/login', {
            method: 'POST',
            headers: getApiHeaders(),
            body : JSON.stringify({
                email: email,
                password: password,
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Auth.setToken(data);
            }else{
                console.error(data.message);
            }
            if (callback) {
                callback(data);
            }
        });
    }

    static logout(callback) {
        localStorage.removeItem('bearerToken');
        localStorage.removeItem('user');
        Auth.user=null;
        fetch (apiUrl + '/logout', {
            method: 'POST',
            headers: getApiHeaders(),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Auth.clearToken();
            } else {
                console.error(data.message);
            }
            if (callback) {
                callback(data);
            }
        });
    }

    static register(name, email, password, password_again, callback) {
        fetch (apiUrl + '/register', {
            method: 'POST',
            headers: getApiHeaders(),
            body : JSON.stringify({
                name: name,
                email: email,
                password: password,
                password_confirmation: password_again,
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Auth.setToken(data);
            } else {
                console.error(data.message);
            }
            if (callback) {
                callback(data);
            }
        });
    }


}



class Router {
    static activeRoute;
    static routes={
        '404' : () => {
            console.error('404 Page not found');
            mainContainer.innerHTML='<h1 class="text-center text-danger">404<br>Page not found</h1>';
            document.title='404 Route not found';
        },
    };
    static set(route, callback) {
        Router.routes[route]=callback;
    }
    static go(route, params) {
        if (Router.activeRoute && Router.activeRoute==route) {
            return;
        }
        Router.activeRoute=route;
        if (route in Router.routes) {
            Router.routes[route](params);
        } else {
            Router.routes['404']();
            console.error('Route not found');
        }
    }
}

/**
 * Show a view
 * @param {string} title
 * @param {string} html
 */
function view(title, html) {
    if (Auth.user) {
        console.log("drawMenu");
        document.querySelectorAll('.loginButton').forEach((item) => {
            item.style.display='none';
        });
        document.querySelectorAll('.logoutButton').forEach((item) => {
            item.style.display='inline-block';
        });
    }else{
        document.querySelectorAll('.loginButton').forEach((item) => {
            item.style.display='inline-block';
        });
        document.querySelectorAll('.logoutButton').forEach((item) => {
            item.style.display='none';
        });
    }
    document.title="Project Management - " + title;
    mainContainer.innerHTML=html;
}

/**
 * Reveal all pages
 */
function revealPages() {
    let a=document.querySelectorAll('.view-pages');
    a.forEach((item) => {
        item.style.display='block';
    });
}

//init router
window.onload=function() {
    Auth.init();
    Router.go('home');
}
</script>

<style>
    .view-pages {
        display: none;
        margin:10px;
        border:1px solid red;
    }
</style>
