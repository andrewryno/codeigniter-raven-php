# Codeigniter Raven PHP

This project allows you to easily use [raven-php](https://github.com/getsentry/raven-php) inside of Codeigniter to use with Sentry or any other Raven client.

To install MY_Log:

* Add the contents of `application/config/config.php` into your existing `application/config/config.php` file (or whatever environment subfolder)
* Place `application/libraries/MY_Log.php` into your `application/libraries/` folder

To install raven-php, you can either:
* Use [composer](http://getcomposer.org/) to install raven-php and include the `vendor/autoload.php` file in your index.php file
* Download `raven-php` and add it at `application/libraries/raven-php`

## Configuration

There are three configuration options:

* `raven_client` allows you to set the DSN string for the client you wish to connect to (such as [Sentry](http://getsentry.com))
* `raven_config` allows you to set the optional configuration options as documented here: https://github.com/getsentry/raven-php#configuration
* `raven_log_threshold` allows you to set which error types should be pushed. **Recommended:** only ERROR, as debug will cause many requests
* `raven_environments` allows you to set which environments raven is enabled. **Recommended:** only production, as adding multiple environments may cause many requests