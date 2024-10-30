<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div class="wrap">

<h1>Custom rules and warnings for Contact form 7</h1>

<p class="submit"><a name="addnew" class="button button-primary" href="?page=custom-rules-contact-form-7%2Fcustom-rules-contact-form-7.php&addnew=0">Add new</a></p>

<?php
if ($gpid === 0 or $gpid > 0) {
?><hr>
	<h2>Add/edit rule </h2>
<form method="post" action="?page=custom-rules-contact-form-7%2Fcustom-rules-contact-form-7.php">
<input type="hidden" name="pid" value="<?php
    echo $gpid;
?>">
<?php
    wp_nonce_field('add_rule_cf');
?>
<table class="form-table">
<tbody>

<tr><td>Rule title</td><td><input type="text" name="crcf7_title" value="<?php
    echo crcf7_value('crcf7_title', $gpid);
?>"></td></tr>
<tr><td>Rule itself</td><td><textarea name="crcf7_itself" style="width:400px" rows="4"><?php
    echo crcf7_value('crcf7_itself', $gpid);
?></textarea>
<br>
Type here comma separated words and if one of them will be typed by your visitor, he/she will be see the warning dialog before the submit. (f.e.  computer,restart,linux)
</td></tr>
<tr><td>Rule type</td><td><label><input type="checkbox" name="crcf7_type" value="1" 
<?php
    echo crcf7_value('crcf7_type', $gpid) != '' ? 'checked' : '';
?>
>Rule is skippable</label><br>
<small>If to choose it, the rule message would be skippable. After first warning the user would be able to skip it and send the message.</small>
</td></tr>
<tr><td>Rule skip button text</td><td><input type="text" name="crcf7_buttontext" value="<?php
    echo crcf7_value('crcf7_buttontext', $gpid);
?>"></td></tr>
<tr><td>Dialog message</td><td><textarea name="crcf7_message" style="width:400px" rows="4"><?php
    echo crcf7_value('crcf7_message', $gpid);
?></textarea></td></tr>
<tr><td>Related Contact Forms</td><td><input type="text" name="crcf7_relateds" value="<?php
    echo crcf7_value('crcf7_relateds', $gpid);
?>"> <br><small>
	Type comma separated ID numbers of Contact Forms which would be affected by this rule. If you want all forms to be affected, type *
</small></td></tr>

</tbody></table>
	<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save the rule"></p>

</form><hr>
	<?php
}
?>



<h2>Existing Rules</h2>
<table class="form-table">
<tbody>
<?php
foreach ($rules as $key => $value) {
?>
<tr>
<th scope="row" style="width:40%"><?php
    echo $value->post_title;
?></th>
<td><a href="?page=custom-rules-contact-form-7%2Fcustom-rules-contact-form-7.php&addnew=<?php
    echo $value->ID;
?>">Edit</a> 
<a href="<?php
    echo wp_nonce_url('?page=custom-rules-contact-form-7%2Fcustom-rules-contact-form-7.php&remove_rule=' . $value->ID, 'trash-rule-' . $value->ID);
?>" 
onclick="return confirm('Are you sure to remove this rule? The process can\'t be undone')" 
>Trash</a> </td>
</tr>
<?php
}
?>


</tbody>
</table>

<br><br><br><br>
<h2>Customizing</h2>
Here is CSS classes of the plugin:<br>
<small>
Skip button: .crcf7 .modal-footer a<br/>
Dialog text: .crcf7 .modal-body<br/>
Dialog title: .crcf7 .modal-header h2<br/>
Dialog itself: .crcf7 .modal-dialog<br/>
</small>

<br><br><br>

<h3><a href="https://codecanyon.net/user/guaven/portfolio?ref=Guaven" target="_blank">Click To See Useful Guaven Plugins You May Like</a></h3>

</div>