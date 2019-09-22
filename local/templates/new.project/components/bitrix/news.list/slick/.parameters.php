<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$parentParams = __DIR__ . '/../.default/.parameters.php';
if( is_file($parentParams) ) {
	include $parentParams;
}

if( empty($arTemplateParameters) ) {
	$arTemplateParameters = array();
}

$arTemplateParameters = array_merge($arTemplateParameters, array(
	"SLICK_infinite" => array(
		"PARENT" => "BASE",
		"NAME" => "Infinite",
		"TYPE" => "CHECKBOX",
		"DEFAULT" => "Y",
		"DESC" => 'Infinite looping',
	),
	"SLICK_slidesToShow" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Slides To Show',
		'DESC'    => 'slides to show at a time',
		"DEFAULT" => "",
		"TYPE" => "NUMBER",
	),
	"SLICK_slidesToScroll" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Slides To Scroll',
		'DESC'    => 'slides to scroll at a time',
		"DEFAULT" => "",
		'TYPE'    => 'NUMBER'
	),
	"SLICK_autoplay" => array(
		"PARENT" => "BASE",
		"NAME" => 'Auto Play',
		'DESC'  => 'Enables auto play of slides',
		'TYPE'  => 'CHECKBOX',
	),
	"SLICK_autoplaySpeed" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Auto Play Speed',
		'DESC'    => 'Auto play change interval',
		'DEFAULT' => '3000',
		"TYPE" => "NUMBER",
	),
	"SLICK_dots" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Dots',
		'DESC'    => 'Current slide indicator dots',
		"TYPE" => "CHECKBOX",
		'data-show' => 'dotsClass'
	),
	// "SLICK_dotsClass" => array(
	// 	"PARENT" => "BASE",
	// 	"NAME"   => 'Dots Class',
	// 	'DESC'    => 'Class for slide indicator dots container',
	// 	'DEFAULT' => 'slick-dots',
	// 	"TYPE" => "text",
	// ),
	"SLICK_arrows" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Arrows',
		'DESC'    => 'Enable Next/Prev arrows',
		'DEFAULT' => 'Y',
		"TYPE" => "CHECKBOX",
            // 'data-show' => 'prevArrow, nextArrow'
	),
	// "SLICK_prevArrow" => array(
	// 	"PARENT" => "BASE",
	// 	"NAME"   => 'Prev Arrow',
	// 	'DESC'    => '(html | jQuery selector) | object (DOM node | jQuery object)   Allows you to select a node or customize the HTML for the "Previous" arrow. (May use %object%)',
	// 	'DEFAULT' => '<button type="button" class="slick-prev">Previous</button>',
	// 	"TYPE" => "text",
	// ),
	// "SLICK_nextArrow" => array(
	// 	"PARENT" => "BASE",
	// 	"NAME"   => 'Next Arrow',
	// 	'DESC'    => '(html | jQuery selector) | object (DOM node | jQuery object) Allows you to select a node or customize the HTML for the "Next" arrow. (May use %object%)',
	// 	'DEFAULT' => '<button type="button" class="slick-next">Next</button>',
	// 	"TYPE" => "text",
	// ),
	"SLICK_speed" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Speed',
		'DESC'    => 'Transition speed',
		'DEFAULT' => '300',
		"TYPE" => "NUMBER",
	),
	"SLICK_centerMode" => array(
		"PARENT" => "BASE",
		"NAME" => 'Center Mode',
		'DESC'  => 'Enables centered view with partial prev/next slides. Use with odd numbered slidesToShow counts.',
		"TYPE" => "CHECKBOX",
            // 'data-show' => 'centerPadding',
	),
	"SLICK_centerPadding" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Center Padding',
		'DESC'    => 'Side padding when in center mode. (px or %)',
		'DEFAULT' => '50px',
		"TYPE" => "text",
	),
	"SLICK_fade" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Fade',
		'DESC'    => 'Enables fade',
		"TYPE" => "CHECKBOX",
	),
	"SLICK_variableWidth" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Variable Width',
		'DESC'    => 'Disables automatic slide width calculation',
		"TYPE" => "CHECKBOX",
	),
	"SLICK_adaptiveHeight" => array(
		"PARENT" => "BASE",
		"NAME" => 'AdaptiveHeight',
		'DESC'  => 'Adapts slider height to the current slide',
		"TYPE" => "CHECKBOX",
	),
	// "SLICK_cssEase" => array(
	// 	"PARENT" => "BASE",
	// 	"NAME"   => 'CSS Ease',
	// 	'DESC'    => 'CSS3 easing',
	// 	'DEFAULT' => 'ease',
	// 	"TYPE" => "text",
	// ),
	// "SLICK_accessibility" => array(
	// 	"PARENT" => "BASE",
	// 	"NAME"   => 'Accessibility',
	// 	'DESC'    => 'Enables tabbing and arrow key navigation',
	// 	'DEFAULT' => 'Y',
	// 	"TYPE" => "CHECKBOX",
	// ),
	// "SLICK_customPaging" => array(
	// 	"PARENT" => "BASE",
	// 	"NAME" => 'Custom Paging',
	// 	'DESC'  => '(use %function_name%) Custom paging templates. See source for use example.',
	// 	"TYPE" => "text",
	// ),
	"SLICK_draggable" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Draggable',
		'DESC'    => 'Enables desktop dragging',
		'DEFAULT' => 'Y',
		"TYPE" => "CHECKBOX",
	),
	// "SLICK_easing" => array(
	// 	"PARENT" => "BASE",
	// 	"NAME"   => 'Easing',
	// 	'DESC'    => 'animate() fallback easing',
	// 	'DEFAULT' => 'linear',
	// 	"TYPE" => "text",
	// ),
	// "SLICK_edgeFriction" => array(
	// 	"PARENT" => "BASE",
	// 	"NAME"   => 'Edge Friction',
	// 	'DESC'    => 'Resistance when swiping edges of non-infinite carousels',
	// 	'DEFAULT' => '0.15',
	// 	"TYPE" => "NUMBER",
	// ),
	// "SLICK_mobileFirst" => array(
	// 	"PARENT" => "BASE",
	// 	"NAME"   => 'Mobile First',
	// 	'DESC'    => 'Responsive settings use mobile first calculation',
	// 	"TYPE" => "CHECKBOX",
	// ),
	"SLICK_initialSlide" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Initial Slide',
		'DESC'    => 'Slide to start on',
		'DEFAULT' => '0',
		"TYPE" => "NUMBER",
	),
	"SLICK_lazyLoad" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Lazy Load',
		'DESC'    => 'Accepts \'ondemand\' or \'progressive\' for lazy load technique. \'ondemand\' will load the image as soon as you slide to it, \'progressive\' loads one image after the other when the page loads.',
		'DEFAULT' => 'ondemand',
		"TYPE" => "text",
	),
	"SLICK_pauseOnFocus" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Pause On Focus',
		'DESC'    => 'Pauses autoplay when slider is focussed',
		'DEFAULT' => 'Y',
		"TYPE" => "CHECKBOX",
	),
	"SLICK_pauseOnHover" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Pause On Hover',
		'DESC'    => 'Pauses autoplay on hover',
		'DEFAULT' => 'Y',
		"TYPE" => "CHECKBOX",
	),
	// "SLICK_pauseOnDotsHover" => array(
	// 	"PARENT" => "BASE",
	// 	"NAME"   => 'Pause On Dots Hover',
	// 	'DESC'    => 'Pauses autoplay when a dot is hovered',
	// 	'DEFAULT' => 'Y',
	// 	"TYPE" => "CHECKBOX",
	// ),
	// "SLICK_respondTo" => array(
	// 	"PARENT" => "BASE",
	// 	"NAME"   => 'Respond To',
	// 	'DESC'    => 'Width that responsive object responds to. Can be \'window\', \'slider\' or \'min\' (the smaller of the two).
	// 	responsive  array   null    Array of objects containing breakpoints and settings objects (see example). Enables settings at given breakpoint. Set settings to "unslick" instead of an object to disable slick at a given breakpoint.',
	// 	'DEFAULT' => 'window',
	// 	"TYPE" => "text",
	// ),
	"SLICK_rows" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Rows',
		'DESC'    => 'Setting this to more than 1 initializes grid mode. Use slidesPerRow to set how many slides should be in each row.',
		"DEFAULT" => "Y",
		"TYPE" => "NUMBER",
	),
	"SLICK_slide" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Slide',
		'DESC'    => 'Slide element query',
		'DEFAULT' => '',
		"TYPE" => "text",
	),
	"SLICK_slidesPerRow" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Slides Per Row',
		'DESC'    => 'With grid mode initialized via the rows option, this sets how many slides are in each grid row.',
		"DEFAULT" => "Y",
		"TYPE" => "NUMBER",
	),
	"SLICK_swipe" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Swipe',
		'DESC'    => 'Enables touch swipe',
		'DEFAULT' => 'Y',
		"TYPE" => "CHECKBOX",
	),
	"SLICK_swipeToSlide" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Swipe To Slide',
		'DESC'    => 'Swipe to slide irrespective of slidesToScroll',
		"TYPE" => "CHECKBOX",
	),
	"SLICK_touchMove" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Touch Move',
		'DESC'    => 'Enables slide moving with touch',
		'DEFAULT' => 'Y',
		"TYPE" => "CHECKBOX",
	),
	// "SLICK_touchThreshold" => array(
	// 	"PARENT" => "BASE",
	// 	"NAME"   => 'Touch Threshold',
	// 	'DESC'    => 'To advance slides, the user must swipe a length of (1/touchThreshold) * the width of the slider.',
	// 	'DEFAULT' => '5',
	// 	"TYPE" => "NUMBER",
	// ),
	// "SLICK_useCSS" => array(
	// 	"PARENT" => "BASE",
	// 	"NAME"   => 'Use CSS',
	// 	'DESC'    => 'Enable/Disable CSS Transitions',
	// 	'DEFAULT' => 'Y',
	// 	"TYPE" => "CHECKBOX",
	// ),
	// "SLICK_useTransform" => array(
	// 	"PARENT" => "BASE",
	// 	"NAME"   => 'Use Transform',
	// 	'DESC'    => 'Enable/Disable CSS Transforms',
	// 	'DEFAULT' => 'Y',
	// 	"TYPE" => "CHECKBOX",
	// ),
	"SLICK_vertical" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Vertical',
		'DESC'    => 'Vertical slide direction',
		"TYPE" => "CHECKBOX",
	),
	"SLICK_verticalSwiping" => array(
		"PARENT" => "BASE",
		"NAME"   => 'Vertical Swiping',
		'DESC'    => 'Changes swipe direction to vertical',
		"TYPE" => "CHECKBOX",
	),
	// "SLICK_rtl" => array(
	// 	"PARENT" => "BASE",
	// 	"NAME"   => 'Right To Left',
	// 	'DESC'    => 'Change the slider\'s direction to become right-to-left',
	// 	"TYPE" => "CHECKBOX",
	// ),
	// "SLICK_waitForAnimate" => array(
	// 	"PARENT" => "BASE",
	// 	"NAME"   => 'Wait For Animate',
	// 	'DESC'    => 'Ignores requests to advance the slide while animating',
	// 	'DEFAULT' => 'Y',
	// 	"TYPE" => "CHECKBOX",
	// ),
	// "SLICK_zIndex" => array(
	// 	"PARENT" => "BASE",
	// 	"NAME"   => 'zIndex',
	// 	'DESC'    => 'Set the zIndex values for slides, useful for IE9 and lower',
	// 	'DEFAULT' => '1000',
	// 	"TYPE" => "NUMBER",
	// ),
	'HIDE_BUILTIN' => array(
		'NAME' => 'HIDE_BUILTIN',
		'TYPE' => 'CUSTOM',
		'JS_FILE' => $templateFolder . '/hide-builtin.js',
		'JS_EVENT' => 'OnHideBuiltin',
		'JS_DATA' => '1',
		'DEFAULT' => '',
		// 'PARENT' => 'BASE',
	)
));


return $arTemplateParameters;
