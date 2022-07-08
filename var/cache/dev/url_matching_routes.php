<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/admin' => [[['_route' => 'admin', '_controller' => 'App\\Controller\\Admin\\DashboardController::index'], null, null, null, false, false, null]],
        '/campaign' => [[['_route' => 'app_campaign', '_controller' => 'App\\Controller\\CampaignController::index'], null, null, null, false, false, null]],
        '/campaign/create' => [[['_route' => 'add_campaign', '_controller' => 'App\\Controller\\CampaignController::addCampaign'], null, null, null, false, false, null]],
        '/chart' => [[['_route' => 'app_chart', '_controller' => 'App\\Controller\\ChartController::index'], null, null, null, false, false, null]],
        '/chart/test' => [[['_route' => 'test_chart', '_controller' => 'App\\Controller\\ChartController::FunctionName'], null, null, null, false, false, null]],
        '/' => [[['_route' => 'app_home', '_controller' => 'App\\Controller\\HomeController::index'], null, null, null, false, false, null]],
        '/login' => [[['_route' => 'app_login', '_controller' => 'App\\Controller\\LoginController::login'], null, null, null, false, false, null]],
        '/logout' => [[['_route' => 'app_logout', '_controller' => 'App\\Controller\\LoginController::logout'], null, null, null, false, false, null]],
        '/register' => [[['_route' => 'app_register', '_controller' => 'App\\Controller\\RegistrationController::register'], null, null, null, false, false, null]],
        '/verify/email' => [[['_route' => 'app_verify_email', '_controller' => 'App\\Controller\\RegistrationController::verifyUserEmail'], null, null, null, false, false, null]],
        '/select/rule/group' => [[['_route' => 'app_select_rule_group', '_controller' => 'App\\Controller\\SelectRuleGroupController::index'], null, null, null, true, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/api(?'
                    .'|(?:/(index)(?:\\.([^/]++))?)?(*:42)'
                    .'|/(?'
                        .'|docs(?:\\.([^/]++))?(*:72)'
                        .'|c(?'
                            .'|ontexts/(.+)(?:\\.([^/]++))?(*:110)'
                            .'|ampaign(?'
                                .'|s(?'
                                    .'|(?:\\.([^/]++))?(?'
                                        .'|(*:150)'
                                    .')'
                                    .'|/([^/\\.]++)(?:\\.([^/]++))?(?'
                                        .'|(*:188)'
                                    .')'
                                .')'
                                .'|_leads(?'
                                    .'|(?:\\.([^/]++))?(?'
                                        .'|(*:225)'
                                    .')'
                                    .'|/([^/\\.]++)(?:\\.([^/]++))?(?'
                                        .'|(*:263)'
                                    .')'
                                .')'
                            .')'
                        .')'
                        .'|leads(?'
                            .'|(?:\\.([^/]++))?(?'
                                .'|(*:301)'
                            .')'
                            .'|/([^/\\.]++)(?:\\.([^/]++))?(?'
                                .'|(*:339)'
                            .')'
                        .')'
                        .'|rule_groups(?'
                            .'|(?:\\.([^/]++))?(?'
                                .'|(*:381)'
                            .')'
                            .'|/([^/\\.]++)(?:\\.([^/]++))?(?'
                                .'|(*:419)'
                            .')'
                        .')'
                    .')'
                .')'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:462)'
                    .'|wdt/([^/]++)(*:482)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:528)'
                            .'|router(*:542)'
                            .'|exception(?'
                                .'|(*:562)'
                                .'|\\.css(*:575)'
                            .')'
                        .')'
                        .'|(*:585)'
                    .')'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        42 => [[['_route' => 'api_entrypoint', '_controller' => 'api_platform.action.entrypoint', '_format' => '', '_api_respond' => 'true', 'index' => 'index'], ['index', '_format'], null, null, false, true, null]],
        72 => [[['_route' => 'api_doc', '_controller' => 'api_platform.action.documentation', '_format' => '', '_api_respond' => 'true'], ['_format'], null, null, false, true, null]],
        110 => [[['_route' => 'api_jsonld_context', '_controller' => 'api_platform.jsonld.action.context', '_format' => 'jsonld', '_api_respond' => 'true'], ['shortName', '_format'], null, null, false, true, null]],
        150 => [
            [['_route' => 'api_campaigns_get_collection', '_controller' => 'api_platform.action.get_collection', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\Campaign', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_collection_operation_name' => 'get'], ['_format'], ['GET' => 0], null, false, true, null],
            [['_route' => 'api_campaigns_post_collection', '_controller' => 'api_platform.action.post_collection', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\Campaign', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_collection_operation_name' => 'post'], ['_format'], ['POST' => 0], null, false, true, null],
        ],
        188 => [
            [['_route' => 'api_campaigns_get_item', '_controller' => 'api_platform.action.get_item', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\Campaign', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_item_operation_name' => 'get'], ['id', '_format'], ['GET' => 0], null, false, true, null],
            [['_route' => 'api_campaigns_delete_item', '_controller' => 'api_platform.action.delete_item', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\Campaign', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_item_operation_name' => 'delete'], ['id', '_format'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'api_campaigns_put_item', '_controller' => 'api_platform.action.put_item', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\Campaign', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_item_operation_name' => 'put'], ['id', '_format'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'api_campaigns_patch_item', '_controller' => 'api_platform.action.patch_item', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\Campaign', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_item_operation_name' => 'patch'], ['id', '_format'], ['PATCH' => 0], null, false, true, null],
        ],
        225 => [
            [['_route' => 'api_campaign_leads_get_collection', '_controller' => 'api_platform.action.get_collection', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\CampaignLeads', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_collection_operation_name' => 'get'], ['_format'], ['GET' => 0], null, false, true, null],
            [['_route' => 'api_campaign_leads_post_collection', '_controller' => 'api_platform.action.post_collection', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\CampaignLeads', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_collection_operation_name' => 'post'], ['_format'], ['POST' => 0], null, false, true, null],
        ],
        263 => [
            [['_route' => 'api_campaign_leads_get_item', '_controller' => 'api_platform.action.get_item', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\CampaignLeads', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_item_operation_name' => 'get'], ['id', '_format'], ['GET' => 0], null, false, true, null],
            [['_route' => 'api_campaign_leads_delete_item', '_controller' => 'api_platform.action.delete_item', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\CampaignLeads', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_item_operation_name' => 'delete'], ['id', '_format'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'api_campaign_leads_put_item', '_controller' => 'api_platform.action.put_item', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\CampaignLeads', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_item_operation_name' => 'put'], ['id', '_format'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'api_campaign_leads_patch_item', '_controller' => 'api_platform.action.patch_item', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\CampaignLeads', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_item_operation_name' => 'patch'], ['id', '_format'], ['PATCH' => 0], null, false, true, null],
        ],
        301 => [
            [['_route' => 'api_leads_get_collection', '_controller' => 'api_platform.action.get_collection', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\Leads', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_collection_operation_name' => 'get'], ['_format'], ['GET' => 0], null, false, true, null],
            [['_route' => 'api_leads_post_collection', '_controller' => 'api_platform.action.post_collection', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\Leads', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_collection_operation_name' => 'post'], ['_format'], ['POST' => 0], null, false, true, null],
        ],
        339 => [
            [['_route' => 'api_leads_get_item', '_controller' => 'api_platform.action.get_item', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\Leads', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_item_operation_name' => 'get'], ['id', '_format'], ['GET' => 0], null, false, true, null],
            [['_route' => 'api_leads_delete_item', '_controller' => 'api_platform.action.delete_item', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\Leads', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_item_operation_name' => 'delete'], ['id', '_format'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'api_leads_put_item', '_controller' => 'api_platform.action.put_item', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\Leads', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_item_operation_name' => 'put'], ['id', '_format'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'api_leads_patch_item', '_controller' => 'api_platform.action.patch_item', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\Leads', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_item_operation_name' => 'patch'], ['id', '_format'], ['PATCH' => 0], null, false, true, null],
        ],
        381 => [
            [['_route' => 'api_rule_groups_get_collection', '_controller' => 'api_platform.action.get_collection', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\RuleGroup', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_collection_operation_name' => 'get'], ['_format'], ['GET' => 0], null, false, true, null],
            [['_route' => 'api_rule_groups_post_collection', '_controller' => 'api_platform.action.post_collection', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\RuleGroup', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_collection_operation_name' => 'post'], ['_format'], ['POST' => 0], null, false, true, null],
        ],
        419 => [
            [['_route' => 'api_rule_groups_get_item', '_controller' => 'api_platform.action.get_item', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\RuleGroup', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_item_operation_name' => 'get'], ['id', '_format'], ['GET' => 0], null, false, true, null],
            [['_route' => 'api_rule_groups_delete_item', '_controller' => 'api_platform.action.delete_item', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\RuleGroup', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_item_operation_name' => 'delete'], ['id', '_format'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'api_rule_groups_put_item', '_controller' => 'api_platform.action.put_item', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\RuleGroup', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_item_operation_name' => 'put'], ['id', '_format'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'api_rule_groups_patch_item', '_controller' => 'api_platform.action.patch_item', '_format' => null, '_stateless' => null, '_api_resource_class' => 'App\\Entity\\RuleGroup', '_api_identifiers' => ['id'], '_api_has_composite_identifier' => false, '_api_item_operation_name' => 'patch'], ['id', '_format'], ['PATCH' => 0], null, false, true, null],
        ],
        462 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        482 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        528 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        542 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        562 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        575 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        585 => [
            [['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
