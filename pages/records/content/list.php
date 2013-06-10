<?php
global $iter_min, $iter_max;

$fields = array();
$fields['page'] = $this->GetCurrentPage();
$fields['per_page'] = $this->GetPerPage();

$total_count = $this->GetDataType()->PostCount();
$data = $this->GetDataType()->GetPosts( $fields );
?>

<div id="poststuff" class="metabox-holder">
	<div id="post-body">
		<div id="post-body-content">
			
			<div class="row-fluid">
				<div class="span12">
					<?php
					if( !$data )
					{ ?>
					<p style="color:#cc0000;">No <?php echo strtolower( $this->m_page_title ); ?> found</p>
					<?php
					}
					else
					{ ?>
					
					<form action="<?php echo $this->GetAsset( 'forms', 'delete', 'url' ); ?>" onsubmit="if (!confirm('Are you sure you wish to execute this action on the selected items?')) { return false; }" method="post">
						<div class="tablenav">
							<div class="alignleft actions">
								<a href="<?php echo $this->GetAsset( 'forms', 'clear', 'url' ); ?>" title="Clear the records" onclick="if (!confirm('Are you sure you wish to purge the records?')) { return false; }" class="button">Clear Records</a>
								<select name="action" class="widefat" style="width:auto;">
									<option value="">- Bulk Actions -</option>
									<option value="delete">Delete</option>
								</select>
								<input type="submit" name="execute" value="Apply" class="button-secondary" />
							</div>
							
							<?php $this->PrintPaging( $total_count ); ?>
							
							<div style="clear:both;"></div>
							
						</div>
						<table class="widefat">
							<thead>
								<tr>
									<th class="check-column"><input type="checkbox" name="" value="" id="checkboxall" /></th>
									<th>ID</th>
									<th>IP</th>
									<th>Redirected From</th>
									<th>To</th>
									<th>Date</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th class="check-column"><input type="checkbox" name="" value="" id="checkboxall" /></th>
									<th>ID</th>
									<th>IP</th>
									<th>Redirected From</th>
									<th>To</th>
									<th>Date</th>
								</tr>
							</tfoot>
							<tbody>
							<?php
							$max_url_length = 40;
							
							$iter = 0;
							foreach( $data as $key => $value )
							{
								$custom = $this->get_datatype_custom( $value->ID, 'record' );
								//$this->ItemDebug( $custom );
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
										<?php echo $custom['ip_address']; ?>
									</td>
									<td>
										<a target="_blank" href="<?php echo $custom['from_url']; ?>">
											<?php echo strlen( $custom['from_url'] ) > $max_url_length ? substr( $custom['from_url'], 0, $max_url_length ).'...' : $custom['from_url']; ?>
										</a>
									</td>
									<td>
										<a target="_blank" href="<?php echo $custom['to_url']; ?>">
											<?php echo strlen( $custom['to_url'] ) > $max_url_length ? substr( $custom['to_url'], 0, $max_url_length ).'...' : $custom['to_url']; ?>
										</a>
									</td>
									<td>
										<span title="<?php echo date( 'D, d M Y g:ia', $value->post_date ); ?>" style="cursor:pointer;">
											<?php echo $this->Helper('tools')->NumberTimeToStringTime( time() - $value->post_date ); ?> ago
										</span>
									</td>
								</tr>
							<?php
							} ?>
								
								
							</tbody>
						</table>
						
						<div class="tablenav">
							
							<?php $this->PrintPerPage(); ?>
							
							<?php $this->PrintPaging( $total_count ); ?>
						</div>
						
					</form>
					<?php
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>

