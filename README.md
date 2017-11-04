#codesearch

## Synopsis

*codesearch* is a REST API to search in Control Version Repository Hosting Service code.

The search query is sent to the host, and its response is processed and returned in a simplified format:

    [
        { "owner": "<owner name>", "repo": "<repository name>", "filename": "<file name>"},
        ...
    ]

## Installation

To install all dependencies enter:

    composer install
    
Rename ```.env.example```` to ```.env```.

You need to configure a web server, or use Artisan's built in one:

    php artisan serve
    


## Control Version Repository Hosting Service

Currently *codesearch* communicates with GitHub, but it could be extended to search in another service.

To do that, the developer must implement App\RepoHost interface, and change the registration in App\Providers\RepoHostProvider. Then, the services can be switched changing REPOHOSTSERVICE in .env file.

### GitHub Authentication

Github only allows searching in all repositories' code to registered users. Thus, authentication is needed to implement *codesearch* functionality.

To that end, I created a user in GitHub, and the application uses its credentials to log in. GitHub credentials are set in .env file.


## API Reference

Endpoints (currently only one) are described in doc/api.pdf.

## Testing

To test the application, enter this command

    composer test

## License

*codesearch* is written by Pablo J. Urbano Santos..

Laravel is copyrighted by Taylor Otwell and released under the terms of MIT License
