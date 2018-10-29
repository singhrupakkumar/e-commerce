<style>
	table{
		width:100%;
		margin:0px;
	}
</style>
<div class="times view">
	<div class="page_heading">
		<h2><?php echo __('Review'); ?></h2>
	</div>
	<div class="row">
		<div class="col-sm-5">
			<div class="form_outer">
				<table class="table-striped table-bordered table-condensed table-hover">
					<tbody>
						<tr>
							<td><?php echo __('Id'); ?></td>
							<td><?php echo h($time['Review']['id']); ?></td>
						</tr>
						<tr>
							<td><?php echo __('Product'); ?></td>
							<td><?php echo $time['Product']['name']; ?></td>
						</tr>
						<tr>
							<td><?php echo __('Name'); ?></td>
							<td><?php echo h($time['Review']['name']); ?></td>
						</tr>
						<tr>
							<td><?php echo __('Email'); ?></td>
							<td><?php echo h($time['Review']['email']); ?></td>
						</tr>
						<tr>
							<td><?php echo __('Product Review'); ?></td>
							<td><?php echo h($time['Review']['text']); ?></td>
						</tr>
						<tr>
							<td><?php echo __('Product Rating'); ?></td>
							<td><?php echo h($time['Review']['punctuality']); ?></td>
						</tr>
						<tr>
							<td><?php echo __('created'); ?></td>
							<td><?php echo h($time['Review']['created']); ?></td>
						</tr>
						<tr>
							<td><?php echo __('modified'); ?></td>
							<td><?php echo h($time['Review']['modified']); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

