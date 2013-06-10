<?php
$data = $this->GetDataType()->Get();
?>
<div id="poststuff" class="metabox-holder">
	<div id="post-body">
		<div id="post-body-content">
			
			<div class="row-fluid">
				<div class="span12">
					<?php
					if( !$data )
					{ ?>
					<p style="color:#cc0000;">No link rotations found</p>
					<?php
					}
					else
					{ ?>
					
					<ul class="subsubsub">
						<li><?php echo count( $data ); ?> link rotations</li>
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
									<th>Rotation Type</th>
									<th>Links</th>
									<th>Shareable Url</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th class="check-column"><input type="checkbox" name="" value="" id="checkboxall" /></th>
									<th>ID</th>
									<th>Name</th>
									<th>Rotation Type</th>
									<th>Links</th>
									<th>Shareable Url</th>
								</tr>
							</tfoot>
							<tbody>
							<?php
							$iter = 0;
							foreach( $data as $key => $value )
							{
								$custom = $this->get_datatype_custom( $value->ID, 'link-rotation' );
								
								$links = $this->DataType( 'link-rotation' )->FetchLinks( $value->ID );
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
											</span>
										</div>
									</td>
									<td>
										<?php echo $this->GetRotationTypeIcon( $custom['rotation_type'] ); ?>
										<?php echo ucwords( str_replace( '_', ' ', $custom['rotation_type'] ) ); ?>
									</td>
									<td>
										<strong>links:</strong>
										<ol class="trigger_list">
										<?php
										foreach( $links as $key2 => $value2 )
										{
											$marker = '';
											
											$icon = $this->GetRotationTypeIcon( $custom['rotation_type'] );
											
											if( $custom['rotation_type'] == 'least_hit' )
												$marker = '('.($value2['hits'] ? $value2['hits'] : 0).' '.$icon.')';
											else if( $custom['rotation_type'] == 'weighted' )
												$marker = '('.($value2['weight'] ? $value2['weight'] : 0).' '.$icon.')';
												
											echo '<li>'.$marker.' <a target="_blank" href="'.$value2['url'].'">'.$value2['url'].'</a></li>';
										} ?>
										</ol>
									</td>
									<td>
										<input type="text" readonly style="width:100px;" onclick="this.select()" value="<?php echo $this->DataType( 'link-rotation' )->GetRotationLink( $value->ID ); ?>" />
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

