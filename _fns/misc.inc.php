<?php
/**
 * @title          Legal Documents Management
 *
 * @author         Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright      (c) 2014, Pierre-Henry Soria. All Rights Reserved.
 * @license        GNU General Public License <http://www.gnu.org/licenses/gpl.html>
 */

defined('PH7') or exit('Restricted access');

function escape($sVal)
{
    return htmlspecialchars($sVal, ENT_QUOTES);
}

function replace($sSearch, $sReplace, $sSubject)
{
    return str_replace('<' . $sSearch . '>', $sReplace, $sSubject);
}

/**
 * Display a page if the file exists, otherwise displays a 404.
 *
 * @param string $sPage The page.
 * @return void
 */
function get_page($sPage)
{
    if (is_file($sPage))
    {
        return file_get_contents($sPage);
    }
    else
    {   // Set the Not Found page
        return error_404();
    }
}

/**
 * Detect the user's preferred language.
 *
 * @return string The first two lowercase letter of the browser language.
 */
function get_browser_lang()
{
    $aLang = explode(',' ,@$_SERVER['HTTP_ACCEPT_LANGUAGE']);
    return escape(strtolower(substr(chop($aLang[0]), 0, 2)));
}

/**
 * @see set_lang()
 * @return string The language available.
 */
function get_lang()
{
    return set_lang();
}

/**
 * Check if the language folder and the language core folder exists.
 *
 * @return string The language available.
 */
function set_lang()
{
    if (!empty($_GET['l']) && is_file(ROOT_PATH . '_data/' . $_GET['l'] . '/' . $_GET['t'] . '.txt'))
    {
        setcookie('hizup_legal_lang', $_GET['l'], time()+60*60*24*365, null, null, false, true);
        $sLang = $_GET['l'];
    }
    elseif (isset($_COOKIE['hizup_legal_lang']) && is_file(ROOT_PATH . '_data/' . $_COOKIE['hizup_legal_lang'] . '/' . $_GET['t'] . '.txt'))
    {
        $sLang = $_COOKIE['hizup_legal_lang'];
    }
    elseif (is_file(ROOT_PATH . '/_data/' . get_browser_lang() . '/' . $_GET['t'] . '.txt'))
    {
        $sLang = get_browser_lang();
    }
    else
    {
        $sLang = DEF_LANG;
    }

    return $sLang;
}

/**
 * Sets an error 404 page with HTTP 404 code status.
 *
 * @return void
 */
function error_404()
{
    header('HTTP/1.1 404 Not Found');
    return '<h1>Page Not Found!</h1>';
}
