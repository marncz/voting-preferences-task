Newest data about all of current constituencies is pulled from this endpoint: http://explore.data.parliament.uk/index.html?endpoint=endpoint/constituencies

Configuration:
1. Open config/db_config.php and change values so it matches your MySQL database.

Installation:
1. Create a mysql database called `voting`
2. Import .sql file from `scripts/voting.sql`
3. Execute script for getting data by running: `php scripts/get_constituencies.php`
4. (Optional) populate database with random data by running `php scripts/populate.php [number_of_votes_to_generate]`
