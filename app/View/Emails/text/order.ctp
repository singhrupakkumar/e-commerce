<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet"> 


<style>
	body{margin:0px auto;padding:0;background:#f2f2f2; font-family: 'Lato', sans-serif; padding:10px;}
	.main_outer {
	border: 5px solid #fff;
	box-shadow: 0 0 5px #D4D4D4;
	background: #f9f9f9;
	border-radius: 4px;
	width: 580px;
}
	
	@media only screen and (max-width: 580px){
		.main_outer{width:550px;}
		}
	@media only screen and (max-width: 480px){
		.main_outer{width:450px;}
		}
	@media only screen and (max-width: 360px){
		.main_outer{width:330px;}
	}
	
	@media only screen and (max-width: 320px){
		.main_outer{width:290px;}
		}
</style>

<body>


<div class="main_outer" style="margin:0px auto; text-align:center; background:#cecdcc;">
	<table width="100%" border="0">
      
      <tr>
        <td style="padding-top:35px;"><img style='height:70px;' src="http://rupak.crystalbiltech.com/shop/home/images/logo.png" alt="images" /></td>
      </tr>
     
      <tr>
        <td>
      
        <p> Hi Dear <?php echo $shop['Order']['first_name'].' '.$shop['Order']['last_name'] ;?>, Your order #<?php echo $shop['Order']['id'] ?> has been  <b style="color:#787878;"><?php if($shop['order_status']==1){ echo 'Placed'; }else if($shop['order_status']==2){ echo 'Confirmed'; }else if($shop['order_status']==3){ echo 'Cancelled'; }else{ echo 'Delivered'; }  ?></b></p>
        </td>
      </tr>

    </table>
	
	
	<table width="400" border="1" cellpadding="10" cellspacing="0" text-align="left" style="text-align:left; margin:0px auto; border-color:#ddd; ">
		<h5> Your order #<?php echo $shop['Order']['id'] ?></h5>
		<thead>
		<tr>
			<th>No. Of items</th>
			<th>Item</th>
			<th>Image</th>
			<th style="text-align:right;">Price </th>
		</tr>
		</thead>
		<tbody>
		<?php
		$counter=1;
		
		//echo $shop['OrderItem'][0]['name'];
			
			for($i=0; $i< count($shop['OrderItem']);$i++){			
				echo "<tr>";				
				echo "<td>$counter</td>";
				echo "<td>".$shop['OrderItem'][$i]['name']."</td>";
				echo "<td><img src='".$shop['OrderItem'][$i]['image']."' style='height:50px;'></td>";
				echo "<td>$".$shop['OrderItem'][$i]['price']."</td>";
				echo "</tr>";
				$counter++;
			}
		
		 ?>
		</tbody>
	</table>
	<table width="100%" border="0">
      
     
      <tr>
        <td>
      
        <h3>Thanks! </h3>
        
        </td>
      </tr>

    </table>
	</div>
	
</div>


</body>
</html>

