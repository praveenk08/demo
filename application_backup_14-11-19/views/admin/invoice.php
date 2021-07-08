
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Invoice</title>
	<!-- <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700&subset=latin,latin-ext' rel='stylesheet'> -->
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700" rel="stylesheet">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta http-equiv="content-type" content="text-html; charset=utf-8">
	<style>
		html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed,figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {	margin: 0;	padding: 0;	border: 0; font: inherit; font-size: 100%;vertical-align: baseline;}

		html {line-height: 1;}
		ol, ul {list-style: none;}
		table {border-spacing: 0;}
		caption, th, td {text-align: left;font-weight: normal;}
		q, blockquote {	quotes: none;}
		q:before, q:after, blockquote:before, blockquote:after {content: "";content: none;}
		a img {	border: none;}
		article, aside, details, figcaption, figure, footer, header, hgroup, main, menu, nav, section, summary {display: block;}
		body {font-family: 'Roboto Slab', serif; font-weight: normal; font-size: 14px; margin: 0; padding: 0; color: #555;}
		body a {text-decoration: none;	color: inherit;}
		body a:hover {color: inherit;opacity: 0.7;}
		body .container {min-width: 500px; max-width: 900px; margin: 0 auto; padding: 0 20px;}
		body .clearfix:after { content: ""; display: table;clear: both;}
		body .left {float: left;}
		body .right {float: right;}
		body .no-break {page-break-inside: avoid;}
		table {width: 100%;}
		strong {font-weight: bold;}
		p {margin-bottom: 7px;}
		p:last-child {margin-bottom: 0;}

		.headerInner {padding: 15px 0; margin-bottom: 30px; border-bottom: 1px solid #ccc;  }
		.headerInner .left {text-align: left;}
		.headerInner .right {text-align: right; font-size: 15px; line-height: inherit; max-width: 500px;}
		.headerInner .right .title {font-size: 24px; }
		.logo img {max-width: 100px;}

		.invoiceInner {margin-bottom: 50px;}
		.sectionTitle {font-size: 20px; text-transform: uppercase; font-weight: bold; margin-bottom: 10px; color: #444;}
		.invoiceInner .left {max-width: 400px;}
		.name {font-size: 16px; color: #444; font-weight: bold;}

		table.orderTable {border: 1px solid #ccc; margin-top: 10px;}
		table.orderTable th {font-weight: bold;}
		table.orderTable th, table.orderTable td {padding: 10px; border: 1px solid #ccc; }
	</style>
</head>
<body>
         <!--  <?="<pre>"; print_r($products);?> -->
	<header class="clearfix">
		<div class="container">
			<div class="headerInner clearfix">
				<table border="0">
					<tr>
						<td>
							<figure class="logo">
									<img src="http://localhost/mahaseel/assets/frontend/images/logo.png" alt="logo">
							</figure>
						</td>
						<td style="text-align: right; padding-right: 10px;">
							<p class="title"><strong>Mahaseel</strong></p>
							<p>5th Floor, AH Building, 756 New Design St, Riffa, Bahrain</p>
							<p><strong>Telephone:</strong> (973)-36690669</p>
							<p><strong>E-mail:</strong> <a href="mailto:care@mahaseel.bh">care@mahaseel.bh</a></p>
							<p><strong>Website:</strong> <a href="https://www.mahaseel.bh/">www.mahaseel.bh</a></p>
						</td>
					</tr>
				</table>	
				
			</div>
		</div>
	</header>
	<section class="invoiceDetail">
		<div class="container">
			<div class="invoiceInner clearfix">
				<p class="sectionTitle">Invoice To:</p>
				<table border="0">
					<tr>
						<td>
							<p class="name"><?=$address['name'];?></p>
							<p><?=$address['phone'];?></p>
							<p><a href="mailto:<?=$address['email'];?>"></a><?=$address['email'];?></p>
							<p><?=$address['address'];?></p>		
						</td>
						<td style="text-align: right; padding-right: 10px;">
							<p><strong>Date Added</strong> 11/Feb/2019</p>
							<p><strong>Invoice No.</strong> INV-2019-001</p>
							<p><strong>Payment Method</strong> Cash on delivery</p>
							<p><strong>Shipping Method</strong> Flat Shipping Method</p>
						</td>
					</tr>
				</table>
				
			</div>
		</div>
	</section>
	<section class="orderDetail">
		<div class="container">
			<table border="0">
				<tr>
					<td><p><span>Order No.</span> <strong>OD-152346</strong></p></td>
					<td style="text-align: right;"><p><span>Order Date:</span> <strong>11 Feb 2019</strong></p></td>
				</tr>
			</table>
			<div class="clearfix"></div>
			<table class="orderTable">
				<thead>
					<tr>
						<th style="white-space: nowrap;min-width: 200px;">Title</th>
						<th>Description</th>
						<th style="text-align: center;">Quantity</th>
						<th style="text-align: right; white-space: nowrap;">Unit Price</th>
						<th style="text-align: right; white-space: nowrap;">Vendor Name</th>
					</tr>
					
				</thead>
				<tbody>
					<?php
					//$sub_total=0;
					 foreach ($products as $key => $product) 
					{ ?>
					<tr>
						<td><?= ucfirst($product['name']);?></td>
						<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim ven.</td>
						<td style="text-align: center;"><?= $product['quantity']?></td>
						<td style="text-align: center;"><?= $product['price']?></td>
						<td style="text-align: center;"><?= $product['vendor_name']?></td>
					</tr>
					<?php 

						// $sub_total=number_format($product['quantity']*$product['price'],2);
						// $grand_total=$grand_total+$sub_total;
				}?>
				</tbody>
				<tfoot>
					<tr>
											
						<td colspan="4" style="text-align: right;"><strong>Sub-Total</strong></td>
						<td style="text-align: right; white-space: nowrap;"><?=$total_amount;?></td>
					</tr>
					<tr>
						<td colspan="4" style="text-align: right;"><strong>Flat Shipping Rate</strong></td>
						<td style="text-align: right; white-space: nowrap;"><?= number_format($a,2);?></td>
					</tr>
					<tr>
						<td colspan="4" style="text-align: right;"><strong>Grand Total</strong></td>
						<td style="text-align: right; white-space: nowrap;"><?=$total_amount;?></td>			
					</tr>
					<tr>
						<td colspan="4" style="text-align: right;"><strong>Transation type</strong></td>
						<td style="text-align: right; white-space: nowrap;"><?=$transaction_id;?></td>			
					</tr>


				</tfoot>
			</table>
		</div>
	</section>
</body>
</html>