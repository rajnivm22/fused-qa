<?php
/*
Plugin Name: Frontend Qa Forum

Author Name: Rajni verma

version: 1.1
*/



class QA_Frontend_Forum_Generator {

    private static $instance;

    private function __construct() {
        add_action('init',array($this,'register_qa_form'));
        add_shortcode('qa-form',array($this,'qa_shortcode_handler'));
        add_action('init',array($this,'qa_insert_post'));
      
 }
/**
 *
 * @return type 
 */
    public static function get_instance() {

        if (!isset(self::$instance))
            self::$instance = new self();

        return self::$instance;
    }
/**
* Custom post type for question
*/
    public function register_qa_form(){
		
		register_post_type('question',array('labels'=>array(
				'name'=>__('Questions'),
				'menu_name' => 'Questions',
				'capability_type' => 'post',
                                'edit_item' => 'Edit Question',
                                'add_new_item' => 'Add New Question',
                                'search_items' => 'Search Questions',
                                'not_found' => 'No Question Found',
                                'view_item' => 'View Question'
                                 ),
                                    'public' => true,
                                    'taxonomies' => array( 'post_tag','category'),
                                    'has_archive' => 'questions/tags',
                                    'supports' => array( 'title', 'editor', 'thumbnail','author')
                             ));
        
     }
/**
 * Shortcode for form
 * @param type $attr
 * @param type $content
 * @return string 
 */
    public function qa_shortcode_handler($attr,$content=null ){

            if(!is_user_logged_in())

                    return "login first";

            ob_start();

            include_once("form.php");

            $post_content=ob_get_clean();

            return "<p class='qa-form'>$post_content</p>";
	
	
   }
/**
* 
*/
    public function qa_insert_post() {
       
          if(isset($_POST['title'])){
                    $title=$_POST['title'];
            }
            if(isset($_POST['description'])){	  
                    $description= $_POST['description'];
            }
            if(isset($_POST['tags'])){
                    $q_tags = $_POST['tags'];
            }  
  if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == "question-form") {
          
      
		$post = array(
				// add the form $post array		
				'post_title' => $title,
				'post_content' => $description,
                                'tags_input'    =>   array($q_tags),
                                'post_category' =>   array($_POST['cat']),
                                'post_status' => 'publish',
				'post_author' => $user->ID,
				'post_type' => 'question'
				
				);
		     //save the post
		    $qa_post=wp_insert_post( $post );
					
                  
								
	}
   }
	 
    
}

 QA_Frontend_Forum_Generator::get_instance();
	

class QA_List_Questions {

    private static $instance;

    private function __construct() {
   
        add_shortcode('list-question', array($this,'list_question_shortcode_handler'));
   
    }

    public static function get_instance() {

        if (!isset(self::$instance))
            self::$instance = new self();

        return self::$instance;
    }
    
    
    
   public function list_question_shortcode_handler(){ 
         
         
         if(!is_user_logged_in())
			
		return "login first";
         
          global $wp_query;
          $list_args = array('post_type' => 'question','orderby' => '' );
          query_posts($list_args);
                $wp_query->is_archive = true;
                $wp_query->is_page = false;
    
						
          $output='';
                
       if(have_posts()){

         while (have_posts() ) { the_post(); 
         $categories_list = get_the_category_list( __( ', ', 'qa' ) );;
         
  ?>
           
         <article <?php post_class('post clearfix');?> id="post-<?php get_the_ID();?>">
            <header>
                <h4 class="post-title"><a href="<?php echo get_permalink();?>" title="View <?php echo the_title_attribute();?>"><?php echo get_the_title();?></a></h4>
                <div class="post-meta clearfix">
                    <div class="datetime"><?php  echo get_the_date('\<\s\t\r\o\n\g\>j\<\s\u\p\>S\<\/\s\u\p\>\<\/\s\t\r\o\n\g\> \<\s\p\a\n\>M\<\/\s\p\a\n\>');?></div>              
                </div> 
            </header>
 
            <div class="clearfix entry ">
                <?php  echo get_the_excerpt();?> 
                <a href="<?php  echo get_permalink();?>" title="<?php   echo the_title_attribute();?>" class="btn btn-info pull-right"><?php _e('View More'); ?></a>
                <div class="post-meta post-meta-bottom">
                    <div class="cat-links"><span class="posted-in"><?php _e( 'Asked in', 'Qa' ) ?> <?php echo $categories_list; ?></span></div>
                    <?php echo get_the_tag_list('<div class="tag-links"><span class="tagged-in">Tags:</span> ', ',', '</div>'); ?>
                  
                    <?php edit_post_link( __( 'Edit', 'qa' ), ' <span class="edit-link">', '</span>' ); ?>
                </div>
            </div>
        </article>    

  <?php    
          }
   
         wp_reset_query();				
 
      }
  
   return $output ; 
         
   }

}

QA_List_Questions::get_instance();
?>

 
   
