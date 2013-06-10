
<table class="form-table">
	<tbody>
		<tr>
			<td>
				<p>Often times it's the theme missing some important code in the header.php or footer.php that causes plugins to not work.</p>

				<p>For Alejandro, it would be in the <a href="<?php echo admin_url('theme-editor.php'); ?>">footer.php</a>.  Please ensure this code is in there, and if not, add it:</p>
				
				<textarea style="width:100%; height:65px;" onclick="this.select();" readonly="readonly"><?php echo "<div style=\"display:none;\">\n<?php wp_footer(); ?>\n</div>"; ?></textarea>
				
				<p>That should fix any "not working at all" oddities!  If you are still experiencing problems after doing that, 
				<a target="_blank" href="http://support.qody.co">contact support</a>.</p>
			</td>
		</tr>
	</tbody>
</table>