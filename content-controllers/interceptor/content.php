<?php
/***************************************************************************
 *	Define any page-specific variables used in the theme
 ***************************************************************************/
//$description_text = $this->GetDescriptionText( $custom );
$theme_custom = $this->GetThemeCustom();
$static_iframe_url = $this->GetFrameUrl();
$static_iframe_no_thanks_url = $this->GetNoThanksUrl();

//$product_link = $this->CreateProductLink( $post->ID );//$custom['product_url'][0];

$real_theme = $this->GetRealTheme();
$this->FixPost();


/***************************************************************************
 *	Fetch the user-designed themed version of the content
 ***************************************************************************/
$themed_content = $this->LoadThemedContent( 'index.php', false, '', $real_theme );


/***************************************************************************
 *	Evaluate the code in this namespace to have access to variables defined above
 ***************************************************************************/
ob_start();
eval( '?>'.$themed_content.'<?php ?>' );
$new_content = ob_get_contents();
ob_end_clean();


/***************************************************************************
 *	Piece together the new content to show in the_content() function
 ***************************************************************************/
//$content .= $notifications;
$content .= $new_content;
?>