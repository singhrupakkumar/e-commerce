<style>
	table{
		width:100%;
		margin:0px;
	}
	table img{
		width:100%;
	}
</style>
<div class="page_heading">
	<h2>View Static Page</h2>
</div>
<p>
	<?php $x=$this->Session->flash();
		if($x){ ?>
		<div class="alert success">
			<span class="icon"></span>
			<strong>Success!</strong><?php echo $x; ?>
		</div>
	<?php } ?>
</p>
<div class="row">
	<div class="col-md-5">
		<div class="form_outer">
			<table class="table-striped table-bordered table-condensed table-hover">
				<tbody>
					<tr>
						<td>Position:</td>
						<td><?php echo h($staticpage['Staticpage']['position']); ?></td>
					</tr>
					<tr>
						<td>Title:</td>
						<td><?php echo h($staticpage['Staticpage']['title']); ?></td>
					</tr>
					<tr>
						<td>Image:</td>
						<td>
							<?php echo $this->Html->image('../files/staticpage/'.$staticpage['Staticpage']['image'],
							array('alt'=>'Staticpage Image','style'=>'height:150px;')); ?>
						</td>
					</tr>
					<tr>
						<td>Created:</td>
						<td><?php echo h($staticpage['Staticpage']['created']); ?></td>
					</tr>
					<tr>
						<td>Status:</td>
						<td><?php  if($staticpage['Staticpage']['status']==1) { echo 'Active';}else{echo "Deactive";} ?></td>
					</tr>
					<tr>
						<td>Description:</td>
						<td><?php echo htmlspecialchars($staticpage['Staticpage']['description']); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
