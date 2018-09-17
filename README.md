# File Upload Coding Test

This application is designed to be run anywhere, but for the sake of simplicity I will only provide instructions for building in any environment.

If you need an environment to run this application, I would suggest using either Laravel's [Valet](https://laravel.com/docs/5.7/valet) or [Homestead](https://laravel.com/docs/5.7/homestead) environments.

### Features

* Upload any number of files asynchronously using chunked uploads
* Download and delete any files
* Search by filename and/or file type (MIME type)
* Laravel 5.7 API
* React + Redux webapp
* API limit of 500 requests per minute
* API tests!
* Model factories!
* Database migrations!
* Flexbox!
* Dropzone!
* Loaders!

### Requirements:
* PHP 7.2 and [Composer](https://getcomposer.org/)
* MySQL
* [Node and NPM](https://nodejs.org/en/)

### Build:
1. Clone the repository `git clone git@github.com:dennislindsey/file-upload-coding-test.git`
    1. Alternatively, unzip the repository provided via secure email
2. Execute the following commands in your terminal:
    1.  ```
        composer install
        npm install
        cp .env.example .env
        php artisan key:generate
        ```
3. Open your new `.env` file in the editor of your choice
4. Update your database and APP_URL settings appropriately for your environment
5. Execute the following commands in your terminal to complete the installation process
    1.  ```
        php artisan migrate:fresh
        npm run dev
        ```
6. If you're using Valet or another service, secure the API behind HTTPS:
    1. `cd /path/to/project && valet secure file-upload-coding-test`
7. Start your local server
    1. `php artisan serve` or whatever environment-specific commands/tools you need
