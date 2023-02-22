# Net2Grid Interview Assignment

This is a Net2Grid assignment to:
1. consume data from an API
2. send the results to an exchange on a RabbitMQ instance where they are
filtered
3. consume the filtered results from a queue
4. store these in a database.

# Installation
- `git clone https://github.com/rigasweb/net2grid_assignment.git`
- `composer install`

# Create the DB
Open a terminal on the root directory and run the following command to create the database:
- `php bin/doctrine orm:schema-tool:create`

# Start the server
To start the server run the following command
- `symfony server:start`


The Controller/Receiver.php is responsible for communicating with the API and retrieving that data.
It returns the rooting key in decimal representation: <gateway eui>.<profile>.<endpoint>.<cluster>.<attribute>.

The Controller/Filter.php filters the data by connecting to a RabbitMQ instance. First it publishes the data and the it consumes them from a queue.

Finally the files Entity/boostrap.php and Entity/data.php are responsible for creating the Database connection configuration and creating the object relational mapping.