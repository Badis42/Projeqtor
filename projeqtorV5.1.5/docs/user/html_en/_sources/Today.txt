.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage


.. contents::
   :depth: 2
   :backlinks: top

.. title:: Today


.. index:: ! Today

Today
-----

This screen allows user to have a global view of its projects and tasks.

.. note::
  
   * This screen is the first to be displayed on each connection.
   * You can define other screen will be displayed in :ref:`Users parameters<graphic-interface-behavior-section>` screen. 

.. index:: ! Message (Section)

.. _messages-section:

Section: Messages
^^^^^^^^^^^^^^^^^

.. figure:: /images/GUI/SEC_TodayMessages.png
   :alt: Today messages section
   :align: center

   Messages section

.. rubric:: Messages

* Messages are displayed depends on affected project or user profile. 
* Every message is component by title |one| and message |two|.
* Messages are defined in :ref:`message` screen.

.. rubric:: Print

* Click on |iconPrint| to print Today screen. 


.. raw:: latex

    \newpage

.. rubric:: Parameters

* Click on |buttonIconParameter| to access screen parameters.

.. figure:: /images/GUI/BOX_TodayParameters.png
   :alt: Today parameters dialog box
   :align: center

   Today parameters dialog box

.. compound:: **Period for task selection**

   * Allows to define the period for tasks will be displayed.

    .. compound:: **Field: Due date**

       * Select only items with due date less than today plus this selected period.

    .. compound:: **Field: Or not set**
 
       * Select also items with due date not set. 


.. compound:: **Items to be displayed**

   * Allows to define sections displayed on the screen.

   .. note::

      * Allows to reorder sections displayed with drag & drop feature.
      * Using the selector area button icon drag |buttonIconDrag|. 





.. raw:: latex

    \newpage


.. index:: ! Start guide


Section: Start guide
^^^^^^^^^^^^^^^^^^^^

* Start page for new installations to assist the administrator in the first configuration steps.
* A progress display |one| allows to determine the percent of complete installation.
* You can hide this section on startup, just unchecked |two|.

  * This section will not be displayed anymore.
  * To show it again, select it as the start page in :ref:`Users parameters<graphic-interface-behavior-section>` screen. 

.. figure:: /images/GUI/SEC_TodayStartGuide.png
   :alt: Today start guide section
   :align: center

   Start guide section





.. raw:: latex

    \newpage

Section: Projects
^^^^^^^^^^^^^^^^^

A quick overview of projects status.

The projects list is limited to the project visibility scope of the connected user. 

.. figure:: /images/GUI/SEC_TodayProjects.png
   :alt: Today projects section
   :align: center

   Projects section



.. rubric:: Scope of the numbers counted

* Checkboxes allow to filter displayed projects: |one|

  * To do: Projects to do.
  * Not closed : Projects to do and done.
  * All : Projects to do, done and closed.

.. rubric:: Projects name

* Click on the name of a project will directly move to it. 

.. rubric:: Manuel indicators

* Manuel indicator can be set on project.
* Trend and health status indicators are displayed.

 .. compound:: **Icon: Trend** |two|

    * This icon allows to display the trend of the project.

 .. compound:: **Icon: Health status** |three|

    * This icon allows to display the health status of the project.  

.. raw:: latex

    \newpage   

.. rubric:: Progress

* Calculated progress and overall progress are displayed.

 .. compound:: **Calculated progress** |four|

    * Actual progress of the work of project.

    .. note:: On mouse over the bar

       * On each project shows part of “to do” (red) compared to “done and closed” (green).

 .. compound:: **Overall progress** |five|

    * Additional progress manually selected for the project.

.. rubric:: Project metrics

* Some metrics are displayed on each project. |six|

.. tabularcolumns:: |l|l|

.. list-table:: Fields of project metrics
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Left
     - Left work for the project.
   * - Margin
     - Work margin.
   * - End date
     - Planified end date of the project.
   * - Late
     - Number of late days in project.

.. rubric:: Numbers of elements concerned to project

* Numbers of elements concerned to a project are displayed. |seven|

.. note:: On mouse over the bar

   * On each element shows part of “to do” (red) compared to “done and closed” (green).


.. raw:: latex

    \newpage

Sections: Tasks
^^^^^^^^^^^^^^^

Here are listed, as a “To do list” all the items for which the connected user is either “assigned to”, “:term:`responsible` of” or “:term:`issuer` or :term:`requestor` of”.

Click on an item will directly move to it.

.. note:: Parameter: Max items to display

   * Number of items listed here are limited to a value defined  in :ref:`Global parameters<global-display-section>`.



.. tabularcolumns:: |l|l|

.. list-table:: 
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`id`
     - Unique Id for the item.
   * - Project
     - The project concerned by the item.
   * - Type
     - Type of item.
   * - Name
     - Name of the item.
   * - Due date
     - Planned end date or due date.
   * - Status
     - Actual status of the item.
   * - Issuer
     - Flag on indicate the user is the issuer for the item.
   * - Resp.
     - Flag on indicate the user is the responsible for the item.

.. topic:: Column: Id

   * Id column displayed unique Id and specific icon for the item. 


.. raw:: latex

    \newpage    

Extending section
^^^^^^^^^^^^^^^^^

You can select any report to be displayed on the Today screen.

.. rubric:: Add selected report

* To do this, just go to the selected report, select parameters and display result (to check it is what you wish on today screen). 
* Click on |buttonIconToday| to insert this report with parameter on the Today screen.
* Any unchanged parameter will be set as default value.
* These reports will be displayed on Today screen like other pre-defined parts.

.. figure:: /images/GUI/SEC_TodayExtending.png
   :alt: Report selection
   :align: center

   Report selection    

.. rubric:: Manage extending section

* Click on |buttonIconParameter| to access screen parameters.
* You can reorder like any other parts.
* Click on |buttonIconDelete| to completely remove them from the list.

.. figure:: /images/GUI/BOX_TodayParametersWithExtending.png
   :alt: Today parameters with extending parts dialog box 
   :align: center

   Parameters with extending parts dialog box  

 


 



