<?php
wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false );
wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false );

// Select which pagehook to use to select which metaboxes to show
$pagehook = $this->m_pages['home']['pagehook'];

global $wpdb;

$timeNow = time();

$records = $this->DataType( 'record' )->GetPosts();

if( $records )
{
	$day = 60 * 60 * 24;
	$today = strtotime( 'today' );
	$yesterday = strtotime( 'yesterday' );	
	
	foreach( $records as $key => $value )
	{
		$custom = $this->DataType( 'record' )->get_datatype_custom( $value->ID );
		
		$date = $value->post_date;
		$post_id = $custom['post_id'];
		$ip_address = $custom['ip_address'];
		$to_url = $custom['to_url'];
		$from_url = $custom['from_url'];
		
		$new_record['data'] = $value;
		$new_record['date'] = $date;
		$new_record['ip'] = $ip_address;
		$new_record['to_url'] = $to_url;
		$new_record['from_url'] = $from_url;
		$new_record['post_id'] = $post_id;
		
		$records_by_latest[] = $new_record;
		
		$records_by_pages[ $post_id ]['all_time']++;
		$records_by_ref[ $from_url ]['all_time']++;
		$records_by_url[ $to_url ]['all_time']++;
		$records_by_ip[ $ip_address ]['all_time']++;
		
		// Today
		if( $date > $today && $date < $today+$day )
		{
			$records_by_pages[ $post_id ]['today']++;
			$records_by_ref[ $from_url ]['today']++;
			$records_by_url[ $to_url ]['today']++;
			$records_by_ip[ $ip_address ]['today']++;
		}
		
		// Yesterday
		if( $date > $yesterday && $date < $yesterday+$day )
		{
			$records_by_pages[ $post_id ]['yesterday']++;
			$records_by_ref[ $from_url ]['yesterday']++;
			$records_by_url[ $to_url ]['yesterday']++;
			$records_by_ip[ $ip_address ]['yesterday']++;
		}
	}
}
?>

<style>
.stat_table {
	table-layout:auto !important;
}
.stat_table td {
	width:auto;
}
.stat_table tr {
	height:auto;
}
td.link_small {
	font-size:10px;
}
</style>
<div class="wrap">
	
	<h2>Qody's Redirector</h2>
	
	<?php $this->Helper('postman')->DisplayMessages(); ?>
	
	<form action="<?php echo $this->m_plugin_url; ?>" method="post" id="">
		<?php //wp_nonce_field($this -> sections -> settings); ?>
	
		<div id="poststuff" class="metabox-holder has-right-sidebar">			
			<div id="side-info-column" class="inner-sidebar">
				
				<img style="width:180px;" class="owl_sidebar" src="<?php echo $this->GetRandomOwlImage( 5 ); ?>" />
				<?php $this->do_meta_boxes( 'side' ); ?>
			</div>
			<div id="post-body" class="has-sidebar">
				<div id="post-body-content" class="has-sidebar-content">
                	<div id="normal-sortables" class="meta-box-sortables ui-sortable">
						
						<h2>Recent Activity</h2>
						
						<table class="widefat stat_table">
							<thead>
								<tr>
									<th>Landing Page</th>
									<th>Redirected to URL</th>
									<th style="text-align:center;">Visitor IP</th>
									<th style="text-align:center;">Date Redirected</th>	
								</tr>
							</thead>
							<tbody>
							<?php
							if( $records_by_latest )
							{
								$iter = 0;
								
								foreach( $records_by_latest as $key => $value )
								{
									$iter++;
									
									if( $iter > 20 )
										break;
									
									if( $value['post_id'] == -1 )
										$title = 'Home';
									else
										$title = get_the_title( $value['post_id'] );
									
									if( strlen( $title ) > 50 )
										$title = substr( $title, 0, 50 ).'...';
									
									$url = $value['to_url'];
									
									if( strlen( $url ) > 30 )
										$url = substr( $url, 0, 30 ).'...';
									
									if( $iter % 2 == 1 )
										$class = 'alternate';
									else
										$class = '';
									?>
								<tr class="<?php echo $class; ?>">
									<td>
										<a href="<?php echo get_permalink($value['post_id']); ?>" target="_blank">
											<?php echo $title; ?>
										</a>
									</td>
									<td class="link_small">
										<a href="<?php echo $value['redirect_url']; ?>" target="_blank" >
											<?php echo $url; ?>
										</a>
									</td>
									<td style="text-align:center;">
										<a href="http://whois.domaintools.com/<?php echo  $value['ip']; ?>" target="_blank">
											<?php echo $value['ip']; ?>
										</a>
									</td>
									<td style="text-align:center;">
										<?php echo $this->Helper('tools')->NumberTimeToStringTime( $timeNow - $value['date'] ); ?> ago
									</td>
								</tr>
								<?php
								}
							}
							else
							{ ?>
								<tr class="alternate">
									<th colspan="4">no recent activity</th>
								</tr>
							<?php
							} ?>
							</tbody>
							<tfoot>
								<tr>
									<th>Landing Page</th>
									<th>Redirected to URL</th>
									<th style="text-align:center;">Visitor IP</th>
									<th style="text-align:center;">Date Redirected</th>	
								</tr>
							</tfoot>
						</table>
						
						<h2>Top 10 Most "Redirected-to" URLs</h2>
						
						<table class="widefat">
							<thead>
								<tr>
									<th>URL Sent To</th>
									<th style="text-align:center;width:75px;">Today</th>
									<th style="text-align:center;width:75px;">Yesterday</th>
									<th style="text-align:center;width:75px;">Total</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							if( $records_by_url )
							{
								$iter = 0;
								
								foreach( $records_by_url as $key => $value ) 
								{
									$iter++;
									
									if( $iter > 10 )
										break;
									
									$today = 0;
									$yesterday = 0;
									$all_time = 0;
										
									if( $iter % 2 == 1 )
										$class = 'alternate';
									else
										$class = '';
									
									$url = $key;
									
									if( strlen( $url ) > 60 )
										$url = substr( $url, 0, 60 ).'...';
									
									if( isset( $value['today'] ) )
										$today = $value['today'];
									if( isset( $value['yesterday'] ) )
										$yesterday = $value['yesterday'];
									if( isset( $value['all_time'] ) )
										$all_time = $value['all_time'];
									?>
								<tr class="<?php echo $class; ?>">
									<td>
										<a href="<?php echo $key; ?>" target="_blank" >
											<?php echo $url; ?>
										</a>
									</td>
									<td style="text-align:center; color:#090; font-weight:bold;">
										<?php echo $today; ?>
									</td>
									<td style="text-align:center; color:#c00;">
										<?php echo $yesterday; ?>
									</td>
									<td style="text-align:center; font-weight:bold;">
										<?php echo $all_time; ?>
									</td>
								</tr>
								<?php 
								}
							}
							else
							{ ?>
								<tr class="alternate">
									<th colspan="4">no recent activity</th>
								</tr>
							<?php
							} ?>
							</tbody>
							<tfoot>
								<tr>
									<th>URL Sent To</th>
									<th style="text-align:center;">Today</th>
									<th style="text-align:center;">Yesterday</th>
									<th style="text-align:center;">Total</th>
								</tr>
							</tfoot>
						</table>
						
						<h2>Top 10 Most Redirected Pages/Posts</h2>
						
						<table class="widefat">
							<thead>
								<tr>
									<th>Post/Page</th>
									<th style="text-align:center;width:75px;">Today</th>
									<th style="text-align:center;width:75px;">Yesterday</th>
									<th style="text-align:center;width:75px;">Total</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if( $records_by_pages )
							{
								$iter = 0;
								foreach( $records_by_pages as $key => $value )
								{
									$iter++;
									
									if( $iter > 10 )
										break;
									
									$today = 0;
									$yesterday = 0;
									$all_time = 0;
									
									if( $key == -1 )
										$title = 'Home';
									else
										$title = get_the_title( $key );
									
									if( strlen( $title ) > 60 )
										$title = substr( $title, 0, 60 ).'...';
										
									if( !$title )
										$title = '<span style="color:#cc0000;">deleted item</span>';
									
									if( $iter % 2 == 1 )
										$class = 'alternate';
									else
										$class = '';
									
									if( isset( $value['today'] ) )
										$today = $value['today'];
									if( isset( $value['yesterday'] ) )
										$yesterday = $value['yesterday'];
									if( isset( $value['all_time'] ) )
										$all_time = $value['all_time'];
									?>
								<tr class="<?php echo $class; ?>">
									<td>
										<a href="<?php echo get_permalink( $key ); ?>" target="_blank">
											<?php echo $title; ?>
										</a>
									</td>
									<td style="text-align:center;color:#090; font-weight:bold;">
										<?php echo $today; ?>
									</td>
									<td style="text-align:center;color:#c00;">
										<?php echo $yesterday; ?>
									</td>
									<td style="text-align:center; font-weight:bold;">
										<?php echo $all_time; ?>
									</td>
								</tr>
								<?php
								}
							}
							else
							{ ?>
								<tr class="alternate">
									<th colspan="4">no recent activity</th>
								</tr>
							<?php
							} ?>
							</tbody>
							<tfoot>
								<tr>
									<th>Post/Page</th>
									<th style="text-align:center;">Today</th>
									<th style="text-align:center;">Yesterday</th>
									<th style="text-align:center;">Total</th>
								</tr>
							</tfoot>
						</table>
						
						<h2>Top 10 IP Address being redirected</h2>
						
						<table class="widefat">
							<thead>
								<tr>
									<th>Visitor IP</th>
									<th style="text-align:center;width:75px;">Today</th>
									<th style="text-align:center;width:75px;">Yesterday</th>
									<th style="text-align:center;width:75px;">Total</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							if( $records_by_ip )
							{
								$iter = 0;
								
								foreach( $records_by_ip as $key => $value ) 
								{
									$iter++;
									
									if( $iter > 10 )
										break;
									
									$today = 0;
									$yesterday = 0;
									$all_time = 0;
										
									if( $iter % 2 == 1 )
										$class = 'alternate';
									else
										$class = '';
									
									if( isset( $value['today'] ) )
										$today = $value['today'];
									if( isset( $value['yesterday'] ) )
										$yesterday = $value['yesterday'];
									if( isset( $value['all_time'] ) )
										$all_time = $value['all_time'];
									?>
								<tr class="<?php echo $class; ?>">
									<td>
										<a href="http://whois.domaintools.com/<?php echo $key; ?>" target="_blank" >
											<?php echo $key; ?>
										</a>
									</td>
									<td style="text-align:center; color:#090; font-weight:bold;">
										<?php echo $today; ?>
									</td>
									<td style="text-align:center; color:#c00;">
										<?php echo $yesterday; ?>
									</td>
									<td style="text-align:center; font-weight:bold;">
										<?php echo $all_time; ?>
									</td>
								</tr>
								<?php 
								}
							}
							else
							{ ?>
								<tr class="alternate">
									<th colspan="4">no recent activity</th>
								</tr>
							<?php
							} ?>
							</tbody>
							<tfoot>
								<tr>
									<th>Visitor IP</th>
									<th style="text-align:center;">Today</th>
									<th style="text-align:center;">Yesterday</th>
									<th style="text-align:center;">Total</th>
								</tr>
							</tfoot>
						</table>
						
						<?php do_meta_boxes( $pagehook, 'normal', $this ); ?>
                        <?php do_meta_boxes( $pagehook, 'advanced', $this ); ?>
                    </div>
				</div>
			</div>
		</div>
	</form>
</div>
	
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready( function($) {
	// close postboxes that should be closed
	$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
	// postboxes setup
	postboxes.add_postbox_toggles('<?php echo $pagehook; ?>');
});
//]]>
</script>