## Working with the same MySQL database
I included in the root of this directory a **.sql** file that will allow you to recover the database I created. It would be good if you could use it. Also, when you modify the database and want to commit/push think about putting a **.sql** file backing up your current modifications. That way we can work on the same version of the database.

## A user to test login/logout features
If you want to test the login/logout forms, I have created a user.

Email: bla@foo.com, Password: modal

Also feel free to add new users, and experiment with possibilities of email/login collisions. I tested it but more is better.

Also, the JavaScript scripts should work properly. If you your form is invalid (different passwords, invalid email, empty item), the form won't be submitted directly to the server side php code. Instead, the user will be presented with the form and the correct/incorrect fields will be highlighted. Moreover, at every key stroke, the JavaScript code will verify the new input and update the highlighted items.

You can test that as well. Just one note, I had included a check for different passwords in the php code. That would seem redundant now, but if the JavaScript code fails for some reason. The php code should normally catch the inconsistency.

## Documenting Issues or Notes
I propose that we keep using this file to write commit notes or suggestions.

## Added .gitignore
I put in it the Database.php file.

## sidebar icons
Note that icons are not saved localy ! 

# New proposed Layout for layouts
Instead of having all helper functions in one big "helper.php" file, I created a folder called helper that contains
    * a file called "utils.php" contaning the functions used by both pages (dashboard and index)
    * a file called "index_utils.php" contaning the functions used exclusively by index
    * a file called "dashboard_utils.php" contaning the functions used exclusively by dashboard
I think this is easier to maintain and will also allow for better function names.
If a function is defined in a file exclusive to one page, we don't have to specify the conerned page
Instead of "generate_home_header" and "generate_dashboard_header" FOR EXAMPLE we could have
two functions called "generate_header" each in the file used by its page.