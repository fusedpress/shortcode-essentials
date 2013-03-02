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

    private function __construct() {
  
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
      
        
        //show current site/Blog
        add_shortcode('site-url',array($this,'site_url'));
        add_shortcode('site-link',array($this,'site_url'));
        add_shortcode('site-name',array($this,'bloginfo'));
        
        add_shortcode('bloginfo',array($this,'bloginfo'));
        add_shortcode('blog-url', array($this,'blog_url'));
        add_shortcode('blog-link',array($this,'blog_url'));
        add_shortcode('link-to-blog',array($this,'link_to_blog'));
        
        //Page url/link
        add_shortcode('page-url',array($this,'blog_url'));
        add_shortcode('page-link',array($this,'page_link'));
        
        //show post url/link
        add_shortcode('post-url', array($this,'post_url'));
        add_shortcode('post-link',array($this,'post_link'));
        
        //total post & draft posts
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
        add_shortcode('admin-url',array($this,'admin_url'));
        
        //user url/link
        add_shortcode('user-url',array($this,'user_url'));
        add_shortcode('user-link',array($this,'user_link'));
        
        //Network url
        add_shortcode('network-home-url',array($this,'network_home_url'));
        
        // login /logout url
        add_shortcode('logout-url',array($this,'logout_url'));
        add_shortcode('login-url',array($this,'login_url'));
        
        //recent posts
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
            return '<div  class="' . esc_attr($class) . '">' .do_shortcode($content). '</div>';
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
            return '<div  class="' . esc_attr($class) . '">' . do_shortcode($content) . '</div>';
        }
    }
    
   /**
    * Show Current Site/Blog Url
    * 
    * [site-url]
    * <a href="[site-url]">Site link</a>
    * 
    * @param type $atts
    * @param type $content
    * @return string 
    */
    public function site_url($atts,$content=null){
    
       extract(shortcode_atts(array(
                    "id" => '',
                    'class' => 'site-url'), $atts));

        if ($id != '') {
            return get_permalink($id);
        }
         return  get_bloginfo('url') ;
       
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
           
            return  get_bloginfo( $atts ) ;
 
    }
    /**
     * Show Post Url
     * 
     * [post-url id=""]
     * 
     * @param type $attsibutes
     * @return type
     */
  public function post_url($atts,$content=null){
        
        extract(shortcode_atts(array(
                    "id" => '',
                    'class' => 'post-url'), $atts));


        $post_id = intval($atts['id']);
        $return_posturl = get_permalink($post_id);
        
        return $return_posturl ;
   
        
    }
   /**
    * Show blog/page url
    * 
    * [blog-url]
    * <a href="[blog-link]">Blog link</a>
    * [page-url id=""]
    * 
    * @param type $atts
    * @return type
    */
   public function blog_url($atts) {
        
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
                return get_bloginfo('url');
		
    }
    /**
     * Link To Blog
     * 
     * <ahref="[link-to-blog id="3"]">Link To Blog</a>
     * 
     * @param type $atts
     * @return type
     */
    public function link_to_blog($atts){
        extract(shortcode_atts(array(
                    'id' => '',
                    'class' => 'lonk-to-blog'
                        ), $atts));
        //$blog_id = 1;
         return get_blog_option( $id, 'siteurl ' );  
    }
     
        
    /**
     * Page link 
     *   
     * [page-link pageid="6"]Page link[/page-link]
     * 
     * @param type $atts
     * @param type $content
     * @return string
     */
   public function page_link($atts,$content=null){
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
      * Post Link
      * 
      * [post-link pid="1038" ]post link[/post-link]
      * 
      * @param type $atts
      * @param type $content
      * @return string
      */
    public function post_link($atts,$content=null){
        
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
        
        return '<div  class="' . esc_attr($class) . '">'.'Total  posts: &nbsp; &nbsp;'.  $count_posts->publish. '</div>';
        
        }
    /**
     * Total Posts(Drafts)
     * 
     *[draft-posts] 
     * 
     * @return type
     */
    public function draft_posts($atts,$content=null){
        
        extract(shortcode_atts(array(
                    'class' => 'total-draft-posts',
                        ), $atts));

        //count draft posts.................. :)
        $count_drafts = wp_count_posts();
        
        return '<div  class="' . esc_attr($class) . '">' . 'Total drafts posts: &nbsp; &nbsp;' . $count_drafts->draft . '</div>';
    }
    /**
     * Total Comments
     * 
     * [comments]
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
     * [post-comments id=""]
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

        return '<div>Total comments on this posts: &nbsp;<a href="'. $permalink . '" class="comments_link">' . $post . '</a>'.'</div>';

    }
    /**
     * Total comments(Moderates)
     * 
     * [moderated]
     * 
     * @return type
     */
     public function moderated_comments($atts,$content=null){
        
          extract(shortcode_atts(array(
                    'class' => 'moderated-comments',
                        ), $atts));
        
          //count moderated comments............. :)
          $count_moderated=  wp_count_comments();
          
           return '<div  class="' . esc_attr($class) . '">' . 'Total moderated Comments: &nbsp; &nbsp;' . $count_moderated->moderated . '</div>';
         
    }
    /**
     * Total comments(approved)
     * 
     * [approved]
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
     * [admin-url]
     * 
     * @param type $atts
     * @return type
     */
     public function admin_url($atts){
        
        extract(shortcode_atts(array(
                    'path' => '',
                    'class'=>'admin-url',
                    'scheme' => 'admin'
                        ), $atts));
        return '<div  class="' . esc_attr($class) . '">'.'Admin Url: &nbsp;'  .admin_url( $path,$scheme). '</div>'; 
  	    
    }
    /**
     * user url
     * 
     * [user-url id=""]
     * 
     * @param type $atts
     * @return type
     */
     public function user_url($atts){
        extract(shortcode_atts(array(
            'id'=>'',
            'class'=>'user-url',
            
        ),$atts));
         return '<div  class="' . esc_attr($class) . '">'.'Usre Url &nbsp;'  .bp_core_get_user_domain( $id ). '</div>'; 
       
    }
    /**
     * User links
     * 
     * [user-link id=""]
     * 
     * @param type $atts
     * @return type
     */
     public function user_link($atts){
           extract(shortcode_atts(array(
                    'id' => '',
                    'class' => 'user-link',
                        ), $atts));
           
        return bp_core_get_userlink( $id ); 
    }
    /**
     * Network home url
     * 
     * [network-home-url]
     * 
     * @param type $atts
     * @return type
     */
    public function network_home_url($atts){
        extract( shortcode_atts( array(
    		'path' => '',
                'class'=>'network-home',
              'scheme' => null
    		
    	), $atts ) );
        
     return '<div  class="' . esc_attr($class) . '">' .'Network Url: &nbsp;' .network_home_url( $path , $scheme ). '</div>'; 
    
        
    }
     /**
     * login url
     * 
     * use this to get login url......[login-url]
     * use this to get login link.....<a href="[login-url]">login link</a>.
     * 
     * @param type $atts
     * @return type
     */
    public function login_url($atts,$content=null){
        
            extract(shortcode_atts(array(
                    'class' => 'login-url',
                        ), $atts));
        return  wp_login_url(site_url()) ;
    }
    /**
     * logout url
     * 
     * Use this to take logout url .....[logout-url] 
     * use this to get logout link.....<a href="[logout-url]">logout link</a>.
     * 
     * @param type $atts
     * @return type
     */
    public function logout_url($atts,$content=null){
        
            extract(shortcode_atts(array(
                    'class' => 'logout-url',
                        ), $atts));

        return  wp_logout_url(site_url());
  
    }
   
    /**
     * Recent posts
     * 
     * [recent-posts]
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
  
}

FPNEWShortCodes::get_instance();
?>