## I changed the structure of the code because with the new feature it became a bit bloated. I used classes.

## I tested the modifications but I think more is better. Things to test:

- Log in with correct credentials
- Log in with correct email and incorrect password
- Log in with incorrect email
- Log in with incorrect email and correct password (you never know)

- Try logging in with an invalid email (invalid=refused by javascript, incorrect=valid but not present in the database) to verify the interactive JavaScript

- Register, try as many combinations as you can for

  - any field as empty
  - invalid email
  - valid email that exists in the database
  - valid email that doesn't exist in the database
  - matching different passwords
  - non matching passwords
  - existing login
  - non existing login
