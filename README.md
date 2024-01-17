# PHP developer Test Task

Welcome to the PHP test task for RexIT!

## Task Description

Develop a service for working with a dataset

Initial data:
.csv dataset
- category, // client's favorite category
- firstname,
- lastname,
- email,
- gender,
- birthDate

Without using third party libraries:

1. Read csv file.
2. Write the received data to the database.
3. Display data as a table with pagination (but you can also use a simple json api)

4. Implement filters by values:
   - category
   - gender
   - Date of Birth
   - age
   - age range (for example, 25 - 30 years)
5. Implement data export (in csv) according to the specified filters.


## Instructions

**Clone the Repository:**
   Clone this repository to your local machine using the following command:
      ```bash
      git clone git@github.com:Gohar13/rexit-task.git
      ```
**Setup:**
1. save .env.local file as .env in root directory, and fill the credentials
2. run migration
   ```
   php migrate.php
   ```
3. Run command of importing data
   ```
   php import_data.php dataset.csv
   ```

4.  Start  built-in PHP web server for the specified directory
   ```
   php -S localhost:8000 -t route
   ```

5. Open browser
   ```
   http://localhost:8000/users.php
   ```
6. For filtering
   ```
   http://localhost:8000/users.php?gender=female&category=toys
   ```
7. For Exporting
   ```
   http://localhost:8000/users.php?gender=female&export=true
   ```