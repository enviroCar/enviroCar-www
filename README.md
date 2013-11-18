enviroCar-www
=============

Website of the enviroCar project

Installation
------------

To run the website on your own you have to install a webserver. We suggest to use an Apache2 webserver with a PHP5 extension. For Ubuntu servers, you can use the following commands:

```
sudo apt-get install apache2
sudo apt-get install php5
```

For the interaction with the RESTful server, you have to install the cURL extension to php.

```
sudo apt-get install php5-curl
```

Project Structure
-----------------

* /
  * HTML and .php files
* /assets
  * /includes (server-side code, responsible for RESTful connection as well as login- and language sessions)
  * /css (Twitter Bootstrap and custom CSS files
  * /js (javascript of libraries)
  * /font (used fonts)
  * /ico (favicon for the browser)
  * /OpenLayers (map library library)
  * /download (example .shp for the information page)
  * /img (images used on the website)


Development
-----------

As described in the File structure the main html files are located in the root directory. To create new pages you simply have to include the header.php and footer.php within a new .php file which contain all necessary CSS and Javascript files.

For the server connection the main logic is located in the file ``/includes/connection.php``. The RESTful methods GET and POST require a parameter specifying if an authorization is required. If the parameter is true, the password and username will be retrieved from the $_SESSION variable set at the login (``/includes/authentification.php``). PUT and DELETE don't require a authorization parameter as all possible methods from the API require a user authorization.

Within the files ``/includes/user.php`` and ``/includes/groups.php`` are several function for specific API calls (e.g. getting tracks) encapsulated as HTTP GET requests which allows them to be called via Javascript (or any other language) without needing to call the php-functions.

The complete server-client communication is based on those php-functions as it allows to handle the user-credentials on the server instead of revealing the password on the client side.

### Languages

Languages are currently managed as ``.php`` files in ``enviroCar-www\assets\includes`` named ``lang_[twoLetterIdentifierForLanguage].php``.

The selection of the language uses the browser's language and can be overridden by user settings, see ``enviroCar-www\assets\includes\languages.php``.


### Styles and CSS

Currently all our custom CSS goes either into the file ``assets/css/custom.css`` or into .php files, which is on our radar to be improved.
