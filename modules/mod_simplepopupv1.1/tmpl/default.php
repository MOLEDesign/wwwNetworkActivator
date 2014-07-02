<?php 
/**
 * Simple PopUp - Joomla Module
 * 
 * @package    Joomla
 * @subpackage Module
 * @author Anders Was�n
 * @link http://wasen.net/
 * @license		GNU/GPL, see LICENSE.php
 * mod_simplepopupJ161.1 is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

defined('_JEXEC') or die('Restricted access'); // no direct access 

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

// If Joomla 3 then load jQuery through Joomla
if (version_compare(JVERSION, '3.0', 'ge')) {
//echo "VERSION 3!";
	$popupjqueryJ3 = true;
} else {
	$popupjqueryJ3 = false;
	//echo "VERSION OLDER";
}
if ($popupjqueryJ3) JHtml::_('jquery.framework');

jimport('joomla.application.module.helper');

$user = &JFactory::getUser();
		
$document =& JFactory::getDocument();

$document->addStyleSheet( $spu_basepath.'tmpl/spustyle.css' );
$document->addStyleSheet( $spu_basepath.'tmpl/fancybox/jquery.fancybox-1.3.4.css');

$spu_entermessage = $params->get( 'spu_entermessage', '' );
$spu_enterhtml = $params->get( 'spu_enterhtml', '' );
if (strlen($spu_enterhtml)) $spu_entermessage = $spu_enterhtml;

$spu_popuparticle = $params->get( 'spu_popuparticle', '' );
$spu_enterpopupurl = $params->get( 'spu_enterpopupurl', '' );
$spu_exitmessage = $params->get( 'spu_exitmessage', '' );
$spu_popexitalert = $params->get( 'spu_popexitalert', '1' );
$spu_popafterexitalert = $params->get( 'spu_popafterexitalert', '0' );
$spu_exitpopupurl = $params->get( 'spu_exitpopupurl', '' );
$spu_exitalert = $params->get( 'spu_exitalert', 'Please stay on this page to see an important message!' );

$spu_aligntext = $params->get( 'spu_aligntext', 'center' );
$spu_boxwidth = $params->get( 'spu_boxwidth', '400' );
$spu_boxheight = $params->get( 'spu_boxheight', 'auto' );
$spu_autodimensions = $params->get( 'spu_autodimensions', 'false' );

$spu2_aligntext = $params->get( 'spu2_aligntext', 'center' );
$spu2_boxwidth = $params->get( 'spu2_boxwidth', '400' );
$spu2_boxheight = $params->get( 'spu2_boxheight', 'auto' );
$spu2_autodimensions = $params->get( 'spu2_autodimensions', 'false' );

$spu_cookie = $params->get( 'spu_cookie', '0' );
$spu_cookiepersistence = $params->get( 'spu_cookiepersistence', '365' );

$spu_jquery = $params->get( 'spu_jquery', '0' );
$spu_jqueryinclude = $params->get( 'spu_jqueryinclude', '0' );
$upload_jqueryver = $params->get( 'upload_jqueryver', '1.7.2' );

$spu_poponexit = $params->get( 'spu_poponexit', '0' );
$spu_poponenter = $params->get( 'spu_poponenter', '1' );
$spu_poponmouseleave = $params->get( 'spu_poponmouseleave', '0' );

//Verification options
$spu_verification = $params->get( 'spu_verification', '0' );
$spu_verificationmsg = $params->get( 'spu_verificationmsg', '' );
$spu_verificationyestext= $params->get( 'spu_verificationyestext', 'Yes' );
$spu_verificationyes = $params->get( 'spu_verificationyes', '' );
$spu_verificationyesaction = $params->get( 'spu_verificationyesaction', '' );
$spu_verificationnotext= $params->get( 'spu_verificationnotext', 'No' );
$spu_verificationno = $params->get( 'spu_verificationno', '0' );
$spu_verificationnoaction = $params->get( 'spu_verificationnoaction', '' );
$spu_verificationjscript = $params->get( 'spu_verificationjscript', '' );
$spu_verificationarticle = (int)$params->get( 'spu_verificationarticle', '' );

$upload_jqueryj3 = $params->get( 'upload_jqueryj3', '0' );
if ($upload_jqueryj3 == 1) {
	$upload_jqueryj3 = 'patch';
} else {
	$upload_jqueryj3 = 'pack';
}

$addjavascript = "";

$resizeOnWindowResize = 'true';
$useragent = $_SERVER['HTTP_USER_AGENT'];
if(preg_match('/android.+mobile|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) $resizeOnWindowResize = 'false';;


// Get Module ID to create unique names
$mid = $module->id;
$spu_enterpopupname = 'spuenter_'.$mid;
$spu_exitpopupname = 'spuexit_'.$mid;

// Make sure "auto" becomes 'auto' for jScript function!
if (!is_numeric($spu_boxwidth)) 
	$spu_boxwidth = "'".$spu_boxwidth."'";

if (!is_numeric($spu_boxheight)) 
	$spu_boxheight = "'".$spu_boxheight."'";


if (!is_numeric($spu2_boxwidth)) 
	$spu2_boxwidth = "'".$spu2_boxwidth."'";

if (!is_numeric($spu2_boxheight)) 
	$spu2_boxheight = "'".$spu2_boxheight."'";

// Check if some other extension has loaded jQuery
if (JFactory::getApplication()->get('jquery')) $spu_jquery = 1;

if ($spu_jquery == 0 && !$popupjqueryJ3) {
	if ($spu_jqueryinclude == 0)
		JHtml::script( $spu_basepath.'tmpl/jquery-'.$upload_jqueryver.'.min.js' );
	else
		echo '<script type="text/javascript" src="'.$spu_basepath.'tmpl/jquery-'.$upload_jqueryver.'.min.js"></script>';
	
	JFactory::getApplication()->set('jquery', true);
}
if ($spu_jquery < 2) {
	if ($spu_jqueryinclude == 0) {
		JHtml::script( $spu_basepath.'tmpl/fancybox/jquery.mousewheel-3.0.4.pack.js' );
		JHtml::script( $spu_basepath.'tmpl/fancybox/jquery.fancybox-1.3.4.'.$upload_jqueryj3.'.js' );
	} else {
		echo '<script type="text/javascript" src="'.$spu_basepath.'tmpl/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>';
		echo '<script type="text/javascript" src="'.$spu_basepath.'tmpl/fancybox/jquery.fancybox-1.3.4.'.$upload_jqueryj3.'.js"></script>';
	}
}

$formtoken = JHtml::_('form.token');

// Show only once per session and not on register page	
$session = JFactory::getSession();
$showpop = $session->get('hrbshowpopup');
if ($showpop !== false) $showpop = true;
$session->set('hrbshowpopup', false);
$showpop = true;
//$session->clear('hrbshowpopup');

?>
<!-- SPU HTML GOES BELOW -->
<a style="display:none;" id="a<?php echo $spu_enterpopupname; ?>" href="#<?php echo $spu_enterpopupname; ?>">popup</a>

<script language="javascript" type="text/javascript">
<!--

<?php if ($spu_cookie === '1')  { ?>
function spu_createCookie(name, value, days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	} else {
		var expires = "";
	}
	document.cookie = name+"="+value+expires+"; path=/";
}

function spu_readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
	}
	return null;
}

function spu_eraseCookie(name) {
	spu_createCookie(name,"",-1);
}
<?php } ?>

-->
</script>

<script language="javascript" type="text/javascript">
<!--
var fshowMsg = true;

jQuery(document).ready(function() {
	
	
	<?php if ($type === 'logout' || $showpop == false) echo 'fshowMsg = false;'?>
	
	<?php if ($spu_cookie === '1')  { ?>
		var cookieName = '';
		
		<?php if ($spu_verification == 1)  { ?>
			cookieName = '_verifyyes';
		<?php } else {
				if (strlen($spu_popupname) > 0)  { ?>
					cookieName = '<?php echo $spu_popupname; ?>';
			<?php } else { ?>
					cookieName = '_pageload';
			<?php } 
			} ?>
		
		var cookieRet = spu_readCookie('spu_cookie'+cookieName);
		if(!cookieRet) {
			// Cookie not found, set cookie expiration and show message
			var persistance = <?php if ($spu_cookiepersistence == -1) echo 'false'; else echo $spu_cookiepersistence; ?>;
			
			spu_createCookie('spu_cookie'+cookieName, cookieName, persistance);
		} else {
			// Cookie exists, skip message
			fshowMsg = false;
		}
	<?php } 
	
	if ($spu_poponenter == 1) { ?>
			
		//if (fshowMsg) {
			jQuery("#a<?php echo $spu_enterpopupname; ?>").fancybox({
					<?php if ($spu_autodimensions === 'false') { ?>
				'autoDimensions'	: false,
				'width'         	: <?php echo $spu_boxwidth; ?>,
				'height'        	: <?php echo $spu_boxheight; ?>,
				<?php } else { ?>
				'autoDimensions'	: true,
				<?php } ?>
				<?php if ($spu_verification != 1) { ?>
				'showCloseButton'	: true,
				'hideOnOverlayClick': true,
				<?php } else { ?>
				'hideOnOverlayClick': false,
				'showCloseButton'	: false,
				<?php } ?>
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'resizeOnWindowResize'	: <?php echo $resizeOnWindowResize ?>,
				'centerOnScroll'	: <?php echo $resizeOnWindowResize ?>,
				'overlayOpacity': 0.90,
				'overlayColor': 'black'
				}
			);
		//}
	
	<?php } 
	
	if ($spu_poponexit == 1) { 
	
		if ($spu_popexitalert == 1) { ?>
		
			if (fshowMsg) {
				// Don't pop if there is a cookie
				window.onbeforeunload = spuOnExit;
			}
			
			function spuOnExit() {
				if (fshowMsg) {
					fshowMsg = false;
					<?php if ($spu_popafterexitalert == 1) { ?>
						jQuery("#a<?php echo $spu_exitpopupname; ?>").trigger("click");
					<?php } ?>
					return '<?php echo $spu_exitalert ?>';
				}
			}
		
		<?php } ?>
	
	
		jQuery("#a<?php echo $spu_exitpopupname; ?>").fancybox({
			<?php if ($spu_autodimensions === 'false') { ?>
				'autoDimensions'	: false,
				'width'         	: <?php echo $spu_boxwidth; ?>,
				'height'        	: <?php echo $spu_boxheight; ?>,
				<?php } else { ?>
				'autoDimensions'	: true,
				<?php } ?>
				'showCloseButton'	: true,
				'hideOnOverlayClick': false,
				'transitionIn'		: 'elastic',
				'transitionOut'		: 'elastic',
				'resizeOnWindowResize'	: <?php echo $resizeOnWindowResize ?>,
				'centerOnScroll'	: <?php echo $resizeOnWindowResize ?>
			}
		);
		
		<?php if ($spu_poponmouseleave == 1) { ?>
			jQuery(document).bind('mouseleave', function(event) {
				// Make sure it's only pop'ed once
				if (fshowMsg) {
					jQuery("#a<?php echo $spu_exitpopupname; ?>").trigger("click");
				}
				fshowMsg = false;
			});

	<?php }
	} ?>
	
	
	
});

-->
</script>

<!-- FancyBox -->
<div id="spuSimplePoPup<?php echo $mid; ?>" style="display: none;">
	<?php if ($spu_poponenter == 1) { ?>
	<div id="<?php echo $spu_enterpopupname; ?>">
		<div style="text-align: <?php echo $spu_aligntext; ?>;">	
			<?php
			
			if($spu_verification == 1) {
				$vercookie = '';
				$novercookie = '';
				if ($spu_cookie == 1) $vercookie = ' spu_createCookie(\'spu_cookie_verifyyes\', \'yes\', '.$spu_cookiepersistence.');';
				if ($spu_cookie == 1) $novercookie = ' spu_eraseCookie(\'spu_cookie_verifyyes\', \'yes\', '.$spu_cookiepersistence.');';
				$yesaction = "";
				$noaction = "";
				
				if ($spu_verificationarticle > 0) {
					$db  =& JFactory::getDBO();
					$query = 'SELECT CONCAT(a.introtext, a.fulltext) FROM #__content AS a WHERE a.state=1 AND a.id='.(int)$spu_verificationarticle;
					$db->setQuery($query);
					$rows = $db->loadResult();
					$spu_entermessage = $rows;
				} else {
					$spu_entermessage = $spu_verificationmsg;
				}

                switch ($spu_verificationno) {
                    case "close":
                        $noaction = '<input type="button" class="preview-no-button" value="'.$spu_verificationnotext.'" onclick="javascript:'.$novercookie.' jQuery.fancybox.close();" />';
                        break;
                    case "redir":
                        $noaction = '<input type="button" class="preview-no-button" value="'.$spu_verificationnotext.'" onclick="javascript:'.$novercookie.' window.location=\''.$spu_verificationnoaction.'\';" />';
                        break;
                    case "msg":
                        $noaction = '<input type="button" class="preview-no-button" value="'.$spu_verificationnotext.'" onclick="javascript:'.$novercookie.' alert(\''.$spu_verificationnoaction.'\');" />';
                        break;
                    case "jscript":
                        $noaction = '<input type="button" class="preview-no-button" value="'.$spu_verificationnotext.'" onclick="javascript:'.$novercookie.' '.$spu_verificationnoaction.';" />';
                        break;
                }

				switch ($spu_verificationyes) {
					case "close":
						$yesaction = '<input type="button" class="preview-yes-button" value="'.$spu_verificationyestext.'" onclick="javascript:'.$vercookie.' jQuery.fancybox.close();" />';
						break;
					case "redir":
						$yesaction = '<input type="button" class="preview-yes-button" value="'.$spu_verificationyestext.'" onclick="javascript:'.$vercookie.' window.location=\''.$spu_verificationyesaction.'\';" />';
						break;
					case "msg":
						$yesaction = '<input type="button" class="preview-yes-button" value="'.$spu_verificationyestext.'" onclick="javascript:'.$vercookie.' spu_createCookie(\'spu_verifyyes\'); alert(\''.$spu_verificationyesaction.'\');" />';
						break;
					case "jscript":
						$yesaction = '<input type="button" class="preview-yes-button" value="'.$spu_verificationyestext.'" onclick="javascript:'.$vercookie.' spu_createCookie(\'spu_verifyyes\'); '.$spu_verificationyesaction.';" />';
						break;
				}

				$spu_entermessage .= '<br /><div>'.$yesaction.'&nbsp;'.$noaction.'</div>';

			} else {
			
				if ($spu_popuparticle > 0) {
					$db  =& JFactory::getDBO();
					$query = 'SELECT CONCAT(a.introtext, a.fulltext) FROM #__content AS a WHERE a.state=1 AND a.id='.(int)$spu_popuparticle;
					$db->setQuery($query);
					$rows = $db->loadResult();
					$spu_entermessage = $rows;
				}
				
				// Add module(s)
				$regex = '/{loadposition\s*.*?}/i';
				$module_content = $spu_entermessage;
				$loadmodule = "";
				preg_match_all( $regex, $module_content, $matches );

			   // Number of loadposition
				$modulecount = count( $matches[0] );

				// Load modules
				if ($modulecount) {
					for ( $i=0; $i < $modulecount; $i++ )
					{
					   $loadmodule = str_replace( 'loadposition', '', $matches[0][$i] );
					   $loadmodule = str_replace( '{', '', $loadmodule );
					   $loadmodule = str_replace( '}', '', $loadmodule );
					   $loadmodule = trim( $loadmodule );
//echo "LOAD:".$loadmodule."<br/>";
					}

			   
//echo "MC:".$module_content."<br/>";

					$db  =& JFactory::getDBO();
					$db->setQuery("SELECT module, content FROM #__modules WHERE position='".$loadmodule."' AND published=1");
					$rows = $db->loadResult();
					$moduletype = $rows;
					
					$module = JModuleHelper::getModule($moduletype,$loadmodule);
//echo "Found ".count($module)." modules<br/>Looked for: ".$moduletype.", ".$loadmodule."<br/>";

					if ($moduletype === 'mod_custom') {
						$db->setQuery("SELECT content FROM #__modules WHERE position='".$loadmodule."' AND published=1");
						$rows = $db->loadResult();
						$module_content = $rows;
					} else {
						$module_content = JModuleHelper::renderModule($module);
					}
					
					
					$module_content = str_replace( '[return]', $return, $module_content );
					$module_content = str_replace( '[token]', $formtoken, $module_content );
					
					
					// removes tags without matching module positions
				   $spu_entermessage = preg_replace( $regex, $module_content, $spu_entermessage);
				}
				
				if(strlen($spu_enterhtml) > 0) {
					// For special login
					$formaction = JRoute::_('index.php', true, $params->get('usesecure'));
					
					$spu_entermessage = str_replace( '[action]', $formaction, $spu_entermessage );
					$spu_entermessage = str_replace( '[return]', $return, $spu_entermessage );
					$spu_entermessage = str_replace( '[token]', $formtoken, $spu_entermessage );
					
					
				}
				
				if(strlen($spu_enterpopupurl) > 0) {
					$pagecontent = file_get_contents($spu_enterpopupurl, FILE_TEXT);
					$pagecontent = mb_convert_encoding($pagecontent, 'UTF-8', mb_detect_encoding($pagecontent, 'UTF-8, ISO-8859-1', true));

					if ($pagecontent === false) $pagecontent = 'URL ('.$spu_enterpopupurl.') failed to load. Please inform the site administrator!';
					$spu_entermessage = $pagecontent;
				}
			}
			
			
			
			echo $spu_entermessage;
			?>
	<?php }
	
	
	if ($spu_poponexit == 1) { ?>
	
	<a id="a<?php echo $spu_exitpopupname; ?>" href="#<?php echo $spu_exitpopupname; ?>">popup</a>
	<div id="<?php echo $spu_exitpopupname; ?>" class="spu_content" style="text-align: <?php echo $spu2_aligntext; ?>;">
		<?php 
		if(strlen($spu_exitpopupurl) > 0) {
			$pagecontent = file_get_contents($spu_exitpopupurl, FILE_TEXT);
			$pagecontent = mb_convert_encoding($pagecontent, 'UTF-8', mb_detect_encoding($pagecontent, 'UTF-8, ISO-8859-1', true));

			if ($pagecontent === false) $pagecontent = 'URL ('.$spu_exitpopupurl.') failed to load. Please inform the site administrator!';
			$spu_exitmessage = $pagecontent;
		}
		echo $spu_exitmessage;
		?>
	</div>
	<?php } ?>
</div>

<?php if ($spu_poponenter == 1) { ?>
<script type="text/javascript">
jQuery(document).ready(function() {
	if (fshowMsg) {
		jQuery("#a<?php echo $spu_enterpopupname; ?>").trigger("click");
	}
});
</script>
<?php } ?>
<!-- END SFG HTML -->