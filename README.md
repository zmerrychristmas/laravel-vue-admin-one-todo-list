## Introdution
This is laravel vue project setup to create a todo task list.
User can login and update task status.
Admin can login after that create a task and assign task to user.

This demo used admin one laravel to follow, can login to source project at this link
https://github.com/vikdiesel/admin-one-laravel-dashboard
Based on Laravel 7.0
## Account
User: Nguyen Huy Binh
Email: huybinh.ad@gmail.com
This test used admin one admin
## Installation
b1: git clone project
`git clone git@github.com:zmerrychristmas/laravel-vue-admin-one-todo-list.git`
b2: composer install
Install composer from link: https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos

`compose install`

b3: Update database link
- In project, i used sqlite db so firstly you should rechange link to sqlite file.
at file `.env` change
`
DB_CONNECTION=sqlite
DB_DATABASE=path/laravel.sqlite
`
- Run Database migrate
`php artisan migrate`
- Run Database seed
`php artisan db:seed`

b4: Run vue process and compile styles
- `npm install`
- `npm run dev`
- For better to change and edit: `npm run watch`
b5: Run project
- run by laravel command
`php artisan serve`
### Login info
— Login: user@example.com
— Password: secret

— Login(admin): admin@example.com
— Password: admin
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
