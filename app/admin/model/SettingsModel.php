<?php
// Admin
$settingAdmin = new User(1);
$setting_admin_name       = $settingAdmin->getName();
$setting_admin_firstname  = $settingAdmin->getFirstName();
$setting_admin_fullname   = $settingAdmin->getFullName();
$setting_admin_mail       = $settingAdmin->getMail();
$setting_admin_pass       = $settingAdmin->getPass();
$setting_admin_role       = $settingAdmin->getRole();

// User
$settingUser = new User(2);
$setting_user_name       = $settingUser->getName();
$setting_user_firstname  = $settingUser->getFirstName();
$setting_user_fullname   = $settingUser->getFullName();
$setting_user_mail       = $settingUser->getMail();
$setting_user_pass       = $settingUser->getPass();
$setting_user_role       = $settingUser->getRole();

// Site
$settingSite = new Site();
$setting_site_name       = $settingSite->getName();
$setting_site_mail       = $settingSite->getMail();
$setting_site_domain     = $settingSite->getDomain();
$setting_site_url        = $settingSite->getUrl();
$setting_site_srcimg     = $settingSite->getSrcImg();
$setting_site_colorimg   = $settingSite->getColorImg();

?>