<?php
$data = $this->GetDataType()->Get();
//$this->ItemDebug( $data );
?>
<div id="poststuff" class="metabox-holder">
	<div id="post-body">
		<div id="post-body-content">
			
			<div class="row-fluid">
				<div class="span12">
					<?php
					if( !$data )
					{ ?>
					<p style="color:#cc0000;">No interceptors found</p>
					<?php
					}
					else
					{ ?>
					
					<ul class="subsubsub">
						<li><?php echo count( $data ); ?> interceptors</li>
					</ul>
					
					<form action="<?php echo $this->GetAsset( 'forms', 'delete', 'url' ); ?>" onsubmit="if (!confirm('Are you sure you wish to execute this action on the selected items?')) { return false; }" method="post">
						<div class="tablenav">
							<div class="alignleft actions">
								<select name="action" class="widefat" style="width:auto;">
									<option value="">- Bulk Actions -</option>
									<option value="delete">Delete</option>
								</select>
								<input type="submit" name="execute" value="Apply" class="button-secondary" />
							</div>
						</div>
						<table class="widefat">
							<thead>
								<tr>
									<th class="check-column"><input type="checkbox" name="" value="" id="checkboxall" /></th>
									<th>ID</th>
									<th>Name</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th class="check-column"><input type="checkbox" name="" value="" id="checkboxall" /></th>
									<th>ID</th>
									<th>Name</th>
								</tr>
							</tfoot>
							<tbody>
							<?php
							$iter = 0;
							foreach( $data as $key => $value )
							{
								$custom = $this->get_datatype_custom( $value->ID, 'rule' );
								
								$page_triggers = $custom['page_triggers'];
								$category_triggers = $custom['category_triggers'];
								
								$pages = $this->FormatPageTriggers( $page_triggers );
								$categories = $this->FormatCategoryTriggers( $category_triggers );
								//ItemDebug( $custom );
								//echo '<a href="'.$this->GetAsset( 'forms', 'reset', 'url ').'?item_id='.$post_id.'">reset</a>';
								?>
								<tr id="historyrow12" class="<?php echo $iter % 2 == 1 ? 'alternate' : ''; ?>">
									<th class="check-column">
										<input id="checklist12" type="checkbox" name="post_ids[]" value="<?php echo $value->ID; ?>" />
									</th>
									<td>
										<?php echo $value->ID; ?>
									</td>
									<td>
										<strong>
											<a class="row-title" href="<?php echo $this->AdminUrl( array( 'content' => 'add', 'id' => $value->ID ) ); ?>" title="View this item">
												<?php echo $this->Helper('tools')->Clean( $value->post_title ); ?>
											</a>
										</strong>
										<div class="row-actions"> 
											<span class="edit"> 
												<a class="" href="<?php echo $this->AdminUrl( array( 'content' => 'add', 'id' => $value->ID ) ); ?>" onclick="" title="Edit" target="_self">
													Edit
												</a> 
												|
											</span> 
											<span class="delete"> 
												<a class="submitdelete" href="<?php echo $this->GetAsset( 'forms', 'delete', 'url' ); ?>?post_ids[]=<?php echo $value->ID; ?>" onclick="if (!confirm('Are you sure you want to delete this item and all it\'s data?')) { return false; }" title="Delete" target="_self">
													Delete
												</a> 
												|
											</span>
											<!--<span class="edit"> 
												<a class="" href="<?php echo $this->AdminUrl( array( 'content' => 'add', 'id' => $value->ID ) ); ?>" onclick="" title="Edit" target="_self">
													View
												</a> 
												|
											</span>--> 
											<span class="edit"> 
												<a class="" href="<?php echo $this->DataType( 'interceptor' )->GetRemoteLink( $value->ID ); ?>" onclick="" title="Live View" target="_blank">
													Live View
												</a> 
											</span> 
										</div>
									</td>
								</tr>
							<?php
							} ?>
								
								
							</tbody>
						</table>
						
					</form>
					<?php
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>

