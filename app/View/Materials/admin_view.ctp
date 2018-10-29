<style>
	table{
		width:100%;
		margin:0px;
	}
	.form_outer{
		margin-bottom:20px;
	}
</style>
<div class="page_heading">
	<h2>Material</h2>
</div>
<div class="row">
	<div class="col-sm-5">
		<div class="form_outer">
			<table class="table-striped table-bordered table-condensed table-hover">
				<tr>
					<td>Id</td>
					<td><?php echo h($Material['Material']['id']); ?></td>
				</tr>
				<tr>
					<td>Name</td>
					<td><?php echo h($Material['Material']['name']); ?></td>
				</tr>
				<tr>
					<td>Created</td>
					<td><?php echo h($Material['Material']['created']); ?></td>
				</tr>
				<tr>
					<td>Modified</td>
					<td><?php echo h($Material['Material']['modified']); ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>