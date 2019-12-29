<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * xmnews module
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */

use Xmf\Module\Admin; 
use Xmf\Request;

require __DIR__ . '/admin_header.php';
include_once XOOPS_ROOT_PATH.'/class/xoopsform/grouppermform.php';
$moduleAdmin = Admin::getInstance();
$moduleAdmin->displayNavigation('permission.php');

// Get permission
$permission = Request::getInt('permission', 1);

// Category
$criteria = new CriteriaCompo();
$category_arr = $categoryHandler->getall($criteria);
if (count($category_arr) > 0) {
    $tab_perm = [1 => _MA_XMNEWS_PERMISSION_VIEW_ABSTRACT, 2 => _MA_XMNEWS_PERMISSION_VIEW_NEWS, 3 => _MA_XMNEWS_PERMISSION_SUBMIT, 4 => _MA_XMNEWS_PERMISSION_EDITAPPROVE, 5 => _MA_XMNEWS_PERMISSION_DELETE];
	$permission_options = '';
	foreach (array_keys($tab_perm) as $i) {
		$permission_options .= '<option value="' . $i . '"' . ($permission == $i ? ' selected="selected"' : '') . '>' . $tab_perm[$i] . '</option>';
	}
	$xoopsTpl->assign('permission_options', $permission_options);

	switch ($permission) {
		case 1:    // View permission abstract
			$formTitle = _MA_XMNEWS_PERMISSION_VIEW_ABSTRACT;
			$permissionName = 'xmnews_viewabstract';
			$permissionDescription = _MA_XMNEWS_PERMISSION_VIEW_ABSTRACT_DSC;
			foreach (array_keys($category_arr) as $i) {
				$global_perms_array[$i] = $category_arr[$i]->getVar('category_name');
			}
			break;
			
		case 2:    // View permission news
			$formTitle = _MA_XMNEWS_PERMISSION_VIEW_NEWS;
			$permissionName = 'xmnews_viewnews';
			$permissionDescription = _MA_XMNEWS_PERMISSION_VIEW_NEWS_DSC;
			foreach (array_keys($category_arr) as $i) {
				$global_perms_array[$i] = $category_arr[$i]->getVar('category_name');
			}
			break;

		case 3:    // Submit permission
			$formTitle = _MA_XMNEWS_PERMISSION_SUBMIT;
			$permissionName = 'xmnews_submit';
			$permissionDescription = _MA_XMNEWS_PERMISSION_SUBMIT_DSC;
			foreach (array_keys($category_arr) as $i) {
				$global_perms_array[$i] = $category_arr[$i]->getVar('category_name');
			}
			break;

		case 4:    // Edit/appove permission
			$formTitle = _MA_XMNEWS_PERMISSION_EDITAPPROVE;
			$permissionName = 'xmnews_editapprove';
			$permissionDescription = _MA_XMNEWS_PERMISSION_EDITAPPROVE_DSC;
			foreach (array_keys($category_arr) as $i) {
				$global_perms_array[$i] = $category_arr[$i]->getVar('category_name');
			}
			break;

		case 5:    // Delete permission
			$formTitle = _MA_XMNEWS_PERMISSION_DELETE;
			$permissionName = 'xmnews_delete';
			$permissionDescription = _MA_XMNEWS_PERMISSION_DELETE_DSC;
			foreach (array_keys($category_arr) as $i) {
				$global_perms_array[$i] = $category_arr[$i]->getVar('category_name');
			}
			break;
	}

	$permissionsForm = new XoopsGroupPermForm($formTitle, $helper->getModule()->getVar('mid'), $permissionName, $permissionDescription, 'admin/permission.php?permission=' . $permission);
	foreach ($global_perms_array as $perm_id => $permissionName) {
		$permissionsForm->addItem($perm_id , $permissionName) ;
	}
	$xoopsTpl->assign('form', $permissionsForm->render());
} else {
	$xoopsTpl->assign('error_message', _MA_XMNEWS_ERROR_NOCATEGORY);
}


$xoopsTpl->display("db:xmnews_admin_permission.tpl");

require __DIR__ . '/admin_footer.php';
