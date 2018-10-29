<style>
	.input.text{
		width:100%;
		float:left;
		margin-bottom:20px;
	}
	label{
		width:100%;
		float:left;
	}
	.form-control{
		width:auto;
		float:left;
	}
	button{
		float:left;
		margin-left:4px;
	}
	img{
		width:100%;
	}
	table{
		width:100%;
		margin:0px;
	}
</style>
<div class="page_heading">
	<h2>Product Gallery</h2>
</div>
<div class="row">
    <div class="col-sm-5">
		<div class="form_outer">
			<form action="<?php echo $this->webroot;?>admin/products/uploadproductimage/<?php echo $this->request->params['pro_id']; ?>" id="MaterialAdminAddForm" method="post" enctype='multipart/form-data'>
				<div class="input text required input_file-sec">
					<label for="MaterialName">Image</label>
					<span class="input_img">Choose Image</span>
					<input name="file" class="form-control" type="file"  required="required">
					<input name="product_id" value="<?php echo $_GET['pro_id'];?>" type="hidden"  required="required">
					<input name="server" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" type="hidden"  required="required">
					<button class="btn btn-primary" type="submit">Submit</button>
				</div>
			</form>
			<table class="table-striped table-bordered table-condensed table-hover">
				<tr>
					<th><?php echo $this->Paginator->sort('image'); ?></th>
					<th class="actions">Actions</th>
				</tr>
				<?php foreach ($gallery as $val) : ?>
				<tr>
					<td><?php echo $this->Html->Image('/images/large/' . $val['Gallery']['image'], array('alt' => $val['Gallery']['image'], 'class' => 'image')); ?></td>
					<td class="actions">
					<a href="<?php echo $this->webroot;?>admin/products/deletegallery?gid=<?php echo $val['Gallery']['id'];?>&pid=<?php echo $_GET['pro_id'];?>"" class="btn btn-default btn-xs btn-delet">Delete</a>	 
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>


