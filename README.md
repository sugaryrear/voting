A voting script that uses an API to validate votes from different sites and rewards users with credits that are stored in a database.

Process:
1) The admin of the voting script creates an ad on any of the voting pages of choice.
2) During the process of creating the ad there will be an option for a callback URL. The callback URL is the location
of the voting PHP file server sided (http://yoursite.com/callback.php) that will load once the user has voted. 
During the creation of the ad there will also be unique API key that the admin must take a note of (for example 59819303449)
5) Now once the user has successfully voted, 2 variables (the unique API key and the users IP address) are sent to the callback URL
6) The variables are processed in the callback.php and if successful the credits are applied to the user in the mysql database.

run the java program "dbtest" to test the program
