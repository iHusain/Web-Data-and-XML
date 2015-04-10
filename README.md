# Web-Data-and-XML
All projects covered in the subject Web Data and XML at UTA


---------------------------------Project 1--------------------------------------
Your project is to develop a web application to get information about movies, their cast, their posters, etc. This application should be developed using plain JavaScript and Ajax. You should not use any JavaScript library, such as JQuery. Note that everything should be done asynchronously and your web page should never be redrawn/refreshed completely. This means that the buttons or any other input element in your HTML forms must have JavaScript actions, and should not be regular HTTP requests.

Your application should have a text section where one can type a movie title (eg, The Matrix), one "Display Info" button to search, one section to display the search results, and one section to display information about a movie. The search results is an itemized clickable list of movie titles along with their years they were released. When you click on one of these movie titles, you display information about the movie: the poster of the movie as an image, the movie title, its genres (separated by comma), the movie overview (summary), and the names of the top five cast members (ie, actors who play in the movie).

You need to use the following TMDb HTTP methods listed in The Movie Database API:
/3/search/movie: Search for movies by title.
/3/movie/{id}: Get the basic movie information for a specific movie id.
/3/movie/{id}/credits: Get the cast and crew information for a specific movie id.
You need to call the TMDb web service through the proxy.php. For example, to get information about the movie "The Matrix" (which has id 603), you use the HTTP call proxy.php?method=/3/movie/603 (it doesn't need the API key -- it's already in the proxy). To search for the movie "matrix", you call proxy.php?method=/3/search/movie&query=matrix.


---------------------------------Project 2--------------------------------------

You need to edit the HTML file yelp.html and the JavaScript file yelp.js. Your HTML web page must have 3 sections:

a search text area to put search terms with the button "Find"
a Google map of size 600*500 pixels, initially centered at (32.75, -97.13) with zoom level 16
a text display area
When you write some search terms in the search text area, say "Indian buffet", it will find the 10 best restaurants in the map area that match the search terms. They may be less than 10 (including zero) sometimes. The map will display the location of these restaurants as map overlay markers with labels from 1 to 10. The text display area will display various information about these restaurants. It will be an ordered list from 1 to 10 that correspond to the best 10 matches. Each list item in the display area will include the following information about the restaurant: the image "image_url", the "name" as a clickable "url" to the Yelp page of this restaurant, the image "rating_img_url" (1-5 stars), and the "snippet_text". When you search for new terms, it will clear the display area and all the map overlay markers, and will create new ones based on the new search.

How do you find the latitude and longitude of a restaurant to put an overlay marker on the map? You need to extract the postal address from the Yelp response and use Geocoding
How do you tell Yelp to search only on the displayed map? You need to "Specify Location by Geographical Bounding Box" on your Yelp search. You get this box from the Google Map.
Note that everything should be done asynchronously and your web page should never be redrawn completely. You need only one XMLHttpRequest object for sending a request to Yelp, since Google Maps is already asynchronous. You should not use JQuery.

---------------------------------Project 3--------------------------------------

You will use the shopping.com API for shopping. The eBay Commerce Network API ("ECN API") is a flexible way to access and recreate practically everything you see on Shopping.com. First, you need to get an API key. You may use my API key in the given buy.php. You will use the Search by keyword method and the Requesting category tree information -> Include all descendants in category tree method from the eBay Commerce Network Publisher API Use Cases.

Your search form must have a menu to select a category, a text window to specify search keywords, and a submit button. The menu must contain all sub-categories of the category "computers" (whose id is 72). The menu items must be generated in your PHP code by requesting all the descendants of the category tree with id=72 (the computers category). The result of a keyword search must contain up to 20 products within the selected category that best match the keyword query. Each product contains a link productOffersURL to the shopping.com web page that gives a detailed description of the product and a list of best offers from various sellers. So each product has a range minPrice - maxPrice of the prices offered by these sellers. We will ignore the list of offers and we will assume that when we buy this product we pay the minPrice.

You need to use a PHP session to store the shopping basket (the list of chosen items throughout the session) as well as the results of the previous search. For each chosen item, you store the Id, the name, the minPrice, the first image, and the productOffersURL (the link to the shopping.com web page that lists the best offers for this item). Your PHP script must be able to handle the following query strings:

To search for all items in the "Laptops" category that match the search keywords "samsung i7":
buy.php?category=9007&search=samsung+i7
This should call the web service request http://sandbox.api.ebaycommercenetwork.com/publisher/3.0/rest/GeneralSearch?apiKey=xxx&trackingId=yyy&category=9007&keyword=samsung+i7&numItems=20, where xxx and yyy are your access apiKey and your trackingId. The web service results will arrive in XML. To see how the XML data look like, cut and paste this URL on your browser and look at the reply.
To put a listed item with id=138681275 in the shopping basket (if it does not exist):
buy.php?buy=138681275
Your script should look at the results of the last search stored in $_SESSION to find the item under this Id and should copy it into the shopping basket.
To remove a listed item with Id=138681275 from the shopping basket (if exists):
buy.php?delete=138681275
To clear the shopping basket:
buy.php?clear=1

---------------------------------Project 4--------------------------------------

Your script board.php must be able to produce 4 web pages (can be from the same script or you can split it into 4 different php scripts):

Page1: a login form that has text windows for username and password, a "Login" button, and a "New users must register here" button.
Page2: a "Logout" button, a "New Message" button, and the printout of all messages.
Page3: a textarea with a "Post" button.
Page4: a form to fill out user information along with a "Register" button
When board.php is executed for the first time, it displays Page1:
If the user enters a wrong username/password and pushes "Login", it should go back to Page1
If the user enters a correct username/password and pushes "Login", it should go to Page2
If the user pushes the "New users must register here" button, it should go to Page4
From Page4, if the user pushes "Register" and the username doesn't already exist it goes to Page1; otherwise, it goes to Page4.
From Page2, if the user pushes "Logout", it should logout and go to Page1.
From Page3, if the user fills out the textarea and pushes the "Post" button, it will insert the new message in the database and will go to Page2.
For each posted message, you print:

The message ID. If the message is a reply, it should also display the message ID of the message it replies to (ie, the attribute follows).
The username and the fullname of the person who posted the message.
The date and time when this message was posted.
A button "Reply" to reply to this message. If the user pushes this button, it goes to Page3. Page3 must store the new message as a reply to the original message (ie, the attribute follows of the new message must contain the ID of the original message).
The message text.
To make the project easier, the messages must be printed ordered by date/time (oldest first) only. That is, you don't need to nest the replies.

---------------------------------Project 5--------------------------------------

You will develop a trivial photo-album application on Dropbox using JSF and Java. Your task is to support the following operations:

Provide a form to upload a new image (a *.jpg).
A menu to choose a file name from the images in your dropbox directory and a button to download the image from Dropbox and display it in the image section.
A menu to choose a file name from the images in your dropbox directory and a button to delete the chosen image from the dropbox storage.
An image section that displays the chosen image.
Note that the images that you display/delete are those stored in your cse5335 dropbox directory. You should not display any local images stored on your PC.

---------------------------------Project 6--------------------------------------

Based on this ER diagram, do the following:

Create a DTD that captures all this information. Avoid data redundancies (do not duplicate data, except idrefs). You may use IDs/IDrefs in DTD. You may introduce your own ids (ID/IDRefs can hold alphanumerical values only).
Create a small XML document that matches your DTD.
Validate your XML document against your DTD.
Create an XML Schema that matches your XML document. You must define all ids/idrefs. Do not use keys/keyrefs.
Validate your XML document against your XML Schema.

---------------------------------Project 7--------------------------------------

You will evaluate XPath and XSLT over XML data from the shopping.com API (the eBay Commerce Network API) for shopping, which you used in Project #3. More specifically:
Write a Java program xpath.java that reads some search keywords from input, searches the eBay API for items in the category with id=72 (the computers category) that match these keywords, and displays information about these products by evaluating the following XPath queries over the returned XML data:
Print the full description of all products that have a rating 4.50 or higher.
Print the name and the minimum price of all products whose name contains the word Sony.
Print the names of all products whose name contains the word Sony and the price is between $1000 and $2000, inclusive.
Write an XSLT program search.xsl to display the search results by transforming the XML result to XHTML using XSLT so that it looks like the HTML page you generated for the search results in Project #3. Use the Java program xslt.java to test your XSLT and then load the resulting html output file on your web browser.
Note: To call a web service, use the java.net.URL class. To URL-encode the query string, use the java.net.URLEncoder class. For example, this calls the ISBN DB and prints the result.


