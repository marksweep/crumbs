<?php
/**
 * Routes
 *
 * Crumbs_routes.php will be loaded in main app/config/routes.php file.
 */
//    Croogo::hookRoutes('Crumbs');
/**
 * Behavior
 *
 * This plugin's Crumbs behavior will be attached whenever Node model is loaded.
 */
   Croogo::hookBehavior('Node', 'Crumbs.Crumbs', array());
/**
 * Component
 *
 * This plugin's Crumbs component will be loaded in ALL controllers.
 */
    Croogo::hookComponent('*', 'Crumbs.Crumbs');
/**
 * Helper
 *
 * This plugin's Crumbs helper will be loaded via NodesController.
 */
//    Croogo::hookHelper('Nodes', 'Crumbs.Crumbs');
/**
 * Admin menu (navigation)
 *
 * This plugin's admin_menu element will be rendered in admin panel under Extensions menu.
 */
    //Croogo::hookAdminMenu('Crumbs');
/**
 * Admin row action
 *
 * When browsing the content list in admin panel (Content > List),
 * an extra link called 'Crumbs' will be placed under 'Actions' column.
 */
    //Croogo::hookAdminRowAction('Nodes/admin_index', 'Crumbs', 'controller:nodes/action:edit/:id#node-revisions');
/**
 * Admin tab
 *
 * When adding/editing Content (Nodes),
 * an extra tab with title 'Crumbs' will be shown with markup generated from the plugin's admin_tab_node element.
 *
 * Useful for adding form extra form fields if necessary.
 */
//    Croogo::hookAdminTab('Nodes/admin_add', 'Crumbs', 'Crumbs.admin_tab_node');
//    Croogo::hookAdminTab('Nodes/admin_edit', 'Crumbs', 'Crumbs.admin_tab_node');
?>