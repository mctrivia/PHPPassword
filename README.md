# PHPPassword
example on how to properly deal with passwords


There has been a lot of really bad advice on how to properly handle passwords. the only thing that should be used is password_hash. md5, sha1, or shutter to think some even suggested base64_encode should never be used as they are totally insecure. There are commands that could be used safely like crypt but shouldn't be used since there is no way to easily future proof them.
If you do not have php 5.5 or greater you will need to include https://github.com/ircmaxell/password_compat/blob/master/lib/password.php
Here is a simple example how properly to deal with passwords. Please note you need to write the first 2 functions to deal with your database. The last 2 lines are examples of use.
