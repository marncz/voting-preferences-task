
# Requirements 

Build a mini web app to provide a poll of voting intention for an upcoming (General) election.
The web app should allow a user to specify their constituency along with enter answers to the questions "Are you going to vote?" and "Who are you going to vote for?".
It should display the results for all users nationally and for each constituency separately.

You may use:
* PHP
* JavaScript
* MySQL or PostgreSQL
* Refrain from using a PHP framework.

# Introduction 
Newest data about all of current constituencies is pulled from this endpoint: http://explore.data.parliament.uk/index.html?endpoint=endpoint/constituencies

Used php-simple-captcha library: https://labs.abeautifulsite.net/simple-php-captcha/

# Requirements

- PHP 5.6+
- PHP GD2 library needed by php-simple-captcha 

## Configuration
1. Open config/db_config.php and change values so it matches your MySQL database.

## Installation
1. Clone the project into your web server by running:  `git clone https://github.com/marncz/voting-preferences-task.git voting` 
2. Create a mysql database on your server, preferably called `voting`
3. Import the .sql file from `scripts/voting.sql`
4. Execute script for getting data by running: `php scripts/get_constituencies.php`
5. (Optional) populate database with random data by running `php scripts/populate.php [number_of_votes_to_generate]`

# Design choices
- Form validation in PHP instead of JavaScript.
- Simple captcha to avoid flooding a bit (in real life application) - not so much as this is a basic captcha only.
- Only one external library used, so no need for package managment (composer). 
- MVC model really not needed for such small app, comments are clear and there would be no problems to extending or adding features to this web app.

## Database 
I chose to go with the simplest possible setup and shift calculating votes to the PHP serving the webpage. Database uses gss_codes served by the British parliament's API.  
