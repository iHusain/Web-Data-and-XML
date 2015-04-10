<!-- 
Name : Husain Mandsaurwala
ID : 1001009859
-->

<?php
# Start the Session
session_start();
# If session variable not set then create an array for the session variable to hold all the selected data
if(!isset($_SESSION['items'])){
	$_SESSION['items'] = array();
}
# if session variable for the cart is not set then create a session variable
if(!isset($_SESSION['cart'])){
	$_SESSION['cart'] = array();
}
$GLOBALS['sum'] =0;
?>

<html>
	<head>
		<title>Buying Products</title>
	</head>
	<body>
		<p>
		Shopping Cart :
		</p>
		<table border=1>
		</table>
		<p/>
		<?php
			# On clicking buy the item is pushed to the Array 
			if(isset($_GET['buy'])){
			# check for duplicate addition
			if(in_array($_GET['buy'],$_SESSION['items'])){
				phpAlert("Trying to add the same element twice thus it will erase and start fresh");
				emptyCart();
			}
			else {
				array_push($_SESSION['items'], $_GET['buy']);
				}
			}
		?>
		<?php
			# Puts the product in the session shopping cart with respect to the product id passed
			if(!empty($_SESSION['items'])){
			if(isset($_GET['buy'])){
				foreach ($_SESSION['items'] as $items) {
				# the values searched by the call to the API is saved in $_SESSION['values'] and looped through and checked with $_SESSION['items'] array
					foreach ($_SESSION['values'] as $key => $value) {
						# if it's totally similar along the type also then push to cart
						if($items===$value[0]){
							array_push($_SESSION['cart'], $value);
						}
					}
				}
			}
		}
		?>
<?php 
# Print the value in the shopping cart
if(isset($_SESSION['cart'])){
	printCart();
}
?>
<?php
# Deletes the selected product
if(isset($_GET['delete'])){
	deleteCart();
} 
?>
		Total: <?php printSum(); ?><p/>
		<form action="buy.php" method="GET">
		<input type="hidden" name="clear" value="1"/>
		<input type="submit" value="Empty Basket"/>
		</form>
<?php 
	if(isset($_GET['clear'])){
	emptyCart();
	}
?>
		<p/>
		<form action="buy.php" method="GET">
		<fieldset><legend>Find products:</legend>
		<label>Category: <select name="category"><option value="72">Computers</option><optgroup label="Computers:"><option value="1714">Components</option><optgroup label="Components:"><option value="1722">Graphics Cards</option><option value="1725">Input Adapters</option><option value="1717">Motherboards</option><option value="1718">PC Cases</option><option value="1719">Processors</option><option value="1724">Sound Cards</option><option value="96448">System Cooling</option><option value="96452">System Power Supplies</option></optgroup><option value="96409">Computer Accessories</option><optgroup label="Computer Accessories:"><option value="1627">Cables and Connectors</option><option value="352">Cartridges and Toners</option><option value="1721">Computer Speakers</option><option value="1633">Laptop and Tablet Accessories</option><option value="1632">Monitor Accessories</option><option value="1635">Printer Accessories</option><option value="96436">Scanner Accessories</option><option value="1646">Surge Suppressors</option><option value="96453">UPS Accessories</option><option value="1647">UPS Systems Devices</option></optgroup><option value="96262">Computer Memory</option><optgroup label="Computer Memory:"><option value="96258">Cache Memory</option><option value="96261">Memory Adapters</option><option value="96259">Memory Cards</option><option value="96256">Random Access Memory (RAM)</option><option value="96260">Read Only Memory (ROM)</option><option value="96257">Video Memory</option></optgroup><option value="85721">Hardware</option><optgroup label="Hardware:"><option value="96500">Barcode Scanners</option><option value="96600">Barebone Systems</option><option value="9007">Laptops</option><option value="96297">Mac Desktops</option><option value="460">Mac Laptops</option><option value="9006">Monitors</option><option value="96438">Network Terminals</option><option value="451">PC Desktops</option><option value="6">Printers</option><option value="7">Scanners</option><option value="96263">Servers</option><option value="96601">Tablets and eBook Readers</option></optgroup><option value="456">Input Devices</option><optgroup label="Input Devices:"><option value="1694">Graphic Tablets</option><option value="1696">Keyboards and Mice</option><option value="1693">PC Gaming Devices</option><option value="1697">Web Cameras</option></optgroup><option value="461">Modems</option><option value="455">Networking</option><optgroup label="Networking:"><option value="96267">Bridges</option><option value="96286">Concentrators and Multiplexers</option><option value="96283">Expansion Modules</option><option value="96288">Firewalls</option><option value="1684">Hubs and Switches</option><option value="96405">IP Phones</option><option value="96623">Media Streamers</option><option value="96291">Network Accessories</option><option value="1683">Network Adapters</option><option value="96287">Network Cables</option><option value="1687">Networking Repeaters</option><option value="96292">Other Network Devices</option><option value="96268">Routers</option><option value="96284">Serial Adapters</option><option value="96270">Transceivers</option><option value="96290">Wireless Access Points</option><option value="96619">Wireless Adapters</option></optgroup><option value="90187">PDAs and Portable Hardware</option><optgroup label="PDAs and Portable Hardware:"><option value="9">PDAs</option><option value="1637">eBook Reader and PDA Accessories</option></optgroup><option value="96394">Software</option><option value="462">Storage and Media</option><optgroup label="Storage and Media:"><option value="63686">Blank Media</option><option value="94757">CD, DVD and Blu-ray Burners</option><option value="94758">DVD and CD ROM Drives</option><option value="96269">Drive Cases</option><option value="1702">Floppy Drives</option><option value="1701">Hard Drives</option><option value="1707">Network Storage</option><option value="96437">Storage Controllers</option><option value="1708">Tape Drives</option><option value="1705">Zip and Other Drives</option></optgroup></optgroup></select></label>
		<label>Search keywords: <input type="text" name="search"/ required><label>
		<input type="submit" value="Search"/>
		</fieldset>
		</form>
		<p/>
		<?php
			# This will ignore all the warnings
			error_reporting(E_ERROR | E_PARSE);
	if (isset($_GET['search'])) {
				searchApi();
	}		
		?>	
		
<!-- The search function which uses the shopping API is called from here -->
		<?php 
		function searchApi() {
			$url="http://sandbox.api.ebaycommercenetwork.com/publisher/3.0/rest/GeneralSearch?apiKey=78b0db8a-0ee1-4939-a2f9-d3cd95ec0fcc&trackingId=7000610&category=".urlencode($_GET['category'])."&keyword=".urlencode($_GET['search'])."&numItems=20";
			$string_content=file_get_contents($url);
			$xml= new SimpleXMLElement($string_content);
			# make an array for the session to hold
			$_SESSION['values'] = array();
				if($xml !=null){
						# create an array where the products are pushed
						echo "<table border='1'>";
						foreach($xml->categories->category->items->product as $product) {
							echo "<tr>";
							echo "<td><a href=buy.php?buy=".$product->attributes()."><img src=\"".$product->images->image->sourceURL."\"></td>";
							echo "<td>".$product->name."</td>";
							echo "<td>".$product->minPrice."$"."</td>";
							echo "<td>".$product->fullDescription."</td>";
							echo "</tr>";
						# create a temp array 
						$temp = array();
						# values being pushed into the temp array
						array_push($temp,(string)$product->attributes(),(string)$product->images->image->sourceURL,(string)$product->name,(string)$product->minPrice,(string)$product->fullDescription);
						# the temp array pushed into the Session variable 
						array_push($_SESSION['values'], $temp); 
					}
					echo "</table>";
				}
		}
		?>
<!-- Empty Cart function is written here -->
<?php 
function emptyCart(){
	# Remove all Session Variables
	session_unset();
	# Destroy the Session
	session_destroy();
	}
?>

<!-- Deleting from the Cart -->
<?php 
function deleteCart(){
foreach ($_SESSION['cart'] as $key => $value) {
			if (in_array($_GET['delete'], $value)){
				unset($_SESSION['cart'][$key]);
				unset($_SESSION['values'][$key]);
				unset($_SESSION['items'][$key]);
		}	
	}
}
?>
<!-- Printing the shopping cart -->
<?php 
function printCart(){
echo "<table border='1'>";
	
	foreach ($_SESSION['cart'] as $key => $value) {
		echo "<tr>";
		echo "<td><img src=\"".$value[1]."\"></td>";
		echo "<td>".$value[2]."</td>";
		echo "<td>".$value[3]."$"."</td>";
		echo "<td><a href=buy.php?delete=".$value[0].">Delete</a></td>";
		$GLOBALS['sum'] += $value[3];
		echo "</tr>";
	}
	echo "<table border='1'>";
}
?>

<!-- for duplicates insertion -->
<?php
function phpAlert($msg) {
    echo '<script type="text/javascript">alert("' . $msg.'")</script>';
}
?>
<!-- Printing sum -->
<?php 
function printSum(){
	echo $GLOBALS['sum']."$";
}
?>
	</body>
</html>
