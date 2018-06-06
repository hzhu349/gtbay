gtbay project for CS6400 Intro to Databases



./index.php	-- Global loader
./config.php	-- Variables for database username, password, database hostname, and database name
./view 		-- All view php files



index.php takes a GET variable called action, which specifies which view to load.  All of the views have mysql calls embeded
directly in them, and for the most part the respective views handle their own form submissions.

BluePrintCSS was used for the styling (to some extent)
