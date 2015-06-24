<?php
/**
 * @package Amazing_Flipkart
 * @version 1.0
Plugin Name: Amazing Flipkart
Plugin URI: http://adalbadall.com/
Description: This plugin is used to make the site flipkart based widgets.
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

require_once AMAZE_PLUG_DIR . '/lib/Flipkart.class.php';
/******************/
/**Admin Menu*/
add_action( 'admin_menu', 'register_flipkart_menu_page' );
function register_flipkart_menu_page(){
    add_menu_page( 'Amazing Flipkart', 'Flipkart', 'manage_options', 'amazing-flipkart/widgt.php', '', plugins_url( 'amazing-flipkart/assets/images/shopping-cart.png' ), 12 );
    add_submenu_page( 'amazing-flipkart/amaze.php', 'New Widget', 'New widget', 'manage_options', 'amazing-flipkart/widgt.php');
}
/**JS Enquee*/
function flipkart_enqueue($hook) {
    if( 'amaze.php' != $hook )
        return;
    wp_deregister_script('jquery');
    wp_register_script('jquery',plugin_dir_url( __FILE__ ) . '/assets/js/jquery.min.js', false, '1.4.2','');
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'javascript', plugin_dir_url( __FILE__ ) . '/assets/js/test.js',array('jquery') );
}
add_action( 'admin_enqueue_scripts', 'flipkart_enqueue' );
/*********/

/***Ajax handler through search form****/
add_action( 'wp_ajax_add_products','flipkart_ajax_add_products' );

function flipkart_ajax_add_products() {
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
/**
 * API calling class
 */
class flipkartdx{
    
   
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
        $record = $wpdb->get_results($sql,OBJECT);
        
        $flipkart = new Flipkart("marjss21g", "b329faed5f2440ad925b2f6fcaf125fb", "json");
       
        $dotd_url = 'https://affiliate-api.flipkart.net/affiliate/offers/v1/dotd/json';
        $topoffers_url = 'https://affiliate-api.flipkart.net/affiliate/offers/v1/top/json';
        //To view category pages, API URL is passed as query string.
        $url = isset($_GET['url'])?$_GET['url']:false;
       
        if($url){
                //URL is base64 encoded to prevent errors in some server setups.
                $url = base64_decode($url);

                //This parameter lets users allow out-of-stock items to be displayed.
                $hidden = isset($_GET['hidden'])?false:true;

                //Call the API using the URL.
                $details = $flipkart->call_url($url);

                if(!$details){
                        echo 'Error: Could not retrieve products list.';
                        exit();
                }

                //The response is expected to be JSON. Decode it into associative arrays.
                $details = json_decode($details, TRUE);

                //The response is expected to contain these values.
                $nextUrl = $details['nextUrl'];
                $validTill = $details['validTill'];
                $products = $details['productInfoList'];
                //The navigation buttons.
                echo '<h2><a href="?">HOME</a> | <a href="?url='.base64_encode($nextUrl).'">NEXT >></a></h2>';

                //Message to be displayed if out-of-stock items are hidden.
                if($hidden)
                        echo 'Products that are out of stock are hidden by default.<br><a href="?hidden=1&url='.base64_encode($url).'">SHOW OUT-OF-STOCK ITEMS</a><br><br>';

                //Products table
                echo "<table border=2 cellpadding=10 cellspacing=1 style='text-align:center'>";
                $count = 0;
                $end = 1;

                //Make sure there are products in the list.
                if(count($products) > 0){
                        foreach ($products as $product) {
                            $cat =  $this->recursiveFind($product['productBaseInfo']['productIdentifier'],'title');
                            $cats = explode("_",$cat[0]);
                            $newcat= array_map('ucfirst', $cats);
                            $categ = implode(" ", $newcat);
                            echo '<pre>';
                            print_r($product);
                            echo'</pre>';
                            die;





                            //Hide out-of-stock items unless requested.
                                $inStock = $product['productBaseInfo']['productAttributes']['inStock'];
                                if(!$inStock && $hidden)
                                        continue;

                                //Keep count.
                                $count++;

                                //The API returns these values nested inside the array.
                                //Only image, price, url and title are used in this demo
                                $productId = $product['productBaseInfo']['productIdentifier']['productId'];
                                $title = $product['productBaseInfo']['productAttributes']['title'];
                                $productDescription = $product['productBaseInfo']['productAttributes']['productDescription'];

                                //We take the 200x200 image, there are other sizes too.
                                $productImage = array_key_exists('400x400', $product['productBaseInfo']['productAttributes']['imageUrls'])?$product['productBaseInfo']['productAttributes']['imageUrls']['200x200']:'';
                                $loPrice = $product['productBaseInfo']['productAttributes']['sellingPrice']['amount'];
                                $liPrice = $product['productBaseInfo']['productAttributes']['maximumRetailPrice']['amount'];
                                $productUrl = $product['productBaseInfo']['productAttributes']['productUrl'];
                                $productBrand = $product['productBaseInfo']['productAttributes']['productBrand'];
                                $color = $product['productBaseInfo']['productAttributes']['color'];
                                $detUrl = $product['productBaseInfo']['productAttributes']['productUrl'];
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
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                //Setting up the table rows/columns for a 3x3 view.
                                $end = 0;
                                if($count%3==1)
                                        echo '<tr><td>';
                                else if($count%3==2)
                                        echo '</td><td>';
                                else{
                                        echo '</td><td>';
                                        $end =1;
                                }

                                echo '<a target="_blank" href="'.$productUrl.'"><img src="'.$productImage.'"/><br>'.$title."</a><br>Rs. ".$sellingPrice;

                                if($end)
                                        echo '</td></tr>';

                        }
                }

                //A message if no products are printed.	
                if($count==0){
                        echo '<tr><td>The retrieved products are not in stock. Try the Next button or another category.</td><tr>';
                }

                //A hack to make sure the tags are closed.	
                if($end!=1)
                        echo '</td></tr>';

                echo '</table>';

                //Next URL link at the bottom.
                echo '<h2><a href="admin.php?page=amazing-flipkart/widgt.php&?url='.base64_encode($nextUrl).'">NEXT >></a></h2>';

                //That's all we need for the category view.
                exit();
        }
        $home = $flipkart->api_home();
//Make sure there is a response.
if($home==false){
	echo 'Error: Could not retrieve API homepage';
	exit();
}
//Convert into associative arrays.
$home = json_decode($home, TRUE);
$list = $home['apiGroups']['affiliate']['apiListings'];

//Create the tabulated view for different categories.
echo '<table border=2 style="text-align:center;">';
$count = 0;
$end = 1;
foreach ($list as $key => $data) {
	$count++;
	$end = 0;
	//To build a 3x3 table.
	if($count%3==1)
		echo '<tr><td>';
	else if($count%3==2)
		echo '</td><td>';
	else{
		echo '</td><td>';
		$end =1;
	}
	echo "<strong>".$key."</strong>";
	echo "<br>";
	//URL is base64 encoded when sent in query string.
	echo '<a href="admin.php?page=amazing-flipkart/widgt.php&url='.base64_encode($data['availableVariants']['v0.1.0']['get']).'">View Products &raquo;</a>';
}
if($end!=1)
	echo '</td></tr>';
echo '</table>';

//return $response;
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