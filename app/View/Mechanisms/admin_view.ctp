<style>
	.form_outer table{
		width:100%;
		margin:0px;
	}
</style>
<div class="page_heading">
	<h2>Mechanism</h2>
</div>
<div class="row">
	<div class="col-sm-5">
		<div class="form_outer">
			<table class="table-striped table-bordered table-condensed table-hover">
				<tr>
					<td>Id</td>
					<td><?php echo h($Mechanism['Mechanism']['id']); ?></td>
				</tr>
				<tr>
					<td>Name</td>
					<td><?php echo h($Mechanism['Mechanism']['name']); ?></td>
				</tr>
				<tr>
					<td>Created</td>
					<td><?php echo h($Mechanism['Mechanism']['created']); ?></td>
				</tr>
				<tr>
					<td>Modified</td>
					<td><?php echo h($Mechanism['Mechanism']['modified']); ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>