<?php c2pf_header(); ?>

<?php 		
// processing functions
if( isset( $_POST['c2pf_design_submit'] ) )
{	
	$_POST = stripslashes_deep($_POST);
	c2pf_savedesign( 'Default',$_POST['c2pf_title'],$_POST['c2pf_content'],$_POST['c2pf_shortcodedesign'],$_POST['c2pf_aioseotitle'],$_POST['c2pf_aioseodescription'] );
}

// is user requesting design test
if( isset( $_POST['c2pf_testlayoutspage_submit'] ) || isset( $_POST['c2pf_testlayoutspost_submit'] ) )
{
	c2pf_designtest(	$_POST['c2pf_design'],$_POST['c2pf_project'] );
}

// process snippet generator - image button - tokens
if( isset( $_POST['c2pf_snip_imagebut_t'] ) )
{
	c2pf_snippetgenerator('imagebutton','t');
}

// process snippet generator - image button - shortcodes
if( isset( $_POST['c2pf_snip_imagebut_s'] ) )
{
	c2pf_snippetgenerator('imagebutton','s');
}

// process snippet generator - image only - tokens
if( isset( $_POST['c2pf_snip_image_t'] ) )
{
	c2pf_snippetgenerator('image','t');
}

// process snippet generator - image only - tokens
if( isset( $_POST['c2pf_snip_image_s'] ) )
{
	c2pf_snippetgenerator('image','s');
}

// process snippet generator - link - tokens
if( isset( $_POST['c2pf_snip_link_t'] ) )
{
	c2pf_snippetgenerator('link','t');
}

// process snippet generator - link - shortcodes
if( isset( $_POST['c2pf_snip_link_s'] ) )
{
	c2pf_snippetgenerator('link','s');
}			

// get data arrays
$set = get_option('c2pf_set');
$que = get_option('c2pf_que');
$pro = get_option( 'c2pf_pro' );
$csv = get_option( 'c2pf_' . $pro['current'] );
$des = get_option('c2pf_des');
?>

<div class="wrap">
	<div id="icon-index" class="icon32"><br /></div>

	<h2>CSV 2 POST WYSIWYG Designs</h2>
	
    <?php 
	if( !isset( $pro['current'] ) || isset( $pro['current'] ) && $pro['current'] == 'None Selected' )
	{
		c2pf_err( 'No Current Project','You will see errors on this screen after installing the plugin or deleting the "Current Project". 
				The errors are simply because there is no project data created. Please create a project or make an existing project your
				Current Project.' );
		
		$pro['current'] = ' No Current Project ';
	}
	?>
	
    <p>For the ability to create more than a single design please hire WebTechGlobal for a custom plugin that allows you to do that. We can install it and have it running within
    24 hours with any customising required for your project done in the first week.</p>
	
    <div id="poststuff" class="meta-box-sortables" style="position: relative; margin-top:10px;">

		<?php	
		// open current projects design by default else check if user is working and submitting another design
		if( isset( $csv['design'] ) && !isset( $_POST['c2pf_selectdesign_submit'] ) && !isset( $_POST['c2pf_newdesign_submit'] ) ) 
		{
			$d = 'Default';
		}		
		elseif( isset( $_POST['c2pf_newdesign_submit'] ) ) 
		{
			$d = 'Default';
			$des[$d]['title'] = '';
			$des[$d]['content'] = '';
			$des[$d]['shortcodedesign'] = '';
			$des[$d]['seotitle'] = '';
			$des[$d]['seodescription'] = '';
		}
		elseif( isset( $_POST['c2pf_selectdesign_submit'] ) || isset( $_POST['c2pf_design_submit'] ) )
		{
			$d = 'Default';// open submitted design name to continue working on it
		}
		else
		{
			$d = 'Default';// open default installed template when creating new design
		}
		?>		
        <div class="postbox">
            <div class="handlediv" title="Click to toggle"><br /></div>
            <h3>WYSIWYG Editor</h3>
            <div class="inside">
            
                <form method="post" name="c2pf_design_form" action="">
                    <div id="titlediv">
                        <div id="titlewrap">
                            <h4><a href="#" title="Enter a unique name to remember what the design is for. Maximum 12 characters.">Design Name</a></h4>
                            <input type="text" name="c2pf_name" size="12" maxlength="12" value="Default" id="title" />
                        </div>
                    </div>
                                                                
                    <div id="titlediv">
                        <div id="titlewrap">
                            <h4><a href="#" title="Build your post titles by stringing together tokens and text">Post Title</a></h4>
                            <input type="text" name="c2pf_title" size="30" value="<?php echo $des[$d]['title']; ?>" id="title" />
                        </div>
                    </div>     
                    
                    <div id="<?php echo user_can_richedit() ? 'postdivrich' : 'postdiv'; ?>" class="postarea">
                            <?php the_editor( $des[$d]['content'], 'c2pf_content'); ?>
                        <div id="post-status-info">
                            <span id="wp-word-count" class="alignleft"></span>
                        </div>
                    </div>     		

                    <div class="postbox closed">
                        <div class="handlediv" title="Click to toggle"><br /></div>
                        <h3>Shortcode Block Design</h3>
                        <div class="inside">
                            <textarea name="c2pf_shortcodedesign" cols="75" rows="5" disabled="disabled"><?php echo $des[$d]['shortcodedesign'] ?></textarea>
                        </div>
                    </div>  
                                            
<!-- ALL IN ONE SEO PLUGIN SUPPORT - ONLY IF THE PLUGIN IS INSTALLED -->
                    <div class="postbox closed">
                        <div class="handlediv" title="Click to toggle"><br /></div>
                        <h3>All In One SEO</h3>
                        <div class="inside">
                       
                            <label>Title: <input type="text" name="c2pf_aioseotitle" size="68" value="<?php echo $des[$d]['seotitle']; ?>" disabled="disabled" /></label>
                            <br />
                            <label>Description: <textarea name="c2pf_aioseodescription" cols="50" rows="5" disabled="disabled"><?php echo $des[$d]['seodescription']; ?></textarea></label>
                    
                        </div>
                    </div>  
                    
                    <input class="button-primary" type="submit" name="c2pf_design_submit" value="Save" />
                </form>
            </div>
        </div>


        <div class="postbox closed">
            <div class="handlediv" title="Click to toggle"><br /></div>
            <h3>Tokens</h3>
            <div class="inside">
                <?php c2pf_displaytokenlist('tokens'); ?>
            </div>
        </div>
                       
        <!-- START OF STANDARD SHORTCODES BOX -->
       <div class="postbox closed">
            <div class="handlediv" title="Click to toggle"><br /></div>
            <h3>Shortcodes</h3>
            <div class="inside">
                
                <h4>Standard Shortcodes</h4>
                <?php c2pf_displaytokenlist('shortcodes'); ?>
                
                <h4>Label/Null Replace Shortcodes</h4>
                <?php c2pf_displaytokenlist('shortcodeslabel'); ?>
                
            </div>
        </div>  
        <!-- END OF STANDARD SHORTCODES BOX -->

        <!-- START OF STANDARD SHORTCODES BOX -->
       <div class="postbox closed">
            <div class="handlediv" title="Click to toggle"><br /></div>
  
                
	</div><!-- END OF PAGE WIDE BOXES -->
				
	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder">
		
		
			<div class='postbox-container' style='width:49%;'>
				<div id="normal-sortables" class="meta-box-sortables">	
				
					<!-- START OF BOX -->
					<div id="dashboard_right_now" class="postbox" >
						<div class="handlediv" title="Click to toggle"><br /></div>
						
						<h3 class='hndle'><span>Current Designs &amp; Create New</span></h3>
						<div class="inside">
							<div class="table table_content">
								<form method="post" name="c2pf_selectdesign_form" action="">  
							
									<p class="sub">Select To Edit</p>
									
									<table>
										<tr>
											<td></td>
											<td class="last t comments">Name</td>
											<td class="last t comments">ID</td>
										</tr>	
									<?php
									// if designs exist, list them else show message
									if( isset( $des ) )
									{
										foreach( $des as $name=>$d )
										{
											if( $name != 'arraydesc' )
											{
											?>
											<tr>
												<td class="b b-comments"><input type="radio" name="c2pf_name" value="<?php echo $name;?>" checked  /></td>
												<td class="last t comments"><a href="?page=c2pf_config&config=fullspeed"><?php echo $name;?></a></td>
												<td class="last t comments"><a href="?page=c2pf_config&config=fullspeed"><?php echo $d['id'];?></a></td>
											</tr>											
											<?php 
											}
										}
									}
									else
									{
										echo 'No WYSIWYG Designs Were Found';
									}
									?>

									</table>
								</div>
														
								<div class="versions">   	
									<input class="button-primary" type="submit" name="c2pf_selectdesign_submit" value="Open" /> 
									<input class="button-primary" type="submit" name="c2pf_newdesign_submit" value="Create New Design" /> 
								</form>   				
								<br class="clear" />
							</div>
							
						</div>
					</div>
					<!-- END OF BOX -->
									
				</div>	
			</div>
	
			<!-- RIGHT COLUMN START -->
			
			<div class='postbox-container' style='width:49%;'>
				<div id="side-sortables" class="meta-box-sortables">
	
                                   
					<!-- START OF STANDARD SHORTCODES BOX -->
                   <div class="postbox">
                        <div class="handlediv" title="Click to toggle"><br /></div>
                        <h3>HTML Snippets</h3>
                        <div class="inside">
							<div class="table table_content">
							<form method="post" name="c2pf_snippets_form" action="">  
                                <table class="widefat post fixed">
                                    <tr>
                                        <td><h4>Token Method</h4></td>
                                        <td><h4>Shortcode Method</h4></td>
                                    </tr>
                                    <tr>
                                        <td><input class="button-primary" type="submit" name="c2pf_snip_imagebut_t" value="Image Button" /> </td>
                                        <td><input class="button-primary" type="submit" name="c2pf_snip_imagebut_s" value="Image Button" /> </td>
                                    </tr>
                                    <tr>
                                        <td><input class="button-primary" type="submit" name="c2pf_snip_image_t" value="Image Only" /> </td>
                                        <td><input class="button-primary" type="submit" name="c2pf_snip_image_s" value="Image Only" /> </td>
                                    </tr>
                                    <tr>
                                        <td><input class="button-primary" type="submit" name="c2pf_snip_link_t" value="Text Link" /> </td>
                                        <td><input class="button-primary" type="submit" name="c2pf_snip_link_s" value="Text Link" /> </td>
                                    </tr>								
                                </table>  
                             </form>			
								<br class="clear" />
							</div>

                        </div>
                    </div>  
                    <!-- END OF STANDARD SHORTCODES BOX -->
 
                             																		
													
				</div>	
			</div>
			
		</div>

	<div class="clear"></div>
	</div><!-- dashboard-widgets-wrap -->
</div><!-- wrap -->

<?php c2pf_footer(); ?> 
                            
                            