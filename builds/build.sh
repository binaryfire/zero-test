#!/bin/bash
# Save this as ~/bin/phpacker-wrapper
PHP_CLI_SERVER_MEMORY_LIMIT=512M 
php -d memory_limit=512M ~/.config/composer/vendor/phpacker/phpacker/bin/phpacker "$@"
