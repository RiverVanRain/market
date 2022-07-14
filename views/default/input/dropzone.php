<?php
/**
 * Drag and drop file upload input
 *
 * @uses $vars['class'] CSS classes to apply to the dropzone
 * @uses $vars['name'] Name of the input that you can use in your action. Defaults to file_guids
 * @uses $vars['value'] Were any files uploaded using this dropzone previously? Will the files be overwritten?
 * @uses $vars['multiple'] Allow multiple file uploads
 * @uses $vars['max'] Maximum number of files to handle, defaults to 10
 * @uses $vars['max_filesize'] Maximum file size to upload in MB, defaults by server configuration for filesize upload limitations
 * @uses $vars['accept'] File types to accept
 * @uses $vars['action'] Alternative elgg action to handle temporary file uploads. Defaults to 'action/dropzone/upload'
 * @uses $vars['container_guid'] GUID of the container entity to which new files should be uploaded
 * @uses $vars['subtype'] Subtype of the file to be created
 * @uses $vars['query'] Additional data to pass with the request
 */
$uid = substr(md5(microtime() . rand()), 0, 10);
$options['id'] = "dropzone-$uid";
$fallback_input_id = "dropzone-fallback-$uid";
$vars['id'] = $options['data-fallback-id'] = $fallback_input_id;

// Add dropzone class for JS initialization
if (isset($vars['class'])) {
	$options['class'] = "elgg-input-dropzone {$vars['class']}";
} else {
	$options['class'] = "elgg-input-dropzone";
}

$vars['class'] = 'hidden';

if (!isset($vars['name'])) {
	$vars['name'] = 'file_guids';
}

// Allow multiple file uploads
$multiple = false;
if (isset($vars['multiple'])) {
	$multiple = $vars['multiple'];
}

$options['data-upload-multiple'] = $multiple;
if ($multiple) {
	$vars['name'] = $vars['name'] . '[]';
}

$options['data-name'] = $vars['name'];

// Set input type
$vars['type'] = 'file';

// File previously uploaded
if (isset($vars['value']) && $vars['value']) {
	$options['data-fileexists'] = true;
}

if (isset($vars['max'])) {
	$options['data-max-files'] = $vars['max'];
	unset($vars['max']);
}

// Get post_max_size and upload_max_filesize
$post_max_size = elgg_get_ini_setting_in_bytes('post_max_size');
$upload_max_filesize = elgg_get_ini_setting_in_bytes('upload_max_filesize');
// Determine the correct value
$max_upload = $upload_max_filesize > $post_max_size ? $post_max_size : $upload_max_filesize;

$options['data-max-filesize'] = (int) format_from_bytes($max_upload);
if (isset($vars['max_filesize'])) {
	$options['data-max-filesize'] = $vars['max_filesize'];
	unset($vars['max_filesize']);
}

//timeout
$options['data-timeout'] = 30000;
if (isset($vars['timeout'])) {
	$options['data-timeout'] = $vars['timeout'];
	unset($vars['timeout']);
}

if (isset($vars['accept'])) {
	$options['data-accepted-files'] = $vars['accept'];
}

if (isset($vars['action'])) {
	$options['data-url'] = elgg_add_action_tokens_to_url(elgg_normalize_url($vars['action']));
	unset($vars['action']);
}

if (isset($vars['container_guid'])) {
	$options['data-container-guid'] = $vars['container_guid'];
}

if (isset($vars['subtype'])) {
	$options['data-subtype'] = $vars['subtype'];
}

$query = elgg_extract('query', $vars);
unset($vars['query']);
if ($query) {
	$options['data-query'] = json_encode($query);
}

$options['data-clickable'] = "#{$options['id']} .elgg-dropzone-fallback-control,#{$options['id']} .elgg-dropzone-instructions";

$language = [
	'data-dict-default-message' => elgg_echo('dropzone:default_message'),
	'data-dict-fallback-message' => elgg_echo('dropzone:fallback_message'),
	'data-dict-fallback-text' => elgg_echo('dropzone:fallback_text'),
	'data-dict-invalid-filetype' => elgg_echo('dropzone:invalid_filetype'),
	'data-dict-file-toobig' => elgg_echo('dropzone:file_too_big'),
	'data-dict-response-error' => elgg_echo('dropzone:response_error'),
	'data-dict-cancel-upload' => elgg_echo('dropzone:cancel_upload'),
	'data-dict-cancel-upload-confirmation' => elgg_echo('dropzone:cancel_upload_confirmation'),
	'data-dict-remove-file' => elgg_echo('dropzone:remove_file'),
	'data-dict-max-files-exceeded' => elgg_echo('dropzone:max_files_exceeded'),
];

$options = array_merge($language, $options);

$dropzone_attributes = _elgg_services()->html_formatter->formatAttributes($options);
?>
<div class="elgg-dropzone">
	<?=
	// Add a hidden field to use in the action hook to unserialize the values
	elgg_view('input/hidden', [
		'name' => 'dropzone_fields[]',
		'value' => $vars['name']
	]);
	?>
    <div <?= $dropzone_attributes ?>>
		<span class="elgg-dropzone-instructions dz-default dz-message">
			<?= elgg_view_icon('cloud-upload') ?>
			<?= $language['data-dict-default-message'] ?>
		</span>
    </div>
    <div data-template><?= elgg_view('dropzone/template') ?></div>
</div>
<?php
$params = $vars;
unset($params['value']);

echo elgg_view('input/file', $params);
?>
<script>
	require(['dropzone/dropzone'], function (dropzone) {
		dropzone.init();
	});
</script>