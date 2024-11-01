<?php 
/*
Plugin Name: Simple Post Meta
Plugin URI:  https://wordpress.org/plugins/simple-post-meta/
Description: Simple Post Meta is awsome plugin for show post id, post aurthor, post type, post slug, and all meta information related to post, page.
Version:     1.0
Author:      Saurabh Jain
Author URI:  https://github.com/Saurabh-developer/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

/*
 * This Is activation for plugin.
 */
register_activation_hook( __FILE__, 'spm_Activated' );

// Function for activation plugin.
function spm_Activated(){
	// Code Here..
}

/*
 * This is deactivation for plugin.
 */
register_deactivation_hook( __FILE__, 'spm_Deactivated' );

// Function For deactivated plugin.
function spm_Deactivated(){
    // Code Here..
}

/*
 * Define the Defination , class and functions..
 */

// Define the Plugin URL.
define('spm_plugin_url', plugins_url('/', __FILE__)  );

// Function For add styleseet Plugins
function spm_styles_sheet() 
{
  wp_enqueue_style('spm_styles_sheet', spm_plugin_url.'css/simple-post-meta.css');
  wp_enqueue_script('spm_styles_script', spm_plugin_url.'js/simple-post-meta.js');
}

// Add Admin Script Css
add_action('admin_enqueue_scripts', 'spm_styles_sheet');

// Define the class here..

class spm_Activated_class
{
	// All function here..
	function __construct( )
	{  
	   // Add Meta Box here..
	   add_action( 'add_meta_boxes', 'spm_meta_box' );

	   function spm_meta_box()
	    {
    	  add_meta_box('simple-post-meta', 'Meta Information', 'spm_add_call_back', get_post_type(), 'normal', 'low' );
    	}
       
       // Call Back Function here
       function spm_add_call_back(){ 
         global $post; 
       ?>
		<div id="<?php echo get_post_type();?>" class="spm_data">
		   <div class="inner_spm">
		   	   <table id="spm_post_data">
		   	   	   <thead>
		   	   	   	   <tr>
		   	   	   	      <td class="coloum-number">Sr.</td>
		   	   	   	   	  <td class="coloum-name">Meta Key</td>
		   	   	   	   	  <td class="coloum-value">Meta Value</td>
		   	   	   	   </tr>
		   	   	   </thead>
		   	   	   <tbody>
                       <tr class="display">
		   	   	          <td class="coloum-number">1</td>
		   	   	   	   	  <td class="coloum-name">Meta ID</td>
		   	   	   	   	  <td class="coloum-value"><code><?php echo get_the_ID(); ?></code></td>
		   	   	       </tr>
		   	   	       <tr class="display">
		   	   	       	  <td class="coloum-number">2</td>
		   	   	   	   	  <td class="coloum-name">Aurthor Name</td>
		   	   	   	   	  <td class="coloum-value"><code><?php echo get_author_name
		   	   	   	   	  ($post->post_author) ?></code></td>
		   	   	       </tr>
		   	   	       <tr class="display">
		   	   	          <td class="coloum-number">3</td>
		   	   	   	   	  <td class="coloum-name">Post Type</td>
		   	   	   	   	  <td class="coloum-value"><code><?php echo $post->post_type; ?></code></td>
		   	   	       </tr>
		   	   	       <tr class="display">
		   	   	          <td class="coloum-number">4</td>
		   	   	   	   	  <td class="coloum-name">Post Slug</td>
		   	   	   	   	  <td class="coloum-value"><code><?php echo $post->post_name; ?></code></td>
		   	   	       </tr>
		   	   	      <?php 
		                  $spm_data = get_post_meta(get_the_ID());
		                  $count = 4;
		                  foreach ($spm_data as $key => $value) {
		                  $count++;	 
		                  	 ?> 
		                  <?php 
		                       $class = 'display';
		                       if ($key =='_edit_lock' OR $key == '_edit_last'){
		                       	  $class = 'none';
		                          $count = 4;    
		                       }

                               $result = substr($value[0], 0, 6);

                               if($result=='field_'){
                               	  $class = 'none';
                               }
		                       
		                  ?>
	                         <tr class="<?php echo $class; ?>">
	                             <td class="coloum-number"><?php echo $count; ?></td>  
	           	   	   	   	     <td class="coloum-name"><?php echo $key; ?></td>
	           	   	   	   	     <td class="coloum-value"><code><?php //echo $value[0]
	                               print_r($value[0]);
	           	   	   	   	     ?>
	           	   	   	   	     </code>
	           	   	   	   	     <?php 
	                                     if ( $key == '_thumbnail_id' ){
	                                       	  $media_id = wp_get_attachment_url( $value[0] );
	                                       	  echo '<br>';
	                                       	  echo '<code>'.$media_id.'</code>';
	                                       }
	           	   	   	   	     	?>
	           	   	   	   	     </td>
	           	   	   	     </tr>
		                  	 <?php 
		                  }
		   	   	      ?>
		   	   	   </tbody>
		   	   </table>
		   </div> 
		</div>
      <?php  
       }	
    }
}
// Call The Class
new spm_Activated_class();
?>