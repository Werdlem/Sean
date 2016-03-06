<?php 
include 'menu_bar.html';
require_once 'DAL/PDOConnection.php';
?>
<script src="Jquery/jquery.tools.min.js" type="text/javascript"></script>
<style>
.apple_overlay {
	background-image:url(Css/images/overlay.png);
	display:none;
	width:300px;
	padding:35px
}
#overlay {
	background-image:url(Css/images/background4.png);
	color:#efefef;
	height:450px;
}
div.contentWrap {
	height:300px;
	overflow:hidden;
}
</style>
<title>Product & location Search</title>
<div id="container">
  <div id="inner_container">
    <form action="index.php" method="post" id="Search" >
      <h1>Product Search</h1>
      <div id="search" style="text-align:center">
        <input type="text" class="txt_box" name="search_product" tabindex="1"/>
        </br>
        <input type="submit" name="submit" value="Search" />
        <input type="hidden" name="doSearch" value="1">
      </div>
    </form>
    <br />
    <form action="index.php" method="post" id="Search" >
      <h1>Location/Notes Search</h1>
      <div id="search" style="text-align:center">
        <input type="text" class="txt_box" name="search_location" tabindex="2" />
        </br>
        <input type="submit" name="submit" value="Search" />
        <input type="hidden" name="doSearch" value="2">
      </div>
    </form>
  </div>
</div>
<?php
if(isset($_POST['doSearch'])){
	
	if($_POST['doSearch']==1)
		{
			$productDal = new products;
			$Search = $_POST['search_product'];
			$Search = $productDal->search($Search);
		}
	elseif($_POST['doSearch']==2)
		{
			$productDal = new products;			
			$Search = $_POST['search_location'];	
			$Search = $productDal->SearchLocation($Search);
}



?>
<?php if (!isset($_POST['doSearch']) || $_POST['doSearch']) { ?>
<div id="container">
<div id="inner_container">
<h1>Search Results</h1>
<table width="80%" class="listing_table">
  <form method="POST" action="send.php">
    <thead style="text-align:left">
      <tr class="heading">
        <th>Product</th>
        <th>Location</th>
        <th>Delete</th>
        <th>Order</th>
        <th>Details</th>
      </tr>
    </thead>
    <tbody style="text-align:left">
      <?php foreach ($Search as $result){?>
      <tr>
        <td><strong style="color:#00F"><?php echo $result['product'];?></strong>
          <?php 
				//PRODUCT EDIT AND LOCATION ASSIGN				
				if ($result['product'] == null){ echo("<a href='add_product.php?id=".$result['id']."' style='color:red'>Add</a>");}				
				elseif ($result['location']>0){ 
				echo "<a href='update_product.php?id=".$result['product']."'style='color:red' >edit</a>";}				
				else
				{echo "<a href='product_detail.php?l_id=".$result['product']."'style='color:red'>assign</a>";}				
				?></td>
        <td><strong style="color:#00F"><?php echo $result['location'];?></strong>
          <?php 
				// lOCATION ADD PRODUCT AND ASSIGN PRODUCT
				if ($result['id']>0){ 
				echo "<a href='add_product.php?id=".$result['id']."'style='color:red'>edit</a>";}
				else{ 
				echo "<a href='product_detail.php?l_id=".$result['product']."'style='color:red'>assign</a> ";
				}
				?></td>
                
        <td><a href="delete.php?delete=<?php echo $result['id'];?>"><img src='Css/images/delete.png' style='width:22px; height:20px' /></a></td>
        <td><a href="send.php?product=<?php echo $result['product']; ?>"><img src='Css/images/order.png' style='width:22px; height:20px' /></a></td>
        <?php if ($result['product_id']>0){ ?>
        <td><img src="Css/images/info.png" style="width:22px; height:20px; cursor: pointer;" href="src_results.php?product=<?php echo $result['product_id'];?>" rel="#overlay" /></td>
        <?php } else{echo "<td><img src='Css/images/info_dis.png' style='width:22px; height:20px'></td>";} ?>

        <div class="apple_overlay" id="overlay"> 
          <!--External content loaded here-->
          <div class="contentWrap" style="width:300px; height:300px"> </div>
        </div>
        <?php			
		}
}
?>
      </tr>
    </tbody>
  </form>
</table>
<script>
			 $(function(){
			 $("img[rel]").overlay({
				 mask: 'black',
				effect: 'apple',
				onBeforeLoad: function(){
					//grab wrapper element inside content
					var wrap = this.getOverlay().find(".contentWrap");
					//load page specified in thhe trigger
					wrap.load(this.getTrigger().attr("href"));
				}
			 });
		});
			 </script>
<?php } // if (!isset($Search) || !$Search) ?>
