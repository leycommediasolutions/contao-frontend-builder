<?php 

$GLOBALS['frontendbuilder']['version'] = "1.0";


$GLOBALS['TL_HOOKS']['outputFrontendTemplate'][] = array('frontend_builder.frontend_hooks', 'outputFrontendTemplateHook');
$GLOBALS['TL_HOOKS']['parseFrontendTemplate'][] = array('frontend_builder.frontend_hooks', 'parseFrontendTemplateHook');
$GLOBALS['TL_HOOKS']['getContentElement'][] = array('frontend_builder.frontend_hooks', 'getContentElementHook');
$GLOBALS['TL_HOOKS']['getAttributesFromDca'][] = array('frontend_builder.backend_hooks', 'myGetAttributesFromDca');


// Add Stickyfooter files
if(TL_MODE == 'BE')
{
    $assetsDir = 'bundles/frontendbuilder/backend';
    $GLOBALS['TL_JAVASCRIPT'][] = $assetsDir . '/js/main.js';
}
array_insert($GLOBALS['BE_MOD']['content'], 8, array
(
    'frontendbuilder' => array
	(
        'tables'      => array('tl_frontendbuilder'),
	)
));





//$GLOBALS['TL_HOOKS']['getArticle'][] = array('frontend_builder.frontend_hooks', 'getArticleHook');
//$GLOBALS['TL_HOOKS']['parseTemplate'][] = array('frontend_builder.frontend_hooks', 'parseTemplateHook');
//$GLOBALS['TL_HOOKS']['parseWidget'][] = array('frontend_builder.frontend_hooks', 'parseWidgetHook');
//$GLOBALS['TL_HOOKS']['parseArticles'][] = array('frontend_builder.frontend_hooks', 'parseArticlesHook');
//$GLOBALS['TL_HOOKS']['getAllEvents'][] = array('frontend_builder.frontend_hooks', 'getAllEventsHook');
//$GLOBALS['TL_HOOKS']['getFrontendModule'][] = array('frontend_builder.frontend_hooks', 'getFrontendModuleHook');
//$GLOBALS['TL_HOOKS']['outputBackendTemplate'][] = array('frontend_builder.backend_hooks', 'myOutputBackendTemplate');
//$GLOBALS['TL_HOOKS']['parseBackendTemplate'][] = array('frontend_builder.backend_hooks', 'parseBackendTemplate');
//$GLOBALS['TL_HOOKS']['getUserNavigation']

//$GLOBALS['TL_HOOKS']['parseWidget'][] = array('frontend_builder.backend_hooks', 'parseWidgetHook');
//$GLOBALS['TL_HOOKS']['loadFormField'][] = array('frontend_builder.backend_hooks', 'myLoadFormField');
//$GLOBALS['TL_HOOKS']['addCustomRegexp']
