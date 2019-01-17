<?php
require("marketplace.php");

require("product.php");

require("cart.php");

session_start();
if (!isset($_SESSION['cart']))
{
    $_SESSION['cart'] = new Cart();
}

$marketplace = new Marketplace();

if (isset($_GET['buy']))
{
    $query = $marketplace->query($_GET['buy']);
    // if a get request by the key buy is made, it will add to the cart in the session depending on the value if it is in stock, if not it will inform you it is not in stock and will not add it
    //EXAMPLE:
    // URL: http://localhost:8000/shopifyphp/index.php?buy=Playstation will result in You have added a playstation to your cart! your total is now: 500
    if ($query != -1)
    {
        if ($query->getInvCount() != 0)
        {
            $_SESSION['cart']->addtocart($query);
            echo "You have added a ", $query->getTitle() , " to your cart! Your total now is: ", $_SESSION['cart']->getTotal();
        }
        else
        {
            echo $query->getTitle() , " is out of stock!";
        }
    }
    else
    {
        echo "No such item!";
    }

    echo "<br />";
}

else if (isset($_GET['query']))
{

    // if a get request by the key query is made, it will set th value as the parameter of query function, which
    // if it is 0 it will result in it displaying only products that are in stock, if anything else it will display all products
    // even the ones out of stock
    // EXAMPLE:
    // http://localhost:8000/shopifyphp/index.php?query=0
    // Playstation has 120 products left
    // Gameboy has 30 products left
    // http://localhost:8000/shopifyphp/index.php?query=1
    // Nintendo Switch has 0 products left
    // Playstation has 120 products left
    // Gameboy has 30 products left
    if ($_GET['query'] == "all" || $_GET['query'] == "available")
    {
        for ($x = 0;$marketplace->query($x) != - 1;$x++)
        {
            if ($_GET['query'] == "available" && $marketplace->query($x)->getInvCount() == 0)
            {
                continue;
            }
            echo $marketplace->query($x)->getTitle() , " has ", $marketplace->query($x)->getInvCount() , " remaining items. <br/>";
        }
    }
	else {echo "Unrecognized command!";}

}

else if (isset($_GET['complete']))
{
	if($_GET['complete']==1){
    $cart = $_SESSION['cart'];
	$purchasetotal = 0;
    // this is meant for completing the cart, it will iterate through the cart contents that are saved in the session and will
    // purchase them if they are in stock in the marketplace, and then clear the cart afterwards, and produ
    // EXAMPLE:
    // http://localhost:8000/shopifyphp/index.php?complete=1
    // Your total is: 2000
    // You have purchased 1 Playstation there remains 117
    // You have purchased 1 Nintendo Switch there remains 21
    // You have purchased 1 Nintendo Switch there remains 20
    // You have purchased 1 Gameboy there remains 26
    // You have purchased 1 Gameboy there remains 25
    echo "Your total is: ", $cart->getTotal(),"<br/>";
    foreach ($cart->getContents() as	$product)
    {
	 $result = $marketplace->purchase($product->getID());
     if($result == 1){
	 $purchasetotal = $purchasetotal + $product->getPrice();
	 echo "You have purchased 1 ",$product->getTitle(),"<br/>";
	 }
	 else if($result == -1){
		 echo "Item out of stock! Cannot purchase!<br/>";
	 }
	 else {echo "Item does not exist!<br/>";}
    }
	echo "Your purchase total is: ", $purchasetotal, "<br/>";
	
	$cart->clear();
	}
	else {echo "Unrecognized command!";}
    
}
else {echo "Unknown command!";}

?>