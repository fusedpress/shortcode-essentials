<?php

/**
 * PLugin Name: Fused Essentials Shortcodes
 * Author: Anu Sharma
 * Plugin URI:http://fusedpress.com/plugins/shortcodes/
 * Author URI:http://buddydev.com/members/anusharma/
 * Version:1.0
 * Description:  The Shortcode Library for FusedPress Themes
 */
define('FPNEW_SHORT_CODES_DIR_PATH', plugin_dir_path(__FILE__));

class FPNEWShortCodes {

    function __construct() {
  
        //register shortcodes
        $this->register_shortcodes();

    }

    /**
     * Register  shortcodes
     * 
     */
    private function register_shortcodes() {

        //loggin users
        add_shortcode('loggedin', array($this, 'loggedin_user_message'));
        
        // non loggedin users
        add_shortcode('non_loggedin', array($this,'non_logged_user_message'));
        add_shortcode('visitor', array($this,'non_logged_user_message'));
        
        //show current site/Blog url
        add_shortcode('siteurl',array($this,'siteurl'));
        add_shortcode('sitename',array($this,'fp_bloginfo'));
        add_shortcode('bloginfo',array($this,'fp_bloginfo'));
        add_shortcode('blogurl', array($this,'blogurl'));
        add_shortcode('pageurl',array($this,'blogurl'));
        
        //show post url
        add_shortcode('posturl', array($this,'posturl'));
        add_shortcode('total_posts',array($this,'total_posts'));
        add_shortcode('draft_posts', array($this,'draft_posts'));
        
        
       
               
        //No of users
        add_shortcode('total_users',array($this,'total_users'));
       
        //Comments.
        add_shortcode('comments',array($this,'comments'));
        add_shortcode('moderated',array($this,'moderated_comments'));
        add_shortcode('draft',array($this,'draft_comments'));
        
        //

    }

    /**
     * Loggedin User Message
     * 
     * @param type $atts
     * @param type $content
     * @return string 
     */
    function loggedin_user_message($atts, $content = null) {
        
        //now check if user is logged in..... :P
        if ( is_user_logged_in() && !is_null( $content )){
            
            //now then return the content..... :)
            return '<p>'. $content .'</p>';
        }
    }
    
    /**
     * Non Loggedin User Message
     * 
     * @param type $atts an associative array of attributes, or an empty string if no attributes are given
     * @param type $content the enclosed content 
     * @return String 
     */
    function non_logged_user_message($atts,$content=null){
        
        //now check if user is not logged in....... :P
        if(!is_user_logged_in()){
            
            //now then return content............ :)
            return '<p>'.$content.'</p>';
        }
    }
    /**
     * User Access Capability
     * 
     * @param type $atts
     * @param type $content
     * @return string 
     */
    function  user_access_capability($atts,$content=null){
       extract( shortcode_atts( array( 'capability' => 'subscriber' ), $atts ) );

	if ( current_user_can( $capability ) && !is_null( $content ) && !is_feed() )
		return '<p>'. $content.'</p>';

	return 'Sorry, but you cannot access this content without... permission';

        
    }
   /**
     * Show Current Site/Blog Url
    * 
     * @param type $atts
     * @param type $content
     * @return string 
     */
    function siteurl(){
    
       extract(shortcode_atts(array("id" => ''), $atts));
        
		if($id != ''){
			return  get_permalink($id);
		}
                return '<a>'.get_bloginfo('url').'</a>';

    }
    /**
     * Show site/blog name
     * 
     * @return type
     */
      function fp_bloginfo( $atts ) {
          
	return get_bloginfo( $atts['show'], 'display' );
    }
    /**
     * Show Post Url
     * 
     * @param type $attributes
     * @return type
     */
    function posturl($attributes){
        
        $post_id = intval( $attributes['id'] );
        $return_posturl = get_permalink( $post_id );

        return '<a>'. $return_posturl.'</a>';   
        
    }
   /**
    * Show blog/page url
    * 
    * @param type $atts
    * @return type
    */
    function blogurl($atts) {
	extract(shortcode_atts(array("id" => '',"temp" => false), $atts));
        
		if($id != ''){
			return  get_permalink($id);
		}
		if($temp){
			return get_bloginfo('template_url');
		}
		return '<a>'.get_bloginfo('url').'</a>';
    }
    /**
     * Show total usres
     * 
     * @global type $fp_options
     * @return type
     */
    function total_users() {
        
            $count_users = count_users();
            return '<p>Total Users &nbsp; &nbsp;'. $count_users['total_users'] .'</p>';
    }
     /**
      * Show total posts
      * 
      * @global type $fp_options
      * @return type
      */
    function total_posts() {
           
        $count_posts = wp_count_posts();

        return '<p>Total drafts posts &nbsp; &nbsp;'. $count_posts->publish.'</p>' ;
    }
    
    function draft_posts(){
        
         //count draft posts.................. :)
        $count_drafts = wp_count_posts();
        
        return  '<p>Total drafts posts &nbsp; &nbsp;'. $count_drafts->draft .'</p>' ;
        
    }
    /**
     * Total Comments
     * 
     * @global type $fp_options
     * @return type
     */
    function comments(){
       
        //count total comments.................. :)
	$count_comments = wp_count_comments();
        
	return '<p>Total Comments &nbsp; &nbsp;' .$count_comments->total_comments .'</p>' ;
        
    }
    /**
     * Moderates comments
     * 
     * @return type
     */
    function moderated_comments(){
        
          //count moderated comments............. :)
          $count_moderated=  wp_count_comments();
          
          return '<p>Total moderated Comments  &nbsp; &nbsp;'.$count_moderated->moderated .'</p>';
    }
    /**
     * approved comments
     * 
     * @return type
     */
    
    function draft_comments(){
       
        //count approved comments................. :)
         $count_approved=  wp_count_comments();
         
          return '<p>Total approved Comments &nbsp; &nbsp;'.$count_approved->approved .'</p>';
        
    }


    
    
}

new FPNEWShortCodes();
?>
