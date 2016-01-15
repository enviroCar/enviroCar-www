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
  * /js (javascript files)
  * /font (used fonts)
  * /ico (favicon for the browser)
  * /OpenLayers (map library library)
  * /download (example .shp for the information page)
  * /img (images used on the website)


Development
-----------

We use a ``dev`` and a ``master`` branch. All pull request must be send to the ``dev`` branch.

As described in the File structure the main html files are located in the root directory. To create new pages you simply have to include the header.php and footer.php within a new .php file which contain all necessary CSS and Javascript files.

For the server connection the main logic is located in the file ``/includes/connection.php``. The RESTful methods GET and POST require a parameter specifying if an authorization is required. If the parameter is true, the password and username will be retrieved from the $_SESSION variable set at the login (``/includes/authentification.php``). PUT and DELETE don't require a authorization parameter as all possible methods from the API require a user authorization.

Within the files ``/includes/user.php`` and ``/includes/groups.php`` are several function for specific API calls (e.g. getting tracks) encapsulated as HTTP GET requests which allows them to be called via Javascript (or any other language) without needing to call the php-functions.

The complete server-client communication is based on those php-functions as it allows to handle the user-credentials on the server instead of revealing the password on the client side.

As the code is using short tags (code between <? and ?> tags is recognized as PHP source), the option ``short_open_tag = On`` needs to be set in the ``php.ini`` file. 

Only for Windows machines:

As the server connections are based on curl using SSL, the CA root certificate bundle needs to be downloaded, see for example http://curl.haxx.se/docs/caextract.html, and the path to the bundle needs to be set in the ``php.ini`` file as well, e.g. ``curl.cainfo=c:\php\cacert.pem``.

### Languages

Languages are currently managed as ``.php`` files in ``enviroCar-www\assets\includes`` named ``lang_[twoLetterIdentifierForLanguage].php``.

The selection of the language uses the browser's language and can be overridden by user settings, see ``enviroCar-www\assets\includes\languages.php``.


### Styles and CSS

All custom CSS should be put into separate file and not inside the .php files. For a page example.php create a file /assets/css/example.css, it will automatically be loaded with the example.php page. Application-wide CSS styles can be put into /assets/css/custom.css.

### Javascript
Custom Javascript code belongs in separate files as well. For a page example.php create a file /assets/js/example.js.php, it will automatically be loaded with the example.php page. The .php extension is needed for inline php code.

### Config File
All global variables such as server urls should be saved in /assets/includes/config.php. If you want to use those variables the config.php needs to be included using require_once. A get method is also required. See the config.php or http://www.ibm.com/developerworks/library/os-php-config/ for additional information.
