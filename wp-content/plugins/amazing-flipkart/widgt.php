<form name ="search" method="post" action="">
    <input type='hidden' name='actiona' value='submit-form' />
    <div class="take">
        <label>Category:</label>
        <select id="category" name="category">
            <option value="DVD">DVD</option>
            <option value="Electronics">Electronics</option>
            <option value="Apparel">Apparel</option>
            <option value="Books">Books</option>
            <option value="VideoGames">VideoGames</option>
            <option value="Watches">Watches</option>
            <option value="Shoes">Shoes</option>
            <option value="Software">Software</option>
            <option value="Beauty">Beauty</option>
            <option value="All" selected="selected">All</option>
        </select>
        <label>Country:</label>
    <select id="country" name="country">
      <option value="de">DE</option>
      <option value="in" selected="selected">IN</option>
      <option value="com">USA</option>
      <option value="co.uk">ENG</option>
      <option value="ca">CA</option>
      <option value="fr">FR</option>
      <option value="co.jp">JP</option>
      <option value="it">IT</option>
      <option value="cn">CN</option>
      <option value="es">ES</option>
    </select>
        <label>Name (optional):</label><input type="text" name="product" />
        
        
        
        <label>Page:</label>
    <select id="page" name="page">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
      <option value="6">6</option>
      <option value="7">7</option>
      <option value="8">8</option>
      <option value="9">9</option>
      <option value="10">10</option>
    </select>
        <input type="submit" value="Search" /><input type="reset" value="Reset" />
    </div>
</form>
<?php $obj = new flipkartdx;
 $allproducts =   $obj->search($product, $cat, $country,$page); ?>
<?php if(isset($_GET['url'])){
   
    
 die;
 $array = json_decode(json_encode($allproducts), true);

 $test = $obj->postProduct($array)

  ?>
 <div id="wrapper">
	<div id="columns">
            <form method='post' name ="contents">
         <?php  foreach($array['Items']['Item'] as $itm){ ?>
                
		<div class="pin" id="<?php echo $itm->ASIN;?>">
			<img src="<?php echo $itm->LargeImage->URL; ?>" />
                        <input name="img" type="hidden" value="<?php echo $itm->LargeImage->URL ? $itm->LargeImage->URL :'no_image.jpg'; ?>" id="image_<?php  echo $itm->ASIN; ?>" />
                        <input name="img" type="hidden" value="<?php echo $itm->ItemAttributes->Title ? $itm->ItemAttributes->Title :'Title Not defined' ; ?>" id="title_<?php  echo $itm->ASIN; ?>" />
                        <input name="img" type="hidden" value="<?php echo $itm->ItemAttributes->ListPrice->Amount ? $itm->ItemAttributes->ListPrice->Amount :'N/A'; ?>" id="pricelist_<?php  echo $itm->ASIN; ?>" />
                        <input name="img" type="hidden" value="<?php if(!empty($itm->OfferSummary)){ echo $itm->OfferSummary->LowestNewPrice->Amount ;} else { echo 'N/A'; } ?>" id="priceoffer_<?php  echo $itm->ASIN; ?>" />
                        <input name="img" type="hidden" value="<?php echo $itm->ItemAttributes->ListPrice->CurrencyCode ?$itm->ItemAttributes->ListPrice->CurrencyCode:'N/A'; ?>" id="currency_code_<?php  echo $itm->ASIN; ?>" />
                        <input name="img" type="hidden" value="<?php echo $itm->LargeImage->URL ?$itm->LargeImage->URL:'no_image.jpg'; ?>" id="product_group_<?php  echo $itm->ASIN; ?>" />
                        <input name="img" type="hidden" value="<?php echo $itm->DetailPageURL ? $itm->DetailPageURL:'N/A'; ?>" id="details_url_<?php  echo $itm->ASIN; ?>" />
                        <input name="img" type="hidden" value="<?php echo $itm->SalesRank ?$itm->SalesRank:'N/A'; ?>" id="sales_rank_<?php  echo $itm->ASIN; ?>" />
                        <input name="img" type="hidden" value="<?php if($itm->EditorialReviews){echo $itm->EditorialReviews->EditorialReview->Content ? wp_strip_all_tags($itm->EditorialReviews->EditorialReview->Content) :'No Reviews Yet';}else{echo 'No Reviews Yet';} ?>" id="review_<?php  echo $itm->ASIN; ?>" />
                        <p>
                                <input type="checkbox" name="data[]" value='<?php echo $itm->ASIN ;?>'  id="<?php echo $itm->ASIN;?>"/>
				<?php echo substr($itm->EditorialReviews->EditorialReview->Content, 0,150); ?>
			</p>
		</div>
	<?php }?>
                <input type='submit' value='Save' />
            </form>
		
	</div>
</div>

<style>
   

#wrapper {
	width: 90%;
	max-width: 1100px;
	min-width: 800px;
	margin: 50px auto;
}

#columns {
	-webkit-column-count: 4;
	-webkit-column-gap: 10px;
	/*-webkit-column-fill: auto;*/
	-moz-column-count: 4;
	-moz-column-gap: 10px;
	/*-moz-column-fill: auto;*/
	column-count: 4;
	column-gap: 15px;
	column-fill: auto;
}

.pin {
	display: inline-block;
	background: #FEFEFE;
	border: 2px solid #FAFAFA;
	box-shadow: 0 1px 2px rgba(34, 25, 25, 0.4);
	margin: 0 2px 15px;
	-webkit-column-break-inside: avoid;
	-moz-column-break-inside: avoid;
	column-break-inside: avoid;
	padding: 15px;
	padding-bottom: 5px;
	background: -webkit-linear-gradient(45deg, #FFF, #F9F9F9);
	opacity: 1;
	
	-webkit-transition: all .2s ease;
	-moz-transition: all .2s ease;
	-o-transition: all .2s ease;
	transition: all .2s ease;
}

.pin img {
	width: 100%;
	border-bottom: 1px solid #ccc;
	padding-bottom: 15px;
	margin-bottom: 5px;
}

.pin p {
	font: 12px/18px Arial, sans-serif;
	color: #333;
	margin: 0;
}

@media (min-width: 960px) {
	#columns {
		-webkit-column-count: 3;
		-moz-column-count: 3;
		column-count:3;
	}
}

@media (min-width: 1100px) {
	#columns {
		-webkit-column-count: 4;
		-moz-column-count: 4;
		column-count: 4;
	}
}
#columns:hover .pin:not(:hover) {
	/*opacity: 0.4;*/
}
</style>
<?php
} ?>

<script>
   var $=jQuery;
  $(document).ready(function(){
        var keys = [];
        var values = [];
       $('form[name=contents]').submit(function() {
        //var dataToPost = $(this).find('.sideon :input').serialize();
        //$.post(this.action, dataToPost, function(result) {
       //  $.post($("#content").serialize())
        var searchIDs= $(".pin input:checkbox:checked").map(function(){
      return $(this).val();
    });

   // var toydata = $.parseJSON(searchIDs);
    
    
           var image = $(".pin input:checkbox:checked").map(function(){
            var id = $(this).val();
        return $(this).parent().parent().find('#image_'+id).val();
    });
    
    var listprice = $(".pin input:checkbox:checked").map(function(){
            var id = $(this).val();
        return $(this).parent().parent().find('#pricelist_'+id).val();
    });
    var title = $(".pin input:checkbox:checked").map(function(){
            var id = $(this).val();
        return $(this).parent().parent().find('#title_'+id).val();
    });
     var offerprice = $(".pin input:checkbox:checked").map(function(){
            var id = $(this).val();
        return $(this).parent().parent().find('#priceoffer_'+id).val();
    });
     var currency = $(".pin input:checkbox:checked").map(function(){
            var id = $(this).val();
        return $(this).parent().parent().find('#currency_code_'+id).val();
    });
     var group = $(".pin input:checkbox:checked").map(function(){
            var id = $(this).val();
        return $(this).parent().parent().find('#product_group_'+id).val();
    });
     var detail_url = $(".pin input:checkbox:checked").map(function(){
            var id = $(this).val();
        return $(this).parent().parent().find('#details_url_'+id).val();
    });
    var sales_rank = $(".pin input:checkbox:checked").map(function(){
            var id = $(this).val();
        return $(this).parent().parent().find('#sales_rank_'+id).val();
    });
    var review = $(".pin input:checkbox:checked").map(function(){
            var id = $(this).val();
        return $(this).parent().parent().find('#review_'+id).val();
    });
    $.each(searchIDs,function(key,value){
        keys.push(key);
        values.push(value);
    })
    $.each(image,function(key,value){
        keys.push(key);
        values.push(value);
    })
    $.each(listprice,function(key,value){
        keys.push(key);
        values.push(value);
    })
    $.each(title,function(key,value){
        keys.push(key);
        values.push(value);
    })
//    $.each(currency,function(key,value){
//        keys.push(key);
//        values.push(value);
//    })
    $.each(offerprice,function(key,value){
        keys.push(key);
        values.push(value);
    })
    $.each(group,function(key,value){
        keys.push(key);
        values.push(value);
    })
    $.each(detail_url,function(key,value){
        keys.push(key);
        values.push(value);
    })
    $.each(sales_rank,function(key,value){
        keys.push(key);
        values.push(value);
    })
    $.each(review,function(key,value){
        keys.push(key);
        values.push(value);
    })
    console.log(values);console.log(keys);
    var page = $("#page").val();
    ids = [];
    jQuery.post(
    ajaxurl, 
    {
        'action': 'add_products',
        'data': {ids:values,keys:keys;page:page}
    }, 
    function(response){
//        alert('The server responded: ' + response);
    }
);
        return false;
    });
  })  
//  function caller(keyw,result){
//$.ajax({
//url: 'http://gdata.youtube.com/feeds/base/videos/-/'+keyw+'?max-results='+result+'&alt=json&format=5',
//data: $('.content').val(),
//dataType:'json',
//success:function(response){
//    var obj=response.feed.entry;
//    $(obj).each(function(index){
//     //  alert (index);
//     //   $('.content').append(this.content.$t);
//       var title=this.title.$t;
//       var link= this.link[0].href;
//       var author= this.author[0].name.$t;
//       var published= this.published.$t;
//       var id = this.id.$t;
//       var pk = id.substr(id.length - 11);
//     
//        var MyDate = new Date( Date.parse(published.replace(/ *\(.*\)/,"")));
//        var date_Str = MyDate.getMonth() + 1  + "/" + MyDate.getDate() +   "/" +  MyDate.getFullYear();
//      // console.log(link)
//       var img = $('<div>' + this.content.$t + '</div>').find('img[src$=".jpg"]').attr('src');
//       var span = $('<div>' + this.content.$t + '</div>').find('span').text();
//      
//    //  var span=this.content.$t.span;
//       $('#content').append('<div class ="ycontainer"><input type = "hidden" id="link_'+pk+'" name="vidoes[link]"value="'+link+'"><input type = "hidden" id ="date_'+pk+'" name="vidoes[img]"value="'+date_Str+'"><input type = "hidden" name="vidoes[img]"value="'+img+'"><input type = "hidden" id="title_'+pk+'" name="vidoes[title]"value="'+title+'"><input type = "hidden"  id="author_'+pk+'" name="vidoes[author]"value="'+author+'"><input type = "hidden" name="vidoes[intro]"value="'+span+'"><div class ="yimage"><a href="'+link+'"><img src = "'+img+'"></a></div><div class=inner><div class="ytitle"><a href="'+link+'">'+title+'</a></div><div class="yspan">'+span+'</div><div class="yauthor"><span style="font-weight:bold">Author: </span><i>'+author+'</i></div><div class="ypublished"><span style="font-weight:bold">Date:</span> '+date_Str+'</div><input type="checkbox" name="vidoes[vid]" value="'+pk+' "id="cont" url="http://www.youtube.com/watch?v=Jzxc_rR6S-U&amp;feature=youtube_gdata" author="Google Chrome" date="21/4/2014" content="youtube google" style="margin-left:110px;margin-top:5px;" ></div></div></div>');
////      var url = $('#cont').attr('url');
//    });
//      
//        //console.log(response.feed.entry)
//}}); }
       
</script>