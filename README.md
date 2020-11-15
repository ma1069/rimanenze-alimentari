# mirror
PHP Portal to prevent waste of food surplus.

The website allow shops to report the surplus they have so that charities can recover them
by "booking" them and scheduling the pick up time/date. This allows shops to get rid of 
some of their surplus and charities to plan a pick up route, effectively gathering 
everything they need. 

The project is hosted on http://retedisostegno.org and developed by the Accademia 
dell'Hardware e del Software Libero "Adriano Olivetti", an italian association promoting 
knowledge about open hardware and software.

## Requirements

Mirror is a simple PHP application, so it just requires a server able to process PHP pages 
and a MySQL-compatible database server to hold the dump file. The server just needs PHP, 
the PDO driver and Composer.

## How to install

After checking out the repository, just run
``` $ composer install ```
to install the required dependendcies, and you are good to go. Apache (or Nginx, or 
anything else) needs to point to `/pages`, while the rest of the code must remain 
inaccessible to the public.

The next step is to load the `dump.sql` file to your own database, and configure the 
`lib/database.php` file with the proper database url/database/password.

Then, you should be good to go. Happy coding :) Pull requests are more than welcome!


