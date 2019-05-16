# Let's use an external storage

Actual Drupal 8 instance that uses a REST API as persistent storage for some of its entities instead of an SQL storage.

## Installation

* Copy `web/sites/default/settings.example.php` to `web/sites/default/settings.php`
* Edit `web/sites/default/settings.php` to your needs
* Install the site by running `composer site:install`

## Configuration

Administrative user credentials are `administrator/admin`.

Thing entities storage endpoint is `https://my-json-server.typicode.com/ericmorand/things/things`. This setting is available under `Structure > Things`;
