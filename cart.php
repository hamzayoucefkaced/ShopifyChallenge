<?php
include_once ("product.php");

class Cart

{
	private $contents;

	private $total;
	
	public function getContents(){
		return $this->contents;
	}
	
	public function setContents($content){
		$this->contents=$content;
	}
	
	public function getTotal(){
		return $this->total;
	}
	
	public function setTotal($total){
		$this->total=$total;
	}

	public function addtocart($product){

		// add  to cart will add the product name to the array contents, and will add the price to the total

		$this->contents[] = $product;
		$this->total = $this->total + $product->getPrice();
	}

	public function clear()
	{

		// clear will empty the cart

		$this->contents = [];
		$this->total = 0;
	}
}

?>
