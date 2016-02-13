.. include:: ImageReplacement.txt

.. title:: Graphical User Interface

.. raw:: latex

    \newpage

Global view
===========

ProjeQtOr interface is divided into several areas.

Those areas are :

* :ref:`top-bar` |one|
* :ref:`logo-area` |two|
* :ref:`menu-document-window` |three|
* :ref:`message-link-window` |four|
* :ref:`list-window` |five|
* :ref:`detail-window` |six|
* :ref:`info-bar` |seven|

.. figure:: /images/GUI/SCR_GeneralwithArea.png
   :alt: Global view
   :align: center

   Global view



.. raw:: latex

    \newpage


.. rubric:: Area separation

* The splitters allow resizing areas in the interface.
* The green splitter allows to resize the areas **«Menu and Documents window» and «Message and Link window»**.
* The red splitter allows to resize the areas left and right.
* The orange splitter allows to resize the areas **«List window» and «Detail window»**.

.. figure:: /images/GUI/SCR_WindowsSplitters.png
   :alt: Windows splitters
   :align: center

   Area separation


.. raw:: latex

    \newpage

.. _top-bar:

Top bar
-------

.. figure:: /images/GUI/SCR_TopBar.png
   :alt: Top bar
   :align: center

   Top bar

.. rubric:: Menu buttons

.. figure:: /images/GUI/ZONE_MenuButtons.png
   :alt: Menu buttons zone
   :align: center

   Menu buttons zone

* The menu buttons |two| give rapid access to main elements.
* The arrows |three| allow to scroll buttons list.

 .. compound:: **Contextual menu buttons** |one|

    * Allows to select a work context to limit the displayed buttons.

.. raw:: latex

    \newpage

.. index:: ! Project (Selector)

.. rubric:: Project selector

.. figure:: /images/GUI/ZONE_ProjectSelector.png
   :alt: Project selector zone
   :align: center

   Project selector zone

* Allows restricting the visibility of all objects of the dedicated project, including sub-projects if any.
* The selection will also define the “default” project for new items.

 .. compound:: **Project selector parameters**

    * Click on |buttonIconParameter| to display the project selector parameters dialog box, you can select :

      * View closed projects.
      * Change the project selector format.
      * Refresh the list.

.. figure:: /images/GUI/BOX_ProjectSelectorParameters.png
   :alt: Project selector parameters dialog box
   :align: center

   Project selector parameters dialog box

.. raw:: latex

   \newpage

.. _navigation-buttons:

.. rubric:: Navigation buttons

.. figure:: /images/GUI/ZONE_NavigationButtons.png
   :alt: Navigation buttons zone
   :align: center

   Navigation buttons zone

* The navigation buttons |buttonIconBackNavigation| |buttonIconForwardNavigation| give access to previous and next items in the history.

.. rubric:: Button «New tab» 

* Allows to open a new tab within the same session.

.. figure:: /images/GUI/ZONE_NewTabButton.png
   :alt: New tab button zone
   :align: center

   Button «New tab» zone

.. raw:: latex

   \newpage

.. _logo-area:

Logo area
---------

.. figure:: /images/GUI/SCR_LogoArea.png
   :alt: Logo area
   :align: center

   Logo area

.. rubric:: Information about the software

* Click on «Logo Area» will display the software information box.

.. figure:: /images/GUI/INFO_SoftwareInformation.png
   :alt: Software information box
   :align: center

   Software information box


.. rubric:: Online user manual

* Click on |buttonIconHelp| or use shortcut key :kbd:`F1` will open the online user manual, to the page corresponding to the current screen. 

  .. note:: 

     * You can change logo with your own.
     * Refer to administration guide to replace the logo.


.. raw:: latex

    \newpage

.. _menu-document-window:

«Menu» and «Documents» windows
------------------------------

.. figure:: /images/GUI/SCR_MenuAndDocumentsWindows.png
   :alt: «Menu» and «Documents» windows 
   :align: center

   «Menu» and «Documents» windows

.. note:: Toggling between windows

   * To toggling between windows, just click on window header.  

.. raw:: latex

   \newpage


.. rubric:: Menu window

* The menu is proposed as a tree view of reachable items. 
* The items presented will depend on the access rights of user to the screens.
* Click on a grouping line will expand-shrink the group.
* Click on an item will display the corresponding screen in the main area (right side of the screen).

.. figure:: /images/GUI/ZONE_MenuWindow.png
   :alt: Menu window
   :align: center
   
   Menu window

.. note:: User parameter “Icon size in menu”

   * This parameter defines the size of icons in the menu.


.. raw:: latex

   \newpage

.. rubric:: Documents window

* Document directories give direct access to documents contained in the directory.

.. figure:: /images/GUI/ZONE_DocumentsWindow.png
   :alt: Documents window
   :align: center

   Documents window


.. topic:: Document directories

   This icon |buttonIconDocDir| gives direct access to the :ref:`document-directory` screen.

.. raw:: latex

    \newpage

.. _message-link-window:

«External shortcuts» and «Console messages» windows
---------------------------------------------------

.. figure:: /images/GUI/SCR_MessageAndLinkWindows.png
   :alt: External shortcuts and Console messages windows
   :align: center

   «External shortcuts» and «Console messages» windows

.. note:: Toggling between windows

   * To toggling between windows, just click on window header.   

.. raw:: latex

    \newpage

.. rubric:: External shortcuts window

* Display hyperlinks to remote web pages.
* These links are defined as hyperlink attachments on projects.
* Links displayed here depend on the selected project.


.. figure:: /images/GUI/ZONE_ExternalShortcuts.png
   :alt: External shortcuts
   :align: center

   External shortcuts window



.. rubric:: Console messages window

* Displays information about main actions: insert, update, delete. 
* The timestamp indicates when the action was done.

.. figure:: /images/GUI/ZONE_ConsoleMessages.png
   :alt: Console messages
   :align: center

   Console messages window

.. note::

   * Messages displayed here are not stored and will be flushed when user logout.

.. raw:: latex

    \newpage


.. _list-window:

List window
-----------

.. figure:: /images/GUI/SCR_ListWindow.png
   :alt: List window
   :align: center

   List window



.. figure:: /images/GUI/ZONE_ListWindowPart.png
   :alt: List window zone
   :align: center

   List window zone


.. rubric:: 1 - Element identifier

* Displays the element name and the count of items in the list.  
* Each element is identified with a distinctive icon.




.. raw:: latex

    \newpage

.. _rapid-filter:

.. rubric:: 2 - Rapid filter

* Rapid filtering fields are proposed : «Id», «Name» and «Type».

.. topic:: Any change on «Id» and «Name»

   * Will instantly filter data.  
   * Search is considered as «contains», so typing «1» in «Id» will select «1», «10», «11», «21», «31» and so on.

.. topic:: Selecting a «Type»
  
   * Will restrict the list to the corresponding type.


.. rubric:: 3 - Buttons 

* Click on |buttonIconSearch| to execute a textual search. (See: :ref:`quick-search`)
* Click on |buttonIconFilter| to define an advanced filter. (See: :ref:`advanced-filter`)
* Click on |buttonIconColumn| to define the columns displayed. (See: :ref:`displayed-columns`)
* Click on |buttonIconPrint| to get a printable version of the list.
* Click on |buttonIconPdf| to export it to PDF format.
* Click on |buttonIconCsv| to export data of the selected items in a CSV format file. (See: :ref:`export-csv-format`)
* Click on |buttonIconNew| to create a new item of the element.


.. rubric:: 4 - Checkbox «Show closed items»

* Flag on «Show closed items» allows to list also closed items.


.. rubric:: 5 - Column headers

* Click a column header to sort the list on that column (first ascending, then descending).

.. note:: Sorting is not always on the name displayed 

   * If the sorted column is linked to a reference list with sort order value, the sorting is executed on this sort value.

   .. admonition:: For instance    
     
      * Sorting on the «Status» allows to sort values such as defined in the workflow. 

.. rubric:: 6 - Items list

* Click on a line (any column) will display the corresponding item in the detail window.




.. raw:: latex

    \newpage

.. _quick-search:

Quick search
^^^^^^^^^^^^

The quick search allows to execute a textual search.

.. figure:: /images/GUI/ZONE_QuickSearch.png
   :alt: Quick search zone
   :align: center

   Quick search zone

   * Click on |buttonIconSearch| to execute the search.
   * Click on |buttonIconUndo| to close the quick search.

.. raw:: latex

    \newpage

.. _advanced-filter:

Advanced filter
^^^^^^^^^^^^^^^

The advanced filter allows to define clause to filter and sort.

* The advanced filter definition dialog box is divided into two sections.

.. figure:: /images/GUI/BOX_AdvancedFilterDefinition.png
   :alt: Advanced filter definition dialog box
   :align: center

   Advanced filter definition dialog box

 
.. rubric:: 1 - Active filter

* This section allows to define the filter and sort clauses.

 .. compound:: **Add criteria**

    * Define the clauses of filter or sort in «Add a filter or sort clause».
    * Select the name of the field, the operator and the value to the clause.
    * Click on |buttonAdd| to add additional criteria. 
    * Click on **OK** button to apply the filter.
    * Click on **Cancel** button to revert to previous filter.

 .. compound:: **Remove criteria**

    * To remove a criteria, click on |buttonIconDelete| on the line.
    * To remove all criteria, click on |buttonIconDelete| on the header.
    * Click on the **Clear** button to reset the active filter.

 .. compound:: **Save active filter**

    * Active filter can be saved to reuse.
    * Fill the filter name and click on |IconSave| to save the filter definition.  


.. raw:: latex

    \newpage

 
.. rubric:: 2 - Saved filters

* This section allows to manage saved filters.

* Click on a saved filter to retrieve its definition.
* Click on |buttonIconDelete| from a saved filter to delete it.
* Click on the **Default** button to to define the active stored filter as the default, kept even after disconnection.

.. note:: Default filter

   * The default filter is defined for the user.
   * The filter will be automatically applied in the next connection.

------------

.. rubric:: List of filters

* The filter list allows to select a stored filter.
* To see the filter list, move the cursor over the advanced filter icon.

.. figure:: /images/GUI/TIP_AdvancedFilterList.png
   :alt: Advancedilter list toolti
   :align: center

   Stored filters

* Click on the filter name to apply. |buttonIconActiveFilter|
* Click on **«no filter clause»** to reset the filter. |buttonIconFilter|


.. raw:: latex

    \newpage


.. _displayed-columns:

Displayed columns
^^^^^^^^^^^^^^^^^

This functionality allows to define columns displayed in the list  for this element.

* Click on **OK** button to apply changes.
* Click on **Reset** button to reset the list to its default format. 

 .. note::
   
    * The columns display is defined for the user.
    * The definition will be automatically applied in the next connection.

.. figure:: /images/GUI/BOX_SelectColunmsToDisplay.png
   :alt: Select columns to display dialog box
   :align: center

   Select columns to display dialog box


.. rubric:: Column selection

* Use checkboxes to select or unselect columns to display.

 .. note:: 

    * **Id** and **name** are mandatory fields.
    * They cannot be removed from display.

.. rubric:: Columns order

* Use the selector area |buttonIconDrag| to reorder fields with drag & drop feature.


.. raw:: latex

    \newpage

.. rubric:: Column size 

* Use the spinner button |one| to change the width of the field.
* Width is in % of the total list width.
* The minimum width is 1%. 
* The maximum width is 50%.

 .. note:: Field: Name

    * The width of the field is automatically adjusted so that the total list width is 100%.
    * The width of the field cannot be less than 10%.

 .. warning:: Total width over 100%

    * The total width must be limited to a maximum 100%.
    * The exceedance will be highlighted beside the buttons. |two|
    * This may lead to strange display, over page width, on list, reports and PDF export, depending on the browser.




.. raw:: latex

    \newpage

.. _export-csv-format:

Export to CSV format
^^^^^^^^^^^^^^^^^^^^

This functionality allows to export data of list in a CSV file.

The fields are regrouped and presented in the order as they appear in the item description.

* Click on **OK** button to export data.
* Click on **Cancel** button to close the dialog box.

.. note::

   * The active filter defined will be applied to export data.
   * The CSV exported files can directly be imported through the import functionality. (See: :ref:`import-data`)
   * The export definition is defined for each user. 
   * The same definition can be applied in the next export.

.. figure:: /images/GUI/BOX_Export.png
   :alt: Export dialog box
   :align: center

   Export dialog box

.. rubric:: Fields selection

* Use the checkbox to select or unselect all fields.
* Click on **«Select list columns»** button to restrict selected fields to the ones that are currently displayed in the list.

.. rubric:: Id or name for references

* For fields that reference another item, you can select to export either the id or the clear name for the referenced item.





.. raw:: latex

    \newpage

.. _detail-window:

Detail window
-------------

.. figure:: /images/GUI/SCR_DetailWindow.png
   :alt: Detail window
   :align: center

   Detail window


.. figure:: /images/GUI/ZONE_DetailWindowPart.png
   :alt: GUI detail window Part
   :align: center

.. rubric:: 1 - Item identifier

* Identifies the item with the element name and the item id.
* Each element is identified with a distinctive icon.

.. rubric:: 2 - Creation information

* Information on the item (issuer and creation date).

 .. note::

    * Administrator can change information.

.. raw:: latex

    \newpage

.. rubric:: 3 - Buttons

* Click on |buttonIconNew| to create a new item.        
* Click on |buttonIconSave| or use shortcut key :kbd:`Control-s` to save the changes. 
* Click on |buttonIconPrint| to get a printable version of the details.
* Click on |buttonIconPdf|  to get a printable version of the details in PDF format.
* Click on |buttonIconCopy| to copy the current item. (See: :ref:`copy-item`)        
* Click on |buttonIconUndo| to cancel ongoing changes.      
* Click on |buttonIconDelete| to delete the item.      
* Click on |buttonIconRefresh| to refresh the display.      
* Click on |buttonIconEmail| to send details of item by email. (See: :ref:`email-detail`)
* Click on |buttonIconMultipleUpdate| to update several items in one operation. (See: :ref:`multiple-update`)
* Click on |buttonIconShowChecklist| to show the checklist form. (See: :ref:`checklist`)
* Click on |buttonIconShowHistory| to show history of changes. (See: :ref:`change-history`)


 .. note::

    * Some buttons are not clickable when changes are ongoing.
    * |buttonIconUndo| button is clickable only when changes are ongoing.

 .. warning::

    * When changes are ongoing, you cannot select another item or another menu item. 
    * Save or cancel ongoing changes first.

.. rubric:: 4 - Drop file area

* This area allows to add an attachment file to the item.

  * Drop the file in the area.
  * Or click on the area to select a file.

.. raw:: latex

    \newpage


.. rubric:: 5 -Sections

* The fields are regrouped under a section.
* All sections can be folded or unfolded, clicking on the section title. 
* The sections are organized in columns.

  * Maximum three columns can be displayed.

* Some sections are displayed on almost all screens. (See : :ref:`common-sections`)  

 .. compound:: **Item count in the list**

    * When the section contains a list, the item count is displayed at right of the header.

    .. figure:: /images/GUI/ZONE_SectionHeader.png
       :alt: Header section dialog box
       :align: center

       Header section dialog box





.. raw:: latex

    \newpage



.. _copy-item:

Copy item
^^^^^^^^^

* Allows copied an item of the element.
* The options displayed in dialog box depends on whether the element is simple or complex.

.. figure:: /images/GUI/BOX_CopyElement.png
   :alt: Copy element dialog box
   :align: center

   Copy element dialog box

.. rubric:: Simple element

* Simple element (environment parameters, lists,…) can only be copied “as is”.

.. rubric:: Complex element

* Complex element (Tickets, Activities, …), it is possible to copy them into a new kind of elements.

* For instance, it is possible to copy a Ticket (the request) into an Activity (the task to manage the request). 

.. compound::

   * It is possible to select:

     * New kind of element.
     * Select new type (corresponding to the kind of element).
     * Change the name.
     * Select whether the initial element will be indicated as the origin of the copied one.
     * For main items, it is also possible to choose to copy links, attachments and notes.
     * For Projects and Activities, it is also possible to copy the hierarchic structure of activities (sub-projects, sub-activities). 

.. note:: 
  
   * The new item has the status “copied”.


.. raw:: latex

    \newpage

.. index:: ! Email (Send)
  
.. _email-detail:

Email detail
^^^^^^^^^^^^

Allows to send an informative email to defined recipients list.

.. figure:: /images/GUI/BOX_EmailDetail.png
   :alt: Email detail dialog box
   :align: center

   Email detail dialog box

.. rubric:: Recipients list

* The list is defined according to the role of the recipient. (See: :ref:`projeqtor-roles`)
* Flag on the role checkbox to define the recipients list.

 .. compound:: **Checkbox “other”**

    * Flag on the checkbox “other” to manually enter email addresses.

.. rubric:: Message

* The message that will be included in the body of the email, in addition to a  complete description of the item.

.. rubric:: Save as note

* Flag on to indicate the email message will be saved as a note.



.. raw:: latex

    \newpage

.. _multiple-update:

Multiple update
^^^^^^^^^^^^^^^

Allows to update several items in one operation.

* The fields that can be updated depends on the element.
* The fields are grouped by section.
* Click on |buttonQuitMultiMode| to quit the multiple mode window.

.. rubric:: Select items

* The selection of items can be done by selecting them in the list window. |one|
* Or use checkboxes to select/unselect all items in the list. |two|
* The count of items selected is displayed. |three|

.. figure:: /images/GUI/ZONE_MultipleModeList.png
   :alt: Multiple mode item selection
   :align: center

   Multiple mode item selection


.. figure:: /images/GUI/ZONE_MultipleMode.png
   :alt: Multiple mode
   :align: center

   Multiple mode window

.. rubric:: Apply updates

* Click on |buttonIconSave| to save updates on selection.
* Click on |buttonIconDelete| to delete all selected items.
* The update will be applied to all the items (if possible) and a report will be displayed on the right. |four|


.. index:: ! Checklist

.. _checklist:

Checklist
^^^^^^^^^

Allows to fill a checklist form.

A checklist is available, whether a checklist form is already defined for the element or the element type.


.. note::

   * The checklist forms are defined in :ref:`checklist-definition` screen.

.. note::

   * The access to view the checklist depends on your access rights.


.. rubric:: Displaying the checklist

* The user parameter «Display checklists» allows to define whether the checklist appears in a section or in a dialog box.
* If the value “On request” is set, the button |buttonIconShowChecklist| appears on the detail header window.
  
  * Click on |buttonIconShowChecklist| to display the checklist form.

* With other value the “Checklist” section appears in the detail window. 

.. figure:: /images/GUI/BOX_Checklist.png
   :alt: Checklist dialog box 
   :align: center

   Checklist dialog box 
 
.. figure:: /images/GUI/ZONE_Checklist.png
   :alt: Checklist section
   :align: center

   Checklist section

.. rubric:: How to use
 
* The user just has to check information corresponding to the situation.
* When done, the user name and checked date are recorded and displayed.
* Each line can get an extra comment, as well as globally on the checklist.


.. raw:: latex

    \newpage

.. index:: ! Change history

.. _change-history:

History of changes
^^^^^^^^^^^^^^^^^^

All the changes items are tracked.

They are stored and displayed on each item.

.. note::

   * On creation, just an insert operation is stored, not all the initial values on creation.

.. tabularcolumns:: |l|l|

.. list-table:: Fields of changes
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Operation
     - The operation on the item (insert or update).
   * - Data
     - The field modified.
   * - Value before
     - The value of the field before the update.
   * - Value after
     - The value of the field after the update.
   * - Date
     - Date of change operation.
   * - User
     - Name of the user who operated the change.


.. rubric:: Displaying the history of changes

* The user parameter «Display history» allows to define whether the history of changes appears in a section or in a dialog box.
* If the value “On request” is set, the button |buttonIconShowHistory| appears on the detail header window.
  
  * Click on |buttonIconShowHistory| to display the history of changes.

* If the value “Yes” is set, the “Change history” section appears in the detail window. 

.. figure:: /images/GUI/BOX_HistoryChange.png
   :alt: History of changes dialog box 
   :align: center

   History of changes dialog box 

.. figure:: /images/GUI/ZONE_HistoryChange.png
   :alt: Change history section 
   :align: center

   Change history section

.. rubric:: Show/Hide work

* This button allows to show or hide work changes done in “Real Work Allocation”.
* For section «Change history»  the display of work is defined in  user parameter «Display history».
 

.. raw:: latex

    \newpage

Special fields
^^^^^^^^^^^^^^

This section describes the ProjeQtOr special fields.


Accelerator buttons
"""""""""""""""""""

.. _moveToNextStatus-button:

.. rubric:: Move to next status button

* This button allows to skip to the next status without having to open the list.
* The next status is defined by the workflow linked to the type of element. 

.. figure:: /images/GUI/BUTTON_MoveToNextStatus.png
   :alt: Move to next status button
   :align: center

   Move to next status button

.. _assignToMe-button:

.. rubric:: Assign to me button

* This button allows to set the current user in the related field.

.. figure:: /images/GUI/BUTTON_AssignToMe.png
   :alt: Assign to me button
   :align: center

   Assign to me button

.. raw:: latex

    \newpage


.. _combo-list-fields:

Combo list field
"""""""""""""""""

* Combo list field allows to search, view or create item associated with the field.

.. note::

   * The access to view or create item depends on your access rights.
   * Some buttons can be not available.


.. figure:: /images/GUI/ZONE_ComboListFields.png
   :alt: Combo list field
   :align: center

   Combo list field


* Click on |comboArrowDown| to get the list of values.
* Click on |iconGoto| will directly go to the selected item.

  .. note ::

     * Click on |buttonIconBackNavigation| to return to the last screen. (More detail, see: :ref:`Top bar <navigation-buttons>`)

.. raw:: latex

    \newpage

* Click on |buttonIconSearch| to access item details.
* The next action depends on whether the field value is filled or not.


 .. compound:: **Field value is filled**

    * If the field value is filled, the details of item associated  are displayed.

    .. figure:: /images/GUI/BOX_DetailOfListElement.png
       :alt: Detail of list element dialog box
       :align: center

       Detail of list element dialog box

    * Click on |buttonIconSearch| to re-select an item.
    * Click on |buttonIconUndo| to close the dialog box.



 .. compound:: **Field value is empty**

    * If the field value is empty, the list of items is displayed, allowing to select an item.

    .. figure:: /images/GUI/BOX_DetailOfListElementList.png
       :alt: Detail of list element (list) dialog box
       :align: center

       Detail of list element (list) dialog box 

       * Click on |buttonIconSelect| to select items.
       * Click on |buttonIconNew| to create a new item.
       * Click on |buttonIconUndo| to close the window.

    .. note:: Window header

       * You have access to :ref:`Rapid filter<rapid-filter>`, :ref:`Quick search<quick-search>` and :ref:`Advanced filter<advanced-filter>`.

    .. note:: Select several items

       * Some elements is possible to select several items, use :kbd:`Control` or :kbd:`Shift`.
 
 
.. raw:: latex

    \newpage


Long text field
"""""""""""""""

* Long text fields allow to write description, results, notes, ...
* A mini editor is provided.
* Text zone is extendable.

.. figure:: /images/GUI/ZONE_LongTextFields.png
   :alt: Long text field
   :align: center

   Long text field



.. note:: User parameter “Editor mode always on”

   * This parameter defines that the editor is always activated on long text fields.



.. raw:: latex

    \newpage

.. _origin-field:

Origin field
""""""""""""

* This field allows to determine the element of origin.
* The origin is used to keep track of events (ex.: order from quote, action from meeting).
* The origin may be selected manually or automatically inserted during copying an element. 

.. figure:: /images/GUI/ZONE_OriginField.png
   :alt: Origin field
   :align: center

   Origin field



.. rubric:: Origin element

* Click on |buttonAdd| to add a orgin element.
* Click on |buttonIconDelete| to delete the link.

.. figure:: /images/GUI/BOX_AddAnOriginElement.png
   :alt: Add an origin element dialog box
   :align: center

   Add an origin element dialog box

.. tabularcolumns:: |l|l|

.. list-table:: Fields of add an origin element dialog box
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Type of the orign
     - Type of element to be selected.
   * - Origin element
     - item to select.


Set color field
"""""""""""""""

* This field allows to set the color of an item.
* Used to differentiate items in list or report.
* Click on list of colors to select.
* Click on “Reset” button to erase.

.. figure:: /images/GUI/ZONE_SetColor.png
   :alt: Set color field zone
   :align: center

   Set color field zone





.. raw:: latex

    \newpage

.. _info-bar:

Info bar
--------

.. figure:: /images/GUI/SCR_Infobar.png
   :alt: Info bar
   :align: center

   Info bar

.. figure:: /images/GUI/ZONE_Infobar.png
   :alt: Info bar zone
   :align: center

   Info bar zone

.. rubric:: 1 - Log out button

* Allows to disconnect the user.

 .. note:: User parameter “Confirm quit application”

    * This parameter defines whether a  disconnection confirmation will be displayed before.

.. rubric:: 2 - User parameters button

* Allows to access user parameters.

.. rubric:: 3 - Hide and show menu button

* Allows to hide or show the menu section.

 .. note:: User parameter “Hide menu”

    * This parameter defines whether the menu is hidden by default.

.. rubric:: 4 - Switched mode button

* Allows to enable or disable switched mode that allows to switch between list and detail windows.
* Window selected is displayed in "full screen" mode.
* Hidden window are replaced by a gray bar.
* Click on the gray bar to switch between windows. 

 .. note:: User parameter “Switched mode”

    * This parameter defines whether switching mode is enabled or not.

.. rubric:: 5 - Database name

* Display database name.

.. rubric:: 6 - Version button

* Displays the application version.
* Click on button to access to ProjeQtOr site.














 
 



.. raw:: latex

    \newpage

.. index:: ! Alert (Display)
.. index:: ! Indicator (Display)

Alerts
======

Users may receive some information displayed as pop-up on the bottom right corner of the screen.

Three kinds of information may be displayed:

* Information
* Warning
* Alert

.. figure:: /images/GUI/BOX_Alert.png
   :alt: Information pop-up
   :align: center

   Information pop-up

.. rubric:: Alert response

Two possible actions:

* Select to remind you in a given number of minutes (message will close and appear  again in the given number of minutes).
* Mark it as read to definitively hide it.   

.. note::

   * Possibility to mark the alert as read in :ref:`alerts` screen.

.. rubric:: Send alert

An alert can be sent by the administrator or indicator calculation.


 .. compound:: **By the administrator**

    * The administrator can send alert by administration console. (See: :ref:`admin-console`)

 .. compound:: **Indicator calculation**   

    * Indicator calculation sends only warning and alert message.

    * Alert coming from indicator calculation message contains more information:

     * Item id and type.  
     * Indicator description. 
     * Target value.
     * Alert or warning value.

    * The indicators are defined in :ref:`indicator` screen.    


.. rubric:: Alert icon

On indicatorable items, you may see a small icon on top left of the detail of the item.

Just move the mouse over the icon to display, which indicator has been raised.

.. figure:: /images/GUI/ZONE_Alert.png
   :alt: Alert icon
   :align: center

   Alert icon


.. raw:: latex

    \newpage

Themes
======

Users can select colors Theme to display the interface. 

The new theme is automatically applied when selected.

.. note:: User parameter “Theme”

   * This parameter defines the theme to display.


Multilingual
============

ProjeQtOr is multilingual.

Each user can choose the language to display all the captions.


.. note:: User parameter “Language”

   * This parameter defines the language used to display captions.


Keyboard functionality
======================

.. rubric:: Shortcut keys

* :kbd:`Control-s` to save the changes. 
* :kbd:`F1` to open the online user manual, to the page corresponding to the actual screen.

.. rubric:: Numeric keypad

* The point will be replaced by a comma if the numeric format requires it.


