<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : 
 *  2014 - Caccia : fix #1544
 *
 * This file is part of ProjeQtOr.
 * 
 * ProjeQtOr is free software: you can redistribute it and/or modify it under 
 * the terms of the GNU General Public License as published by the Free 
 * Software Foundation, either version 3 of the License, or (at your option) 
 * any later version.
 * 
 * ProjeQtOr is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for 
 * more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ProjeQtOr. If not, see <http://www.gnu.org/licenses/>.
 *
 * You can get complete code of ProjeQtOr, other resource, help and information
 * about contributors at http://www.projeqtor.org 
 *     
 *** DO NOT REMOVE THIS NOTICE ************************************************/

/* ============================================================================
 * Main page of application.
 * This page includes Frame definitions and framework requirements.
 * All the other pages are included into this one, in divs, using Ajax.
 * 
 *  Remarks for deployment :
 *    - set isDebug:false in djConfig
 */
$mobile=false;
require_once "../tool/projeqtor.php";
header ('Content-Type: text/html; charset=UTF-8');
scriptLog('   ->/view/main.php');
if (Sql::getDbVersion()!=$version) {
	//Here difference of version is an important issue => disconnect and get back to login page.
	//session_destroy();
	Audit::finishSession();
	include_once 'login.php';
	exit;
}
$currency=Parameter::getGlobalParameter('currency');
$currencyPosition=Parameter::getGlobalParameter('currencyPosition');
checkVersion(); 
// Set Project & Planning element as cachable : will not change during operation
SqlElement::$_cachedQuery['Project']=array();
SqlElement::$_cachedQuery['ProjectPlanningElement']=array();
SqlElement::$_cachedQuery['PlanningElement']=array();
$keyDownEventScript=NumberFormatter52::getKeyDownEvent();
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" 
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>   
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="keywork" content="projeqtor, project management" />
  <meta name="author" content="projeqtor" />
  <meta name="Copyright" content="Pascal BERNARD" />
<?php if (! isset($debugIEcompatibility) or $debugIEcompatibility==false) {?>  
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?php }?> 
  <title><?php echo (Parameter::getGlobalParameter('paramDbDisplayName'))?Parameter::getGlobalParameter('paramDbDisplayName'):i18n("applicationTitle");?></title>
  <link rel="stylesheet" type="text/css" href="css/jsgantt.css" />
  <link rel="stylesheet" type="text/css" href="css/projeqtor.css" />
  <link rel="shortcut icon" href="img/logo.ico" type="image/x-icon" />
  <link rel="icon" href="img/logo.ico" type="image/x-icon" />
  <script type="text/javascript" src="../external/CryptoJS/rollups/md5.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../external/CryptoJS/rollups/sha256.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="../external/phpAES/aes.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="js/projeqtor.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="js/jsgantt.js?version=<?php echo $version.'.'.$build;?>"></script>
  <script type="text/javascript" src="js/projeqtorWork.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="js/projeqtorDialog.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript" src="js/projeqtorFormatter.js?version=<?php echo $version.'.'.$build;?>" ></script>
  <script type="text/javascript">
        var dojoConfig = {
            modulePaths: {"i18n":"../../tool/i18n",
                          "i18nCustom":"../../plugin"},
            parseOnLoad: true,
            isDebug: <?php echo getBooleanValueAsString(Parameter::getGlobalParameter('paramDebugMode'));?>
        };
  </script>
  <script type="text/javascript" src="../external/dojo/dojo.js?version=<?php echo $version.'.'.$build;?>"></script>
  <script type="text/javascript" src="../external/dojo/projeqtorDojo.js?version=<?php echo $version;?>"></script>
  <?php Plugin::includeAllFiles();?>
  <script type="text/javascript">
    var customMessageExists=<?php echo(file_exists(Plugin::getDir()."/nls/$currentLocale/lang.js"))?'true':'false';?>; 
    dojo.require("dojo.data.ItemFileWriteStore");
    dojo.require("dojo.date");
    dojo.require("dojo.date.locale");
    dojo.require("dojo.dnd.Container");
    dojo.require("dojo.dnd.Manager");
    dojo.require("dojo.dnd.Source");
    dojo.require("dojo.dom-construct");
    dojo.require("dojo.dom-geometry");
    dojo.require("dojo.i18n");
    dojo.require("dojo.fx.easing");
    //dojo.require("dojox.fx.ext-dojo.NodeList-style"); // ====================NEW
    dojo.require("dojo.NodeList-fx");
    dojo.require("dojo.parser");   // ===================== NEW
    dojo.require("dojo.query");
    dojo.require("dojo.store.DataStore");
    dojo.require("dijit.ColorPalette");
    dojo.require("dijit.Dialog"); 
    dojo.require("dijit.Editor");
    dojo.require("dijit._editor.plugins.AlwaysShowToolbar");
    dojo.require("dijit._editor.plugins.FullScreen");
    dojo.require("dijit._editor.plugins.FontChoice");
    dojo.require("dijit._editor.plugins.Print");
    dojo.require("dijit._editor.plugins.TextColor");
    //dojo.require("dijit._editor.plugins.LinkDialog");
    //dojo.require("dojox.editor.plugins.LocalImage");
    dojo.require("dijit.Fieldset");
    dojo.require("dijit.form.Button");
    dojo.require("dijit.form.CheckBox");
    dojo.require("dijit.form.ComboBox");
    dojo.require("dijit.form.DateTextBox");
    dojo.require("dijit.form.FilteringSelect");
    dojo.require("dijit.form.Form");
    dojo.require("dijit.form.MultiSelect");
    dojo.require("dijit.form.NumberSpinner");
    dojo.require("dijit.form.NumberTextBox");
    dojo.require("dijit.form.RadioButton");
    dojo.require("dijit.form.Select");
    dojo.require("dijit.form.Textarea");
    dojo.require("dijit.form.TextBox");
    dojo.require("dijit.form.TimeTextBox");
    dojo.require("dijit.form.ValidationTextBox");
    dojo.require("dijit.InlineEditBox");
    dojo.require("dijit.layout.AccordionContainer");
    dojo.require("dijit.layout.BorderContainer");
    dojo.require("dijit.layout.ContentPane");
    dojo.require("dijit.Menu"); 
    dojo.require("dijit.MenuBar"); 
    dojo.require("dijit.MenuBarItem");
    dojo.require("dijit.PopupMenuBarItem");
    dojo.require("dijit.ProgressBar");
    dojo.require("dijit.TitlePane");
    dojo.require("dijit.Toolbar") 
    dojo.require("dijit.Tooltip");
    dojo.require("dijit.Tree"); 
    dojo.require("dojox.form.FileInput");
    dojo.require("dojox.form.Uploader");
    dojo.require("dojox.form.uploader.FileList");
    dojo.require("dojox.fx");
    dojo.require("dojox.grid.DataGrid");
    dojo.require("dojox.image.Lightbox");
    dojo.subscribe("/dnd/drop", function(source, nodes, copy, target){
       if (source.id!=target.id) { return;}
       if (nodes.length>0 && nodes[0] && target && target.current) {
         var idFrom = nodes[0].id;
         var idTo = target.current.id;                   
         if (target.id=='dndSourceTable') {
        	 showWait();  
           setTimeout('moveTask("' + idFrom + '", "' + idTo + '")',100);
         } else  if (target.id=='dndPlanningColumnSelector') {
        	 setTimeout('movePlanningColumn("' + idFrom + '", "' + idTo + '")',100);
         } else  if (target.id=='dndListColumnSelector') {
           setTimeout('moveListColumn("' + idFrom + '", "' + idTo + '")',100);
         } else if (target.id=='dndTodayParameters') {
           setTimeout('reorderTodayItems()',100);  
         } else if (target.id=='dndFavoriteReports') {
        	 setTimeout('reorderFavoriteReportItems()',100);  
         }
       }
    });
    dndMoveInProgress=false;
    dojo.subscribe("/dnd/drop/before", function(source, nodes, copy, target){
    	dndMoveInProgress=true;
      setTimeout("dndMoveInProgress=false;",50);
    });
    var historyTable=new Array();
    var historyPosition=-1;    
    var fadeLoading=<?php echo getBooleanValueAsString(Parameter::getGlobalParameter('paramFadeLoadingMode'));?>;
    var refreshUpdates="YES";
    var aesLoginHash="<?php echo md5(session_id());?>";
    var printInNewWindow=<?php echo (getPrintInNewWindow())?'true':'false';?>;
    var pdfInNewWindow=<?php echo (getPrintInNewWindow('pdf'))?'true':'false';?>;
    var alertCheckTime='<?php echo Parameter::getGlobalParameter('alertCheckTime');?>';
    var offDayList='<?php echo Calendar::getOffDayList();?>';
    var workDayList='<?php echo Calendar::getWorkDayList();?>';
    var draftSeparator='<?php echo Parameter::getGlobalParameter('draftSeparator');?>';
    var paramCurrency='<?php echo $currency;?>';
    var paramCurrencyPosition='<?php echo $currencyPosition;?>';
    var paramWorkUnit='<?php echo Parameter::getGlobalParameter('workUnit');?>';
    if (! paramWorkUnit) paramWorkUnit='days';
    var paramHoursPerDay='<?php echo Parameter::getGlobalParameter('dayTime');?>';
    if (! paramHoursPerDay) paramHoursPerDay=8;
    var paramConfirmQuit="<?php echo Parameter::getUserParameter("paramConfirmQuit")?>";
    var browserLocaleDateFormat="<?php echo Parameter::getUserParameter('browserLocaleDateFormat');?>";
    var browserLocaleDateFormatJs=browserLocaleDateFormat.replace(/D/g,'d').replace(/Y/g,'y');
    <?php $fmt=new NumberFormatter52( $browserLocale, NumberFormatter52::DECIMAL );?>
    var browserLocaleDecimalSeparator="<?php echo $fmt->decimalSeparator?>";
    dojo.addOnLoad(function(){
      currentLocale="<?php echo $currentLocale;?>";
      <?php 
      if (isset($_SESSION['hideMenu'])) {
        if ($_SESSION['hideMenu']!='NO') {
          echo "menuHidden=true;";
          echo "menuShowMode='" . $_SESSION['hideMenu'] . "';";
        }
      }
      if (isset($_SESSION['switchedMode'])) {
        if ($_SESSION['switchedMode']!='NO') {
          echo "switchedMode=true;";
          echo "switchListMode='" . $_SESSION['switchedMode'] . "';";
        }
      }     
      ?>
      dijit.Tooltip.defaultPosition=["below", "right"];
      addMessage("<?php echo i18n('welcomeMessage').' '.((getSessionUser()->resourceName)?getSessionUser()->resourceName:getSessionUser()->name);?>");
      //dojo.byId('body').className='<?php echo getTheme();?>';
      saveResolutionToSession();
      saveBrowserLocaleToSession();
      // Relaunch Cron (if stopped, any connexion will restart it)
      adminCronRelaunch();
      var onKeyPressFunc = function(event) {
        if(event.ctrlKey && ! event.altKey && event.keyChar == 's'){
          event.preventDefault();
          if (dojo.isFF) stopDef(event);
          globalSave();
        } else if (event.keyCode==dojo.keys.F1 && ! event.keyChar) {
          event.preventDefault();
          if (dojo.isFF) stopDef(event);
          showHelp();
        }  
      };
      var onKeyDownFunc = function(event) {
        if (event.keyCode == 83 && (navigator.platform.match("Mac") ? event.metaKey : event.ctrlKey) && ! event.altKey) { // CTRL + S
          event.preventDefault();
          if (dojo.isFF) stopDef();
          globalSave();
        } else if (event.keyCode == 112) { // On F1
          event.preventDefault();
          if (dojo.isFF) stopDef();
          showHelp();
        }
      };
      if (dojo.isIE<=8) {
        dojo.connect(document, "onkeypress", this, onKeyPressFunc);
      } else {
        dojo.connect(document, "onkeydown", this, onKeyDownFunc);
      }
      <?php 
      $firstPage="welcome.php";
      if (securityCheckDisplayMenu(1) ) {
      	$firstPage="today.php";
      }
      $paramFirstPage=Parameter::getUserParameter('startPage');
      if ($paramFirstPage) {
        $firstPage=$paramFirstPage;
      }
      if (array_key_exists("directAccessPage",$_REQUEST)) {
        securityCheckRequest();
        $firstPage=$_REQUEST['directAccessPage'];
        if (array_key_exists("menuActualStatus",$_REQUEST)) {
          $menuActualStatus=$_REQUEST['menuActualStatus'];
          if ($menuActualStatus!='visible') {
            echo 'hideShowMenu();';
          }
        }         
        for ($i=1;$i<=9;$i++) {
          $pName='p'.$i.'name';
          $pValue='p'.$i.'value';
          if (array_key_exists($pName,$_REQUEST) and array_key_exists($pValue,$_REQUEST) ) {
            $firstPage.=($i==1)?'?':'&';
            $firstPage.=htmlentities($_REQUEST[$pName])."=".htmlentities($_REQUEST[$pValue]);
          } else {
            break;
          }
        }
        echo "dojo.byId('directAccessPage').value='';";
        echo "dojo.byId('menuActualStatus').value='';";
      } else if (array_key_exists('objectClass', $_REQUEST) and array_key_exists('objectId', $_REQUEST) ) {
        $class=$_REQUEST['objectClass'];
        $id=$_REQUEST['objectId'];
        if (array_key_exists('directAccess', $_REQUEST)) {
        	echo "noDisconnect=true;";
        	if (isset($_SESSION['directAccessIndex'])) {
        		$directAccessIndex=$_SESSION['directAccessIndex'];
        	}	else { 
        	  $directAccessIndex=array();
          }
          $index=count($directAccessIndex)+1;
          if ($class) $directAccessIndex[$index]=new $class($id);
          else $directAccessIndex[$index]='';
          $_SESSION['directAccessIndex']=$directAccessIndex;
        	echo "directAccessIndex=$index;";
        }
        if ($class=="Today") {
          $firstPage="welcome.php";
        } else { 
          echo 'gotoElement("' . $class . '","' . $id . '");';
          $firstPage="";
        }
      } else if (Parameter::getUserParameter('hideMenu') and Parameter::getUserParameter('hideMenu')!='NO'){
        echo 'hideShowMenu();';
      }
      
      if ($firstPage) {
      ?>
        loadContent("<?php echo $firstPage;?>","centerDiv");
      <?php 
      }
      ?>
      dojo.byId("loadingDiv").style.visibility="hidden";
      dojo.byId("loadingDiv").style.display="none";
      dojo.byId("mainDiv").style.visibility="visible"; 
      setTimeout('checkAlert();',5000); //first check at 5 seco 
      <?php if ($firstPage=="welcome.php") {?>
          setTimeout("runWelcomeAnimation();",2000);
      <?php } ?>
      <?php // check for ongoing work on Ticket 
      if (getSessionUser()->id) {
	      $crit=array('ongoing'=>'1','idUser'=>getSessionUser()->id);
	      $we=SqlElement::getSingleSqlElementFromCriteria('WorkElement', $crit);
	      if ($we and $we->id) {
	      	$start=$we->ongoingStartDateTime;
	      	//echo "startStopWork('start', '$we->refType', $we->refRefId, $start);";
	      }
      }
      ?>
      showHideMoveButtons();
    }); 
    var ganttPlanningScale="<?php echo Parameter::getUserParameter('planningScale');?>";
    var cronSleepTime=<?php echo Cron::getSleepTime();?>;
    var canCreateArray=new Array();
    var dependableArray=new Array();
    var linkableArray=new Array();
    var originableArray=new Array();
    var copyableArray=new Array();
    var indicatorableArray=new Array();
    var mailableArray=new Array();
    var textableArray=new Array();
    var checklistableArray=new Array();
    var planningColumnOrder=new Array();
    <?php
      echo "\n";
      $list=SqlList::getListNotTranslated('Dependable');
      foreach ($list as $id=>$name) {
      	$right=securityGetAccessRightYesNo('menu' . $name,'create');
      	echo "canCreateArray['" . $name . "']='" . $right . "';";
      	echo "dependableArray['" . $id . "']='" . $name . "';";
      }
      echo "\n";
      $list=SqlList::getListNotTranslated('Linkable');
      foreach ($list as $id=>$name) {
        $right=securityGetAccessRightYesNo('menu' . $name,'create');
        echo "canCreateArray['" . $name . "']='" . $right . "';";
        echo "linkableArray['" . $id . "']='" . $name . "';";
      }
      echo "\n";
      $list=SqlList::getListNotTranslated('Originable');
      foreach ($list as $id=>$name) {
        $right=securityGetAccessRightYesNo('menu' . $name,'create');
        echo "canCreateArray['" . $name . "']='" . $right . "';";
        echo "originableArray['" . $id . "']='" . $name . "';";
      }
      echo "\n";
      $list=SqlList::getListNotTranslated('Copyable');
      foreach ($list as $id=>$name) {
        echo "copyableArray['" . $id . "']='" . $name . "';";
      }
      echo "\n";
      $list=SqlList::getListNotTranslated('Indicatorable');
      foreach ($list as $id=>$name) {
        echo "indicatorableArray['" . $id . "']='" . $name . "';";
      }
      echo "\n";
      $list=SqlList::getListNotTranslated('Mailable');
      foreach ($list as $id=>$name) {
        echo "mailableArray['" . $id . "']='" . $name . "';";
      }
      echo "\n";
      $list=SqlList::getListNotTranslated('Textable');
      foreach ($list as $id=>$name) {
        echo "textableArray['" . $id . "']='" . $name . "';";
      }
      echo "\n";
      $list=SqlList::getListNotTranslated('Checklistable');
      foreach ($list as $id=>$name) {
      	echo "checklistableArray['" . $id . "']='" . $name . "';";
      }
      echo "\n";
      $list=Parameter::getPlanningColumnOrder();
      foreach ($list as $order=>$name) {
        echo "planningColumnOrder[" . ($order-1) . "]='" . $name . "';";
      }
      echo "\n";
      Plugin::getTranslationJsArrayForPlugins('i18nPluginArray');
      ?>
    //window.onbeforeunload = function (evt){ return beforequit();};
  </script>
</head>
<body id="body" class="tundra <?php echo getTheme();?>" onBeforeUnload="return beforequit();" onUnload="quit();">
<div id="centerThumb80" style="display:none;z-index:999999;position:absolute;top:10px;left:10px;height:80px;width:80px;"></div>
<div id="loadingDiv" class="<?php echo getTheme();?> loginFrame" 
 style="position:absolute; visibility: visible; display:block; width:100%; height:100%; margin:0; padding:0; border:0">  
  <table align="center" width="100%" height="100%" class="loginBackground">
    <tr height="100%">
      <td width="100%" align="center">
        <div class="background loginFrame" >
        <table align="center" >
          <tr style="height:10px;">
            <td align="left" style="position:relative;height: 100%;" valign="top">
              <div style="position:relative; width: 400px; height: 54px;">
    	          <div style="overflow:visible;position:absolute;width: 480px; height: 280px;top:15px;text-align: center">
    	           <div id="waitLogin" style="position:absolute;top:50%"></div>  
	    		        <img style="max-height:60px" src="<?php 
	    		          if (file_exists("../logo.gif")) echo '../logo.gif';
	    		          else if (file_exists("../logo.jpg")) echo '../logo.jpg';
	    		          else if (file_exists("../logo.png")) echo '../logo.png';
	    		          else echo 'img/titleSmall.png';?>" />
    	          </div>
  	            <div style="width: 470px; height:130px;position:absolute;top:160px;overflow:hidden;text-align:center;">
                  Loading ...                               
                </div>
              </div>
            </td>
          </tr>
          <tr style="height:100%" height="100%">
            <td style="height:99%" align="left" valign="middle">
              <div  id="" style="width: 470px; height:210px;overflow:hidden">
              </div>
            </td>
          </tr>
        </table>
        </div>
      </td>
    </tr>
  </table>
</div>
<div id="mainDiv" style="visibility: hidden;">
  <div id="wait" >
  </div>
  <div dojoType="dijit/ProgressBar" id="downloadProgress" data-dojo-props="maximum:1">
  </div>
  
  <div id="globalContainer" class="container" dojoType="dijit.layout.BorderContainer" liveSplitters="false">    
    <div id="leftDiv" dojoType="dijit.layout.ContentPane" region="left" splitter="true">
     <div id="menuBarShow" onMouseover="tempShowMenu('mouse');" onClick="tempShowMenu('click');"><div id="menuBarIcon" valign="middle"></div></div>       
      <div class="container" dojoType="dijit.layout.BorderContainer" liveSplitters="false">
        <div id="logoDiv" dojoType="dijit.layout.ContentPane" region="top">
          <script> 
            aboutMessage="<?php echo $aboutMessage;?>";
            aboutMessage+='Dojo '+dojo.version+'<br/><br/>';
          </script>
          <?php 
            $width=300;
            if (array_key_exists('screenWidth',$_SESSION)) {
              $width = $_SESSION['screenWidth'] * 0.2;
            }
            $zoom=round($width/300*100, 0);  
          ?>
          <div id="logoTitleDiv" 
               style="background-image: url(<?php echo (file_exists("../logo.gif"))?'../logo.gif':'img/titleWhiteSmall.png';?>); 
                      background-repeat: no-repeat; height: 50px;" 
               onclick="showAbout(aboutMessage);" title="<?php echo i18n('aboutMessage');?>" > 
          </div>
          <div style="position:absolute; right:0; bottom:0px" id="helpbutton" style="text-align:right;" onclick="showHelp();"><img width="32px" height="32px" src='../view/img/help.png' title="<?php echo i18n('help');?>" onclick="showHelp();" /></div>
        </div>
        <div id="mapDiv" dojoType="dijit.layout.ContentPane" region="center" style="padding: 0px; margin:0px">
          <div dojoType="dijit.layout.AccordionContainer" style="height: 300px;" >
            <div dojoType="dijit.layout.ContentPane" title="<?php echo i18n('menu');?>" style="overflow: hidden !important;" selected="true">
              <?php include "menuTree.php"; ?>
            </div>
            <?php if (securityCheckDisplayMenu(null,'Document')) {?>
            <div dojoType="dijit.layout.ContentPane" title="<?php echo i18n('document');?>">
              <div dojoType="dojo.data.ItemFileReadStore" id="directoryStore" jsId="directoryStore" url="../tool/jsonDirectory.php">
              <div style="position: absolute; float:right; right: 5px; cursor:pointer;"
                title="<?php echo i18n("menuDocumentDirectory");?>"
                onclick="if (checkFormChangeInProgress()){return false;};loadContent('objectMain.php?objectClass=DocumentDirectory','centerDiv');"
                class="iconDocumentDirectory22">
              </div>
              </div>
              <div dojoType="dijit.tree.ForestStoreModel" id="directoryModel" jsId="directoryModel" store="directoryStore"
               query="{id:'*'}" rootId="directoryRoot" rootLabel="Documents"
               childrenAttrs="children">
              </div>             
              <div dojoType="dijit.Tree" id="documentDirectoryTree" model="directoryModel" openOnClick="false" showRoot='false'>
                <script type="dojo/method" event="onClick" args="item">;
                  if (checkFormChangeInProgress()){return false;}
                  loadContent("objectMain.php?objectClass=Document&Directory="+directoryStore.getValue(item, "id"),"centerDiv");
                </script>
              </div>
            </div>
            <?php }?>
          </div>
        </div>
        <div dojoType="dijit.layout.ContentPane" region="bottom" splitter="true" style="height: 300px;">
          <div dojoType="dijit.layout.AccordionContainer">
            <div id="projectLinkDiv" class="background" dojoType="dijit.layout.ContentPane" selected="true" title="<?php echo i18n('ExternalShortcuts');?>">
              <?php include "../view/shortcut.php"?>
            </div>
            <div id="messageDiv" dojoType="dijit.layout.ContentPane" title="<?php echo i18n('Console');?>" >
            </div>
          </div>
        </div>
      </div> 
    </div>
    <?php 
    //$iconSize=Parameter::getUserParameter('paramTopIconSize');
    //$showMenuBar=Parameter::getUserParameter('paramShowMenuBar');
    //$showMenuBar='NO';
    $iconSize=32;
    $showMenuBar='YES';
    //if (! $iconSize or $showMenuBar=='NO') $iconSize=16;
    $iconSize+=9;?>
    <div id="toolBarDiv" style="height:<?php echo ($iconSize+10);?>px" dojoType="dijit.layout.ContentPane" region="top"  >
      <?php include "menuBar.php";?>
    </div>
    <div id="centerDiv" dojoType="dijit.layout.ContentPane" region="center" >      
    </div>
    <div id="statusBarDiv" dojoType="dijit.layout.ContentPane" region="bottom">
      <table width="100%">
        <tr>
          <td width="5%"  >
            <div class="pseudoButton" style="min-width:100px" title="<?php echo i18n('disconnectMessage');?>" onclick="disconnect(true);">
              <table>
                <tr>
                  <td>
                    <img style="height:24px" src="img/disconnect.png" />
                  </td>
                  <td>
                    &nbsp;<?php echo i18n('disconnect'); ?>&nbsp;&nbsp;
                  </td>
                </tr>
              </table>    
            </div>
          </td>
          <td width="1px">&nbsp;</td>
          <td width="5%">
            <?php 
            $menu=SqlElement::getSingleSqlElementFromCriteria('Menu', array('name'=>'menuUserParameter'));
            $buttonUserParameter=securityCheckDisplayMenu($menu->id,$menu);
            if ($buttonUserParameter) {?>
            <div class="pseudoButton" style="min-width:100px" title="<?php echo i18n('menuUserParameter');?>" onClick="loadMenuBarItem('UserParameter','UserParameter','bar');">
              <table >
                <tr>
                  <td>
                    <?php $user=getSessionUser();
                       $imgUrl=Affectable::getThumbUrl('User',$user->id, 22,true);
                       if (!$imgUrl) {
                         $imgUrl="css/images/iconUserParameter22.png";
                       }?>
                       
                    <img style="border-radius:13px;height:26px" src="<?php echo $imgUrl; ?>" />
                  </td>
                  <td>&nbsp;<?php echo $user->name; ?>&nbsp;&nbsp;</td>
                </tr>
              </table>      
            </div>
            <?php } else {?>
              <table >
                <tr>
                  <td>
                    <img style="height:24px" src="css/images/iconUser22.png" />
                  </td>
                  <td>&nbsp;<?php echo getSessionUser()->name; ?>&nbsp;&nbsp;</td>
                </tr>
              </table>    
            <?php }?>
          <td width="1px">&nbsp;</td>
          <td width="30%" style="vertical-align: top;">
            <div id="statusBarProgressDiv" style="text-align: left;color: #000000">
              <table><tr><td>
              <div class="pseudoButton" onclick="hideShowMenu();" style="width:150px">
                <table >
                  <tr>
                    <td style="width:40px">
                      <div class="dijitButtonIcon dijitButtonIconHideMenu"></div>
                    </td>
                    <td id="buttonHideMenuLabel"><?php echo i18n("buttonHideMenu");?></td>
                  </tr>
                </table>    
              </div>
              </td>
              <td width="1px">&nbsp;</td>
              <td>
              <div class="pseudoButton" onclick="switchMode();" style="width:150px">
                <table >
                  <tr>
                    <td style="width:40px">
                      <div class="dijitButtonIcon dijitButtonIconSwitchMode"></div>
                    </td>
                    <td id="buttonSwitchModeLabel">
                      <?php 
                      if (isset($_SESSION['switchedMode']) and $_SESSION['switchedMode']!='NO') {
                        echo i18n("buttonStandardMode");
                      } else {
                        echo i18n("buttonSwitchedMode");
                      }?>
                    </td>
                  </tr>
                </table>    
              </div>
              </td></tr></table>               
            </div>
          </td>
          <td width="40%" style="vertical-align: middle;" >
            <div id="statusBarMessageDiv" style="text-align: left">
              <?php htmlDisplayDatabaseInfos();?>
            </div>
          </td>
          <td width="20%" title="<?php echo i18n('infoMessage');?>" style="vertical-align: middle;text-align:center;"> 
            <div class="pseudoButton" style="margin:0;padding:0;width:100px;float:right"><a target="#" href="<?php echo $website;?>" >
              <table style="width:100%">
                  <tr>
                    <td style="color:#000000;position:relative; top:-2px;vertical-align: middle;text-align:center;width:70px">
                      <?php echo "$copyright<br>$version";?>
                    </td>
                    <td  style="width:35px">
                      <img style="height:28px;width:28px" src="img/logoSmall.png" />
                    </td>
                  </tr>
                </table>
            </a></div>            
          </td>
        </tr>
      </table>  
    </div>    
  </div>
</div>

<div id="dialogReminder" >
 <div id="reminderDiv" style="width:100%;height: 75%"></div>
  <div style="width:100%; height:15%; text-align:right">
    <?php echo i18n("remindMeIn");?>
   <input type="input" dojoType="dijit.form.TextBox" id="remindAlertTime" name="remindAletTime" value="15" style="width:25px" />
    <?php echo i18n("shortMinute");?>
   <button dojoType="dijit.form.Button" onclick="setAlertRemindMessage();">
            <?php echo i18n("remind");?>
   </button>
 </div>
 <div style="width:100%; height:10%; text-align:right">
	 <button  dojoType="dijit.form.Button" onclick="setAlertReadMessage();">
	          <?php echo i18n("markAsRead");?>
	 </button>
 </div>
</div>
<div id="dialogInfo" dojoType="dijit.Dialog" title="<?php echo i18n("dialogInformation");?>">
  <table>
    <tr>
      <td width="50px">
        <img src="img/info.png" />
      </td>
      <td>
        <div id="dialogInfoMessage">
        </div>
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <br/>
        <button class="smallTextButton" dojoType="dijit.form.Button" type="submit" onclick="dijit.byId('dialogInfo').hide();">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogError" dojoType="dijit.Dialog" title="<?php echo i18n("dialogError");?>">
  <table>
    <tr>
      <td width="50px">
        <img src="img/error.png" />
      </td>
      <td>
        <div id="dialogErrorMessage">
        </div>
      </td>
    </tr>
    <tr height="50px">
      <td colspan="2" align="center">
        <?php echo i18n("contactAdministrator");?>
      </td>
    </tr>
    <tr><td colspan="2" align="center">&nbsp;</td></tr>
    <tr>
      <td colspan="2" align="center">
        <button class="smallTextButton" dojoType="dijit.form.Button" type="submit" onclick="dijit.byId('dialogError').hide();">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogAlert" dojoType="dijit.Dialog" title="<?php echo i18n("dialogAlert");?>">
  <table>
    <tr>
      <td width="50px">
        <img src="img/alert.png" />
      </td>
      <td>
        <div id="dialogAlertMessage">
        </div>
      </td>
    </tr>
    <tr><td colspan="2" align="center">&nbsp;</td></tr>
    <tr>
      <td colspan="2" align="center">
        <button class="smallTextButton" dojoType="dijit.form.Button" type="submit" onclick="dijit.byId('dialogAlert').hide();">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogQuestion" dojoType="dijit.Dialog" title="<?php echo i18n("dialogQuestion");?>">
  <table>
    <tr>
      <td width="50px">
        <img src="img/confirm.png" />
      </td>
      <td>
        <div id="dialogQuestionMessage"></div>
      </td>
    </tr>
    <tr><td colspan="2" align="center">&nbsp;</td></tr>
    <tr>
      <td colspan="2" align="center">
        <button class="smallTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogQuestion').acceptCallbackNo();dijit.byId('dialogQuestion').hide();">
          <?php echo i18n("buttonNo");?>
        </button>
        <button class="smallTextButton" id="dialogQuestionSubmitButton" dojoType="dijit.form.Button" type="submit" onclick="protectDblClick(this);dijit.byId('dialogQuestion').acceptCallbackYes();dijit.byId('dialogQuestion').hide();">
          <?php echo i18n("buttonYes");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogConfirm" dojoType="dijit.Dialog" title="<?php echo i18n("dialogConfirm");?>">
  <table>
    <tr>
      <td width="50px">
        <img src="img/alert.png" />
      </td>
      <td>
        <div id="dialogConfirmMessage"></div>
      </td>
    </tr>
    <tr><td colspan="2" align="center">&nbsp;</td></tr>
    <tr>
      <td colspan="2" align="center">
        <input type="hidden" id="dialogConfirmAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogConfirm').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" id="dialogConfirmSubmitButton" dojoType="dijit.form.Button" type="submit" onclick="protectDblClick(this);dijit.byId('dialogConfirm').acceptCallback();dijit.byId('dialogConfirm').hide();">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogPrint" dojoType="dijit.Dialog" title="<?php echo i18n("dialogPrint");?>" onHide="window.document.title=i18n('applicationTitle');dojo.byId('printFrame').src='../view/preparePreview.php';" >
  <?php 
    $printHeight=600;
    $printWidth=1010;
    //if (array_key_exists('screenWidth',$_SESSION)) {
    //   $printWidth = $_SESSION['screenWidth'] * 0.8;
    //}
    if (array_key_exists('screenHeight',$_SESSION)) {
      $printHeight=round($_SESSION['screenHeight']*0.65);
    }
    if (array_key_exists('screenWidth',$_SESSION) and $_SESSION['screenWidth']<1160) {
      $printWidth=round($_SESSION['screenWidth']*0.87);
    }
  ?> 
  <div style="widht:100%" id="printPreview" dojoType="dijit.layout.ContentPane" region="center">
    <table style="widht:100%">
      <tr>
        <td width="<?php echo $printWidth;?>px" align="right">
          <div id="sentToPrinterDiv">
            <table width="100%"><tr><td width="300px" align="right">
              <button  id="sendToPrinter" dojoType="dijit.form.Button" showlabel="false"
                title="<?php echo i18n('sendToPrinter');?>" 
                iconClass="dijitEditorIcon dijitEditorIconPrint" >
                <script type="dojo/connect" event="onClick" args="evt">
                  sendFrameToPrinter();
                </script>
              </button>
            </td>
            <td align="left" width="<?php echo $printWidth - 300;?>px">
              &nbsp;<b><i><?php echo i18n('sendToPrinter')?></i></b>
            </td></tr></table>
          </div>
        </td>
      </tr>
      <tr>
        <td>   
          <iframe width="100%" height="<?php echo $printHeight;?>px"
            scrolling="auto" frameborder="0px" name="printFrame" id="printFrame" src="">
          </iframe>
        </td>
      </tr>
    </table>
  </div>
</div>

<div id="dialogShowHtml" dojoType="dijit.Dialog" onHide="window.frames['showHtmlFrame'].location.href='../view/preparePreview.php';" title="">
  <?php 
    $printHeight=600;
    $printWidth=1010;
    if (array_key_exists('screenHeight',$_SESSION)) {
      $printHeight=round($_SESSION['screenHeight']*0.50);
    }
  ?> 
  <div style="widht:100%" id="showHtmlLink" dojoType="dijit.layout.ContentPane" region="center">
    <table style="widht:100%">
      <tr>
        <td width="<?php echo $printWidth;?>px">   
          <iframe width="100%" height="<?php echo $printHeight;?>px"
            scrolling="auto" frameborder="0px" name="showHtmlFrame" id="showHtmlFrame" src="">
          </iframe>
        </td>
      </tr>
    </table>
  </div>
</div>

<div id="dialogDetail" dojoType="dijit.Dialog" title="<?php echo i18n("dialogDetailCombo");?>" class="background" >
  <?php 
    $detailHeight=600;
    $detailWidth=1010;
    if (array_key_exists('screenWidth',$_SESSION) and $_SESSION['screenWidth']<1160) {
       $detailWidth = $_SESSION['screenWidth'] * 0.87;
    }
    if (array_key_exists('screenHeight',$_SESSION)) {
      $detailHeight=round($_SESSION['screenHeight']*0.65);
    }
  ?> 
  <div id="detailView" dojoType="dijit.layout.ContentPane" region="center" style="overflow:hidden" class="background">
    <table style="width:100%;height:100%">
      <tr style="height:10px;"><td></td></tr>
      <tr>
        <td width="32px" align="left" style="white-space:nowrap">
          <input type="hidden" name="canCreateDetail" id="canCreateDetail" />
          <input type="hidden" id='comboName' name='comboName' value='' />
          <input type="hidden" id='comboClass' name='comboClass' value='' />
          <input type="hidden" id='comboMultipleSelect' name='comboMultipleSelect' value='' />
          <button id="comboSearchButton" dojoType="dijit.form.Button" showlabel="false"
            title="<?php echo i18n('comboSearchButton');?>" 
            iconClass="dijitButtonIcon dijitButtonIconSearch" class="dialogDetailButton">
            <script type="dojo/connect" event="onClick" args="evt">
              displaySearch();
            </script>
          </button>
          <button id="comboSelectButton" dojoType="dijit.form.Button" showlabel="false"
            title="<?php echo i18n('comboSelectButton');?>" 
            iconClass="dijitButtonIcon dijitButtonIconSelect" class="dialogDetailButton">
            <script type="dojo/connect" event="onClick" args="evt">
              selectDetailItem();
            </script>
          </button>
          <button id="comboNewButton" dojoType="dijit.form.Button" showlabel="false"
            title="<?php echo i18n('comboNewButton');?>" 
            iconClass="dijitButtonIcon dijitButtonIconNew" class="dialogDetailButton">
            <script type="dojo/connect" event="onClick" args="evt">
              newDetailItem();
            </script>
          </button>
          <button id="comboSaveButton" dojoType="dijit.form.Button" showlabel="false"
            title="<?php echo i18n('comboSaveButton');?>" 
            iconClass="dijitButtonIcon dijitButtonIconSave" class="dialogDetailButton">
            <script type="dojo/connect" event="onClick" args="evt">
              saveDetailItem();
            </script>
          </button>
         <button id="comboCloseButton" dojoType="dijit.form.Button" showlabel="false"
            title="<?php echo i18n('comboCloseButton');?>" 
            iconClass="dijitButtonIcon dijitButtonIconUndo" class="dialogDetailButton">
            <script type="dojo/connect" event="onClick" args="evt">
              hideDetail();
            </script>
          </button>
        </td>
        <td align="left" style="width:<?php echo ($detailWidth - 400);?>px; position:relative;">
          <div style="width:100%;font-size:8pt" dojoType="dijit.layout.ContentPane" region="center" name="comboDetailResult" id="comboDetailResult"></div>
        </td>
        <td></td>
      </tr>
      <tr><td colspan="3">&nbsp;</td></tr>
      <tr>
        <td width="<?php echo $detailWidth;?>px" colspan="3">   
          <iframe width="100%" height="<?php echo $detailHeight;?>px"
            scrolling="auto" frameborder="0px" name="comboDetailFrame" id="comboDetailFrame" src="" >
          </iframe>
        </td>
      </tr>
    </table>
  </div>
</div>

<div id="dialogNote" dojoType="dijit.Dialog" title="<?php echo i18n("dialogNote");?>">
  <table>
    <tr><td><div id="dialogNotePredefinedDiv" dojoType="dijit.layout.ContentPane" region="center"></div></td></tr>
    <tr>
      <td>
       <form id='noteForm' name='noteForm' onSubmit="return false;">
         <input id="noteId" name="noteId" type="hidden" value="" />
         <input id="noteRefType" name="noteRefType" type="hidden" value="" />
         <input id="noteRefId" name="noteRefId" type="hidden" value="" />
         <textarea dojoType="dijit.form.Textarea" type="hidden"
          id="noteNote" name="noteNote"
          style="width: 500px;display:none;"></textarea>
         
        <div data-dojo-type="dijit.Editor" id="noteNoteEditor" height="125px" 
         data-dojo-props="onChange:function(){top.dojo.byId('noteNote').value=arguments[0];}
          ,plugins:['removeFormat','bold','italic','underline','|', 'indent', 'outdent', 'justifyLeft', 'justifyCenter', 
                    'justifyRight', 'justifyFull','|','insertOrderedList','insertUnorderedList','|']
          ,onKeyDown:function(event){top.onKeyDownFunction(event,'noteNoteEditor',this);}
          ,onBlur:function(event){top.editorBlur('noteNoteEditor',this);}
          ,extraPlugins:['dijit._editor.plugins.AlwaysShowToolbar','foreColor','hiliteColor']"
          style="width: 500px;color:#606060 !important; background:none; 
            padding:3px 0px 3px 3px;margin-right:2px;max-height:150px;min-height:16px;overflow:auto;"
          class="input" >
        </div>

          <table width="100%"><tr height="25px">
            <td width="33%" class="smallTabLabel" >
              <label class="smallTabLabelRight" for="notePrivacyPublic"><?php echo i18n('public');?>&nbsp;</label>
              <input type="radio" data-dojo-type="dijit/form/RadioButton" name="notePrivacy" id="notePrivacyPublic" value="1" />
            </td>
            <td width="34%" class="smallTabLabel" >
              <label class="smallTabLabelRight" for="notePrivacyTeam"><?php echo i18n('team');?>&nbsp;</label>
              <input type="radio" data-dojo-type="dijit/form/RadioButton" name="notePrivacy" id="notePrivacyTeam" value="2" />
            </td>
            <td width="33%" class="smallTabLabel" >
              <label class="smallTabLabelRight" for="notePrivacyPrivate"><?php echo i18n('private');?>&nbsp;</label>
              <input type="radio" data-dojo-type="dijit/form/RadioButton" name="notePrivacy" id="notePrivacyPrivate" value="3" />
            </td>
          </tr></table>
       </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="dialogNoteAction">
        <button class="mediumTextButton"  dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogNote').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton"  id="dialogNoteSubmit" dojoType="dijit.form.Button" type="submit" onclick="protectDblClick(this);saveNote();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogLink" dojoType="dijit.Dialog" title="<?php echo i18n("dialogLink");?>">
  <table>
    <tr>
      <td>
       <form id='linkForm' name='linkForm' onSubmit="return false;">
         <input id="linkFixedClass" name="linkFixedClass" type="hidden" value="" />
         <input id="linkId" name="linkId" type="hidden" value="" />
         <input id="linkRef1Type" name="linkRef1Type" type="hidden" value="" />
         <input id="linkRef1Id" name="linkRef1Id" type="hidden" value="" />
         <table>
           <tr>
             <td class="dialogLabel"  >
               <label for="linkRef2Type" ><?php echo i18n("linkType") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" id="linkRef2Type" name="linkRef2Type" onchange="refreshLinkList();"
                class="input" value="">
                 <?php htmlDrawOptionForReference('idLinkable', null, null, true);?>
               </select>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
             <td class="dialogLabel" >
               <label for="linkRef2Id" ><?php echo i18n("linkElement") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <table><tr><td>
               <div id="dialogLinkList" dojoType="dijit.layout.ContentPane" region="center">
                 <input id="linkRef2Id" name="linkRef2Id" type="hidden" value="" />
               </div>
               </td><td style="vertical-align: top">
               <button id="linkDetailButton" dojoType="dijit.form.Button" showlabel="false"
                 title="<?php echo i18n('showDetail')?>"
                 iconClass="iconView">
                 <script type="dojo/connect" event="onClick" args="evt">
                    showDetailLink();
                 </script>
               </button>
               </td></tr></table>
             </td>
           </tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           </table>
           <div id="linkDocumentVersionDiv" style="display:none">
           <table>
           <tr>
               <td class="dialogLabel" >
                   <label for="linkRef2Type" ><?php echo i18n("colIdVersion") ?>&nbsp;:&nbsp;</label>
               </td>
               <td>
                  <select dojoType="dijit.form.FilteringSelect" 
                    id="linkDocumentVersion" name="linkDocumentVersion" 
                    onchange=""
                    class="input" value="" >
                  </select>
                  <?php if (0) { //Desactivated?>                
                  <img src="css/images/smallButtonAdd.png" onClick="addDocumentVersion();" title="<?php echo i18n('addDocumentVersion');?>" class="smallButton"/>
                  <?php }?>
               </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
         </table>
         </div>
         <table>  
           <tr>
               <td class="dialogLabel" >
                   <label for="linkRef2Type" ><?php echo i18n("colComment") ?>&nbsp;:&nbsp;</label>
               </td>
               <td>
                   <textarea dojoType="dijit.form.Textarea"
                             id="linkComment" name="linkComment"
                             style="width: 400px;"
                             maxlength="4000"
                             class="input"></textarea>
               </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="dialogLinkAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogLink').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogLinkSubmit" onclick="protectDblClick(this);saveLink();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogOtherVersion" dojoType="dijit.Dialog" title="<?php echo i18n("dialogOtherVersion");?>">
  <table>
    <tr>
      <td>
       <form id='otherVersionForm' name='otherVersionForm' onSubmit="return false;">
         <input id="otherVersionRefType" name="otherVersionRefType" type="hidden" value="" />
         <input id="otherVersionRefId" name="otherVersionRefId" type="hidden" value="" />
         <input id="otherVersionType" name="otherVersionType" type="hidden" value="" />
         <input id="otherVersionId" name="otherVersionId" type="hidden" value="" />
         <table>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
             <td class="dialogLabel" >
               <label for="otherVersionId" ><?php echo i18n("colOtherVersions") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <table><tr><td>
               <div id="dialogOtherVersionList" dojoType="dijit.layout.ContentPane" region="center">
                 <input id="otherVersionIdVersion" name="otherVersionIdVersion" type="hidden" value="" />
               </div>
               </td><td style="vertical-align: top">
               <button id="otherVersionDetailButton" dojoType="dijit.form.Button" showlabel="false"
                 title="<?php echo i18n('showDetail')?>"
                 iconClass="iconView">
                 <script type="dojo/connect" event="onClick" args="evt">
                   showDetailOtherVersion();
                 </script>
               </button>
               </td></tr></table>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="dialogOtherVersionAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogOtherVersion').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogOtherVersionSubmit" onclick="protectDblClick(this);saveOtherVersion();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogApprover" dojoType="dijit.Dialog" title="<?php echo i18n("dialogApprover");?>">
  <table>
    <tr>
      <td>
        <form id='approverForm' name='approverForm' onSubmit="return false;">
          <input id="approverRefType" name="approverRefType" type="hidden" value="" />
          <input id="approverRefId" name="approverRefId" type="hidden" value="" />
          <input id="approverItemId" name="approverItemId" type="hidden" value="" />
          <table>
            <tr>
              <td class="dialogLabel" >
                <label for="approverId" ><?php echo i18n("approver") ?>&nbsp;:&nbsp;</label>
              </td>
              <td>
                <table><tr><td>
                  <div id="dialogApproverList" dojoType="dijit.layout.ContentPane" region="center">
                    <input id="approverId" name="approverId" type="hidden" value="" />
                  </div>
                </td><td style="vertical-align: top">
                  <button id="approverIdDetailButton" dojoType="dijit.form.Button" showlabel="false"
                          title="<?php echo i18n('showDetail')?>"
                          iconClass="iconView">
                    <script type="dojo/connect" event="onClick" args="evt">
                      showDetailApprover();
                    </script>
                  </button>
                </td></tr></table>
              </td>
            </tr>
            <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
          </table>
         </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="approverAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogApprover').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogApproverSubmit" onclick="protectDblClick(this);saveApprover();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogOrigin" dojoType="dijit.Dialog" title="<?php echo i18n("dialogOrigin");?>">
  <table>
    <tr>
      <td>
       <form id='originForm' name='originForm' onSubmit="return false;">
         <input id="originId" name="originId" type="hidden" value="" />
         <input id="originRefId" name="originRefId" type="hidden" value="" />
         <input id="originRefType" name="originRefType" type="hidden" value="" />
         <table>
           <tr>
             <td class="dialogLabel"  >
               <label for="originOriginType" ><?php echo i18n("originType") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" 
                id="originOriginType" name="originOriginType" 
                onchange="refreshOriginList();"
                class="input" value="" >
                 <?php htmlDrawOptionForReference('idOriginable', null, null, true);?>
               </select>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
             <td class="dialogLabel" >
               <label for="OriginOriginId" ><?php echo i18n("originElement") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <table><tr><td>
               <div id="dialogOriginList" dojoType="dijit.layout.ContentPane" region="center">
                 <input id="originOriginId" name="originOriginId" type="hidden" value="" />
               </div>
               </td><td style="vertical-align: top">
               <button id="originDetailButton" dojoType="dijit.form.Button" showlabel="false"
                 title="<?php echo i18n('showDetail')?>"
                 iconClass="iconView">
                 <script type="dojo/connect" event="onClick" args="evt">
                    showDetailOrigin();
                 </script>
               </button>
               </td></tr></table>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="dialogOriginAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogOrigin').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogOriginSubmit" onclick="protectDblClick(this);saveOrigin();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogCreationInfo" dojoType="dijit.Dialog" title="<?php echo i18n("dialogCreationInfo");?>">
  <table>
    <tr>
      <td>
        <table >
          <tr id="dialogCreationInfoCreatorLine">
            <td class="dialogLabel"  >
              <label for="dialogCreationInfoCreator" ><?php echo i18n("colIssuer") ?>&nbsp;:&nbsp;</label>
            </td>
            <td>
              <select dojoType="dijit.form.FilteringSelect" id="dialogCreationInfoCreator" class="input" value="" >
                <?php htmlDrawOptionForReference('idUser', null, null, true);?>
              </select>
            </td>
          </tr>
          <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
          <tr id="dialogCreationInfoDateLine">
            <td class="dialogLabel" >
              <label for="dialogCreationInfoDate" ><?php echo i18n("colCreationDate") ?>&nbsp;:&nbsp;</label>
            </td>
            <td>
              <div id="dialogCreationInfoDate" dojoType="dijit.form.DateTextBox" 
                 constraints="{datePattern:browserLocaleDateFormatJs}"
                 invalidMessage="<?php echo i18n('messageInvalidDate');?> " 
                 type="text" maxlength="10" 
                 style="width:100px; text-align: center;" class="input"
                 required="true" hasDownArrow="true" 
                 missingMessage="<?php echo i18n('messageMandatory',array('colDate'));?>" 
                 invalidMessage="<?php echo i18n('messageMandatory',array('colDate'));?>" 
                 >
              </div>
              <span id="dialogCreationInfoTimeLine">
              <div id="dialogCreationInfoTime" dojoType="dijit.form.TimeTextBox" 
                 invalidMessage="<?php echo i18n('messageInvalidTime');?>"
                 type="text" maxlength="8"
                 style="width:65px; text-align: center;" class="input"
                 required="true" 
                 >
              </div>
              </span>
            </td>
          </tr>
          <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="center">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogCreationInfo').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogCreationInfoSubmit" onclick="protectDblClick(this);saveCreationInfo();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogCopy" dojoType="dijit.Dialog" title="<?php echo i18n("dialogCopy");?>">
  <table>
    <tr>
      <td>
       <form dojoType="dijit.form.Form" id='copyForm' name='copyForm' onSubmit="return false;">
         <input id="copyClass" name="copyClass" type="hidden" value="" />
         <input id="copyId" name="copyId" type="hidden" value="" />
         <table>
           <tr>
             <td class="dialogLabel"  >
               <label for="copyToClass" ><?php echo i18n("copyToClass") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" 
                id="copyToClass" name="copyToClass" required
                class="input" value="" >
                 <?php htmlDrawOptionForReference('idCopyable', null, null, true);?>
                 <script type="dojo/connect" event="onChange" args="evt" >
                   var objclass=copyableArray[this.value];
                   dijit.byId('copyToType').reset();
                   refreshList("idType","scope", objclass, null,'copyToType',true);
                   if (dojo.byId('copyClass').value==objclass) {
                     var runModif="dijit.byId('copyToType').set('value',dijit.byId('id"+objclass+"Type').get('value'))";
                     setTimeout(runModif,1);
                   }
                   copyObjectToShowStructure();
                 </script> 
               </select>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
             <td class="dialogLabel"  >
               <label for="copyToType" ><?php echo i18n("copyToType") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" 
                id="copyToType" name="copyToType" required
                class="input" value="" >
               </select>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
             <td class="dialogLabel" >
               <label for="copyToName" ><?php echo i18n("copyToName") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="copyToName" name="copyToName" dojoType="dijit.form.ValidationTextBox"
                required="required"
                style="width: 400px;"
                trim="true" maxlength="100" class="input"
                value="">
               </div>     
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
             <td class="dialogLabel" colspan="2" style="width:100%; text-align: left;">
               <div id="copyWithStructureDiv" style="display:none;">
	               <label for="copyWithStructure" style="width:90%;text-align: right;"><?php echo i18n("copyWithStructure") ?>&nbsp;:&nbsp;</label>
	               <div id="copyWithStructure" name="copyWithStructure" dojoType="dijit.form.CheckBox" type="checkbox" 
	                checked >
	               </div>
	               <br />
                 <label for="copyWithAssignments" style="width:90%;text-align: right;"><?php echo i18n("copyAssignments") ?>&nbsp;:&nbsp;</label>
                 <div id="copyWithAssignments" name="copyWithAssignments" dojoType="dijit.form.CheckBox" type="checkbox" 
                   >
                 </div>
              </div>
             </td>
           </tr>
           
           <tr>
             <td class="dialogLabel" colspan="2" style="width:100%; text-align: left;">
               <label for="copyToOrigin" style="width:90%;text-align: right;"><?php echo i18n("copyToOrigin") ?>&nbsp;:&nbsp;</label>
               <div id="copyToOrigin" name="copyToOrigin" dojoType="dijit.form.CheckBox" type="checkbox" 
                checked >
               </div>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" colspan="2" style="width:100%; text-align: left;">
               <label for="copyToLinkOrigin" style="width:90%;text-align: right;"><?php echo i18n("copyToLinkOrigin") ?>&nbsp;:&nbsp;</label>
               <div id="copyToLinkOrigin" name="copyToLinkOrigin" dojoType="dijit.form.CheckBox" type="checkbox" 
                checked >
               </div>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" colspan="2" style="width:100%; text-align: left;">
               <label for="copyToWithLinks" style="width:90%;text-align: right;"><?php echo i18n("copyToWithLinks") ?>&nbsp;:&nbsp;</label>
               <div id="copyToWithLinks" name="copyToWithLinks" dojoType="dijit.form.CheckBox" type="checkbox" 
                checked >
               </div>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" colspan="2" style="width:100%; text-align: left;">
               <label for="copyToWithAttachments" style="width:90%;text-align: right;"><?php echo i18n("copyToWithAttachments") ?>&nbsp;:&nbsp;</label>
               <div id="copyToWithAttachments" name="copyToWithAttachments" dojoType="dijit.form.CheckBox" type="checkbox" 
                checked >
               </div>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" colspan="2" style="width:100%; text-align: left;">
               <label for="copyToWithNotes" style="width:90%;text-align: right;"><?php echo i18n("copyToWithNotes") ?>&nbsp;:&nbsp;</label>
               <div id="copyToWithNotes" name="copyToWithNotes" dojoType="dijit.form.CheckBox" type="checkbox" 
                checked >
               </div>
             </td>
           </tr>       
           <tr><td>&nbsp;</td><td >&nbsp;</td></tr>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="copyAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogCopy').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogCopySubmit" onclick="protectDblClick(this);copyObjectToSubmit();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogCopyProject" dojoType="dijit.Dialog" title="<?php echo i18n("dialogCopyProject");?>">
  <table>
    <tr>
      <td>
       <form dojoType="dijit.form.Form" id='copyProjectForm' name='copyProjectForm' onSubmit="return false;">
         <input id="copyProjectId" name="copyProjectId" type="hidden" value="" />
         <table>
           <tr>
             <td class="dialogLabel"  >
               <label for="copyProjectToType" ><?php echo i18n("colProjectType") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" 
                id="copyProjectToType" name="copyProjectToType" required
                class="input" value="" >
                <?php htmlDrawOptionForReference('idProjectType', null, null, true);?>
               </select>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
             <td class="dialogLabel" >
               <label for="copyProjectToName" ><?php echo i18n("copyToName") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="copyProjectToName" name="copyProjectToName" dojoType="dijit.form.ValidationTextBox"
                required="required"
                style="width: 400px;"
                trim="true" maxlength="100" class="input"
                value="">
               </div>     
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
             <td class="dialogLabel" colspan="2" style="width:100%; text-align: left;">
               <label for="copyProjectStructure" style="width:90%;text-align: right;"><?php echo i18n("copyProjectStructure") ?>&nbsp;:&nbsp;</label>
               <div id="copyProjectStructure" name="copyProjectStructure" dojoType="dijit.form.CheckBox" type="checkbox" 
                onChange="copyProjectStructureChange()" checked >
               </div>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" colspan="2" style="width:100%; text-align: left;">
               <label for="copySubProjects" style="width:90%;text-align: right;"><?php echo i18n("copySubProjects") ?>&nbsp;:&nbsp;</label>
               <div id="copySubProjects" name="copySubProjects" dojoType="dijit.form.CheckBox" type="checkbox" 
                checked >
               </div>
             </td>
           </tr>
            <tr>
             <td class="dialogLabel" colspan="2" style="width:100%; text-align: left;">
               <label for="copyProjectAffectations" style="width:90%;text-align: right;"><?php echo i18n("copyProjectAffectations") ?>&nbsp;:&nbsp;</label>
               <div id="copyProjectAffectations" name="copyProjectAffectations" dojoType="dijit.form.CheckBox" type="checkbox" 
                 >
               </div>
             </td>
           </tr>
            </tr>
            <tr>
             <td class="dialogLabel" colspan="2" style="width:100%; text-align: left;">
               <label for="copyProjectAssignments" style="width:90%;text-align: right;"><?php echo i18n("copyAssignments") ?>&nbsp;:&nbsp;</label>
               <div id="copyProjectAssignments" name="copyProjectAssignments" dojoType="dijit.form.CheckBox" type="checkbox" 
                 >
               </div>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td >&nbsp;</td></tr>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="copyProjectAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogCopyProject').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogProjectCopySubmit" onclick="protectDblClick(this);copyProjectToSubmit();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogAttachment" dojoType="dijit.Dialog" title="<?php echo i18n("dialogAttachment");?>"></div>
<form id='attachmentAckForm' name='attachmentAckForm'> 
   <input type='hidden' id="resultAck" name="resultAck" />
</form>   
    
<div id="dialogDocumentVersion" dojoType="dijit.Dialog" title="<?php echo i18n("dialogDocumentVersion");?>"></div>
  
<div id="dialogAssignment" dojoType="dijit.Dialog" title="<?php echo i18n("dialogAssignment");?>">
  <table>
    <tr>
      <td>
       <form dojoType="dijit.form.Form" id='assignmentForm' jsid='assignmentForm' name='assignmentForm' onSubmit="return false;">
         <input id="assignmentId" name="assignmentId" type="hidden" value="" />
         <input id="assignmentRefType" name="assignmentRefType" type="hidden" value="" />
         <input id="assignmentRefId" name="assignmentRefId" type="hidden" value="" />
         <table>
           <tr>
             <td class="dialogLabel" >
               <label for="assignmentIdResource" ><?php echo i18n("colIdResource");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
              <select dojoType="dijit.form.FilteringSelect"
                id="assignmentIdResource" name="assignmentIdResource"
                class="input" value="" 
                onChange="assignmentChangeResource();"
                missingMessage="<?php echo i18n('messageMandatory',array(i18n('colIdResource')));?>" >
                 <?php //htmlDrawOptionForReference('idResource', null, null, true); 
                       // No need : will be updated when opening Dialog?>
               </select>  
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="assignmentIdRole" ><?php echo i18n("colIdRole");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
              <select dojoType="dijit.form.FilteringSelect" 
                id="assignmentIdRole" name="assignmentIdRole"
                class="input" value="" 
                onChange="assignmentChangeRole();" >                
                 <?php htmlDrawOptionForReference('idRole', null, null, true);?>            
               </select>  
             </td>
           </tr>
           <?php $pe=new PlanningElement();
           $pe->setVisibility(); ?>
           <tr <?php echo ($pe->_costVisibility=='ALL')?'':'style="display:none;"'?>>
             <td class="dialogLabel" >
               <label for="assignmentDailyCost" ><?php echo i18n("colCost");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <?php echo ($currencyPosition=='before')?$currency:''; ?>
               <div id="assignmentDailyCost" name="assignmentDailyCost" value="" 
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0}" 
                 style="width:97px"            
                 readonly >
                 <?php echo $keyDownEventScript;?>
                 </div>
               <?php echo ($currencyPosition=='after')?$currency:'';
                     echo " / ";
                     echo i18n('shortDay'); ?>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="assignmentRate" ><?php echo i18n("colRate");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="assignmentRate" name="assignmentRate" value="" 
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0,max:999}" 
                 style="width:97px" 
                 missingMessage="<?php echo i18n('messageMandatory',array(i18n('colRate')));?>" 
                 required="true" >
                 <?php echo $keyDownEventScript;?>
                 </div>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="assignmentAssignedWork" ><?php echo i18n("colAssignedWork");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="assignmentAssignedWork" name="assignmentAssignedWork" value="" 
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0,max:9999.99}" 
                 style="width:97px"
                 onchange="assignmentUpdateLeftWork('assignment');"
                 onblur="assignmentUpdateLeftWork('assignment');" >
                 <?php echo $keyDownEventScript;?>
                 </div>
               <input id="assignmentAssignedUnit" name="assignmentAssignedUnit" value="" readonly tabindex="-1"
                 xdojoType="dijit.form.TextBox" 
                 class="display" style="width:15px; background-color:white; color:#000000; border:0px;"/>
               <input type="hidden" id="assignmentAssignedWorkInit" name="assignmentAssignedWorkInit" value="" 
                 style="width:97px"/>  
             </td>    
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="assignmentRealWork" ><?php echo i18n("colRealWork");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="assignmentRealWork" name="assignmentRealWork" value=""  
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0,max:9999.99}" 
                 style="width:97px" readonly >
                 <?php echo $keyDownEventScript;?>
                 </div>
               <input id="assignmentRealUnit" name="assignmentRealUnit" value="" readonly tabindex="-1"
                 xdojoType="dijit.form.TextBox" 
                 class="display" style="width:15px;background-color:#FFFFFF; color:#000000; border:0px;"/>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="assignmentLeftWork" ><?php echo i18n("colLeftWork");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="assignmentLeftWork" name="assignmentLeftWork" value=""  
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0,max:9999.99}" 
                 onchange="assignmentUpdatePlannedWork('assignment');"
                 onblur="assignmentUpdatePlannedWork('assignment');"  
                 style="width:97px" >
                 <?php echo $keyDownEventScript;?>
                 </div>
               <input id="assignmentLeftUnit" name="assignmentLeftUnit" value="" readonly tabindex="-1"
                 xdojoType="dijit.form.TextBox" 
                 class="display" style="width:15px;background-color:#FFFFFF; color:#000000; border:0px;"/>
               <input type="hidden" id="assignmentLeftWorkInit" name="assignmentLeftWorkInit" value="" 
                 style="width:97px"/>  
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="assignmentPlannedWork" ><?php echo i18n("colPlannedWork");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="assignmentPlannedWork" name="assignmentPlannedWork" value=""  
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0,max:9999.99}" 
                 style="width:97px" readonly > 
                 <?php echo $keyDownEventScript;?>
                 </div>
               <input id="assignmentPlannedUnit" name="assignmentPlannedUnit" value="" readonly tabindex="-1"
                 xdojoType="dijit.form.TextBox" 
                 class="display" style="width:15px;background-color:#FFFFFF; border:0px;"/>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="assignmentComment" ><?php echo i18n("colComment");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <input id="assignmentComment" name="assignmentComment" value=""  
                 dojoType="dijit.form.Textarea"
                 class="input" 
                 /> 
             </td>
           </tr>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="dialogAssignmentAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogAssignment').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" id="dialogAssignmentSubmit" type="submit" onclick="protectDblClick(this);saveAssignment();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>
<div id="dialogExpenseDetail" dojoType="dijit.Dialog" title="<?php echo i18n("dialogExpenseDetail");?>">
  <table>
    <tr>
      <td>
       <form dojoType="dijit.form.Form" id='expenseDetailForm' jsid='expenseDetailForm' name='expenseDetailForm' onSubmit="return false;">
         <input id="expenseDetailId" name="expenseDetailId" type="hidden" value="" />
         <input id="idExpense" name="idExpense" type="hidden" value="" />
         <table>
           <tr>
             <td class="dialogLabel" >
               <label for="expenseDetailName" ><?php echo i18n("colName");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <input id="expenseDetailName" name="expenseDetailName" value="" 
                 dojoType="dijit.form.TextBox" 
                 style="width:400px" 
                 required="true" 
                 missingMessage="<?php echo i18n('messageMandatory',array('colName'));?>" 
                 invalidMessage="<?php echo i18n('messageMandatory',array('colName'));?>"              
               />
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="expenseDetailDate" ><?php echo i18n("colDate");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="expenseDetailDate" name="expenseDetailDate"
                 dojoType="dijit.form.DateTextBox" 
                 constraints="{datePattern:browserLocaleDateFormatJs}"
                 invalidMessage="<?php echo i18n('messageInvalidDate');?> " 
                 type="text" maxlength="10" 
                 style="width:100px; text-align: center;" class="input"
                 required="true"
                 hasDownArrow="true" 
                 missingMessage="<?php echo i18n('messageMandatory',array('colDate'));?>" 
                 invalidMessage="<?php echo i18n('messageMandatory',array('colDate'));?>" 
                 >
             </div>
             </td>
           </tr>
 
           <tr>
             <td class="dialogLabel" >
               <label for="expenseDetailType" ><?php echo i18n("colType");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
              <select dojoType="dijit.form.FilteringSelect" 
                id="expenseDetailType" name="expenseDetailType"
                style="width:200px" 
                class="input" value="" 
                onChange="expenseDetailTypeChange();" >                
                 <?php htmlDrawOptionForReference('idExpenseDetailType', null, null, true);?>            
               </select>  
             </td>
           </tr>
           <tr>
            <td colspan="2">
              <div id="expenseDetailDiv" dojoType="dijit.layout.ContentPane" region="center" >    
              </div>
            </td> 
           </tr>

           <tr>
             <td class="dialogLabel" >
               <label for="expenseDetailAmount" ><?php echo i18n("colAmount");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <?php echo ($currencyPosition=='before')?$currency:''; ?>
               <div id="expenseDetailAmount" name="expenseDetailAmount" value="" 
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0}" 
                 style="width:97px"
                 readonly="readonly" >
                 <?php echo $keyDownEventScript;?>
                 </div>
               <?php echo ($currencyPosition=='after')?$currency:'';?>
             </td>
           </tr> 
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="dialogExpenseDetailAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogExpenseDetail').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogExpenseDetailSubmit" onclick="protectDblClick(this);saveExpenseDetail();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogPlan" dojoType="dijit.Dialog" title="<?php echo i18n("dialogPlan");?>">
  <table>
    <tr>
      <td>
       <form id='dialogPlanForm' name='dialogPlanForm' onSubmit="return false;">
         <table>
           <tr>
             <td class="dialogLabel"  >
               <label for="idProjectPlan" ><?php echo i18n("colIdProject") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" 
                id="idProjectPlan" name="idProjectPlan" 
                class="input" value=" " >
                 <?php 
                    $proj=null; 
                    if (array_key_exists('project',$_SESSION)) {
                        $proj=$_SESSION['project'];
                    }
                    if ($proj=="*" or ! $proj) $proj=null;
                    $user=getSessionUser();
                    $projs=$user->getListOfPlannableProjects();
                    htmlDrawOptionForReference('planning', $proj, null, false);
                 ?>
               </select>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           <tr>
             <td class="dialogLabel"  >
               <label for="startDatePlan" ><?php echo i18n("colStartDate") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div dojoType="dijit.form.DateTextBox" 
                 id="startDatePlan" name="startDatePlan" 
                 constraints="{datePattern:browserLocaleDateFormatJs}"
                 invalidMessage="<?php echo i18n('messageInvalidDate')?>" 
                 type="text" maxlength="10"
                 style="width:100px; text-align: center;" class="input"
                 required="true"
                 hasDownArrow="true"
                 missingMessage="<?php echo i18n('messageMandatory',array(i18n('colStartDate')));?>"
                 value="<?php echo date('Y-m-d');?>" >
               </div>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="dialogPlanAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="cancelPlan();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogPlanSubmit" onclick="protectDblClick(this);plan();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>


<div id="dialogDependency" dojoType="dijit.Dialog" title="<?php echo i18n("dialogDependency");?>">
  <table>
    <tr>
      <td>
       <form dojoType="dijit.form.Form" id='dependencyForm' name='dependencyForm' onSubmit="return false;">
         <input id="dependencyId" name="dependencyId" type="hidden" value="" />
         <input id="dependencyRefType" name="dependencyRefType" type="hidden" value="" />
         <input id="dependencyRefId" name="dependencyRefId" type="hidden" value="" />
         <input id="dependencyType" name="dependencyType" type="hidden" value="" />
         <table>
           <tr>
             <td class="dialogLabel"  >
               <label for="dependencyRefTypeDep" ><?php echo i18n("linkType") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" 
                id="dependencyRefTypeDep" name="dependencyRefTypeDep" 
                onchange="refreshDependencyList();"
                missingMessage="<?php echo i18n('messageMandatory',array(i18n('linkType')));?>"
                class="input" value="" >
                 <?php htmlDrawOptionForReference('idDependable', null, null, true);?>
               </select>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
         </table>
         <div id="dependencyAddDiv" >
         <table>
           <tr>
             <td class="dialogLabel" >
               <label for="dependencyRefIdDep" ><?php echo i18n("linkElement") ?>&nbsp;:&nbsp;</label>
             </td>
             <td><table><tr><td>
               <div id="dialogDependencyList" dojoType="dijit.layout.ContentPane" region="center">
                 <input id="dependencyRefIdDep" name="dependencyRefIdDep" type="hidden" value="" />
                  OK
               </div>
               </td><td style="vertical-align: top">
               <button id="dependencyDetailButton" dojoType="dijit.form.Button" showlabel="false"
                 title="<?php echo i18n('showDetail')?>"
                 iconClass="iconView">
                 <script type="dojo/connect" event="onClick" args="evt">
                    showDetailDependency();
                 </script>
               </button>
               </td></tr></table>
             </td>
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
         </table>
         </div>
         <div id="dependencyEditDiv">
           <table>
             <tr>
               <td class="dialogLabel"  >
                 <label for="dependencyRefIdDepEdit" ><?php echo i18n("linkElement") ?>&nbsp;:&nbsp;</label>
               </td>
               <td>
                 <select dojoType="dijit.form.FilteringSelect" 
                  id="dependencyRefIdDepEdit" name="dependencyRefIdDepEdit" 
                  class="input" value="" size="10">
                 </select>
               </td>
             </tr>
              <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
           </table>  
         </div>
         <div id="dependencyDelayDiv">
	         <table>
	           <tr>
	             <td class="dialogLabel" >
	               <label for="dependencyDelay" ><?php echo i18n("colDependencyDelay");?>&nbsp;:&nbsp;</label>
	             </td>
	             <td><nobr>
	               <?php echo ($currencyPosition=='before')?$currency:''; ?>
	               <input id="dependencyDelay" name="dependencyDelay" value="0" 
	                 dojoType="dijit.form.NumberTextBox" 
                   constraints="{min:-999, max:999}" 
	                 style="width:50px; text-align: center;" 
	                 missingMessage="<?php echo i18n('messageMandatory',array(i18n('colDependencyDelay')));?>" 
	                 required="true" />&nbsp;
	               <?php echo i18n('colDependencyDelayComment'); ?>
	               </nobr>
	             </td>
	           </tr>
	           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
	         </table>
          </div>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="dialogDependencyAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogDependency').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogDependencySubmit" onclick="protectDblClick(this);saveDependency();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogResourceCost" dojoType="dijit.Dialog" title="<?php echo i18n("dialogResourceCost");?>">
  <table>
    <tr>
      <td>
       <form dojoType="dijit.form.Form" id='resourceCostForm' jsid='resourceCostForm' name='resourceCostForm' onSubmit="return false;">
         <input id="resourceCostId" name="resourceCostId" type="hidden" value="" />
         <input id="resourceCostIdResource" name="resourceCostIdResource" type="hidden" value="" />
         <input id="resourceCostFunctionList" name="resourceCostFunctionList" type="hidden" value="" />
         <table>
           <tr>
             <td class="dialogLabel" >
               <label for="resourceCostIdRole" ><?php echo i18n("colIdRole");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
              <select dojoType="dijit.form.FilteringSelect" 
                id="resourceCostIdRole" name="resourceCostIdRole"
                class="input" value=""
                onChange="resourceCostUpdateRole();"
                missingMessage="<?php echo i18n('messageMandatory',array(i18n('colIdRole')));?>" >
                 <?php htmlDrawOptionForReference('idRole', null, null, true);?>
               </select>  
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="resourceCostValue" ><?php echo i18n("colCost");?>&nbsp;:&nbsp;</label>
             </td>
             <td><nobr>
               <?php echo ($currencyPosition=='before')?$currency:''; ?>
               <div id="resourceCostValue" name="resourceCostValue" value="" 
                 dojoType="dijit.form.NumberTextBox" 
                 constraints="{min:0}" 
                 style="width:97px; text-align: right;" 
                 missingMessage="<?php echo i18n('messageMandatory',array(i18n('colCost')));?>" 
                 required="true" >
                 <?php echo $keyDownEventScript;?>
                 </div>
               <?php echo ($currencyPosition=='after')?$currency:'';
                     echo " / ";
                     echo i18n('shortDay'); ?>
               </nobr>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="resourceCostStartDate" ><?php echo i18n("colStartDate");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="resourceCostStartDate" name="resourceCostStartDate" value="" 
                 dojoType="dijit.form.DateTextBox" 
                 constraints="{datePattern:browserLocaleDateFormatJs}"
                 style="width:100px" class="input"
                 hasDownArrow="true"
               >
               </div>
             </td>    
           </tr>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="dialogResourceCostAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogResourceCost').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogResourceCostSubmit" onclick="protectDblClick(this);saveResourceCost();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>


<div id="dialogVersionProject" dojoType="dijit.Dialog" title="<?php echo i18n("dialogVersionProject");?>">
  <table>
    <tr>
      <td>
       <form dojoType="dijit.form.Form" id='versionProjectForm' name='versionProjectForm' onSubmit="return false;">
         <input id="versionProjectId" name="versionProjectId" type="hidden" value="" />
         <table>
           <tr>
             <td class="dialogLabel"  >
               <label for="versionProjectProject" ><?php echo i18n("colIdProject") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" 
                id="versionProjectProject" name="versionProjectProject" 
                class="input" value="" required="required">
                 <?php //htmlDrawOptionForReference('idProject', null, null, true);
                       // no use : will be updated on dialog opening;?>
               </select>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel"  >
               <label for="versionProjectVersion" ><?php echo i18n("colIdVersion") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" 
                id="versionProjectVersion" name="versionProjectVersion" 
                class="input" value="" required="required">
                 <?php //htmlDrawOptionForReference('idVersion', null, null, true);
                       // no use : will be updated on dialog opening;?>
               </select>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="versionProjectStartDate" ><?php echo i18n("colStartDate");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="versionProjectStartDate" name="versionProjectStartDate" value="" 
                 dojoType="dijit.form.DateTextBox" 
                 constraints="{datePattern:browserLocaleDateFormatJs}"
                 style="width:100px" class="input"
                 hasDownArrow="true"
               >
               </div>
             </td>    
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="versionProjectEndDate" ><?php echo i18n("colEndDate");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="versionProjectEndDate" name="versionProjectEndDate" value="" 
                 dojoType="dijit.form.DateTextBox" 
                 constraints="{datePattern:browserLocaleDateFormatJs}"
                 style="width:100px" class="input"
                 hasDownArrow="true"
               >
               </div>
             </td>    
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="versionProjectIdle" ><?php echo i18n("colIdle");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="versionProjectIdle" name="versionProjectIdle"
                 dojoType="dijit.form.CheckBox" type="checkbox" >
               </div>
             </td>    
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="versionProjectAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button"  onclick="dijit.byId('dialogVersionProject').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogVersionProjectSubmit" onclick="protectDblClick(this);saveVersionProject();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogTestCaseRun" dojoType="dijit.Dialog" title="<?php echo i18n("dialogTestCaseRun");?>">
  <table>
    <tr>
      <td>
       <form dojoType="dijit.form.Form" id='testCaseRunForm' name='testCaseRunForm' onSubmit="return false;">
         <input id="testCaseRunId" name="testCaseRunId" type="hidden" value="" />
         <input id="testCaseRunTestSession" name="testCaseRunTestSession" type="hidden" value="" />
         <input id="testCaseRunMode" name="testCaseRunMode" type="hidden" value="" />
         <div id="testCaseRunAddDiv">
	         <table>
	           <tr>
	             <td class="dialogLabel" >
	               <label for="testCaseRunTestCaseList" ><?php echo i18n("colTestCases") ?>&nbsp;:&nbsp;</label>
	             </td>
	             <td>
	               <div id="testCaseRunListDiv" dojoType="dijit.layout.ContentPane" region="center">
	                 <input id="testCaseRunTestCaseList" name="testCaseRunTestCaseList" type="hidden" value="" />
	                  OK
	               </div>
	             </td>
	             <td style="vertical-align: top">
	               <button id="testCaseRunTestCaseDetailButton" dojoType="dijit.form.Button" showlabel="false"
	                 title="<?php echo i18n('showDetail');?>"
	                 iconClass="iconView">
                   <?php $createRight=(securityGetAccessRightYesNo('menuTestCase', 'create')=='YES')?'1':'0';?>
	                 <script type="dojo/connect" event="onClick" args="evt">
                    showDetail("testCaseRunTestCaseList", "<?php echo $createRight;?>","TestCase",true); 
                   </script>
	               </button>
	             </td>
	           </tr>
             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
             <tr>
               <td class="dialogLabel" >
                 <label for="testCaseRunAllowDuplicate" ><?php echo i18n("colAllowDuplicate") ?>&nbsp;:&nbsp;</label>
               </td>
               <td>
                 <div id="testCaseRunAllowDuplicate" name="testCaseRunAllowDuplicate"
                   dojoType="dijit.form.CheckBox" type="checkbox" >
                 </div>
                 <?php echo i18n("colAllowDuplicateTestInSession");?>
               </td>    
             </tr>
	         </table>
         </div>
         <div id="testCaseRunEditDiv">  
	         <table>
	           <tr>
	             <td class="dialogLabel"  >
	               <label for="testCaseRunTestCase" ><?php echo i18n("colTestCase") ?>&nbsp;:&nbsp;</label>
	             </td>
	             <td>
	               <select dojoType="dijit.form.FilteringSelect" 
	                id="testCaseRunTestCase" name="testCaseRunTestCase" 
	                class="input" value="" size="10">
	               </select>
	             </td>
	           </tr>
	           <tr>
	             <td class="dialogLabel"  >
	               <label for="testCaseRunStatus" ><?php echo i18n("colIdStatus") ?>&nbsp;:&nbsp;</label>
	             </td>
	             <td>
	               <select dojoType="dijit.form.FilteringSelect" 
	                id="testCaseRunStatus" name="testCaseRunStatus" 
                  onchange="testCaseRunChangeStatus();"
	                class="input" value="" required="required">
	                 <?php htmlDrawOptionForReference('idRunStatus', null, null, true); ?>
	               </select>
	             </td>
	           </tr>
	         </table>  
	         <div id='testCaseRunTicketDiv' >
		         <table>
		          <tr>
		             <td class="dialogLabel"  >
		               <label for="testCaseRunTicket" ><?php echo i18n("colTicket") ?>&nbsp;:&nbsp;</label>
		             </td>
		             <td>
		               <select dojoType="dijit.form.FilteringSelect" 
		                id="testCaseRunTicket" name="testCaseRunTicket" 
		                class="input" value="" >
		               </select>
		             </td>
                 <td style="vertical-align: top">
	                 <?php
	                 $readRight=(securityGetAccessRightYesNo('menuTicket', 'create')=='YES')?'1':'0'; 
	                 if ($readRight) {
	                   $createRight=(securityGetAccessRightYesNo('menuTicket', 'create')=='YES')?'1':'0';?>
                   <button id="testCaseRunTicketDetailButton" dojoType="dijit.form.Button" showlabel="false"
	                   title="<?php echo i18n('showDetail');?>"
	                   iconClass="iconView">	                   
	                   <script type="dojo/connect" event="onClick" args="evt">
                      showDetail("testCaseRunTicket", "<?php echo $createRight;?>","Ticket"); 
                   </script>
	                 </button>
                   <?php }?>
                </td>
		           </tr>
		         </table>
		       </div>
	         <table>
	           <tr>
	             <td class="dialogLabel" >
	               <label for="testCaseRunComment" ><?php echo i18n("colComment");?>&nbsp;:&nbsp;</label>
	             </td>
	             <td>
	                <textarea dojoType="dijit.form.Textarea"
	                          id="testCaseRunComment" name="testCaseRunComment"
	                          style="width: 400px;"
	                          maxlength="4000"
	                          class="input"></textarea>
	             </td>    
	           </tr>
	         </table>
         </div>
        </form>
      </td>
    </tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr>
      <td align="center">
        <input type="hidden" id="testCaseRunAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogTestCaseRun').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogTestCaseRunSubmit" onclick="protectDblClick(this);saveTestCaseRun();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>
<div id="dialogAffectation" dojoType="dijit.Dialog" title="<?php echo i18n("dialogAffectation");?>">
  <table>
    <tr>
      <td>
       <form dojoType="dijit.form.Form" id='affectationForm' name='affectationForm' onSubmit="return false;">
         <input id="affectationId" name="affectationId" type="hidden" value="" />
         <input id="affectationIdTeam" name="affectationIdTeam" type="hidden" value="" />
         <table>
           <tr>
             <td class="dialogLabel"  >
               <label for="affectationProject" ><?php echo i18n("colIdProject") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" 
                id="affectationProject" name="affectationProject" 
                class="input" value="" required="required">
                 <?php //htmlDrawOptionForReference('idProject', null, null, true);
                       // no use : will be updated on dialog opening;?>
               </select>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel"  >
               <label for="affectationResource" ><?php echo i18n("colIdResource") ?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" 
                id="affectationResource" name="affectationResource" 
                onChange="affectationChangeResource();"
                class="input" value="" required="required">
                 <?php //htmlDrawOptionForReference('idResource', null, null, true);
                       // no use : will be updated on dialog opening;?>
               </select>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="affectationProfile" ><?php echo i18n("colIdProfile");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <select dojoType="dijit.form.FilteringSelect" 
                id="affectationProfile" name="affectationProfile" 
                class="input" value="" required="required">
                 <?php htmlDrawOptionForReference('idProfile', null, null, true);?>
               </select>
               </div>
             </td>    
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="affectationRate" ><?php echo i18n("colRate");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="affectationRate" name="affectationRate" value="" 
                 dojoType="dijit.form.NumberTextBox" 
                 style="width:100px" class="input"
                 hasDownArrow="true"
               >
               <?php echo $keyDownEventScript;?>
               </div>
             </td>    
           </tr>
           <tr>
             <td colspan="2">
               <table>
                 <tr>
                   <td class="dialogLabel" >
                     <label for="affectationStartDate" ><?php echo i18n("colStartDate");?>&nbsp;:&nbsp;</label>
                   </td>
                   <td>
                     <input id="affectationStartDate" name="affectationStartDate" value=""  
			                 dojoType="dijit.form.DateTextBox" 
			                 constraints="{datePattern:browserLocaleDateFormatJs}"
			                 style="width:100px" />
                   </td>
                   <td class="dialogLabel" >
                     <label for="affectationEndDate" ><?php echo i18n("colEndDate");?>&nbsp;:&nbsp;</label>
                   </td>
                   <td>
                   <input id="affectationEndDate" name="affectationEndDate" value=""  
		                 dojoType="dijit.form.DateTextBox" 
		                 constraints="{datePattern:browserLocaleDateFormatJs}"
		                 style="width:100px" />
                   </td>
                 </tr>
               </table>
             </td>
           </tr>
           <tr>
             <td class="dialogLabel" >
               <label for="affectationIdle" ><?php echo i18n("colIdle");?>&nbsp;:&nbsp;</label>
             </td>
             <td>
               <div id="affectationIdle" name="affectationIdle"
                 dojoType="dijit.form.CheckBox" type="checkbox" >
               </div>
             </td>    
           </tr>
           <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
         </table>
        </form>
      </td>
    </tr>
    <tr>
      <td align="center">
        <input type="hidden" id="affectationAction">
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="dijit.byId('dialogAffectation').hide();">
          <?php echo i18n("buttonCancel");?>
        </button>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogAffectationSubmit" onclick="protectDblClick(this);saveAffectation();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
      </td>
    </tr>
  </table>
</div>

<div id="dialogFilter" dojoType="dijit.Dialog" title="<?php echo i18n("dialogFilter");?>" style="top: 100px;">
  <table>
    <tr>
     <td class="section"><?php echo i18n("sectionStoredFilters");?></td>
    </tr>
    <tr>
      <td>
        <div id='listStoredFilters' dojoType="dijit.layout.ContentPane" region="center"></div>
      </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
  </table>
  <table xstyle="border: 1px solid grey;">
    <tr>
     <td class="section"><?php echo i18n("sectionActiveFilter");?></td>
    </tr>
    <tr>
      <td style="margin: 2px;"> 
        <div id='listFilterClauses' dojoType="dijit.layout.ContentPane" region="center" style="overflow: hidden"></div>
         
        <form id='dialogFilterForm' name='dialogFilterForm' onSubmit="return false;">
         <input type="hidden" id="filterObjectClass" name="filterObjectClass" />
         <input type="hidden" id="filterClauseId" name="filterClauseId" />
         <input type="hidden" id="filterDataType" name="filterDataType" />
         <input type="hidden" id="filterName" name="filterName" />
         <input type="hidden" id="noFilterSelected" name="noFilterSelected" value="true" />
         <table width="100%" style="border: 1px solid grey;">
           <tr><td colspan="4" class="filterHeader"><?php echo i18n("addFilterClauseTitle");?></td></tr>
           <tr style="vertical-align: top;">
             <td style="width: 210px;" >
               <div dojoType="dojo.data.ItemFileReadStore" jsId="attributeStore" url="../tool/jsonList.php?listType=empty" searchAttr="name" >
               </div>
               <select dojoType="dijit.form.FilteringSelect" 
                id="idFilterAttribute" name="idFilterAttribute" 
                missingMessage="<?php echo i18n('attributeNotSelected');?>"
                class="input" value="" style="width: 200px;" store="attributeStore">
                  <script type="dojo/method" event="onChange" >
                    filterSelectAtribute(this.value);
                  </script>              
               </select>
             </td>
             <td style="width: 110px;">
               <div dojoType="dojo.data.ItemFileReadStore" jsId="operatorStore" url="../tool/jsonList.php?listType=empty" searchAttr="name" >
               </div>
               <select dojoType="dijit.form.FilteringSelect" 
                id="idFilterOperator" name="idFilterOperator" 
                missingMessage="<?php echo i18n('valueNotSelected');?>"
                class="input" value="" style="width: 100px;" store="operatorStore">
                  <script type="dojo/method" event="onChange" >
                    filterSelectOperator(this.value);
                  </script>        
               </select>
             </td>
             <td style="width:410px;vertical-align:middle;">
               <input id="filterValue" name="filterValue" value=""  
                 dojoType="dijit.form.TextBox" 
                 style="width:400px" />
               <select id="filterValueList" name="filterValueList[]" value=""  
                 dojoType="dijit.form.MultiSelect" multiple
                 style="width:400px" size="10" class="selectList"></select>
                <input type="checkbox" id="filterValueCheckbox" name="filterValueCheckbox" value=""  
                 dojoType="dijit.form.CheckBox" style="padding-top:7px";
                 /> 
                <input id="filterValueDate" name="filterValueDate" value=""  
                 dojoType="dijit.form.DateTextBox" 
                 constraints="{datePattern:browserLocaleDateFormatJs}"
                 style="width:100px" />
                 <select id="filterSortValueList" name="filterSortValueList" value="asc"  
                 dojoType="dijit.form.FilteringSelect"
                 missingMessage="<?php echo i18n('valueNotSelected');?>" 
                 style="width:400px" size="10" class="input">
                  <option value="asc" SELECTED><?php echo i18n('sortAsc');?></option>
                  <option value="desc"><?php echo i18n('sortDesc');?></option>
                 </select> 
             </td>
             <td style="width:25px; text-align: center;vertical-align:middle;" align="center">
               <img src="css/images/smallButtonAdd.png" style="margin-top:3px" class="roundedButtonSmall" onClick="addfilterClause();" title="<?php echo i18n('addFilterClause');?>" class="smallButton"/> 
             </td>
           </tr>
         </table>
        </form>
      </td>
    </tr>
    <tr style="height:32px">
      <td align="center">
        <table><tr><td>
        <span id="filterDefaultButtonDiv">
          <button class="mediumTextButton" dojoType="dijit.form.Button" onclick="defaultFilter();">
            <?php echo i18n("buttonDefault");?>
          </button>
        </span>
        </td><td>
        <button class="mediumTextButton" dojoType="dijit.form.Button" onclick="clearFilter();">
          <?php echo i18n("buttonClear");?>
        </button>
        </td><td>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="button" onclick="cancelFilter();">
          <?php echo i18n("buttonCancel");?>
        </button>
        </td><td>
        <button class="mediumTextButton" dojoType="dijit.form.Button" type="submit" id="dialogFilterSubmit" onclick="protectDblClick(this);selectFilter();return false;">
          <?php echo i18n("buttonOK");?>
        </button>
        </td></tr></table>
      </td>
    </tr>
  </table>
</div>
<div id="xdialogShowImage" dojoType="dojox.image.LightboxDialog" >
</div>
<form  method="POST" style="display:none" id="directAccessForm" action="../view/main.php">
  <input pe="hidden" name="directAccessPage" id="directAccessPage" value="" />
  <input pe="hidden" name="menuActualStatus" id="menuActualStatus" value="" />
  <input pe="hidden" name="p1name" id="p1name" value="" />
  <input pe="hidden" name="p1value" id="p1value" value="" />
</form>
<form id='favoriteForm' name='favoriteForm' onSubmit="return false;">
  <input type="hidden" id="page" name="page" value=""/>
  <input type="hidden" id="print" name="print" value=true />
  <input type="hidden" id="report" name="report" value=true />
  <input type="hidden" id="outMode" name="outMode" value='html' />
  <input type="hidden" id="reportName" name="reportName" value="test" />
</form>
</body>
</html>
