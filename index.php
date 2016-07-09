<?php
/**
 * @title          Legal Documents Management
 *
 * @author         Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright      (c) 2014, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License <http://www.gnu.org/licenses/gpl.html>
 */

define('PH7', 1);
define('ROOT_PATH', __DIR__ . '/');
require '_fns/misc.inc.php';
require '_config.inc.php';

ob_start();

echo '<!DOCTYPE html><html><head><meta charset="utf-8" /><title></title><meta name="robots" content="noindex" /></head><body><div style="text-align:center">';

if (isset($_GET['t'], $_GET['u'], $_GET['n']))
{
    $sType = escape($_GET['t']);
    $sUrl = escape($_GET['u']);
    $sName = escape($_GET['n']);
    $sAdult = (!empty($_GET['is_a'])) ? escape($_GET['is_a']) : 'n';
    $sHosting = (!empty($_GET['h'])) ? escape($_GET['h']) : 'arvixe';
    $sLang = get_lang();

    $sSlugUrl = '&amp;u='.$sUrl.'&amp;n='.$sName.'&amp;is_a='.$sAdult.'&amp;l='.$sLang;
    $sContent = ($sType == 'tos' || $sType == 'privacy' || $sType == 'imprint') ? get_page(ROOT_PATH . '_data/' . $sLang . '/' . $sType . '.txt') : exit('WRONG REQUEST!');


    $sContent = replace('AGE_PARAGRAPH_FR', ($sAdult == 'n' ? AGE_PARAGRAPH_FR : ADULT_AGE_PARAGRAPH_FR), $sContent);
    $sContent = replace('AGE_PARAGRAPH_EN', ($sAdult == 'n' ? AGE_PARAGRAPH_EN : ADULT_AGE_PARAGRAPH_EN) , $sContent);

    $sContent = replace('COMPANY_NAME', COMPANY_NAME, $sContent);
    $sContent = replace('COMPANY_NUMBER', COMPANY_NUMBER, $sContent);
    $sContent = replace('COMPANY_ADDRESS_FR', COMPANY_ADDRESS_FR, $sContent);
    $sContent = replace('COMPANY_ADDRESS_EN', COMPANY_ADDRESS_EN, $sContent);
    $sContent = replace('COMPANY_REGISTER_COUNTRY_EN', REGISTER_COUNTRY_EN, $sContent);
    $sContent = replace('COMPANY_REGISTER_COUNTRY_FR', REGISTER_COUNTRY_FR, $sContent);
    $sContent = replace('SITE_ICO_NUMBER', ICO_NUMBER, $sContent);
    $sContent = replace('SITE_NAME', $sName, $sContent);
    $sContent = replace('SITE_URL', $sUrl, $sContent);
    $sContent = replace('SITE_TOS_URL', LEGAL_URL . '?t=tos' . $sSlugUrl, $sContent);
    $sContent = replace('SITE_PRIVACY_URL', LEGAL_URL . '?t=privacy' . $sSlugUrl, $sContent);
    $sContent = replace('SITE_IMPRINT_URL', LEGAL_URL . '?t=imprint' . $sSlugUrl, $sContent);
    $sContent = replace('HOSTING_INFORMATION_FR', (escape($_GET['h'] == 'faction') ? FACTION_HOST_INFO_FR : ARVIXE_HOST_INFO_FR), $sContent);
    $sContent = replace('HOSTING_INFORMATION_EN', (escape($_GET['h'] == 'faction') ? FACTION_HOST_INFO_EN : ARVIXE_HOST_INFO_EN), $sContent);

    echo $sContent;
}
else
    echo error_404();

echo '</div></body></html>';

ob_end_flush();
