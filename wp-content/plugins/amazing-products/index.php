<?php
/**
 * @package Amazing_Products
 * @version 1.0
Plugin Name: Amazing Products
Plugin URI: http://adalbadall.com/
Description: This plugin is used to make the site amazon based widgets.
Author: Sudhanshu Saxena
Version: 1.0
*/
global $amaze_db_version;
$amaze_db_version = "1.0";


if ( ! defined( 'AMAZE_PLUG_DIR' ) )
        define( 'AMAZE_PLUG_DIR', untrailingslashit( dirname( __FILE__ ) ) );
if ( ! class_exists( 'WP_List_Table' ) ){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' ); 
}

require_once AMAZE_PLUG_DIR . '/lib/AmazonECS.class.php';
/**Register the Database Table**/
register_activation_hook( __FILE__, 'amaze_install' );

function amaze_install(){
   global $wpdb;
   global $amaze_db_version;

   $table_name = $wpdb->prefix . "amazonecs";
   $product_table = $wpdb->prefix . "amazonproducts";   
   $sql = array("CREATE TABLE IF NOT EXISTS $table_name (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `secret_key` text NOT NULL,
  `associate_tag` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1",
"CREATE TABLE IF NOT EXISTS $product_table (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asin` varchar(255) NOT NULL,
  `title` text NOT NULL,
  `list_price` varchar(255) NOT NULL,
  `offer_price` varchar(255) DEFAULT NULL,
  `currency_code` varchar(255) NOT NULL,
  `product_group` text NOT NULL,
  `review` text,
  `image_large` text NOT NULL,
  `image_medium` text,
  `image_small` text,
  `details_url` text NOT NULL,
  `wishlist_url` text,
  `tellfriend_url` text,
  `sales_rank` varchar(255) DEFAULT NULL,
  `groupkey` text,
  `adddate` datetime DEFAULT NULL,
  `update` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB");
  
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql );
 
   add_option( "amaze_db_version", $amaze_db_version );
}
/****Short Code Handler*******/
function products_model($atts, $content = null) {
        ob_start();
        global $wpdb;
   $product_table = $wpdb->prefix . "amazonproducts";  
        wp_register_style('listproduct', plugins_url('/assets/css/style.css',__FILE__ ));
        wp_enqueue_style('listproduct');
         extract(shortcode_atts(array(
                    'id' => 'id',
                        ), $atts));
         
         $key = $atts['id'];
        $sql =" select * from `$product_table` where `groupkey` = '$key'";
        $record = $wpdb->get_results($sql);
        $html.='<div id="wrapper">';
         while($rec =  $wpdb->get_results($record,ARRAY_A)){
            $html .='<div id="columns">
                <div class="pin">
			<a href="'.$rec['details_url'].'"><img src="'.$rec['image_large'].'" /></a>
			'.substr(wp_strip_all_tags($rec['review']), 0,150).'<a href="'.$rec['details_url'].'">..<i>More</i></a>
                </div>
	</div>';
         }
          $html.='</div>';
        $content = ob_get_clean();
          return $html . $content;
    }
add_shortcode('amazon', 'products_model');

/******************/
/**Admin Menu*/
add_action( 'admin_menu', 'register_amazon_menu_page' );
function register_amazon_menu_page(){
    add_menu_page( 'Amazing Products', 'Amazon AWS', 'manage_options', 'amazing-products/amaze.php', '', plugins_url( 'amazing-products/assets/images/shopping-cart.png' ), 12 );
    add_submenu_page( 'amazing-products/amaze.php', 'New Widget', 'New widget', 'manage_options', 'amazing-products/widgt.php');
    add_submenu_page( 'amazing-products/amaze.php', 'Shortcodes', 'Shortcodes', 'manage_options', 'shortcodes.php','render_product_list_page');
}
/**JS Enquee*/
function amaze_enqueue($hook) {
    if( 'amaze.php' != $hook )
        return;
    wp_deregister_script('jquery');
    wp_register_script('jquery',plugin_dir_url( __FILE__ ) . '/assets/js/jquery.min.js', false, '1.4.2','');
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'javascript', plugin_dir_url( __FILE__ ) . '/assets/js/test.js',array('jquery') );
}
add_action( 'admin_enqueue_scripts', 'amaze_enqueue' );
/*********/

/***Ajax handler through search form****/
add_action( 'wp_ajax_add_products','prefix_ajax_add_products' );

function prefix_ajax_add_products() {
 global $wpdb; // this is how you get access to the database
 $gkey = rand(1000, 9999999999);      
 $data = $_POST['data']['ids'];
 $keys = $_POST['data']['keys'];
    foreach($data AS $key1 => $value1) {
     $out[(string)$value1] = $keys[$key1];
     }
    $i =0;
    foreach ($out as $key=>$keyid){
        $master[$keyid][$i] .=$key;
        $i++;
    }
    $j=0;
    foreach ($master as $i =>$slave){
       foreach($slave as $s=>$pd){
           $peasant[$i][$j] =$pd;
       $j++;
       }
    }
   $k=0;
 foreach($peasant as $keyss=>$products){
        $save = new amazing;
        if($save->inserter($products,$gkey))
          $save->shots($gkey);
        else
            echo 'Error';
   }
  
die(); // this is required to return a proper result
}
/***********/
/**Shortcode list tables**/
function render_product_list_page(){
    global $ListTable;
    global $wpdb;
   $product_table = $wpdb->prefix . "amazonproducts";  
  $ListTable = new Amaze_Shortcodes_List_Table();
  echo '</pre><div class="wrap"><h2>Products Group Shortcodes</h2>'; 
   if( isset($_POST['s']) ){
        $ListTable->prepare_items($_POST['s']);
        } else {
                $ListTable->prepare_items();
        }?>
 <form method="post" >
    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>">
<?php 
$ListTable->search_box( 'search', 'search-input' );
$ListTable->display(); 
  echo '</form></div>'; 
  
  if( isset( $_GET['action'] ) ) {
        if($_GET['action']=='delete'){
           $id = $_GET['id'];
           $sel = "select groupkey from  $product_table where id =$id";
           $recordset = $wpdb->get_results($sel);
           if($recordset){
           while($rec = $wpdb->get_results($recordset,ARRAY_A)){
               $keys = $rec['groupkey'];
           }
           $sql = "delete from $product_table where groupkey =$keys";
           if($wpdb->get_results($sql)){
               echo 'deleted';
           }else{
               echo 'error';
        }}
         }
  }else {
  // Show my WP_List_Table
  }
 }

function add_options() {
  global $ListTable;
  $option = 'per_page';
  $args = array(
         'label' => 'Products',
         'default' => 2,
         'option' => 'products_per_page'
         );
  add_screen_option( $option, $args );
  $ListTable = new Amaze_Shortcodes_List_Table();
}

class Amaze_Shortcodes_List_Table extends WP_List_Table {

    function __construct() {
        global $status, $page;

        parent::__construct(array(
            'singular' => __('product', 'productlisttable'), //singular name of the listed records
            'plural' => __('products', 'productlisttable'), //plural name of the listed records
            'ajax' => false        //does this table support ajax?
        ));
        add_action('admin_head', array(&$this, 'admin_header'));
    }

    function admin_header() {
        $page = ( isset($_GET['page']) ) ? esc_attr($_GET['page']) : false;
        if ('shortcodes' != $page)
            return;
        echo '<style type="text/css">';
        echo '.wp-list-table .column-id { width: 5%; }';
        echo '.wp-list-table .column-code { width: 40%; }';
        echo '.wp-list-table .column-adddate { width: 35%; }';
        echo '</style>';
    }

    function no_items() {
        _e('Nothing found, try again.');
    }

    function product_datas($search = NULL) {
        global $wpdb;
        $table_name = $wpdb->prefix . "amazonproducts";

        $sql = " select id, groupkey,adddate from `$table_name` group by groupkey";
        $query = "select * from `$table_name` group by groupkey";
        $orderby = !empty($_GET["orderby"]) ? mysql_real_escape_string($_GET["orderby"]) : 'ASC';
        $order = !empty($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : '';
        if ($search != NULL) {
            $query = "select * from `$table_name` WHERE `id` like '%$search%' OR `adddate` like '%$search%' OR `groupkey` like '%$search%'  group by groupkey";
            $record = $wpdb->get_results($query);
            $newrec = array();
            while ($rec = $wpdb->get_results($record,ARRAY_A)) {
                $newrec[] = $rec;
            }
            foreach ($newrec as $key => $code) {
                $product[$key]['groupkey'] = '[amazon id = "' . $code["groupkey"] . '"]';
                $product[$key]['id'] = $code["id"];
                $product[$key]['adddate'] = $code["adddate"];
            }

            return $product;
        } else if (!empty($orderby) & !empty($order)) {
            $query.=' ORDER BY ' . $orderby . ' ' . $order;
            $record = $wpdb->get_results($query);
            $newrec = array();
            while ($rec = $wpdb->get_results($record,ARRAY_A)) {
                $newrec[] = $rec;
            }
            foreach ($newrec as $key => $code) {
                $product[$key]['groupkey'] = '[amazon id = "' . $code["groupkey"] . '"]';
                $product[$key]['id'] = $code["id"];
                $product[$key]['adddate'] = $code["adddate"];
            }
            return $product;
        } else {
            $record = $wpdb->get_results($sql);
            $newrec = array();
            while ($rec = $wpdb->get_results($record,ARRAY_A)) {
                $newrec[] = $rec;
            }
            foreach ($newrec as $key => $code) {
                $product[$key]['groupkey'] = '[amazon id = "' . $code["groupkey"] . '"]';
                $product[$key]['id'] = $code["id"];
                $product[$key]['adddate'] = $code["adddate"];
            }
            return $product;
        }
    }

    function get_columns() {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'id' => __('ID', 'productlisttable'),
            'groupkey' => __('Code', 'productlisttable'),
            'adddate' => __('Date', 'productlisttable')
        );

        return $columns;
    }

    function get_sortable_columns() {
        $sortable_columns = array(
            'id' => array('id', false),
            'groupkey' => array('groupkey', false),
            'adddate' => array('adddate', false)
        );
        return $sortable_columns;
    }

    function usort_reorder($a, $b) {
        // If no sort, default to title
        $orderby = (!empty($_GET['orderby']) ) ? $_GET['orderby'] : 'id';
        // If no order, default to asc
        $order = (!empty($_GET['order']) ) ? $_GET['order'] : 'asc';
        // Determine sort order
        $result = strcmp($a[$orderby], $b[$orderby]);
        // Send final sort direction to usort
        return ( $order === 'asc' ) ? $result : -$result;
    }

    function column_id($item) {
        $actions = array(
            //'edit'      => sprintf('<a href="?page=%s&action=%s&book=%s">Edit</a>',$_REQUEST['page'],'edit',$item['ID']),
            'delete' => sprintf('<a href="?page=%s&action=%s&id=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['id']),
        );

        return sprintf('%1$s %2$s', $item['id'], $this->row_actions($actions));
    }

    function get_bulk_actions() {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }
    function process_bulk_action() {

        $action = $this->current_action();
    
        //Detect when a bulk action is being triggered...
        if( 'delete'===$action ) {
           
           global $wpdb;
        $table_name = $wpdb->prefix . 'amazonproducts'; // do not forget about tables prefix

        
            $ids = isset($_REQUEST['widgt']) ? $_REQUEST['widgt'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                 $sql = "select * from `$table_name` WHERE id IN($ids)";
                    $record = $wpdb->get_results($sql);
                    while($rec= $wpdb->get_results($record,ARRAY_A)){
                        $item[] .= $rec['groupkey'];
                    }
                      if (is_array($item)) $items = implode(',', $item);
                
                
             $wpdb->query("DELETE FROM $table_name WHERE groupkey IN($items)");
                
            }
        }
    }
    function column_cb($item) {
        return sprintf(
                '<input type="checkbox" name="widgt[]" value="%s" />', $item['id']
        );
    }

    function prepare_items($search = NULL) {
       

        if ($search != NULL) {
             $columns = $this->get_columns();
        $screen = get_current_screen();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        usort($this->product_datas($search), array(&$this, 'usort_reorder'));
        $this->process_bulk_action();
        $per_page = 2;
        $current_page = $this->get_pagenum();
            $total_items = count($this->product_datas($search));
            // only ncessary because we have sample data
            //$this->found_data = array_slice( $this->product_datas($search),( ( $current_page-1 )* $per_page ), $per_page );
            $this->set_pagination_args(array(
                'total_items' => $total_items, //WE have to calculate the total number of items
                'per_page' => $per_page                     //WE have to determine how many items to show on a page
            ));

            $this->items = $this->product_datas($search);
        } else {
             $columns = $this->get_columns();
        $screen = get_current_screen();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        usort($this->product_datas(), array(&$this, 'usort_reorder'));
        $this->process_bulk_action();
        $per_page = 2;
        $current_page = $this->get_pagenum();
            $total_items = count($this->product_datas());
            // only ncessary because we have sample data
            $this->found_data = array_slice($this->product_datas(), ( ( $current_page - 1 ) * $per_page), $per_page);
            $this->set_pagination_args(array(
                'total_items' => $total_items, //WE have to calculate the total number of items
                'per_page' => $per_page                     //WE have to determine how many items to show on a page
            ));

            $this->items = $this->found_data;
        }
    }

    function column_default($item, $column_name) {
        switch ($column_name) {
            case 'id':
            case 'groupkey':
            case 'adddate':
                return $item[$column_name];
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }

}

/************/
/**
 * API calling class
 */
class amazing{
    
    public function recursiveFind(array $array, $needle)
        {
            $iterator  = new RecursiveArrayIterator($array);
            $recursive = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);
            $aHitList = array();
            foreach ($recursive as $key => $value) {
                if ($key === $needle) {
                    array_push($aHitList, $value);
                }
            }
            return $aHitList;
        }
    public function fetcher($val){
        global $wpdb;
         $table_name = $wpdb->prefix . "amazonecs";
        $sql = "select `$val` from $table_name where 1" ;
        $rs=$wpdb->get_results($sql,ARRAY_N);
        if(!empty($rs)){
        return $wpdb->get_results($sql,OBJECT);
        
        } else {
            return false;
        }
    }
    public function saver($key,$skey,$astag){
            global $wpdb;
            $table_name = $wpdb->prefix . "amazonecs";
             $sql2 = "select * from $table_name where 1" ;
            $rs= $wpdb->get_results($sql2);
            if($record = $wpdb->num_rows($rs)){
                $sql ="Update $table_name SET `key`='$key',`secret_key` = '$skey',`associate_tag` = '$astag' where id = $record[0]";
                    if ($wpdb->get_results($sql)){
                        return true;}else {return false;}
                }else{
                    $sql ="insert into $table_name(`key`,`secret_key`,`associate_tag`) values('$key','$skey','$astag')";
                    if ($wpdb->get_results($sql)){
                        return true;}else {return false;}
                }
                
    }
    public function search($product,$category,$country,$page=''){
        global $wpdb;
        $pageNo = 1;
        if(isset($page)) {
            $pageNo = $page;
        }
        $table =$wpdb->prefix . 'amazonecs';
       $sql='select * from '.$table ;
//      $rec = $wpdb->get_results($sql);
      $record = $wpdb->get_results($sql,OBJECT);

      $amazonEcs = new AmazonECS($record['0']->key, $record['0']->secret_key, $country, $record->associate_tag);
    $amazonEcs->associateTag($record['0']->associate_tag);
     $response = $amazonEcs->category($category)->responseGroup('Small,ItemAttributes,OfferSummary,Images')->optionalParameters(array('ItemPage' => $pageNo))->search($product);
   // $response1 = $amazonEcs->responseGroup('Large')->optionalParameters(array('Condition' => 'New'))->lookup('B0017TZY5Y', 'B004DULNPY');
      //  print_r($response);
         
return $response;
    }
    public function inserter($products,$gkey){
        global $wpdb;
       $i=0;
        foreach ($products as $product1){
           $product[$i] .=$product1;
           $i++;
       }
       if($product[7]){
           $product[7] =$product[7];
       }else{
           $product[7] = 'No Reviews';
       }
//       if (!is_numeric($product[2]))
//                {
//                    $product[2] ='N/A';
//                }else{
//                    $product[2] =  $product[2]; 
//                }
//                if (!is_numeric($product[4]))
//                {
//                    $product[4] ='N/A';
//                }else{
//                    $product[4] =  $product[4]; 
//                }
        $sql = "INSERT INTO ".$wpdb->prefix."amazonproducts (`id`, `asin`,`image_large`, `list_price`,  `title`,`offer_price`,`details_url`,`sales_rank`, `review`,  `currency_code`, `product_group`,  `image_medium`, `image_small`, `wishlist_url`, `tellfriend_url`,  `adddate`, `update`, `status`,`groupkey`) VALUES 
                (NULL, 
                '$product[0]',
                    '$product[1]',
                        '$product[2]',
                            '$product[3]',
                                '$product[4]',
                                    '$product[5]', 
                                        '$product[6]',
                                            '$product[7]',
                                                '','','','','','',NOW(),'',1,'$gkey')";

            if($wpdb->get_results($sql)){
            return true;}else{return false;}
        }
    public function shots($key){
         global $wpdb;
        $product_table = $wpdb->prefix . "amazonproducts"; 
        $sql =" select * from $product_table where groupkey = $key";
        $record = $wpdb->get_results($sql);
    }
    public function olLiTree( $tree ) {
        $ul = '<ul>';
        foreach ( $tree as $key => $item ) {
            $ul .= "<li id=\"$key\"> $item </li>";
        }
    $ul .= '</ul>';
    return $ul;
    }
    public function postProduct($array) {
        global $wpdb;
        require_once ( ABSPATH . 'wp-admin/includes/image.php' );
        foreach($array['Items']['Item'] as $itm){ 
        $lowestPrice  = $this->recursiveFind($itm,'LowestNewPrice');
        $listPrice  = $this->recursiveFind($itm,'ListPrice');
        $largeImage  = $this->recursiveFind($itm,'LargeImage');
        $itemAttribues  = $this->recursiveFind($itm,'ItemAttributes');
        $title = $itemAttribues[0]['Title'];
        $cat = $itemAttribues[0]['Binding'];
        $subcat = $itemAttribues[0]['ProductGroup'];
        $brand = $itemAttribues[0]['Brand'];
        $feature = $this->olLiTree($itemAttribues[0]['Feature']); 
        $asin = $itm['ASIN'];
        $detUrl = $itm['DetailPageURL'];
        $loPrice = 'N/A';
        $liPrice = 'N/A';
        $largeImg = 'N/A';
            if(!empty($lowestPrice)) {
                $loPrice = $lowestPrice[0]['FormattedPrice'];
            }
            if(!empty($listPrice)) {
                $liPrice = $listPrice[0]['FormattedPrice'];
            }
            if(!empty($largeImage)) {
                $largeImg = $largeImage[0]['URL'];
            }
            
  $categ =  wp_create_category($subcat);
$feature .='<div class="entry-meta">
	<a class="" href="javascript:;" title="Lowest Price">Lowest Price: <span class="love-no">'.$loPrice.'</span></a>
	<a class="" href="javascript:;" title="0 Comments">Other Price: '.$liPrice.'</a>
        <br>
        <a class="btn" href="'.$detUrl.'" style="padding:3px 8px 5px 9px;">Go to Purchase</a>
        <br>
	<a class="permalink" href="'.$detUrl.'" title="Permalink to: '.$title.'">'.$title.'</a>
</div>';
$post = array(
  'ID'             => "", // Are you updating an existing post?
  'post_content'   => $feature,//[ <string> ] // The full text of the post.
  'post_name'      => $title,//[ <string> ] // The name (slug) for your post
  'post_title'     => $title,//[ <string> ] // The title of your post.
  'post_status'    => "publish",//[ 'draft' | 'publish' | 'pending'| 'future' | 'private' | custom registered status ] // Default 'draft'.
  'post_type'      => "post",//[ 'post' | 'page' | 'link' | 'nav_menu_item' | custom post type ] // Default 'post'.
  'post_author'    => "",//[ <user ID> ] // The user ID number of the author. Default is the current user ID.
  'ping_status'    => "closed",//[ 'closed' | 'open' ] // Pingbacks or trackbacks allowed. Default is the option 'default_ping_status'.
  'post_parent'    => "",//[ <post ID> ] // Sets the parent of the new post, if any. Default 0.
  'menu_order'     => "",//[ <order> ] // If new post is a page, sets the order in which it should appear in supported menus. Default 0.
  'to_ping'        => "",// Space or carriage return-separated list of URLs to ping. Default empty string.
  'pinged'         => "",// Space or carriage return-separated list of URLs that have been pinged. Default empty string.
  'post_password'  => "",//[ <string> ] // Password for post, if any. Default empty string.
  'guid'           => "",// Skip this and let Wordpress handle it, usually.
  'post_content_filtered' => "",// Skip this and let Wordpress handle it, usually.
  'post_excerpt'   => $feature,//[ <string> ] // For all your post excerpt needs.
  'post_date'      => "",//[ Y-m-d H:i:s ] // The time post was made.
  'post_date_gmt'  => "",//[ Y-m-d H:i:s ] // The time post was made, in GMT.
  'comment_status' => "",//[ 'closed' | 'open' ] // Default is the option 'default_comment_status', or 'closed'.
  'post_category'  => array($categ),//[ array(<category id>, ...) ] // Default empty.
  'tags_input'     => array($cat,$subcat,$brand),//[ '<tag>, <tag>, ...' | array ] // Default empty.
  'tax_input'      => "",//[ array( <taxonomy> => <array | string>, <taxonomy_other> => <array | string> ) ] // For custom taxonomies. Default empty.
  'page_template'  => ""//[ <string> ] // Requires name of template file, eg template.php. Default empty.
);  
$new_post_id  = wp_insert_post( $post );
$tag = 'post-format-gallery';
$taxonomy = 'post_format';
    wp_set_post_terms( $new_post_id, $tag, $taxonomy );
    $post_id = $new_post_id; // this value is retrived with '$post_id = wp_insert_post(....)'
    $image = imagecreatefromjpeg($largeImg);
        imagejpeg($image, ABSPATH . 'wp-content/uploads/'.$asin.".jpg");
        $filename = ABSPATH . 'wp-content/uploads/'.$asin.'.jpg';
        $wp_filetype = wp_check_filetype(basename($filename), null );
        $attachment = array(
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
            'post_content' => '',
            'post_status' => 'inherit'
        );
  $attach_id = wp_insert_attachment( $attachment, $filename, $post_id );
  $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
  wp_update_attachment_metadata( $attach_id, $attach_data );
  set_post_thumbnail( $post_id, $attach_id );
  $sql = "INSERT INTO ".$wpdb->prefix."amazonproducts (`id`, `asin`,`image_large`, `list_price`,  `title`,`offer_price`,`details_url`,`sales_rank`, `review`,  `currency_code`, `product_group`,  `image_medium`, `image_small`, `wishlist_url`, `tellfriend_url`,  `adddate`, `update`, `status`,`groupkey`) VALUES 
                (NULL, 
                '$asin',
                    '$largeImg',
                        '$liPrice',
                            '$title',
                                '$loPrice',
                                    '$detUrl',
                                        '',
                                        '',
                                                '','','','','','',NOW(),'',1,'$gkey')";

            if($wpdb->get_results($sql)){
            }else{}
   } 
    $die;
    }
}