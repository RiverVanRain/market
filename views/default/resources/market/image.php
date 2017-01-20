<?php
/**
 * Elgg Market Plugin
 * @package market
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author slyhne, RiverVanRain
 * @copyright slyhne 2010-2015, wZm 2k17
 * @link https://wzm.me
 * @version 2.2
 */
$guid = elgg_extract('guid', $vars);

$entity = get_entity($guid);

if (!elgg_instanceof($entity, 'object', 'market')) {
	return;
}

// Get the size
$sizenum = elgg_extract('size', $vars);
$size = strtolower($sizenum);
if (!in_array($size,array('large','medium','small','tiny','master'))) {
	$size = "medium";
}

// Get image number (1,2,3 or 4)
$imagenum = elgg_extract('imagenum', $vars);
if ($imagenum == 1) {
	$imagenum = '';
}

// Try and get the icon
$filehandler = new ElggFile();
$filehandler->owner_guid = $entity->owner_guid;
$filehandler->setFilename("market/" . $entity->guid . $size . $imagenum . ".jpg");
		
$success = false;
if ($filehandler->open("read")) {
	if ($contents = $filehandler->read($filehandler->getSize())) {
		$success = true;
	} 
}

if (!$success) {
	$path = elgg_get_site_url() . "mod/market/graphics/noimage{$size}.png";
	header("Location: $path");
	exit;
}

header("Content-type: image/jpeg");
header('Expires: ' . date('r',time() + 864000));
header("Pragma: public");
header("Cache-Control: public");
header("Content-Length: " . strlen($contents));

$splitString = str_split($contents, 1024);

foreach($splitString as $chunk) {
	echo $chunk;
}

