## About this project

This project is a simple Laravel application that allows you to manage your tasks.

- Default credentials:
  - Email: admin@admin.com
  - Password: password

## Installation

1. Clone the repository
2. Run `composer install`
3. Run `php artisan migrate:fresh --seed`
4. Run `php artisan serve`
5. Optionally you can use `./vendor/bin/sail up` to run the project with Docker


## Capabilities
- Login and Register
- Role based permissions
- Create a new project
- Create a new task for the project
- Edit the task
- Delete the task
- Delete the project

## Screenshots
- Home
![Home](https://github.com/orcnd/project-management-demo-tc-mp/blob/main/screenshots/ss1.png?raw=true)

- Project
![Home](https://github.com/orcnd/project-management-demo-tc-mp/blob/main/screenshots/ss2.png?raw=true)

- Login
![Home](https://github.com/orcnd/project-management-demo-tc-mp/blob/main/screenshots/ss3.png?raw=true)

## Design choices
I prefered to create my own JS router and renderer mechanism.
Because i wanted to make it fun. Goal was achive React router style navigation.
But i also do not want to use something like JSX. I want to keep HTML and CSS as much as possible.
I also do not want to make something that needs compiling. I don't need to compile my backend why i should need to compile my frontend.

I also avoided to use Livewire because i do not like frontend codes that is not in my control.

Backend is basic Laravel. Used apiResources, form requests.
Only custom thing is roles and permissions.
