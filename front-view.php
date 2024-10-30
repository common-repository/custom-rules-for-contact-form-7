<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<script type="text/javascript">
jQuery( document ).ready(function() {
crcf7_skip_warning=0;
crcf7_rule_should_work=0;
function crcf7_rule_checker(event){
  var maincontent=jQuery(".wpcf7-textarea").val();
  if (crcf7_skip_warning==1) return;

  var crcf7_rules="<?php
echo esc_html(addslashes($crcf7_relateds_meta['crcf7_itself'][0]));
?>";
  crcf7_rules_split=crcf7_rules.split(",");
  for (i=0;i<crcf7_rules_split.length;i++) {
    if (maincontent.indexOf(crcf7_rules_split[i])>-1) crcf7_rule_should_work=1;
  }
  if (crcf7_rule_should_work==1) {
    jQuery("#crcf7_centered_box").html("<?php
echo addslashes(wp_kses_data($crcf7_relateds_post->post_content));
?>");
    var href = jQuery('#modaltrigger').attr('href');
        window.location.href = href;
    event.preventDefault();
  }
  
}
  jQuery(".wpcf7").submit(function(){
    crcf7_rule_checker(event);
  });
  jQuery(".wpcf7 input[type=submit]").click(function(){
    crcf7_rule_checker(event);
  });
  jQuery(".crcf7 .skipit").click(function(){crcf7_skip_warning=1;});
  
});
</script>
<div class="crcf7">
<a href="#modal-one" id="modaltrigger"></a>
<div class="modal" id="modal-one" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-header">
      <h2><?php
echo esc_html($crcf7_relateds_post->post_title);
?></h2>
      <a href="#close" class="btn-close" aria-hidden="true">×</a> <!--CHANGED TO "#close"-->
    </div>
    <div class="modal-body" id="crcf7_centered_box">
    
    </div>
    <div class="modal-footer">
    <?php
if ($crcf7_relateds_meta['crcf7_type'][0] != '') {
?>
      <a href="#close" class="btn skipit"><?php
    echo esc_html($crcf7_relateds_meta['crcf7_buttontext'][0]);
?></a> 
      <?php
}
?>
    </div>
    </div>
  </div>
  </div>
<style>
.crcf7 .btn{background:#428bca;border:1px solid #357ebd;border-radius:3px;color:#fff;display:inline-block;font-size:14px;padding:8px 15px;text-decoration:none;text-align:center;min-width:60px;position:relative;transition:color .1s ease}.crcf7 .btn:hover{background:#357ebd}.crcf7 .btn.btn-big{font-size:18px;padding:15px 20px;min-width:100px}.crcf7 .btn-close{color:#aaa;font-size:30px;text-decoration:none;position:absolute;right:5px;top:0}.crcf7 .btn-close:hover{color:#919191}.crcf7 .modal:before{content:"";display:none;background:rgba(0,0,0,.6);position:fixed;top:0;left:0;right:0;bottom:0;z-index:10}.crcf7 .modal:target:before{display:block}.crcf7 .modal:target .modal-dialog{-webkit-transform:translate(0,0);-ms-transform:translate(0,0);transform:translate(0,0);top:20%}.crcf7 .modal-dialog{background:#fefefe;border:1px solid #333;border-radius:5px;margin-left:auto;margin-right:auto;position:fixed;left:25%;top:-100%;z-index:11;width:50%;-webkit-transform:translate(0,-500%);-ms-transform:translate(0,-500%);transform:translate(0,-500%);-webkit-transition:-webkit-transform .3s ease-out;-moz-transition:-moz-transform .3s ease-out;-o-transition:-o-transform .3s ease-out;transition:transform .3s ease-out}.crcf7 .modal-body{padding:20px}.crcf7 .modal-footer,.crcf7 .modal-header{padding:10px 20px}.crcf7 .modal-header{border-bottom:#eee solid 1px}.crcf7 .modal-header h2{font-size:20px}.crcf7 .modal-footer{border-top:#eee solid 1px;text-align:right}.crcf7 #close{display:none}
</style>