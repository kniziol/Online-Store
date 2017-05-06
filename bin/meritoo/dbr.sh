# Database recreate / rebuild
./bin/console doctrine:schema:drop --force
./bin/console doctrine:schema:create
