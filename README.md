CHALLENGE:

Please complete the following challenge, and provide your thought process/work. You can attach your work in a text file, link, etc. on the application page (it is also really great when things are on GitHub). Please ensure it is easy to follow for reviewers - as someone from our team will look at every submission!

Task: Build the barebones of an online marketplace.

To do this, build a server side web api that can be used to fetch products either one at a time or all at once.
Every product should have a title, price, and inventory_count.

Querying for all products should support passing an argument to only return products with available inventory. 

Products should be able to be "purchased" which should reduce the inventory by 1. Products with no inventory cannot be purchased.

P.s. No need to make a frontend!

Extra credit (100% optional as there are lots of different ways to shine in your application): 

Fit these product purchases into the context of a simple shopping cart. 

That means purchasing a product requires first creating a cart, adding products to the cart, and then "completing" the cart.
The cart should contain a list of all included products, a total dollar amount (the total value of all products), and product inventory shouldn't reduce until after a cart has been completed.

Extra extra credit (please, only do this if you really want to, honest!):

Bonus points for making your API (at least partly) secure, writing documentation that doesn’t suck, including unit tests, and/or building your API using GraphQL.

MY SOLUTION:

This was developed using PHP7.3 and tested on the default PHP7.3 webserver. This works on all browsers, but I recommend using it on Firefox, There are some bugs that occur when using Chrome.
I used the php -S localhost:8000 to start the server.
I used a JSON "database" to store the values of the products. 

A session with a cart and a marketplace will automatically be created when the index page is accessed.
I used GET REST protocol for this project.

COMMANDS:

http://localhost:8000/shopifyphp?buy=ID

This will add an item with given ID to the cart and print the total amount of the cart. Refer to json database for Product IDs. Usage of invalid IDs will cause the page to tell you that the item does not exist. Usage of non numeric variable will throw a 400 HTTP error.

http://localhost:8000/shopifyphp?query=all

This will print the values of all the products stored in the database.

http://localhost:8000/shopifyphp?query=available

This will print the values of all the products that are in stock.

Any other value inputted in the "query=" will cause a 400 HTTP error.

http://localhost:8000/shopifyphp?complete=1

This will checkout the cart if it contains some products. It will print a message that the cart is empty if the cart is empty. 

Any other value inputted in the "complete=" will cause a 400 HTTP error.

Any other command will cause a 404 HTTP error.

Navigating to any page that does not exist will throw a 404 HTTP error.

I deliberately coded the index to only allow one get request at a time, hence the usage of if else statements when handling the GET requests. 

http://localhost:8000/shopifyphp?query=available&&nothing=nothing will ONLY process the query request.

Note: I have attempted to incorporate GraphQL technology to this project, but because I was using a university computer, I have found 
it difficult to do so, as I was missing account rights that inhibited me from making necessary changes that will allow the package to run on the system.







 
