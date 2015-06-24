<h1>Amazon Settings</h1>
<hr/>
<?php $am_values = new amazing;

?>
<form method="POST">
<p>
            <label for ='amazon_api_key'>API Key</label>
            <input type='text' name='amazon_api_key' id='amazon_api_key' value="<?php echo isset($am_values->fetcher('key')->key) ? $am_values->fetcher('key')->key:'' ; ?>" />
        </p>
        
        <p>
            <label for ='amazon_secret_key'>Secret Key</label>
            <input type='text' name='amazon_secret_key' id='amazon_secret_key' value="<?php echo $am_values->fetcher('secret_key')->secret_key; ?>"  />
        </p>
         <p>
            <label for ='amazon_associate_tag'>Associate tag</label>
            <input type='text' name='amazon_associate_tag' id='amazon_associate_tag' value="<?php echo $am_values->fetcher('associate_tag')->associate_tag; ?>" />
        </p>
         <p>
            <label for ='amazon_check'>Test your credentials here</label>
            <input type='submit' name='amazon_check' id='amazon_check' value='Test'>
        </p>
</form>
        <?php $amaze = new amazing;
        if(isset($_POST['amazon_api_key']) && isset($_POST['amazon_secret_key']) && isset($_POST['amazon_associate_tag'])){
        
        $key    =   $_POST['amazon_api_key'];
        $skey   =   $_POST['amazon_secret_key'];
        $asso_tag=  $_POST['amazon_associate_tag'];
        $checker = $amaze->tester($key,$skey,$asso_tag);
        if($checker){
            echo '<form method="POST" name="submittor">
                    <input type="hidden" value="'.$key.'" name="key1" /><input type="hidden" value="'.$skey.'" name="skey1"/><input type="hidden" value="'.$asso_tag.'" name="assoc_tag1" />
                    All credentials the successfully validate.Do you want to save these settings? 
                    <input type ="submit" id = "submit" value = "YES" />
                    <input type ="Reset" value = "NO"  /></form>
                    ';}else {echo '';}
        }
        if(isset($_POST['key1']) && isset($_POST['skey1']) && isset($_POST['assoc_tag1'])){
        if($amaze->saver($_POST['key1'],$_POST['skey1'] , $_POST['assoc_tag1'])){
            echo 'All settings are saved now.';die;
                }else { echo 'Eror';die;}
            
        }
function _handle_form_action(){

    {echo 'hello'; }

}
        ?>
<script>
    var $=jQuery;
//    function submittor(key,skey,asso_tag){
//        var chk =  <?php // $amaze->saver($key, $skey, $astag)?>
//       }
   $(document).ready(function(){
       
});
    </script>
    