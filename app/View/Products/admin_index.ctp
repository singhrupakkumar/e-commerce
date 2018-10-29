<style>
	.form_outer{
		margin-bottom:20px;
	}
	.form_outer table{
		width:100%;
		margin:0px;
	}
	.form_outer table .actions{
		width:26% !important;
	}
</style>

<?php echo $this->Html->css(array('bootstrap-editable.css', '/select2/select2.css'), 'stylesheet', array('inline' => false)); ?>
<?php echo $this->Html->script(array('bootstrap-editable.js', '/select2/select2.js'), array('inline' => false)); ?>

<script>

$(document).ready(function() {

    $('.category').editable({
        type: 'select',
        name: 'category_id',
        url: '<?php echo $this->webroot; ?>admin/products/editable',
        title: 'Category',
        source: <?php echo json_encode($categorieseditable); ?>,
        placement: 'right',
    });

    $('.brand').editable({
        type: 'select',
        name: 'brand_id',
        url: '<?php echo $this->webroot; ?>admin/products/editable',
        title: 'Brand',
        source: <?php echo json_encode($brandseditable); ?>,
        placement: 'right',
    });

    $('.name').editable({
        type: 'text',
        name: 'name',
        url: '<?php echo $this->webroot; ?>admin/products/editable',
        title: 'Name',
        placement: 'right',
    });

    $('.description').editable({
        type: 'textarea',
        name: 'description',
        url: '<?php echo $this->webroot; ?>admin/products/editable',
        title: 'Description',
        placement: 'right',
    });
    
     $('.feature').editable({
        type: 'textarea',
        name: 'feature',
        url: '<?php echo $this->webroot; ?>admin/products/editable',
        title: 'Feature',
        placement: 'right',
    });

    $('.price').editable({
        type: 'text',
        name: 'price',
        url: '<?php echo $this->webroot; ?>admin/products/editable',
        title: 'Price',
        placement: 'left',
    });

    $('.weight').editable({
        type: 'text',
        name: 'weight',
        url: '<?php echo $this->webroot; ?>admin/products/editable',
        title: 'Weight',
        placement: 'left',
    });

    $('.tags').editable({
        type: 'select2',
        name: 'tags',
        url: '<?php echo $this->webroot; ?>admin/products/tagschanger',
        title: 'Tags',
        placement: 'left',
        source: [
            <?php foreach ($tags as $tag): ?>
            {id: '<?php echo $tag["Tag"]["name"]; ?>', text: '<?php echo $tag["Tag"]["name"]; ?>'},
            <?php endforeach; ?>
        ],
        select2: {
            multiple: true,
            allowClear: true,
            width: 300
        }
    });

});
</script>
<div class="page_heading">
	<h2>Products</h2>
</div>

<div class="row">
	<div class="top-form">

    <?php echo $this->Form->create('Product', array()); ?>
    <?php echo $this->Form->hidden('search', array('value' => 1)); ?>

    <div class="col-sm-2">
        <?php echo $this->Form->input('active', array('label' => false, 'class' => 'form-control', 'empty' => 'Status', 'options' => array(1 => 'Active', 0 => 'Not Active'), 'selected' => $all['active'])); ?>
    </div>

    <div class="col-sm-2">
        <?php echo $this->Form->input('filter', array(
            'label' => false,
            'class' => 'form-control',
            'options' => array(
				'filter' => 'Filter By',
                'name' => 'Name',
                'description' => 'Description',
                'price' => 'Price',
                'created' => 'Created',
            ),
            'selected' => $all['filter']
        )); ?>

    </div>

    <div class="col-sm-2">
        <?php echo $this->Form->input('name', array('label' => false, 'id' => false, 'class' => 'form-control', 'placeholder' => 'Enter Filter Value', 'value' => $all['name'])); ?>

    </div>

    <div class="col-sm-4">
        <?php echo $this->Form->button('Search', array('class' => 'btn btn-default')); ?>
        &nbsp; &nbsp;
        <?php echo $this->Html->link('Reset Search', array('controller' => 'products', 'action' => 'reset', 'admin' => true), array('class' => 'btn btn-danger')); ?>

    </div>

    <?php echo $this->Form->end(); ?>
</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="form_outer">
			<div class="up-img_sec">
				<?php echo $this->Html->link('Add New Product', array('action' => 'add'), array('class' => 'btn btn-default')); ?>
			</div>
			<table class="table-striped table-bordered table-condensed table-hover">
				<tr>
					<th><?php echo $this->Paginator->sort('image'); ?></th>
					<th><?php echo $this->Paginator->sort('category_id'); ?></th>
					<!--th><?php //echo $this->Paginator->sort('brand_id'); ?></th -->
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<!--th><?php //echo $this->Paginator->sort('slug'); ?></th -->
					<th><?php echo $this->Paginator->sort('description'); ?></th>
					 <th><?php echo $this->Paginator->sort('feature'); ?></th>
					<!--th><?php //echo $this->Paginator->sort('image'); ?></th -->
					<th><?php echo $this->Paginator->sort('price'); ?></th>
					<!--th><?php //echo $this->Paginator->sort('weight'); ?></th-->
					<th><?php echo $this->Paginator->sort('tags'); ?></th>
					<!--th><?php //echo $this->Paginator->sort('views'); ?></th-->
					<th><?php echo $this->Paginator->sort('active'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th><?php echo $this->Paginator->sort('modified'); ?></th>
					<th class="actions">Actions</th>
				</tr>
				<?php foreach ($products as $product): ?>
				<tr>
					<td><?php echo $this->Html->Image('/images/large/' . $product['Product']['image'], array('width' => 100, 'height' => 100, 'alt' => $product['Product']['image'], 'class' => 'image')); ?></td>
					<td><span class="category" data-value="<?php echo $product['Category']['id']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Category']['name']; ?></span></td>
					<!--td><span class="brand" data-value="<?php //echo $product['Brand']['id']; ?>" data-pk="<?php //echo $product['Product']['id']; ?>"><?php //echo $product['Brand']['name']; ?></span></td-->
					<td><span class="name" data-value="<?php echo $product['Product']['name']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['name']; ?></span></td>
					<!--td><?php //echo h($product['Product']['slug']); ?></td-->
					<td><span class="description" data-value="<?php echo $product['Product']['description']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['description']; ?></span></td>
					<td><span class="feature" data-value="<?php echo $product['Product']['feature']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['feature']; ?></span></td>
					<!--td><?php //echo h($product['Product']['image']); ?></td-->
					<td><span class="price" data-value="<?php echo $product['Product']['price']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['price']; ?></span></td>
					<!--td><span class="weight" data-value="<?php //echo $product['Product']['weight']; ?>" data-pk="<?php //echo $product['Product']['id']; ?>"><?php //echo $product['Product']['weight']; ?></span></td-->
					<td><span class="tags" data-value="<?php echo $product['Product']['tags']; ?>" data-pk="<?php echo $product['Product']['id']; ?>"><?php echo $product['Product']['tags']; ?></span></td>
					<!--td><?php //echo h($product['Product']['views']); ?></td-->
					<td><?php echo $this->Html->link($this->Html->image('icon_' . $product['Product']['active'] . '.png'), array('controller' => 'products', 'action' => 'switch', 'active', $product['Product']['id']), array('class' => 'status', 'escape' => false)); ?></td>
					<td><?php echo h($product['Product']['created']); ?></td>
					<td><?php echo h($product['Product']['modified']); ?></td>
					<td class="actions">
						<?php echo $this->Html->link('View', array('action' => 'view', $product['Product']['id']), array('class' => 'btn btn-default btn-xs btn-view')); ?>
						<?php // echo $this->Html->link('Tags', array('action' => 'tags', $product['Product']['id']), array('class' => 'btn btn-default btn-xs btn-tags')); ?>
						<?php echo $this->Html->link('Edit', array('action' => 'edit', $product['Product']['id']), array('class' => 'btn btn-default btn-xs btn-edit')); ?>
						<a href="<?php echo $this->webroot;?>admin/products/uploadproductimage?pro_id=<?php echo $product['Product']['id'];?>" class="btn btn-default btn-xs btn-gallery">Gallery</a>
						<?php echo $this->Form->postLink('Delete Product', array('action' => 'delete', $product['Product']['id']), array('class' => 'btn btn-default btn-xs btn-delet'), __('Are you sure you want to delete # %s?', $product['Product']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</div>
</div>
<?php echo $this->element('pagination-counter'); ?>

<?php echo $this->element('pagination'); ?>