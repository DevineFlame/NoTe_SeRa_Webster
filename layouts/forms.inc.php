<?php

function form_start($action='', $class='', $enctype='') {
    echo '
    <form method="post" class="',($class ? $class : 'form-horizontal'),'"',($enctype ? ' enctype="'.$enctype.'"' : ''),'',($action ? ' action="'.CONFIG_SITE_URL.$action.'"' : ''),' role="form">
    ';

    //form_xsrf_token();
}

function form_end() {
    echo '</form>';
}

function form_hidden ($name, $value) {
    $name = htmlspecialchars($name);
    $field_name = strtolower(str_replace(' ','_',$name));
    echo '<input type="hidden" name="',$field_name,'" value="',htmlspecialchars($value),'" />';
}

function form_file ($name,$accept='') {
    $name = htmlspecialchars($name);
    $field_name = strtolower(str_replace(' ','_',$name));
    echo '<input type="file" name="',$field_name,'" id="',$field_name,'" accept="',$accept,'"/>';
}
function form_file_editable ($name,$accept='') {
    $name = htmlspecialchars($name);
    $field_name = strtolower(str_replace(' ','_',$name));
	echo '<div class="form-group">';
    echo '<input type="file" name="',$field_name,'" id="',$field_name,'" accept="',$accept,'" disabled/>';
	echo '<p align="center"><button class="btn btn-primary btn-sm upld_img" type="button"><i class="glyphicon glyphicon-edit" aria-hidden="true"></i> Change</button></div>';
	
}
function form_input_text($name, $prefill = false, array $options = null,$class="" ) {
    $name = htmlspecialchars($name);
    $field_name = strtolower(str_replace(' ','_',$name));
    echo '
    <div class="form-group" id="fg_',$field_name,'">
      <label class="col-sm-3 control-label" for="',$field_name,'">',$name,'</label>
      <div class="col-sm-9">
          <input
            type="text"
            id="',$field_name,'"
            name="',$field_name,'"
            class="form-control ',$class,'"
            placeholder="',$name,'"
            ',($prefill !== false ? ' value="'.htmlspecialchars($prefill).'"' : ''),'
            ',(array_get($options, 'disabled') ? ' disabled' : ''),'
            ',(array_get($options, 'autocomplete') ? ' autocomplete="'.$options['autocomplete'].'"' : ''),'
            ',(array_get($options, 'autofocus') ? ' autofocus' : ''),'
			',(array_get($options, 'required') ? ' required' : ''),'
			',(array_get($options, 'readonly') ? ' readonly' : ''),'
			',(array_get($options, 'list') ? ' list="'.$options['list'].'"' : ''),'
			',(array_get($options, 'pattern') ? ' pattern="'.$options['pattern'].'"' : ''),'
          />
      </div>
    </div>
    ';
}

function form_input_text_editable_spcl($name, $prefill = false, array $options = null,$class="" ) {
    $name = htmlspecialchars($name);
    $field_name = strtolower(str_replace(' ','_',$name));
    echo '
    <div class="form-group" id="fg_',$field_name,'">
      <label class="col-sm-3 control-label" for="',$field_name,'">',$name,'</label>
      <div class="col-sm-9">
	  	<div class="input-group">
          <input
            type="text"
            id="',$field_name,'"
            name="',$field_name,'"
            class="form-control ',$class,'"
            placeholder="',$name,'"
            ',($prefill !== false ? ' value="'.htmlspecialchars($prefill).'"' : ''),'
            ',(array_get($options, 'disabled') ? ' disabled' : ''),'
            ',(array_get($options, 'autocomplete') ? ' autocomplete="'.$options['autocomplete'].'"' : ''),'
            ',(array_get($options, 'autofocus') ? ' autofocus' : ''),'
			',(array_get($options, 'required') ? ' required' : ''),'
			',(array_get($options, 'readonly') ? ' readonly' : ''),'
			',(array_get($options, 'list') ? ' list="'.$options['list'].'"' : ''),'
			',(array_get($options, 'pattern') ? ' pattern="'.$options['pattern'].'"' : ''),'
          />
		  <span class="input-group-btn">
			<button class="btn btn-warning edit_fld" type="button"><i class="glyphicon glyphicon-edit" aria-hidden="true"></i>&nbsp;</button>
		  </span>
		 </div>
      </div>
    </div>
    ';
}

function form_input_password($name, $prefill = false, array $options = null) {
    $name = htmlspecialchars($name);
    $field_name = strtolower(str_replace(' ','_',$name));
    echo '
    <div class="form-group" id="fg_',$field_name,'">
      <label class="col-sm-3 control-label" for="',$field_name,'">',$name,'</label>
      <div class="col-sm-9">
          <input type="password" id="',$field_name,'" name="',$field_name,'" class="form-control" placeholder="',$name,'"',($prefill !== false ? ' value="'.htmlspecialchars($prefill).'"' : ''),'',($options['disabled'] ? ' disabled' : ''),' required />
      </div>
    </div>
    ';
}

/*function form_input_captcha($position = 'private') {

    if (($position == 'private' && CONFIG_RECAPTCHA_ENABLE_PRIVATE) || ($position == 'public' && CONFIG_RECAPTCHA_ENABLE_PUBLIC)) {
        echo '
        <div class="form-group">
          <label class="col-sm-2 control-label" for="captcha"></label>
          <div class="col-sm-10">';

        display_captcha();

        echo '</div>
        </div>
        ';
    }
}*/

function form_input_checkbox ($name, $checked = 0) {
    $name = htmlspecialchars($name);
    $field_name = strtolower(str_replace(' ','_',$name));
    echo '
    <div class="form-group" id="fg_',$field_name,'">
      <label class="col-sm-3 control-label" for="',$field_name,'">',$name,'</label>
      <div class="col-sm-9">
          <input type="checkbox" id="',$field_name,'" name="',$field_name,'" value="1"',($checked ? ' checked="checked"' : ''),' />
      </div>
    </div>
    ';
}

function form_generic ($name, $generic) {
    $name = htmlspecialchars($name);
    $field_name = strtolower(str_replace(' ','_',$name));
    echo '
    <div class="form-group" id="fg_',$field_name,'">
      <label class="col-sm-3 control-label" for="',$field_name,'">',$name,'</label>
      <div class="col-sm-9">
          ',$generic,'
      </div>
    </div>
    ';
}

function form_textarea($name, $prefill = false) {
    $name = htmlspecialchars($name);
    $field_name = strtolower(str_replace(' ','_',$name));
    echo '
    <div class="form-group" id="fg_',$field_name,'">
      <label class="col-sm-3 control-label" for="',$field_name,'">',$name,'</label>
      <div class="col-sm-9">
          <textarea id="',$field_name,'" name="',$field_name,'" class="form-control" rows="6" ',($prefill !== false ? 'placeholder="'.htmlspecialchars($prefill).'"' : ''),'></textarea>
      </div>
    </div>
    ';
}

function form_button_submit ($name, $type = 'primary') {
    $name = htmlspecialchars($name);
    $field_name = strtolower(str_replace(' ','_',$name));
    echo '
    <div class="form-group" id="fg_',$field_name,'">
      <label class="col-sm-3 control-label" for="',$field_name,'"></label>
      <div class="col-sm-9">
          <button type="submit" id="',$field_name,'" class="btn btn-',htmlspecialchars($type),'">',$name,'</button>
      </div>
    </div>
    ';
}

function form_select ($opts, $name, $selected = null,$multi=false,$class="",$option='') {
    $name = htmlspecialchars($name);
    $field_name = strtolower(str_replace(' ','_',$name)).($multi?'[]':'');
    echo '
    <div class="form-group" id="fg_',$field_name,'">
        <label class="col-sm-3 control-label" for="',$field_name,'">',$name,'</label>
        <div class="col-sm-9">

        <select id="',$field_name,'" name="',$field_name,'" class="form-control ',$class,'" ',$multi?'multiple':'',' ',$option,'>
		';

    $group = '';
	if($multi)
		$selected=explode('~',$selected);
    foreach ($opts as $value=>$option) {
		if($multi){
		echo '<option value="',htmlspecialchars($value),'"',((in_array($value,$selected)) ? ' selected' : ''),'>', htmlspecialchars($option), '</option>
		';
		}
		else
        echo '<option value="',htmlspecialchars($value),'"',($value == $selected ? ' selected="selected"' : ''),'>', htmlspecialchars($option), '</option>
		';
    }
  echo '
        </select>

        </div>
    </div>
    ';
}

function form_select_options ($opts, $selected = '') {
    
    foreach ($opts as $value=>$option) {
        echo '<option value="',htmlspecialchars($value),'"',($value == $selected ? ' selected="selected"' : ''),'>', htmlspecialchars($option), '</option>
		';
    }
 
}

function form_datalist_options($opts){
	//echo '<datalist id="dl_',$name,'">';
	foreach($opts as $val){
		echo '<option value="',$val,'">
		';
	}
	//echo '</datalist>';
}

function form_inline_checkbox ($name, array $options, $selected = false) {
    $name = htmlspecialchars($name);
    $field_name = strtolower(str_replace(' ','_',$name));
    echo '
    <div class="form-group" id="fg_',$field_name,'">
      <label class="col-sm-3 control-label" for="',$field_name,'">',$name,'</label>
	  <div class="col-sm-9">';
    	foreach($options as $val=>$nam){
			echo '<label class="radio-inline">
					<input type="radio" name="',$field_name,'" id="',$field_name,$val,'" value="',htmlspecialchars($val),'"',($val == $selected ? ' checked="checked"' : ''),'>',$nam,'</label>&nbsp;&nbsp;&nbsp;
					';
	}
    echo '</div></div>
	';
}
/*function form_bbcode_manual() {
    echo '
    <div class="form-group">
      <label class="col-sm-2 control-label" for="bbcode">BBcode</label>
      <div class="col-sm-10">';
    bbcode_manual();
    echo '
      </div>
    </div>
    ';
}*/

/*function form_logout() {
    echo '
    <form action="/actions/logout" method="post">
        ',form_xsrf_token(),'
        <input type="submit" value="Log out" />
    </form>
    ';
}*/

/*function year_select() {
    $years = db_select_all(
        'years',
        array(
            'id',
            'year_name'
        ),
        null,
        'year_name ASC'
    );

    echo '<select name="year" class="form-control" required="required">
            <option disabled selected>-- Please select --</option>';

    foreach ($years as $year) {
        echo '<option value="',htmlspecialchars($year['id']),'">',htmlspecialchars($year['year_name']),'</option>';
    }

    echo '</select>';
}*/

/*function dynamic_visibility_select($selected = null) {
    $options = array(
        array(
            'val'=>CONST_DYNAMIC_VISIBILITY_BOTH,
            'opt'=>visibility_enum_to_name(CONST_DYNAMIC_VISIBILITY_BOTH)
        ),
        array(
            'val'=>CONST_DYNAMIC_VISIBILITY_PRIVATE,
            'opt'=>visibility_enum_to_name(CONST_DYNAMIC_VISIBILITY_PRIVATE)
        ),
        array(
            'val'=>CONST_DYNAMIC_VISIBILITY_PUBLIC,
            'opt'=>visibility_enum_to_name(CONST_DYNAMIC_VISIBILITY_PUBLIC)
        )
    );

    form_select($options, 'Visibility', 'val', $selected, 'opt');
}*/

/*function user_class_select($selected = null) {
    $options = array(
        array(
            'val'=>CONST_USER_CLASS_USER,
            'opt'=>user_class_name(CONST_USER_CLASS_USER)
        ),
        array(
            'val'=>CONST_USER_CLASS_MODERATOR,
            'opt'=>user_class_name(CONST_USER_CLASS_MODERATOR)
        )
    );

    form_select($options, 'Min user class', 'val', $selected, 'opt');
}*/