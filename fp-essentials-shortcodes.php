<?php

/**
 * PLugin Name: Fused Essentials Shortcodes
 * Author: Anu Sharma
 * Plugin URI:http://fusedpress.com/plugins/shortcodes/
 * Author URI:http://buddydev.com/members/anusharma/
 * Version:1.0
 * Description:  The Shortcode Library for FusedPress Themes
 */
define('FP_ESSENTIALS_SHORTCODES_DIR_PATH', plugin_dir_path(__FILE__));

class FPNEWShortCodes {
    
    private static $instance;

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
        add_shortcode('non-loggedin', array($this,'non_logged_user_message'));
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
        add_shortcode('total-posts',array($this,'total_posts'));
        add_shortcode('draft-posts', array($this,'draft_posts'));
         
        //No of users
        add_shortcode('total-users',array($this,'total_users'));
       
        //Comments.
        add_shortcode('comments',array($this,'comments'));
        add_shortcode('moderated',array($this,'moderated_comments'));
        add_shortcode('approved',array($this,'approved_comments'));
        
        //show particular post comments
        add_shortcode('post-comments',array($this,'post_comments'));
        
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
     * Get Instance
     * 
     * Use singlten patteren
     * @return type
     */
    public static function get_instance() {

        if (!isset(self::$instance))
            self::$instance = new self();

        return self::$instance;
    }


    /**
     * Loggedin User Message
     * 
     * [loggedin]Text message......[/loggedin]
     * 
     * @param type $atts an associative array of attributes, or an empty string if no attributes are given
     * @param type $content the enclosed content 
     * @return String 
     */
    public function loggedin_user_message($atts, $content = null) {
        extract(shortcode_atts(array(
                    'class' => 'loggedin-message',
                        ), $atts));


        //now check if user is logged in..... :P
        if (is_user_logged_in() && !is_null($content)) {

            //now then return the content..... :)
            return '<div  class="' . esc_attr($class) . '">' . $content . '</div>';
        }
    }
    
    /**
     * Non Loggedin User Message
     * 
     *[non-loggedin]Text message......[/non-loggedin]
     * 
     * @param type $atts an associative array of attributes, or an empty string if no attributes are given
     * @param type $content the enclosed content 
     * @return String 
     */
    public function non_logged_user_message($atts,$content=null){
         extract(shortcode_atts(array(
                    'class' => 'nonloggedin-message',
                        ), $atts));

        //now check if user is not logged in....... :P
        if (!is_user_logged_in()) {

            //now then return content............ :)
            return '<div  class="' . esc_attr($class) . '">' . $content . '</div>';
        }
    }
    
   /**
    * Show Current Site/Blog Url
    * 
    * [siteurl]
    * 
    * @param type $atts
    * @param type $content
    * @return string 
    */
    public function siteurl($atts,$content=null){
    
       extract(shortcode_atts(array(
                    "id" => '',
                    'class' => 'site-url'), $atts));

        if ($id != '') {
            return get_permalink($id);
        }
         return '<div  class="' . esc_attr($class) . '">' . get_bloginfo('url') . '</div>';
       
    }
    /**
     * Show site/blog name
     * 
     * [bloginfo]
     * [sitename]
     * 
     * @return type
     */
      public function bloginfo( $atts,$content=null ) {
          
           extract(shortcode_atts(array(
                    "id" => '',
                    'class' => 'blog-info'), $atts));
           
            return '<div  class="' . esc_attr($class) . '">' . get_bloginfo( $atts ) . '</div>';
 
    }
    /**
     * Show Post Url
     * 
     * [posturl id=""]
     * 
     * @param type $attsibutes
     * @return type
     */
  public function posturl($atts,$content=null){
        
        extract(shortcode_atts(array(
                    "id" => '',
                    'class' => 'post-url'), $atts));


        $post_id = intval($atts['id']);
        $return_posturl = get_permalink($post_id);
        
        return '<div  class="' . esc_attr($class) . '">' . $return_posturl . '</div>';
   
        
    }
   /**
    * Show blog/page url
    * 
    * [blogurl]
    * [pageurl]
    * 
    * @param type $atts
    * @return type
    */
   public function blogurl($atts) {
        
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
                return '<div  class="' . esc_attr($class) . '">' .get_bloginfo('url'). '</div>';
		
    }
     /**
     * Post Link
     * 
     * [postlink pid="1038" ]post link[/postlink]
     * 
     * @param type $atts
     * @param type $content
     * @return string
     */
    public function postlink($atts,$content=null){
        
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

        return '<div><a href="' . $permalink . '" class="' . esc_attr($class) . '">' . $content . '</a>'.'</div>';
    }
        
    /**
    * Page link 
    *   
    * [pagelink pageid="6"]Page link[/pagelink]
    * 
    * @param type $atts
    * @param type $content
    * @return string
    */
   public function pagelink($atts,$content=null){
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

        return '<div><a href="' . $permalink . '" class="' . esc_attr($class) . '">' . $content . '</a>'.'</div>';
     
    }
    /**
     * Show total usres
     * 
     * [total-users]
     * 
     * @return type
     */
   public function total_users($atts,$content=null) {
        extract(shortcode_atts(array(
                    'class' => 'total-users',
                        ), $atts));


        $count_users = count_users();
      // echo 'There are ', $count_users['total_users'], ' total users';
            foreach($count_users['avail_roles'] as $role => $count)
               // echo ', ', $count, ' are ', $role, 's';
           //echo '.';
        
        return '<div " class="' . esc_attr($class) . '">'.'There are  &nbsp;' . $count_users['total_users'].'&nbsp;Total users' .'&nbsp;,&nbsp;'.$count.'&nbsp;'.$role.''.'</div>';
       
    
    
    }
   /**
    * Show total posts
    * 
    * [total-posts]
    * 
    * @return type
    */
     public function total_posts($atts,$content=null) {
        
        extract(shortcode_atts(array(
                    'class' => 'total-posts',
                        ), $atts));

        $count_posts = wp_count_posts();
        
        return '<div  class="' . esc_attr($class) . '">'.'Total  posts &nbsp; &nbsp;'.  $count_posts->publish. '</div>';
        
        }
    /**
    * Total Posts(Drafts)
    * 
    * @return type
    */
    public function draft_posts($atts,$content=null){
        
        extract(shortcode_atts(array(
                    'class' => 'total-draft-posts',
                        ), $atts));

        //count draft posts.................. :)
        $count_drafts = wp_count_posts();
        
        return '<div  class="' . esc_attr($class) . '">' . 'Total drafts posts &nbsp; &nbsp;' . $count_drafts->draft . '</div>';
    }
    /**
    * Total Comments
    * 
    * @global type $fp_options
    * @return type
    */
    public function comments($atts,$content=null){
        
          extract(shortcode_atts(array(
                    'class' => 'total-comments',
                        ), $atts));

        //count total comments.................. :)
        $count_comments = wp_count_comments();
        
        return '<div  class="' . esc_attr($class) . '">' . 'Total Comments on this site is &nbsp; &nbsp;' . $count_comments->total_comments . '</div>';
    }
    /**
    * post comment 
    * 
    * show particular comments on a single post
    * 
    * [post_comments id=""]
    * 
    * @param type $atts
    * @return type
    */
   public function post_comments($atts){
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

        return '<div><a href="'. $permalink . '" class="comments_link">' . $post . '</a>'.'</div>';

    }
    /**
    * Total comments(Moderates)
    * 
    * @return type
    */
   public function moderated_comments($atts,$content=null){
        
          extract(shortcode_atts(array(
                    'class' => 'moderated-comments',
                        ), $atts));
        
          //count moderated comments............. :)
          $count_moderated=  wp_count_comments();
          
           return '<div  class="' . esc_attr($class) . '">' . 'Total moderated Comments &nbsp; &nbsp;' . $count_moderated->moderated . '</div>';
         
    }
    /**
    * Total comments(approved)
    * 
    * @return type
    */
   public function approved_comments ($atts,$content=null){
        
         extract(shortcode_atts(array(
                    'class' => 'draft-comments',
                        ), $atts));
       
        //count approved comments................. :)
         $count_approved=  wp_count_comments();
         
        return '<div  class="' . esc_attr($class) . '">' . 'Total approved Comments &nbsp; &nbsp;' . $count_approved->approved. '</div>'; 

    }
    /**
     * Admin Url
     * 
     * @param type $atts
     * @return type
     */
   public function adminurl($atts){
        
        extract(shortcode_atts(array(
                    'path' => '',
                    'class'=>'admin-url',
                        ), $atts));
        return '<div  class="' . esc_attr($class) . '">'.'Admin Url &nbsp;'  .admin_url( $path). '</div>'; 
  	    
    }
    /**
    * Network home url
    * 
    * @param type $atts
    * @return type
    */
   public function network_home_url($atts){
        extract( shortcode_atts( array(
    		'path' => '',
                'class'=>'network-home',
    		
    	), $atts ) );
        
     return '<div  class="' . esc_attr($class) . '">' .'Network Url &nbsp;' .network_home_url( $path ). '</div>'; 
    
        
    }
    /**
    * logout url
    * 
    * @param type $atts
    * @return type
    */
   public function logout_url($atts){
        
            extract(shortcode_atts(array(
                    'class' => 'logout-url',
                        ), $atts));

        return  wp_logout_url(home_url());
  
    }
    /**
    * login url
    * 
    * @param type $atts
    * @return type
    */
    public function login_url($atts){
        
            extract(shortcode_atts(array(
                    'class' => 'login-url',
                        ), $atts));
        return  wp_login_url(home_url()) ;
    }
    /**
    * Recent posts
    * 
    * @param type $atts
    * @return type
    */
   public function recent_posts($atts){
        
        $query = new WP_Query(
                        array('orderby' => 'date', 'posts_per_page' => '5')
        );

        $list = '<ul class="recent-posts">';

        while ($query->have_posts()) : $query->the_post();

            $list .= '<li>' . get_the_date() . '<a href="' . get_permalink() . '">' . get_the_title() . '</a>' . '<br />' . '</li>';

        endwhile;

        wp_reset_query();

        return $list . '</ul>';
    }
    
    public function recent_comments($atts,$content=null){
     

    }
  
}

FPNEWShortCodes::get_instance();
?>