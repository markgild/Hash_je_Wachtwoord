# Hash je Wachtwoord

## About this project

For this backend assignment, I made a small PHP program for registering users and logging in. I learned how to hash passwords and check if a password is correct.

## What can the program do?

- Register a user with an email and password.
- Check if the email address is valid.
- Check if the email is already registered.
- Ask the user to enter the password twice.
- Hash the password with `password_hash()`.
- Check the password with `password_verify()`.
- Save users in a JSON file.
- Log in with an existing account.

## How to run it

You need PHP installed on your computer.

Open the project folder in the terminal and run:

```bash
php index.php
```

Then choose if you want to register or log in and follow the instructions.

## Password hashing

The program saves a password hash instead of the original password. PHP also uses a salt automatically when using `password_hash()`. This means that the same password can have different hashes.

You cannot normally get the original password back from the hash. To check a password, the program uses `password_verify()`.

## User data

The user data is saved in `users.json`. I added this file to `.gitignore` so it will not be uploaded to GitHub.

## What I learned

I learned how to use password hashing, verify passwords, validate input, work with JSON files, and make a simple registration and login system in PHP.