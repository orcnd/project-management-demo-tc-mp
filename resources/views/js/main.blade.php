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


class Auth {
    static login(email, password) {
        fetch (apiUrl + '/login', {
            method: 'POST',
            headers: getApiHeaders(),
            body : JSON.stringify({
                email: email,
                password: password,
                _token: csrfToken,
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bearerToken=data.token;
            } else {
                console.error(data.message);
            }
            return data.message;
        });
    }

    static logout() {
        fetch (apiUrl + '/logout', {
            method: 'POST',
            headers: getApiHeaders(),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bearerToken=null;
            } else {
                console.error(data.message);
            }
            return data.message;
        });
    }

    static register(name, email, password) {
        fetch (apiUrl + '/register', {
            method: 'POST',
            headers: getApiHeaders(),
            body : JSON.stringify({
                name: name,
                email: email,
                password: password,
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                bearerToken=data.token;
            } else {
                console.error(data.message);
            }
            return data.message;
        });
    }
}



class Router {
    static routes={
        '404' : () => {
            console.error('404 Page not found');
            mainContainer.innerHTML='<h1 class="text-center text-danger">404 Page not found</h1>';
            document.title='404 Route not found';
        },
    };
    static go(route) {
        if (route in Router.routes) {
            Router.routes[route]();
        } else {
            Router.routes['404']();
            console.error('Route not found');
        }
    }
}


</script>
