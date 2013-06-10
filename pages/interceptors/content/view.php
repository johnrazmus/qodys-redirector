<?php
//$history_data = $this->GetHistory( $post->ID );

//ItemDebug( $data );
?>
<div style="float:none;" class="subsubsub"> 
	<a class="" href="<?php echo $this->AdminUrl(); ?>" onclick="" title="&larr; All Remote Redirects" target="_self">
		&larr; All Remote Redirects
	</a> 
</div>

<div class="tablenav">
	
	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="<?php echo $this->AdminUrl( array( 'content' => 'add', 'id' => $post->ID ) ); ?>" title="Edit this item" class="btn">
				Edit/Change
			</a> 
			<a href="<?php echo $this->GetAsset( 'forms', 'delete', 'url' ); ?>?post_ids[]=<?php echo $post->ID; ?>" title="Delete this item permanently" class="btn" onclick="if (!confirm('Are you sure you wish to delete this item?')) { return false; }">
				Delete
			</a> 
		</div>
		<?php
		if( $custom['account_type'] == 'pinterest' )
		{ ?>
		<div class="btn-group">
			<a href="<?php echo $this->GetAsset( 'forms', 'board_check', 'url' ); ?>?post_id=<?php echo $post->ID; ?>" title="Force a re-check of this Account's pin boards" class="btn">
				Re-check / Update Boards
			</a>
		</div>
		<?php
		} ?>
	</div>
	
</div>
<table class="widefat">
	<thead>
		<tr>
			<th>Field</th>
			<th>Value</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Field</th>
			<th>Value</th>
		</tr>
	</tfoot>
	<tbody>
		<tr class="alternate">
			<th>Url Slug</th>
			<td>
				/<?php echo $custom['url_slug']; ?> 
			</td>
		</tr>
		<tr class="">
			<th>Remote Url</th>
			<td><?php echo $custom['remote_url']; ?></td>
		</tr>
		<tr class="alternate">
			<th>Destination Url</th>
			<td><?php echo $custom['destination_url']; ?></td>
		</tr>
		<tr class="">
			<th>"Leaving" Action Type</th>
			<td><?php echo $custom['action_type']; ?></td>
		</tr>
		<tr class="alternate">
			<th>Shareable Url</th>
			<td><input type="text" value="<?php echo $this->DataType( 'external-redirect' )->GetRemoteLink( $post->ID ); ?>" readonly onClick="this.select();"></td>
		</tr>
	</tbody>
</table>

<?php
if( $custom['account_type'] == 'pinterest' )
{ ?>
<div class="page-header" style="padding-bottom:5px;">
	<h3>History <small>of pins to Pinterest.com</small></h3>
</div>

<div class="row-fluid">
	<div class="span12">
	
		<?php
		if( !$history_data )
		{ ?>
		<p style="color:#cc0000;">No history generated yet</p>
		<?php
		}
		else
		{ ?>
		
		<ul class="subsubsub">
			<li><?php echo count( $history_data ); ?> pin<?php echo count( $history_data ) > 1 ? 's' : ''; ?> posted</li>
		</ul>
		
		<div class="pull-right">
			<a href="<?php echo $this->GetAsset( 'forms', 'clear', 'url' ); ?>?post_id=<?php echo $post->ID; ?>" class="button" title="Clear the pin history" onclick="if (!confirm('Are you sure you wish to purge the pin history?')) { return false; }">
				Clear History
			</a>
		</div>
		
		<div style="clear:both;"></div>
		
		<table class="widefat">
			<thead>
				<tr>
					<th>ID</th>
					<th>Image</th>
					<th>Pinned</th>
					<th>Board</th>
					<th>Text</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>ID</th>
					<th>Image</th>
					<th>Pinned</th>
					<th>Board</th>
					<th>Text</th>
				</tr>
			</tfoot>
			<tbody>
		
			<?php
			$iter = 0;
			foreach( $history_data as $key => $value )
			{
				$iter++;
				
				$custom = $this->get_datatype_custom( $value->ID, 'pin-history' );
				?>
				<tr id="historyrow12" class="<?php echo $iter % 2 == 1 ? 'alternate' : ''; ?>">
					<td>
						<?php echo $value->ID; ?>
					</td>
					<td>
						<?php
						if( $custom['image_url'] )
						{ ?>
						<ul class="thumbnails" style="margin:0px;">
							<li class="span12" style="margin-bottom:4px;">
								<a href="#" class="thumbnail" title="">
									<img src="<?php echo $custom['image_url']; ?>" style="width:61px;">
								</a>
							</li>
						</ul>
						<?php
						}
						else
						{
							echo 'n/a';
						} ?>
					</td>
					<td>
						<span title="<?php echo date( 'D, d M Y g:ia', $value->post_date ); ?>" style="cursor:pointer;">
							<?php echo $this->Helper('tools')->NumberTimeToStringTime( time() - $value->post_date ); ?> ago
						</span>
						
						<?php
						if( $custom['pinterest_public_url'] )
						{ ?>
						at <a href="<?php echo $custom['pinterest_public_url']; ?>" target="_blank">
							<?php echo $custom['pinterest_public_url']; ?>
						</a>
						<?php
						}?>
						
					</td>
					<td>
						<?php 
						if( $custom['board_id'] )
						{
							echo $this->DataType( 'pin-board' )->get_the_title( $custom['board_id'] );
						}
						else
						{
							echo 'n/a';
						} ?>
					</td>
					<td style="width:40%;">
						<?php echo $this->Helper('tools')->Clean( $custom['pin_text'] ); ?>
					</td>
				</tr>
			<?php
			} ?>
				
				
			</tbody>
		</table>
		<?php
		} ?>
	
	</div>
</div>
<?php
} ?>

