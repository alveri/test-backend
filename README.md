# AutoBidMaster Backend Developer Test

## Usage
After docker environment will start you shoudl enter main container ( for example usong command `make tty`)
And run next commands
 - `composer install`
 - `php bin/console doctrine:migrations:migrate` - to run migrations
 - `php bin/console vehicles:import-from-csv` = to import data from csv file

After these actions records about Vehicles will be avaliable on `http://localhost:8012/api/vehicles` endpoint
 - For search use `/{fieldName}={searchValue}` syntax in URL (for example `http://localhost:8012/api/vehicles?vin=1RNF48A296R014302`). Note that search works by vin or vehicleIdField
 - For sorting results use `?order[{fieldSorting}]={orderSorting}` syntax in URL. For example: `http://localhost:8012/api/vehicles?order[brandName]=desc`. Sorting works on fiels brandName, modelName and saleDate
 - For pagination just use GET parameter `page`. For example `http://localhost:8012/api/vehicles?page=3`


### Environment Requirements
 - [docker](https://www.docker.com/products/docker-desktop)
 - [make](https://www.gnu.org/software/make/manual/html_node/Options-Summary.html)

### Build
The [make](https://www.gnu.org/software/make/manual/html_node/Options-Summary.html) command is used to abstract the project
build commands.  Listed below are the basic build commands needed for starting the project and developing:

 - `make start` Builds the necessary containers for development
 - `make stop` Stops and removes all containers
 - `make tty` Enters the main docker container.  Useful when needing to install new libraries or composer packages from command line
 - `make db-diff` Generates a migration file based on the difference between the entity and current schema
 - `make db-migrate` Runs any migrations that have been generated and are not up-to-date with the database.
 - `make watch` Runs the watch command in poll mode, will compile all frontend assets located in `assets`

There are several other commands listed in the file.  If you type `make` followed by `<Enter>` you will see the full list
of available commands.

To start the project run `make start` and wait for the containers to finish building.  Once everything is built you are ready
to begin development.  The application will be available on `localhost:8012`.  If you wish to change the port then update the
ports under services -> app -> ports in docker-compose.yml to -"{desired_port}:80".


