<style>
	table{
		width:100%;
		margin:0px;
	}
</style>
<div class="page_heading">
	<h2>User</h2>
</div>
<div class="row">
	<div class="col-sm-5">
		<div class="form_outer">
			<table class="table-striped table-bordered table-condensed table-hover">
				<tr>
					<td>Id</td>
					<td><?php echo h($user['User']['id']); ?></td>
				</tr>
				<tr>
					<td>Role</td>
					<td><?php echo h($user['User']['role']); ?></td>
				</tr>
				<tr>
					<td>Username</td>
					<td><?php echo h($user['User']['username']); ?></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><?php echo h($user['User']['password']); ?></td>
				</tr>
				<tr>
					<td>Active</td>
					<td><?php echo h($user['User']['active']); ?></td>
				</tr>
				<tr>
					<td>Created</td>
					<td><?php echo h($user['User']['created']); ?></td>
				</tr>
				<tr>
					<td>Modified</td>
					<td><?php echo h($user['User']['modified']); ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>