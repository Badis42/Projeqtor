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

/*
 */
require_once ('_securityCheck.php');
class WorkElement extends SqlElement {
	
	// extends SqlElement, so has $id
	public $id; // redefine $id to specify its visiblez place
	public $refType;
	public $refId;
	public $idActivity;
	public $refName;
	public $_tab_3_1 = array('estimated', 'real','left','work');
	public $plannedWork;
	public $realWork;
	public $leftWork;
	public $_spe_run;
	public $_spe_dispatch;
	public $idUser;
	public $ongoing;
	public $ongoingStartDateTime;
	
	public $done;
	public $idle;
	public $_nbColMax=3;
	
	private static $_fieldsAttributes = array (
			"refType" => "hidden",
			"refId" => "hidden",
			"refName" => "hidden",
			"realWork" => "",
			"ongoing" => "hidden",
			"ongoingStartDateTime" => "hidden",
			"idUser" => "hidden",
			"idActivity" => "hidden",
			"leftWork" => "readonly",
			"done" => "hidden",
			"idle" => "hidden"
	);
	private static $_colCaptionTransposition = array (
			'plannedWork' => 'estimatedWork' 
	);
	
	/**
	 * ==========================================================================
	 * Constructor
	 * 
	 * @param $id the
	 *        	id of the object in the database (null if not stored yet)
	 * @return void
	 */
	function __construct($id = NULL, $withoutDependentObjects=false) {
		parent::__construct ( $id );
	}
	
	/**
	 * ==========================================================================
	 * Destructor
	 * 
	 * @return void
	 */
	function __destruct() {
		parent::__destruct ();
	}
	
	// ============================================================================**********
	// GET STATIC DATA FUNCTIONS
	// ============================================================================**********
	
	/**
	 * ==========================================================================
	 * Return the specific fieldsAttributes
	 * 
	 * @return the fieldsAttributes
	 */
	protected function getStaticFieldsAttributes() {
		if (! $this->id) {
			self::lockRealWork ();
		}
		return self::$_fieldsAttributes;
	}
	public static function lockRealWork() {
		self::$_fieldsAttributes ['realWork'] = 'readonly';
	}
	/**
	 * ============================================================================
	 * Return the specific colCaptionTransposition
	 * 
	 * @return the colCaptionTransposition
	 */
	protected function getStaticColCaptionTransposition($fld) {
		return self::$_colCaptionTransposition;
	}
	public function save($noDispatch=false) {
		$old = $this->getOld ();
		if (! sessionUserExists()) return parent::save ();
		$user = getSessionUser();
		// Update left work
		$this->leftWork = $this->plannedWork - $this->realWork;
		if ($this->leftWork < 0 or $this->done) {
			$this->leftWork = 0;
		}
		
		// Retrive informations from Ticket and possibly Parent Activity (from Ticket)
		$top = null;
		if ($this->refType) {
			$top = new $this->refType ( $this->refId ); // retrieve Ticket
			$this->refName=$top->name;
			$topProject = $top->idProject; // Retrive project from Ticket
			if (isset ( $top->idActivity )) { // Retrive Activity from Ticket
				$this->idActivity = $top->idActivity;
			}
		} else { // Should never come here; workElement is always sub-item of Ticket
			// $top = new Project();
			$topProject = $this->idProject;
		}
		
		// Set done if Ticket is done
		if ($top and isset ( $top->done ) and $top->done == 1) {
			$this->leftWork = 0;
			$this->done = 1;
		}
		
		if ($top and property_exists ( $top, 'idActivity' ) and ! $noDispatch) {
			$this->idActivity = $top->idActivity;
			// Check if changed Planning Activity
			if (! trim ( $old->idActivity ) and $old->idActivity != $this->idActivity) {
			  // If Activity changed, retrieve existing work
				$crit = array (
						'refType' => $this->refType,
						'refId' => $this->refId 
				);
				$work = new Work ();
				$workList = $work->getSqlElementsFromCriteria ( $crit );
				// Assign existing work to the activity (preserve link through idWorkElement)
				foreach ( $workList as $work ) {
					$work->refType = 'Activity';
					$work->refId = $this->idActivity;
					$work->idAssignment = self::updateAssignment ( $work, $work->work );
					$work->idWorkElement=$this->id;
					$work->save ();
				}
			}
		}
		$result = parent::save ();
		if ($noDispatch) {
		  return $result;
	  }
		$diff = $this->realWork - $old->realWork;
		// If realWork has changed (not through Dispatch screen), update the work
		if ($diff != 0) {
			// Set work to Ticket
			$idx = - 1;
			// Will retrive work for current WorkElement, Current resource
			$crit = array (
				'idWorkElement' => $this->id,
				'idResource' => $user->id 
				);
			// If change is add work, will input current date
			if ($diff > 0) {
				$crit ['workDate'] = date ( 'Y-m-d' );
			}
			$work = new Work ();
			$workList = $work->getSqlElementsFromCriteria ( $crit, true, null, 'day asc' );
			if (count ( $workList ) > 0) { // If work exists, retrive the last one
				$idx = count ( $workList ) - 1;
				$work = $workList [$idx];
			} else { // If work does not exist, will create new one
				$work = new Work ();
				$work->refType = $this->refType;
				$work->refId = $this->refId;
				$work->idResource = $user->id;
				$work->idProject = $topProject;
				$work->dailyCost = 0;
				$work->idWorkElement=$this->id;
				$work->cost = 0;
			}
			if ($diff > 0) {
				$work->work += $diff;
				$work->setDates ( date ( 'Y-m-d' ) );
				if ($work->work < 0) { // Should never happen as $diff is > 0 here 
					$work->work = 0;
				}
				if ($this->idActivity) {
				  $work->refType = 'Activity';
				  $work->refId = $this->idActivity;
				} else { // Ensure work is correcly set to ref item
					$work->refType = $this->refType;
					$work->refId = $this->refId;
				}
				$work->idProject = $topProject;
				$work->idAssignment = self::updateAssignment ( $work, $diff );
				$work->idWorkElement=$this->id;
				$work->save();
			} else {
			  // Remove work : so need to remove from existing (reverse loop on date) 
				while ( $diff < 0 and $idx >= 0 ) {
					$valDiff = 0;
					if ($work->work + $diff >= 0) {
						$valDiff = $diff;
						$work->work += $diff;
						$diff = 0;
					} else {
						$valDiff = (- 1) * $work->work;
						$diff += $work->work;
						$work->work = 0;
					}
					$work->idAssignment = self::updateAssignment ( $work, $valDiff );
					$work->idWorkElement=$this->id;
					if ($work->work == 0) {
						if ($work->id) {
							$work->delete ();
						}
					} else {
						$work->save ();
					}
					$idx --;
					if ($idx >= 0) { // Retrieve previous work element
						$work = $workList [$idx];
					} else if ($diff!=0) { // Not more work for current user, but could not remove all difference (exiting work for other user)
					  // Reaffect work !!!
					  $this->realWork=$diff*(-1);
					  $resSaveLeft=$this->save(true); // Save but do not try and dispatch any more
					}
				}
			}
		}
		if ($top and property_exists ( $top, 'idActivity' ) and $top->idActivity) {
			$ape = SqlElement::getSingleSqlElementFromCriteria ( 'ActivityPlanningElement', array (
					'refType' => 'Activity',
					'refId' => $top->idActivity 
			) );
			if ($ape and $ape->id) {			
				$ape->updateWorkElementSummary ();
			}
		}
		return $result;
	}
	
	public static function updateAssignment($work, $diff) {
		if ($work->refType != 'Activity') {
			return null;
		}
		$ass = new Assignment ();
		$crit = array (
				'refType' => $work->refType,
				'refId' => $work->refId,
				'idResource' => $work->idResource 
		);
		$lstAss = $ass->getSqlElementsFromCriteria ( $crit );
		if (count ( $lstAss ) > 0) {
			$ass = $lstAss [count ( $lstAss ) - 1];
		} else {
			$ass = new Assignment ();
			$ass->refType = $work->refType;
			$ass->refId = $work->refId;
			$ass->idResource = $work->idResource;
		}
		$ass->leftWork -= $diff;
		$ass->realWork += $diff;
		if ($ass->leftWork < 0 or $ass->leftWork == null) {
			$ass->leftWork = 0;
		}
		if ($ass->realWork < 0) {
			$ass->realWork = 0;
		}
		$ass->save ();
		return $ass->id;
	}
	
	public function start() {
		// First, stop all ongoing work
		getSessionUser()->stopAllWork ();
		// Then start current work
		$this->idUser = getSessionUser()->id;
		$this->ongoing = 1;
		$this->ongoingStartDateTime = date ( 'Y-m-d H:i:s' );
		$this->save ();
		// save to database
	}
	
	/**
	 */
	public function stop() {	  
		$start = $this->ongoingStartDateTime;
		$stop = date ( 'Y-m-d H:i:s' );
		$work = workTimeDiffDateTime ( $start, $stop );
		$this->realWork += $work;
		$this->idUser = null;
		$this->ongoing = 0;
		$this->ongoingStartDateTime = null;
		$this->save ();
	}
	
	/**
	 * =========================================================================
	 * Draw a specific item for the current class.
	 * 
	 * @param $item the
	 *        	item. Correct values are :
	 *        	- subprojects => presents sub-projects as a tree
	 * @return an html string able to display a specific item
	 *         must be redefined in the inherited class
	 */
	public function drawSpecificItem($item, $included=false) {
		global $print, $comboDetail, $nbColMax;
		$result = "";
		$refObj = new $this->refType ( $this->refId );
		if ($item == 'run' and ! $comboDetail and ! $this->idle) {
			if ($print or $this->isAttributeSetToField('realWork', 'readonly')) {
				return "";
			}
			$user = getSessionUser();
			$title = i18n ( 'startWork' );
			if ($this->ongoing) {
				$title = i18n ( 'stopWork' );
			}
			$canUpdate = (securityGetAccessRightYesNo ( 'menu' . $this->refType, 'update', $refObj ) == 'YES');			
			$result .= '<div style="position:absolute; right:2px;width:150px !important';
      $result .= ' border: 0px solid #FFFFFF; -moz-border-radius: 15px; border-radius: 15px; text-align: right;">';     
      if ($user->isResource and $canUpdate and $this->id) {
				$result .= '<button id="startStopWork" dojoType="dijit.form.Button" showlabel="true"';
				if (($this->ongoing and $this->idUser != $user->id) or ! $user->isResource) {
					$result .= ' disabled="disabled" ';
				}
				$result .= ' title="' . $title . '" style="vertical-align: middle;">';
				$result .= '<span>' . $title . '</span>';
				$result .= '<script type="dojo/connect" event="onClick" args="evt">';
				$result .= 'startStopWork("' . (($this->ongoing) ? 'stop' : 'start') . '","' . $this->refType . '",' . $this->refId . ');';
				// $result .= ' loadContent("../tool/startStopWork.php?action=' . (($this->ongoing) ? 'stop' : 'start') . '","resultDiv","objectForm",true);';
				$result .= '</script>';
				$result .= '</button><br/>';
				
			}
			if ($canUpdate and $this->id and property_exists($this,'_spe_dispatch')) {
			  $result.=$this->drawSpecificItem('dispatch', true);
			}
			if ($this->ongoing) {
				if ($this->idUser == $user->id) {
					// $days = workDayDiffDates($this->ongoingStartDateTime, date('Y-m-d H:i'));
					if (substr ( $this->ongoingStartDateTime, 0, 10 ) != date ( 'Y-m-d' )) {
						// $result .= i18n('workStartedSince', array($days));
						$result .= i18n ( 'workStartedAt', array (
								substr ( $this->ongoingStartDateTime, 11, 5 ) . ' (' . htmlFormatDate ( substr ( $this->ongoingStartDateTime, 0, 10 ) ) . ')' 
						) );
					} else {
						$result .= i18n ( 'workStartedAt', array (
								substr ( $this->ongoingStartDateTime, 11, 5 ) 
						) );
					}
				} else {
					$result .= i18n ( 'workStartedBy', array (
							SqlList::getNameFromId ( 'Resource', $this->idUser ) 
					) );
				}
			}
			$result .= '</div>';
			return $result;
		} else if ($item == 'dispatch' and ! $comboDetail and ! $this->idle and $included) {
			if ($print or $this->isAttributeSetToField('realWork', 'readonly')) {
				return "";
			}
			$user = getSessionUser();
			$canUpdate = (securityGetAccessRightYesNo ( 'menu' . $this->refType, 'update', $refObj ) == 'YES');
			if ($canUpdate and $this->id) {
			  $result .= '<div style="position:absolute; right:0px;width:80px !important;top:-24px;text-align:right;">';
				$result .= '<button id="dispatchWork" dojoType="dijit.form.Button" showlabel="true"';
				$result .= ' title="'.i18n('dispatchWork').'" style="max-width:77px;vertical-align: middle;">';
				$result .= '<span>' . i18n('dispatchWorkShort') . '</span>';
				$result .= '<script type="dojo/connect" event="onClick" args="evt">';
				$result .= 'dispatchWork("' . $this->refType . '",' . $this->refId . ');';
				$result .= '</script>';
				$result .= '</button>';
				$result.='</div>';
			}
		}
		return $result;
	}
}
?>