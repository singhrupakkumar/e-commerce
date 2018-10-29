<style>
	table{
		width:100%;
		margin:0px;
	}
</style>
<div class="page_heading">
	<h2>Band</h2>
</div>
<di class="row">
	<div class="col-sm-5">
		<div class="form_outer">
			<table class="table-striped table-bordered table-condensed table-hover">
				<tr>
					<td>Id</td>
					<td><?php echo h($brand['Brand']['id']); ?></td>
				</tr>
				<tr>
					<td>Name</td>
					<td><?php echo h($brand['Brand']['name']); ?></td>
				</tr>
				<tr>
					<td>Slug</td>
					<td><?php echo h($brand['Brand']['slug']); ?></td>
				</tr>
				<tr>
					<td>Active</td>
					<td><?php echo h($brand['Brand']['active']); ?></td>
				</tr>
				<tr>
					<td>Created</td>
					<td><?php echo h($brand['Brand']['created']); ?></td>
				</tr>
				<tr>
					<td>Modified</td>
					<td><?php echo h($brand['Brand']['modified']); ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>