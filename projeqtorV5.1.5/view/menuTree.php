<?php
/*** COPYRIGHT NOTICE *********************************************************
 *
 * Copyright 2009-2015 ProjeQtOr - Pascal BERNARD - support@projeqtor.org
 * Contributors : -
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
 * Presents left menu of application. 
 */
  require_once "../tool/projeqtor.php";
  scriptLog('   ->/view/menuTree.php');
  $menuNextIsFirst=true; // is next element fisrt of a group
  $level=0;
  $menuLevel=array('0'=>'0');
  /** ==========================================================================
   * Draw a tree item to present a menu
   * @param $menu the name of menu
   * @param $type the type : 'menu', 'item' or 'object'
   * @param $hasChildren boolean wether the menu has sub-menu or not
   * @param $icon name of icon class, if different from name
   * @param $force boolean to force display, not depending on security check
   * @return void
   */
  function drawMenuItem($idMenu,$menuName,$type,$hasChildren=false,$force=false, $class=null) {
    global  $menuNextIsFirst, $level, $menuLevel;
    $paramIconSize=Parameter::getUserParameter('paramIconSize');
    $menu=substr($menuName,4);
    if (securityCheckDisplayMenu($idMenu,$menu) or $force) {
      if (! $menuNextIsFirst) {
        echo ", \n";
      }
      //echo $level;
      $name=ucfirst($menu);
      if ($class) {
        $icon=$class;
      } else {
        $icon=$name;
      }
      echo substr('          ',0,$level*2);
      echo '{ id:"' . $name . '", name:"' . i18n('menu'.$menu) . '"';
      echo ', "type":"' . $type . '" , iconClass:"icon' . $icon .  $paramIconSize . '"'; 
      if ($class and $type=='class') {
        echo ', "objectClass":"' . $class . '"';
      }
      if ($hasChildren) {
        echo ", children: [\n";
        $menuNextIsFirst=true;
        $level+=1;
        $menuLevel[$level]=$idMenu;
      } else {
       echo '}';
        $menuNextIsFirst=false;
      }
    }
 }  
 
 /** ==========================================================================
  * Draw all menu and sub-menu for an object class
  * @param $class the class
  * @return void
  */
  function drawMenuItemClass($idMenu, $menuName) {
    $class=substr($menuName,4);
    global  $menuTree;
    if (securityCheckDisplayMenu($idMenu, $class)) {
     drawMenuItem($idMenu,$class, 'menu', true);
     drawMenuItem($idMenu, 'All' . $class, 'class', false, true, $class); 
     //drawMenuCloseChildren($idMenu);
    }
  }  
 
 /** ==========================================================================
  * Draw the closing of sub-menu list
  * @param $menu the menu name (just for scurity check to validate visibility)
  * @return void
  */
  function drawMenuCloseChildren() {
    global  $menuNextIsFirst, $level, $menuLevel;
    echo " ] } ";
    unset($menuLevel[$level]); 
    $level-=1;
    $menuNextIsFirst=false;
  }
?>

<?php if ( ! $testMode) {?>
<script>
<?php }?>
var menuData = {
"identifier": "id",
"label": "name",
"items": [
<?php  
  $obj=new Menu();
  $menuList=$obj->getSqlElementsFromCriteria(null, false);
  $idMenu=null;
  $prioMenuType=null;
  foreach ($menuList as $menu) {
    //echo "id=" . $menu->id . "     idMenu=" . $menu->idMenu . "     level=" . $level . "\n";
    if ($level>0 and securityCheckDisplayMenu($menu->id,$menu) ) {
      while ($level>0 and $menu->idMenu!= $menuLevel[$level]) {
        drawMenuCloseChildren();
      }
    }
    if ($menu->type=='class') {
      drawMenuItemClass($menu->id,$menu->name);
    } else if ($menu->type=='menu') {
      drawMenuItem($menu->id,$menu->name,'menu', true);
    } else if ($menu->type=='item') {
      drawMenuItem($menu->id,$menu->name,'item', false);
    } else if ($menu->type=='object') {
      drawMenuItem($menu->id,$menu->name,'object', false);
    }
  }
  while ($level>0) {
    drawMenuCloseChildren();
  }
  ?>
]
};

<?php if ( ! $testMode) {?>
var menuStore = new dojo.data.ItemFileReadStore({data: menuData});
</script>

<div dojoType="dijit.tree.ForestStoreModel" jsId="menuModel" 
     store="menuStore" query="{type:'*'}" rootId="ProjeQtOr" rootLabel="ProjeQtOr Menu">
</div>

<div class="container" dojoType="dijit.layout.BorderContainer" liveSplitters="false">
  <div dojoType="dijit.layout.ContentPane" region="center" >
    <div dojoType="dijit.Tree" id="menuTree" jsId="menuTree" model="menuModel"
     labelAttr="name" typeAttr="menu" showRoot="false" openOnClick="true">
      <script type="dojo/method" event="onClick" args="item">
    if (checkFormChangeInProgress()) {
      return false;
    }
    menuClick();
    if (item.type=='object') {
        loadMenuBarObject(item.id,item.name,'tree');
    } else if (item.type=='item') {
        loadMenuBarItem(item.id, item.name,'tree');
    } else if (item.type=='class') {
      cleanContent("detailDiv");
	    formChangeInProgress=false;
	    loadContent("objectMain.php?objectClass="+item.objectClass,"centerDiv");
	  } else if (item.type=='menu') {
       // Nothing
    } else if (item.type=='plugin') {
      loadMenuBarPlugin(item.id, item.name,'tree');
    } else {
	    showInfo(i18n("messageSelectedNotAvailable", new Array(item.name)));
	  }
      </script>
      <script type="dojo/method" event="getIconClass" args="item, opened">
    if (item == this.model.root) {
      return "checkBox";
    } else {
      return menuStore.getValue(item, "iconClass");
    }
      </script>
    </div>
  </div>
</div>
<?php }?>