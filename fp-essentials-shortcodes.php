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
        add_shortcode('sitename',array($this,'bloginfo'));
        add_shortcode('bloginfo',array($this,'bloginfo'));
        add_shortcode('blogurl', array($this,'blogurl'));
        
        //Page url/link
        add_shortcode('pageurl',array($this,'blogurl'));
        add_shortcode('pagelink',array($this,'pagelink'));
        
        //show post url
        add_shortcode('posturl', array($this,'posturl'));
        add_shortcode('postlink',array($this,'postlink'));
        add_shortcode('total_posts',array($this,'total_posts'));
        add_shortcode('draft_posts', array($this,'draft_posts'));
         
        //No of users
        add_shortcode('total_users',array($this,'total_users'));
       
        //Comments.
        add_shortcode('comments',array($this,'comments'));
        add_shortcode('moderated',array($this,'moderated_comments'));
        add_shortcode('approved',array($this,'approved_comments'));
        //show particular post comments
        add_shortcode('post_comments',array($this,'post_comments'));
        
        //admin url
        add_shortcode('adminurl',array($this,'adminurl'));
        
        //Network url/link
        add_shortcode('networkhomeurl',array($this,'network_home_url'));
        
        //login /logout url & link
        add_shortcode('logout-url',array($this,'logout_url'));
        add_shortcode('login-url',array($this,'login_url'));
        
        //recent comments
        add_shortcode('recent-posts',array($this,'recent_posts'));
    }

    /**
     * Loggedin User Message
     * 
     * @param type $atts an associative array of attributes, or an empty string if no attributes are given
     * @param type $content the enclosed content 
     * @return String 
     */
    function loggedin_user_message($atts, $content = null) {
        extract(shortcode_atts(array(
                    'class' => 'loggedin-message',
                        ), $atts));


        //now check if user is logged in..... :P
        if (is_user_logged_in() && !is_null($content)) {

            //now then return the content..... :)
            return '<p  class="' . esc_attr($class) . '">' . $content . '</p>';
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
         extract(shortcode_atts(array(
                    'class' => 'nonloggedin-message',
                        ), $atts));

        //now check if user is not logged in....... :P
        if (!is_user_logged_in()) {

            //now then return content............ :)
            return '<p  class="' . esc_attr($class) . '">' . $content . '</p>';
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
    function siteurl($atts,$content=null){
    
       extract(shortcode_atts(array(
                    "id" => '',
                    'class' => 'site-url'), $atts));

        if ($id != '') {
            return get_permalink($id);
        }
         return '<p  class="' . esc_attr($class) . '">' . get_bloginfo('url') . '</p>';
       
    }
    /**
     * Show site/blog name
     * 
     * @return type
     */
      function bloginfo( $atts,$content=null ) {
          
           extract(shortcode_atts(array(
                    "id" => '',
                    'class' => 'blog-info'), $atts));
           
            return '<p  class="' . esc_attr($class) . '">' . get_bloginfo( $atts ) . '</p>';
 
    }
    /**
     * Show Post Url
     * 
     * @param type $attributes
     * @return type
     */
    function posturl($atts,$content=null){
        
        extract(shortcode_atts(array(
                    "id" => '',
                    'class' => 'post-url'), $atts));


        $post_id = intval($atts['id']);
        $return_posturl = get_permalink($post_id);
        
        return '<p  class="' . esc_attr($class) . '">' . $return_posturl . '</p>';
   
        
    }
   /**
    * Show blog/page url
    * 
    * @param type $atts
    * @return type
    */
    function blogurl($atts) {
	extract(shortcode_atts(array(
            "id" => '',
            "temp" => false,
            "class"=>'blog-url'
            ), $atts));
        
		if($id != ''){
			return  get_permalink($id);
		}
		if($temp){
			return get_bloginfo('template_url');
		}
                return '<p  class="' . esc_attr($class) . '">' .get_bloginfo('url'). '</p>';
		
    }
     /**
     * Post Link [postlink pid="1038" ]post link[/postlink]
     * 
     * @param type $atts
     * @param type $content
     * @return string
     */
    function postlink($atts,$content=null){
        
        extract(shortcode_atts(array(
                    'class' => 'post-link',
                    'pid' => null
                        ), $atts));

        // Return empty string if no post ID provided
        if (!$pid) {
            return '';
        }

        $permalink = get_permalink($pid);
        // Return empty string if no permalink found
        if (!$permalink) {
            return ;
        }

        // Use the page/post title if no content provided
        if (empty($content)) {
            $content = get_the_title($pid);
        }

        return '<a href="' . $permalink . '" class="' . esc_attr($class) . '">' . $content . '</a>';
    }
        
    /**
     * Page link 
        
     * [pagelink pageid="6"]Page link[/pagelink]
     * 
     * @param type $atts
     * @param type $content
     * @return string
     */
    function pagelink($atts,$content=null){
          extract(shortcode_atts(array(
                    'class' => 'page-link',
                    'pageid' => null
                        ), $atts));

        // Return empty string if no blog ID provided
        if (!$pageid) {
            return '';
        }

        $permalink = get_permalink($pageid);
        // Return empty string if no permalink found
        if (!$permalink) {
            return '';
        }

        // Use the page/post title if no content provided
        if (empty($content)) {
            $content = get_the_title($pageid);
        }

        return '<a href="' . $permalink . '" class="' . esc_attr($class) . '">' . $content . '</a>';
     
    }
    /**
     * Show total usres
     * 
     * @global type $fp_options
     * @return type
     */
    function total_users($atts,$content=null) {
        extract(shortcode_atts(array(
                    'class' => 'total-users',
                        ), $atts));


        $count_users = count_users();
      // echo 'There are ', $count_users['total_users'], ' total users';
            foreach($count_users['avail_roles'] as $role => $count)
               // echo ', ', $count, ' are ', $role, 's';
           //echo '.';
        
        return '<p " class="' . esc_attr($class) . '">'.'There are  &nbsp;' . $count_users['total_users'].'&nbsp;Total users' .'&nbsp;,&nbsp;'.$count.'&nbsp;'.$role.''.'</p>';
       
    
    
    }
     /**
      * Show total posts
      * 
      * @global type $fp_options
      * @return type
      */
    function total_posts($atts,$content=null) {
        
        extract(shortcode_atts(array(
                    'class' => 'total-posts',
                        ), $atts));

        $count_posts = wp_count_posts();
        
        return '<p  class="' . esc_attr($class) . '">'.'Total  posts &nbsp; &nbsp;'.  $count_posts->publish. '</p>';
        
    }
    /**
     * Total Posts(Drafts)
     * 
     * @return type
     */
    function draft_posts($atts,$content=null){
        
        extract(shortcode_atts(array(
                    'class' => 'total-draft-posts',
                        ), $atts));

        //count draft posts.................. :)
        $count_drafts = wp_count_posts();
        
        return '<p  class="' . esc_attr($class) . '">' . 'Total drafts posts &nbsp; &nbsp;' . $count_drafts->draft . '</p>';
    }
    /**
     * Total Comments
     * 
     * @global type $fp_options
     * @return type
     */
    function comments($atts,$content=null){
        
          extract(shortcode_atts(array(
                    'class' => 'total-comments',
                        ), $atts));

        //count total comments.................. :)
        $count_comments = wp_count_comments();
        
        return '<p  class="' . esc_attr($class) . '">' . 'Total Comments on this site is &nbsp; &nbsp;' . $count_comments->total_comments . '</p>';

    }
    /**
     * post comment 
     * 
     * show particular comments on a single post
     * [post_comments id=""]
     * @param type $atts
     * @return type
     */
    function post_comments($atts){
        extract(shortcode_atts(array(
                    'id' => ''
                        ), $atts));

        $num = 0;
        $post_id = $id;
        $queried_post = get_post($post_id);
        $post = $queried_post->comment_count;
        if ($post == $num || $post > 1) : $post = $post . ' Comments';
        else : $post = $post . ' Comment';
        endif;
        $permalink = get_permalink($post_id);

        return '<a href="'. $permalink . '" class="comments_link">' . $post . '</a>';

    }
    /**
     * Total comments(Moderates)
     * 
     * @return type
     */
    function moderated_comments($atts,$content=null){
        
          extract(shortcode_atts(array(
                    'class' => 'moderated-comments',
                        ), $atts));
        
          //count moderated comments............. :)
          $count_moderated=  wp_count_comments();
          
           return '<p  class="' . esc_attr($class) . '">' . 'Total moderated Comments &nbsp; &nbsp;' . $count_moderated->moderated . '</p>';
         
    }
    /**
     * Total comments(approved)
     * 
     * @return type
     */
    
    function approved_comments ($atts,$content=null){
        
         extract(shortcode_atts(array(
                    'class' => 'draft-comments',
                        ), $atts));
       
        //count approved comments................. :)
         $count_approved=  wp_count_comments();
         
        return '<p  class="' . esc_attr($class) . '">' . 'Total approved Comments &nbsp; &nbsp;' . $count_approved->approved. '</p>'; 

    }
    /**
     * Admin Url
     * 
     * @param type $atts
     * @return type
     */
    function adminurl($atts){
        
        extract(shortcode_atts(array(
                    'path' => '',
                    'class'=>'admin-url',
                    'scheme' => 'admin'
                        ), $atts));
        return '<p  class="' . esc_attr($class) . '">'  .admin_url( $path, $scheme ). '</p>'; 
  	    
    }
    /**
     * Network home url
     * 
     * @param type $atts
     * @return type
     */
    function network_home_url($atts){
        extract( shortcode_atts( array(
    		'path' => '',
    		'scheme' => null
    	), $atts ) );
    
    	return network_home_url( $path, $scheme );
        
    }
    /**
     * logout url
     * 
     * @param type $atts
     * @return type
     */
    function logout_url($atts){
        
            extract(shortcode_atts(array(
                    'class' => 'logout-url',
                        ), $atts));

        return '<p  class="' . esc_attr($class) . '">'  . wp_logout_url(home_url()). '</p>';
  
    }
    /**
     * login url
     * 
     * @param type $atts
     * @return type
     */
    function login_url($atts){
        
            extract(shortcode_atts(array(
                    'class' => 'login-url',
                        ), $atts));
        return '<p  class="' . esc_attr($class) . '">' . wp_login_url(home_url()) . '</p>';
    }
    /**
     * Recent posts
     * 
     * @param type $atts
     * @return type
     */
    function recent_posts($atts){
        
        $query = new WP_Query(
                        array('orderby' => 'date', 'posts_per_page' => '4')
        );

        $list = '<ul class="recent-posts">';

        while ($query->have_posts()) : $query->the_post();

            $list .= '<li>' . get_the_date() . '<a href="' . get_permalink() . '">' . get_the_title() . '</a>' . '<br />' . get_the_excerpt() . '</li>';

        endwhile;

        wp_reset_query();

        return $list . '</ul>';
    }

}

new FPNEWShortCodes();
?>