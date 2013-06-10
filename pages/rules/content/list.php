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
					<p style="color:#cc0000;">No redirect rules found</p>
					<?php
					}
					else
					{ ?>
					
					<ul class="subsubsub">
						<li><?php echo count( $data ); ?> redirect rules</li>
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
									<th>Enabled</th>
									<th>Triggers</th>
									<th>Destination</th>
									<th>Action</th>
									<th>Repeats</th>
									<th>Priority</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th class="check-column"><input type="checkbox" name="" value="" id="checkboxall" /></th>
									<th>ID</th>
									<th>Name</th>
									<th>Enabled</th>
									<th>Triggers</th>
									<th>Destination</th>
									<th>Action</th>
									<th>Repeats</th>
									<th>Priority</th>
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
								$url_triggers = $custom['specific_url_triggers'];
								
								$pages = $this->FormatPageTriggers( $page_triggers );
								$categories = $this->FormatCategoryTriggers( $category_triggers );
								$custom_urls = $this->FormatUrlTriggers( $url_triggers );
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
											</span>
										</div>
									</td>
									<td>
										<?php
										if( $custom['enable_redirect'] == 'yes' )
										{ ?>
										<span style="color:#007700; font-weight:bold;">Yes</span>
										<?php 
										}
										else
										{ ?>
										<span style="color:#cc0000;">No</span>
										<?php
										} ?>
									</td>
									<td>
										<?php
										if( $pages || $categories || $custom_urls )
										{
											if( $pages )
											{
												echo '<strong>pages:</strong><ol class="trigger_list">';
												foreach( $pages as $key => $value )
												{
													echo '<li>'.$value.'</li>';
												}
												echo '</ol>';
											}											
											if( $categories )
											{
												echo '<strong>categories:</strong><ol class="trigger_list">';
												foreach( $categories as $key => $value )
												{
													echo '<li>'.$value.'</li>';
												}
												echo '</ol>';
											}
											if( $custom_urls )
											{
												echo '<strong>urls:</strong><ol class="trigger_list">';
												foreach( $custom_urls as $key => $value )
												{
													echo '<li>'.$value.'</li>';
												}
												echo '</ol>';
											}
										}
										else
										{
											echo '<small>none...</small>';
										} ?>
									</td>
									<td>
										<?php
										if( $custom['url_type'] == 'url' )
										{ ?>
										url - 
										<a target="_blank" href="<?php echo $custom['destination_url']; ?>">
											<?php echo $custom['destination_url']; ?>
										</a>
										<?php
										}
										else if( $custom['url_type'] == 'rotation' )
										{ ?>
										rotation - 
										<a href="#">
											<?php echo $this->DataType( 'link-rotation' )->get_the_title( $custom['link_rotation'] ); ?>
										</a>
										<?php
										}
										else if( $custom['url_type'] == 'clicked_url' )
										{ ?>
										clicked url
										<?php
										}
										else
										{ ?>
										<span style="color:#cc0000;">none...</span>
										<?php
										} ?>
									</td>
									<td>
										<?php echo ucwords( $custom['action_type'] ); ?>
									</td>
									<td>
										<?php
										if( $custom['redirect_again'] == 'yes' )
										{ ?>
										<span style="color:#007700; font-weight:bold;">Yes</span>
										<?php
										}
										else
										{ ?>
										<span style="color:#cc0000;">No</span>, waits 
										<?php 
											echo $this->Helper('tools')->NumberTimeToStringTime( $custom['redirect_wait_period'] );
										} ?>
									</td>
									<td>
										<i class="icon-star-empty"></i> <?php echo $custom['priority']; ?>
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

