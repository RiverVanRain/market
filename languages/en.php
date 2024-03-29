<?php
/**
 * Market
 * @author Nikolai Shcherbin
 * @license GNU Public License version 2
 * @copyright (c) Nikolai Shcherbin 2017
 * @link https://wzm.me
 */
return [

	// Menu items and titles	
	'market' => "Market",
	'collection:object:market' => "Market",
	'collection:object:market:owner' => "%s's ads",
	'collection:friends' => "%s's friends Market",
	'collection:object:market:group' => "Group market",
	'market:posts' => "Market Posts",
	'market:title' => "Market",
	'market:collection:title' => "%s's ads",
	'market:user' => "%s's Ads",
	'market:user:friends' => "%s's friends Market",
	'market:user:friends:title' => "%s's friends ads",
	'market:type:mine' => "My Ads",
	'market:mine:title' => "My ads on The Market",
	'market:posttitle' => "%s's Market item: %s",
	'market:friends' => "Friends Market",
	'market:friends:title' => "My friends ads on The Market",
	'market:everyone:title' => "All ads on The Market",
	'market:everyone' => "All ads",
	'item:object:market' => 'Market ad',
	'market:none:found' => 'No market ad found',
	
	'item:object:market_file' => 'Market files',
	'collection:object:market_file' => "Market file",
	
	'add:object:market' => "Create new ad",
	'market:read' => "View ad",
	'market:mark:sold' => 'Mark as Sold',
	'market:mark:open' => 'Open for %s',
	'market:add' => "Create new ad",
	'market:add:title' => "Create a new ad on The Market",
	'market:edit' => "Edit Ad",
	'market:upload' => "Upload images to show in the ad",
	'market:text' => "Give a brief description about the item",
	'market:strapline' => "Created",
	'market:action:open' => "Item marked as open",
	'market:action:sold' => "Item marked as sold",
	
	'market:icon:upload:new' => "Add cover icon to your ad",
	'market:icon:upload:edit' => "Edit cover icon of your ad",
	'market:uploadimages' => "Add images to your ad.",
	
	'market:pmbuttontext' => "Send Private Message",
	'market:price' => "Price",
	'market:price:help' => "In %s",
	'market:location' => "Location",
	'market:location:help' => "Where is this item located",
	'market:tags:help' => "Separate with commas",
	'market:replies' => "Replies",
	'market:created:gallery' => "Created by %s <br>at %s",
	'market:created:listing' => "Created by %s at %s",
	'market:showbig' => "Show larger picture",
	'market:type' => "Type",
	'market:type:choose' => 'Choose market post type',
	'market:choose' => "Choose one...",
	'market:charleft' => "characters left",
	'market:accept:terms' => "I have read and accepted the %s",
	'market:terms:title' => "Terms of use",
	
	//Notifications
	'market:notify:subject' => "New Market ad %s was created",
	'market:notify:summary' => "New Market ad %s was created",
	'market:notify:body' => "%s created a new ad on the Market:

%s - %s

View the Market ad here: %s
",
	//Groups
	'market:group' => "Group market",
	'market:none' => "No market",
	'settings:market:enable_groups' => "Enable market in groups",
	'groups:tool:market' => "Enable group market",
	
	//Widget
	'market:widget' => "Market",
	'market:widget:description' => "Showcase your ads on The Market",
	'market:widget:viewall' => "View all ads on The Market",
	'market:num_display' => "Number of ads to display",

	//River
	'river:object:market:create' => '%s posted a new ad in the market %s',
	'river:object:market:update' => '%s updated the ad %s in the market',
	'river:object:market:comment' => '%s commented on the market ad %s',
	'river:object:market:open' => '%s opened the ad %s for sell in the market',
	'river:object:market:sold' => '%s marked the ad %s as sold in the market',

	// Status messages
	'market:posted' => "Your Market ad was successfully posted.",
	'market:deleted' => "Your Market ad was successfully deleted.",
	'market:uploaded' => "Your image was succesfully added.",
	'market:image:deleted' => "Your image was succesfully deleted.",
	'market:status:sold' => 'The item has been marked as sold by the owner',

	// Error messages	
	'market:save:failure' => "Your Market ad could not be saved. Please try again.",
	'market:error:missing:title' => "Error: missing title",
	'market:error:missing:description' => "Error: Mmissing description",
	'market:error:missing:category' => "Error: missing category",
	'market:error:missing:price' => "Error: missing price",
	'market:error:missing:market_type' => "Error: missing type",
	'market:notfound' => "Sorry; we could not find the specified Market ad.",
	'market:notdeleted' => "Sorry; we could not delete this Market ad.",
	'market:tomany' => "Error: too many Market ads",
	'market:tomany:text' => "You have reached the maximum number of Market ads per user. Please delete some first",
	'market:accept:terms:error' => "You must accept the terms of use",
	'market:error' => "Error: Cannot save market ad",
	'market:error:cannot_write_to_container' => "Error: Cannot write to container",

	// Settings
	'settings:basic:config' => "Basic configuration",
	'settings:market:max:posts' => "Maximum number of market ads per user",
	'settings:market:max:posts:help' => "Set 0 for unlimited ads",
	'settings:market:adminonly' => "Only admin can create market posts",
	'settings:market:currency' => "Currency ($, €, DKK or something else)",
	'settings:market:allowhtml' => "Allow HTML in market ads",
	'settings:market:numchars' => "Maximum number of characters in market ad",
	'settings:market:numchars:help' => "Only valid without HTML. Set 0 for unlimited number of characters",
	'settings:market:pmbutton' => "Enable private message button",
	'settings:market:location' => "Enable a location field",
	'settings:market:comments' => "Allow comments",
	'settings:market:categories' => 'Market categories',
	'settings:market:categories:help' => 'Separate categories with commas',
	'settings:market:image_size' => 'Select image size to show in the ads',
	'settings:market:image_size:tiny' => 'Tiny (25px)',
	'settings:market:image_size:small' => 'Small (60px)',
	'settings:market:image_size:medium' => 'Medium (153px)',
	'settings:market:image_size:large' => 'Large (600px)',
	'settings:market:image_size:master' => 'Original image',
	
	'settings:market:settings:type' => 'Enable market ad types (buy/sell/swap/free)',	
	'market:type:all' => "All ads",
	'market:type:buy' => "Buying",
	'market:type:sell' => "Selling",
	'market:type:swap' => "Swap",
	'market:type:free' => "Free",
	
	'settings:market:expire' => "Ads expire settings",
	'settings:market:expire:date' => "Auto delete market ads older than:",
	'settings:market:expire:month' => "month",
	'settings:market:expire:months' => "months",
	'market:expire:subject' => "Your market ad has expired",
	'market:expire:body' => "Hi %s,

Your market ad '%s' you created %s has been deleted.

This happens automatically when market ad are older than %s month(s).
",

	'settings:market:terms' => "Terms of use",
	'settings:market:terms:enable' => "Enable the market terms",
	'settings:market:terms:text' => "Write the market terms",

	// Market categories
	'market:categories' => 'Market categories',
	'market:categories:choose' => 'Choose category',
	'market:categories:settings:categories' => 'Market categories',
	'market:category:all' => "All",
	'market:category' => "Category",
	'market:category:title' => "Category: %s",

	// Custom select
	'settings:market:custom' => "Custom field",
	'settings:market:custom:help' => "Set some predefined choices for the custom select dropdown box in the ads form",
	'settings:market:custom:activate' => "Enable custom select",
	'settings:market:custom:choices' => "Custom select choices",
	'settings:market:custom:choices:help' => "Separate choices with commas",
	'market:custom:select' => "Item condition",
	'market:custom:text' => "Condition",
	
	//DROPZONE
	'item:object:temp_file_upload' => 'Dropzone temp file',
	'collection:object:temp_file_upload' => 'Dropzone temp file',
	
	'dropzone:response_error' => 'An unknown error has occurred',
	'dropzone:default_message' => '<strong>Drop your files here</strong><br /><span>or click to select them from your device</span>',
	'dropzone:remove_file' => 'Remove',
	'dropzone:max_files_exceeded' => 'You have reached the maximum number of files you can upload at once',
	'dropzone:fallback_message' => 'Your browser does not support drag and drop uploads',
	'dropzone:fallback_text' => 'Please use the file input to upload your files the old way',
	'dropzone:invalid_filetype' => 'Files of this type are not allowed',
	'dropzone:file_too_big' => 'File is too big',
	'dropzone:cancel_upload' => 'Cancel upload',
	'dropzone:cancel_upload_confirmation' => 'Are you sure you want to cancel the upload?',
	'dropzone:server_side_error' => 'Server Error',
	'dropzone:file_not_entity' => 'File entity could not be created',
	'dropzone:ini:upload_limit' => 'Maximum allowed file size is %s',
	
];
