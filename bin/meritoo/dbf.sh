# Database - reload data fixtures from all bundles (purge data without recreating whole database)
./bin/console hautelook:fixtures:load --no-interaction --purge-with-truncate -vv
