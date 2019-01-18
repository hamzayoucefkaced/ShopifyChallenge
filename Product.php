<?php
class Product{
    private $productid;
    private $price;
    private $title;
    private $inventory_count;

    public function __construct($id,$prc, $ttl, $invcount){
		$this->productid = $id;
        $this->price = $prc;
        $this->title = $ttl;
        $this->inventory_count = $invcount;
    }
	
	public function setPrice($newprice){
		$this->price = $newprice;
	}
	
	public function getPrice(){
		return $this->price;
	}
	
	public function setTitle($newtitle){
		$this->title = $newtitle;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
	public function setInvCount($newinvcount){
		$this->inventory_count = $newinvcount;
	}
	
	public function getInvCount(){
		return $this->inventory_count;
	}
	
	public function setID($id){
		$this->productid = $productid;
	}
	
	public function getID(){
		return $this->productid;
	}
	
}
?>
