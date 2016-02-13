.. include:: ImageReplacement.txt

.. raw:: latex

    \newpage


.. contents:: Planning elements
   :depth: 2
   :backlinks: top
   :local:


.. title:: Planning elements


Planning elements are : :ref:`project`, :ref:`activity`, :ref:`pe-milestone-label`, :ref:`Test session <test-session>`, :ref:`meeting` and :ref:`periodic-meeting`.

All previous elements can be planning, following with Gantt chart.

.. topic:: Progress

   * All planning elements have own progress data.
   * Some metrics are consolidate on top activities and project.  

.. raw:: latex

    \newpage

.. index:: ! Project 

.. _project:

Project
-------

.. sidebar:: Other sections

   * :ref:`pe-progress-section-label`
   * :ref:`Affectations<affectations-section>`
   * :ref:`pe-predSuces-element-section-label`
   * :ref:`Linked element<linkElement-section>`   
   * :ref:`Attachments<attachment-section>`   
   * :ref:`Notes<note-section>`   

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table:: Project description section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the project.
   * - **Name**
     - Short name of the project.
   * - **Type**
     - Type of project.
   * - Customer
     - The customer of the project.
   * - Bill contact
     - Billing contact.
   * - Project code
     - Code of the project.
   * - Contract code
     - Code of the contract of the project.
   * - Customer code
     - Code of the customer of the project.
   * - Is sub-project of
     - Name of the top project if this project is a sub-project. 
   * - Sponsor
     - Name of the sponsor of the project.
   * - :term:`Manager<Project manager>`
     - Name of the resource who manages the project.
   * - Color
     - Color of the project, to be displayed in some reports.
   * - **Status**
     - Actual :term:`status` of the project.
   * - Health status
     - Global health status of the project, displayed on today screen.
   * - Quality level
     - Estimation of quality level of project (result of audits).
   * - Trend
     - Trend of global project health.
   * - Overall progress
     - Overall progress to be selected in a defined list.
   * - Fix planning
     - Selector to fix the planning of the project, and its sub-projects.
   * - :term:`Done`
     - Flag to indicate that project is been finished.
   * - :term:`Closed`
     - Flag to indicate that project is archived.
   * - Cancelled
     - Flag to indicate that project is cancelled.
   * - :term:`Description`
     - Complete description of the project.
   * - Objectives
     - Objectives of the project.

**\* Required field**


.. rubric:: Section: Version linked to this project

.. rubric:: Section: Sub projects




.. raw:: latex

    \newpage

.. index:: ! Activity 

.. _activity:

Activity
--------

An activity is a kind of task that must be planned, or that regroups other activities.

It is generally a long time activity, that will be assigned to one or more resources.

Activities will appear on Gantt planning view.

For instance, you can manage as activities : 

* Planned tasks.
* Change requests.
* Phases.
* Versions or releases.

.. rubric:: Activities regroupment

*  Activities can have parents to regroup activities.
 
* So a WBS (work breakdown structure number) is calculated for the activities.

* Activities can be sorted inside their parent activity, on the Gantt planning view, using drag and drop.

* Parent activity must belong to the same project.

.. rubric:: Assigned ressources

* Resources are can be assigned to activities.

* This means that some work is planned on this activity for the resources.

* See : :ref:`pe-assignment-section-label`

.. sidebar:: Other sections

   * :ref:`pe-assignment-section-label`
   * :ref:`pe-progress-section-label`
   * :ref:`pe-predSuces-element-section-label`
   * :ref:`Linked element<linkElement-section>`   
   * :ref:`Attachments<attachment-section>`   
   * :ref:`Notes<note-section>`   

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table:: Activity description section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the activity.
   * - **Name**
     - Short description of the activity.
   * - **Activity type**
     - Type of activity.
   * - **Project**
     - The project concerned by the activity.
   * - :term:`External reference`
     - External reference of the activity.
   * - :term:`Requestor`
     - Contact at the origin of the activity.
   * - :term:`Origin`
     - Element which is the origin of the activity.
   * - :term:`Description`
     - Complete description of the activity.

**\* Required field**

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table:: Activity treatment section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Parent activity
     - Parent activity for grouping purpose. 
   * - **Status**
     - Actual :term:`status` of the activity.
   * - :term:`Responsible`
     - Resource who is responsible for the activity.
   * - :term:`Handled`
     - Flag to indicate that activity is taken into account.
   * - :term:`Done`
     - Flag to indicate that activity has been treated.
   * - :term:`Closed`
     - Flag to indicate that activity is archived.
   * - Cancelled
     - Flag to indicate that activity is cancelled.
   * - Target version
     - The target version of the product that will deliver the object of the activity.	
   * - :term:`Result`
     - Complete description of the treatment done on the activity. 
 
**\* Required field**

.. raw:: latex

    \newpage

.. index:: ! Milestone

.. _pe-milestone-label:

Milestone
---------

A Milestone is a flag in the planning, to point out key dates.

Milestones are commonly used tom check delivery dates. 

They can also by used to highlight transition from one phase to the following one.

Opposite to Activities, Milestones have no duration and no work.

.. topic:: Floating milestone

   * This milestone will automatically move to take into account dependencies.

.. topic:: Fixed milestone

   * This milestone is fixed in the planning, not taking into account predecessor dependencies.
   * This kind of milestone is interesting for instance to set-up start date for some tasks.

.. sidebar:: Other sections

   * :ref:`pe-predSuces-element-section-label`
   * :ref:`Linked element<linkElement-section>`   
   * :ref:`Attachments<attachment-section>`   
   * :ref:`Notes<note-section>`   

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table:: Milestone description section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the milestone.
   * - **Name**
     - Short description of the milestone.
   * - **Milestone type**
     - Type of milestone.
   * - **Project**
     - The project concerned by the milestone.
   * - :term:`Origin`
     - Element which is the origin of the milestone.
   * - :term:`Description`
     - Long description of the milestone.

**\* Required field**


.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table:: Milestone treatment section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Parent activity
     - Parent activity for grouping purpose. 
   * - **Status**
     - Actual :term:`status` of the milestone.
   * - :term:`Responsible`
     - Resource who is responsible for the milestone.
   * - :term:`Handled`
     - Flag to indicate that milestone is taken into account.
   * - :term:`Done`
     - Flag to indicate that milestone has been treated.
   * - :term:`Closed`
     - Flag to indicate that milestone is archived.
   * - Cancelled
     - Flag to indicate that milestone is cancelled.
   * - Target version
     - The target version of the product that will deliver the object of the milestone.	
   * - :term:`Result`
     - Complete description of the treatment done on the milestone. 
 
**\* Required field**


.. rubric:: Section: Progress

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Validated due date
     - Committed end date : milestone should not end later. 
   * - Planned due date
     - Calculated end date, taking into account all the constraints.
   * - Real due date
     - Real end date, when milestone is set to “done”.
   * - Requested due date
     - Wished end date.

.. topic:: Field: :term:`WBS`

   * Hierarchical position of the milestone in the global planning.

.. topic:: List of value: Planning mode

   * Planning mode for the milestone (floating or fixed).

.. raw:: latex

    \newpage

Common sections
----------------




.. raw:: latex

    \newpage

.. _pe-assignment-section-label:

Assignment
""""""""""

Resources can be assigned to activities.

It is possible to assign several times the same resource to an activity.

It can for instance be used to add extra work without modifying initial assignment. 

.. topic:: Go to
 
   * Click on the resource name will directly move to the resource.

.. rubric:: Project affectaion

* Only resources affected to the project of the activity can be assigned.
* Affectations may have start and end dates.
* So, for a given assignment planned work will not start before affectation start date on project of the activity and will stop on affectation end date. 
* This can lead to incompletely planned tasks. These would appear as brown bars in the Gantt view.

.. rubric:: Assignment Popup

Click on |buttonAdd| to assign a new resource. An "Assignment" pop up will be displayed.

Click on |buttonEdit| to modify the assignment.

Click on |buttonIconDelete| to delete the assignment.

.. note::

   * If real work exists for an assignment, it can not be deleted.

.. figure:: /images/GUI/BOX_Assignment.png
   :alt: Assignment dialog box
   :align: center

   Assignment dialog box

.. tabularcolumns:: |l|l|

.. list-table:: Assignment dialog box fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Resource
     - Name of the resource assigned to the activity.
   * - Function
     - The function of the resource on this assignment.
   * - Cost
     - The daily cost of the assignment.
   * - Rate
     - The max rate (in %) to plan the resource on the activity by day.
   * - Assigned work
     - Work initially planned to complete the task.
   * - Real work
     - Real work entered by the resource on his weekly report, on the “real work allocation” screen.
   * - Left work
     - Work left to complete the task.
   * - Planned work
     - The new total work planned to complete the task.
   * - Comments
     - Any comment on the affectation.

.. topic:: Fields: Function and Cost
 
   * Function determine the daily cost of the assignment.
   * Cost is automatically updated from the function of the resource.

.. topic:: Field: Rate

   * For instance, if rate is 50%, the resource will not be planned more than half days on the activity.

.. topic:: Field: Left work

   * Calculated as “Assigned Work” – “Real Work”.
   * Must be updated by the resource on the “real work allocation” screen to reflect the really estimated work needed to complete the task.

.. topic:: Field: Planned work

   * “planned work” = “real work” + “left work”

.. topic:: Field: Comments

   * When a comment exists, the |Note| icon will appear on the  Assignment section, and on the description of the activity on the “real work allocation” screen.
   * Moving the mouse over the description will display the comment. 

.. raw:: latex

    \newpage

.. _pe-progress-section-label:

Progress
""""""""

The progress allows to follow up planning element.

This section cover progress to planning element : project, activity and test session.

.. topic:: Reassessed metrics

   * Reassessed is the sum of real and left metrics.

.. topic:: Expense reassessed metrics

   * Assigned minus real metrics.

.. topic:: Consolidating metrics
  
   * fdfdf

.. topic:: Real metrics

   * Real metrics input entered by an resource on the “Real work allocation” screen.

.. rubric:: Duration metrics

*  Allow to determine planning elements duration for project, activity and test session.

.. topic:: Calculating duration

   * Duration is the **work days** numbers between end and start dates.

.. topic:: End date

   * If not set, end date is the start date + duration.

.. tabularcolumns:: |l|l|

.. list-table:: Duration metrics fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Validated start date
     - Planning element should not start later.
   * - Validated end date
     - Planning element should not end later.
   * - Validated duration
     - Planning element should not last longer.
   * - Planned start date
     - Calculated start date, taking into account all the constraints.
   * - Planned end date
     - Calculated end date, taking into account all the constraints.
   * - Planned duration
     - Calculated duration.
   * - Real start date
     - Date of the first real work input.
   * - Real end date
     - Date of the last real work input.
   * - Real duration
     - Calculated duration.
   * - Requested start date
     - Wished start date.
   * - Requested end date
     - Wished end date.
   * - Requested duration
     - Wished duration.

.. topic:: Field: Real end date

   * The real end date appearing only when planning element status is "done".

.. rubric:: Work metrics

* Planning elements work is the sum of tasks like activity, test session and meeting.

.. tabularcolumns:: |l|l|

.. list-table:: Work metrics fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Validated work
     - Work of the planning element should not be more.
   * - Assigned work
     - Sum of all the work for the assignments on the planning element.
   * - Real work
     - Sum of all the work really spent on the planning element. 
   * - Left work
     - Left work to complete. 
   * - Reassessed work
     - Work needed to complete.
   * - Progress
     - Actual progress of the work, in percent real under planned.
   * - Expected
     - Expected progress of work, in percent real under validated.
   * - Margin
     - Margin between validated and planned work.

.. topic:: Field: Margin

   * Metrics available only in project progress section.


.. rubric:: Cost metrics

.. topic:: Planning elements cost

   * Planning elements cost is the sum of tasks like activity, test session and meeting.

.. topic:: Expense cost

   * Expense cost is the sum of individual and project expense.
   * Metrics available only in project progress section.

.. tabularcolumns:: |l|l|

.. list-table:: Cost metrics fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Validated cost
     - Cost of the planning element should not be more.
   * - Assigned cost
     - Sum of all the cost for the assignments on the planning element.
   * - Real cost
     - Sum of all the cost really spent on the planning. 
   * - Left cost
     - Left cost to complete. 
   * - Reassessed cost
     - Cost needed to complete.
   * - Validated expense
     - Expense of the project should not be more.
   * - Assigned expense
     - Sum of all the expense on project for the planned amount.
   * - Real expense
     - Sum of all the expense on project for the real amount. 
   * - Left expense
     - Alaways zero for expense. 
   * - Reassessed expense
     - Sum of all the expense on project for reassessed amount.
   * - Margin
     - Margin between total validated and total planned cost.


.. topic:: Field: Margin

   * Metrics available only in project progress section.

.. topic:: Total cost

   * Sum of planning elements and expense cost.
   * Metrics available only in project progress section.

.. rubric:: Ticket metrics

* Allows to display global work for tickets linked with the activity. 
* Metrics available only in activity progress section. 

.. tabularcolumns:: |l|l|

.. list-table:: Ticket metrics fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Number
     - Numbers of ticket linked with the activity.
   * - Estimated
     - Sum of all planned work of ticket linked with the activity.
   * - Real
     - Sum of all real work of ticket linked with the activity. 
   * - Left
     - Sum of all left work of ticket linked with the activity. 
 
.. rubric:: Others metrics

.. topic:: Field: :term:`WBS`

   * Hierarchical position of the planning element in the global planning.

.. topic:: Field: Priority

   * :term:`Planning priority` of the planning element.

.. topic:: List of values: Planning

   * ddfd
 
.. raw:: latex

    \newpage

.. _pe-predSuces-element-section-label:

Predecessor and Sucessor element
""""""""""""""""""""""""""""""""

Planning element can have predecessors and successors, to generate dependencies. 


Click |buttonAdd| on the corresponding section to add a predecessor or successor. An “add predecessor” or “add successor” pop up will be displayed. 

Select the type of element to add as predecessor or successor.

* The list of items below will then be automatically updated. 

Click on |buttonEdit| to edit the dependency.

Click on |buttonIconDelete| to delete the corresponding dependency.

.. figure:: /images/GUI/BOX_PredecessorSuccessorElement.png
   :alt: Predecessor or Successor element dialog box
   :align: center

   Predecessor or Successor element dialog box



.. note:: 

   * Recursive loops are controlled on saving.
   * Predecessors and successors must belong to the same project or be a project.

.. topic:: Linked element

   * Click on |buttonIconSearch| to show element detail.
   * Depends on whether the element is selected or not a pop up is displayed.
   * Detail about pop up, see :ref:`Combo list fields<combo-list-fields>`

.. topic:: Multi-value selection

   * Multi-line selection is possible using :kbd:`Control` key while clicking.

.. topic:: Delay (late)

   * Days between predecessor end and successor start.

.. topic:: Reciprocally interrelated

   * If element A is a predecessor of element B, element B is automatically successor of element A. 

.. rubric:: Dependency information

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Element
     - Type and id of the predecessor or successor.
   * - Name
     - Name of the dependency.
   * - Date
     - Date of creation of the dependency.
   * - User
     - User who created the dependency.
   * - Status
     - Actual status of the dependency.

.. topic:: Go to
 
   * Click on the name of a predecessor or successor will directly move to it.





