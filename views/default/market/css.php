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
?>

.market_pricetag {
	font-weight: 600;
	color: #ffffff;
	background:#00a700;
	border: 1px solid #00a700;
	-webkit-border-radius: 4px; 
	-moz-border-radius: 4px;
	width: auto;
	height: 12px;
	padding: 2px 10px 2px 10px;
	margin:10px 0 10px 0;
}
.market-image-popup {
	max-width: 100%;
}
.market-category-menu-item {
	line-height: 21px;
	display: block;
	text-decoration: none;
	padding-left: 3px;
}
.market-category-menu-item:hover {
	background-color: #dedede;
	text-decoration: none;
}
.market-category-menu-item.selected {
	background-color: #dedede;
	text-decoration: none;
}
.market-image-block > .elgg-image {
	min-width: 208px;
	text-align: center;
}
.market-image-block > .elgg-image-alt {
	margin: 25px 25px 0 0;
}
.market-river-image {
	width: 60px;
	height: 60px;
}
.market-form-image {
	width: 75px;
	height: 75px;
}
.market-thumbnail {
	cursor:url(<?php echo elgg_get_site_url(); ?>mod/market/graphics/zoom_in.png),url(<?php echo elgg_get_site_url(); ?>mod/market/graphics/zoom_in.png),auto;
	margin-right: 5px;
}
.market_characters_remaining {
	bottom: 0;
    color: #666;
    font-size: 11px;
    left: 0;
    line-height: 20px;
    padding: 0 8px;
    text-align: right;
    vertical-align: middle;
}
.market_charleft {
    margin: 0 5px 0 0;
}
.market-counter-overflow {
	color: #f00!important;
}
.market-accepts > * {
	max-height: 1em;
	display: inline-block;
	margin-right: 5px;
}

@media (max-width: 600px) {
	.market-item-list > .elgg-image-block > .elgg-image {
		max-width: 100px;
	}
	img.market-image-list {
		width: 100%;
	}
	.market-image-block > .elgg-image {
		min-width: 104px;
		margin-right: 5px;
	}
	.market-image-block > .elgg-image > img.elgg-photo {
		width: 100%;
	}
}
