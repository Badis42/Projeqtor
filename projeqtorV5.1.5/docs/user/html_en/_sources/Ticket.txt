.. include:: ImageReplacement.txt


.. contents::
   :depth: 1
   :backlinks: top

.. title:: Tickets

.. index:: ! Ticket 

.. _ticket:

Tickets
-------

A ticket is a kind of task that can not be unitarily planned. 

It is generally a short time activity for a single ticket, that is interesting to follow unitarily to give a feedback to the issuer or to keep trace of result. 

It can be globally planned as a general activity, but not unitarily.

For instance, bugs should be managed through tickets : 

* You can not plan bugs before they are registered.
* You must be able to give a feedback on each bug.
* You can (or at least should) globally plan bug fixing activity. 

.. rubric:: Planning activity

* Planning activity field allows to link the ticket with a planning activity.
* Work on the ticket will be included in this activity.

 .. compound:: **Put the real work from tickets to the resource timesheet**

    * When a resource has entered the real work on the ticket and the ticket is linked to a planning activity.
    * The resource is automatically assigned to this activity.
    * Real work set on tickets is automatically set in resource timesheet.

.. rubric:: Restrict the entry of real work in the ticket.

* Possibility to define that only the responsible of ticket can enter real work.
* This behavior can be set in  :ref:`Global parameters<responsible-section>` screen.

-----------

.. rubric:: Due dates

* Initial and planned due date allows to define a target date for solving the ticket.

 .. compound:: **Initial due date**

    * If a definition of ticket delay exists for giving ticket type and urgency the date is automatically calculated with this delay.
    * Else date is initialized to current day.
    * :ref:`delay-for-ticket` screen allows to define ticket delay.

 .. compound:: **Planned due date**

    * Is used to define a target date after evaluation.
    * Automatically initialized to the initial due date.

 .. compound:: **Indicators**

    * Possibility to define indicators to follow the respect of dates values.
    * See: :ref:`indicator` screen.

-----------

.. rubric:: Version of product

* Is used to determine **original version** where the ticket has been identified and **target version** that will deliver the object of the ticket.
* Only versions of product linked with the project are available. 

.. topic:: Multi-version selection

   * Allows to select multi-version of orginal and target version.
   * Is used to specify versions of product referenced to this ticket. 
   * See: :ref:`multi-version-selection`.
  

.. raw:: latex

    \newpage

.. sidebar:: Other sections

   * :ref:`Linked element<linkElement-section>`
   * :ref:`Attachments<attachment-section>`
   * :ref:`Notes<note-section>`
   

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table:: Tickets description section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the ticket.
   * - **Name**
     - Short description of the ticket.
   * - **Ticket type**
     - Type of ticket.
   * - **Project**
     - The project concerned by the ticket.
   * - :term:`External reference`
     - External reference of the ticket.
   * - Urgency
     - Urgency for treatment of the ticket, as requested by the issuer.
   * - :term:`Requestor`
     - Contact at the origin of the ticket.
   * - :term:`Origin`
     - Element which is the origin of the ticket.
   * - Duplicate ticket
     - Link to another ticket, to link duplicate tickets.
   * - Context
     - List of 3 items describing the context of the ticket.
   * - Product
     - The product where ticket has been identified.
   * - Original version
     - Version of product where ticket has been identified. 
   * - :term:`Description`
     - Complete description of the ticket.

**\* Required field**

.. topic :: Field: Context

   * Contexts are initialized for IT Projects as “Environment”, “OS” and “Browser”. 
   * This can be easily changed values in :ref:`context` screen.  

.. topic:: Field: Original version

   * Click on |buttonAdd| to add a other version, see :ref:`multi-version-selection`.


.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table:: Tickets treatment section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Planning activity
     - Activity where global work for this kind of ticket is planned. 
   * - **Status**
     - Actual :term:`status` of the ticket.
   * - :term:`Responsible`
     - Resource who is responsible for the ticket.
   * - Criticality
     - Importance of impact on the system, as determined after analysis.
   * - Priority
     - Priority of treatment.
   * - Initial due date
     - Initial target date for solving the ticket.
   * - Planned due date
     - Actual target date for solving the ticket.
   * - Estimated work
     - Estimated workload needed to treat the ticket.
   * - Real work
     - Real workload spent to treat the ticket.
   * - Left work
     - Left workload needed to finish the ticket.
   * - :term:`Handled`
     - Flag to indicate that ticket is taken into account.
   * - :term:`Done`
     - Flag to indicate that ticket has been treated.
   * - :term:`Closed`
     - Flag to indicate that ticket is archived.
   * - Cancelled
     - Flag to indicate that ticket is cancelled.
   * - Target version
     - The target version of the product that will deliver the object of the ticket.
   * - :term:`Result`
     - Complete description of the resolution of the ticket. 
 
**\* Required field**


.. topic:: Field: Priority

   * Automatically calculated from Urgency and Criticality values. See: :ref:`priority-calculation`.
   * Can be changed manually.

.. topic:: Field: Left work

   * Automatically calculated as Estimated – Real.
   * Set to zero when ticket is done.

.. topic:: Field: Target version

   * Click on |buttonAdd| to add a other version, see :ref:`multi-version-selection`.



.. raw:: latex

    \newpage

.. rubric:: Button: Start/End work

* This button is clock on/off timer.
* If connected user is a resource, he has the possibility to start working on the ticket.
* When work is finished, he will just have to stop the timer.

.. note::

   * Closing the application or starting work on another ticket will automatically stop the current ongoing work.

* The spend time will automatically be converted as real work, and transferred on planning activity if it is set (decreasing left work on the activity). 

.. rubric:: Button: Dispatch

This button allows to dispatch ticket.

.. figure:: /images/GUI/BOX_DispatchWork.png
   :alt: Dispatch work dialog box
   :align: center

   Dispatch work dialog box


* Click on |buttonAdd| to add a line. 

.. tabularcolumns:: |l|l|

.. list-table:: Dispatch work dialog box fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Date
     - Dispatch date.
   * - Resources
     - Work dispatch to a resource.
   * - Work
     - Planned work to this resource. 



.. raw:: latex

    \newpage

.. _priority-calculation:

Priority value calculation
""""""""""""""""""""""""""

Priority value is automatically calculated from **Urgency** and **Criticality** values.

Priority, Urgency and Criticality values  are defined in lists of values screens. See: :ref:`priority`, :ref:`urgency` and :ref:`criticality` screens.

In the previous screens, a name of value is set with numeric value.  

Priority numeric value is determined by a simple equation as follows:

.. topic:: Equation

   * [Priority value] = [Urgency value] X [Criticality value] / 2
   * For example:

     * Critical priority (8) = Blocking (4) X Critical (8) / 2

.. rubric:: Default values

* Default values are determined.
* You can change its values while respecting the equation defined above. 




.. raw:: latex

    \newpage


.. index:: ! Ticket (Simple) 

.. _simple-ticket:

	
Tickets (simple)
----------------

Simple ticket is just a restricted view of Ticket, with limited write access to “Description” section, and limited view on “treatment” section.

This view is dedicated to provide access to Ticket to users who should not be able to change treatment of Tickets, such an External Team members, but can possibly create new ones. 

.. sidebar:: Other sections

   * :ref:`Attachments<attachment-section>`
   * :ref:`Notes<note-section>`
   

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table:: Simple ticket description section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the ticket.
   * - **Name**
     - Short description of the ticket.
   * - **Project**
     - The project concerned by the ticket.
   * - Urgency
     - Urgency for treatment of the ticket, as requested by the issuer.
   * - Context
     - List of 3 items describing the context of the ticket.
   * - Version
     - Version of product where ticket has been identified.
   * - :term:`Description`
     - Complete description of the ticket.

**\* Required field**

.. topic :: Field: Context

   * Contexts are initialized for IT Projects as “Environment”, “OS” and “Browser”. 
   * This can be easily changed values in :ref:`context` screen.  

.. topic:: Field: Version

   * Click on |buttonAdd| to add a other version, see :ref:`multi-version-selection`.



.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table:: Simple ticket treatment section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - **Status**
     - Actual :term:`status` of the ticket.
   * - :term:`Responsible`
     - Resource who is responsible for the ticket.
   * - Due date
     - Actual target date for solving the ticket.
   * - :term:`Handled`
     - Flag to indicate that ticket is taken into account.
   * - :term:`Done`
     - Flag to indicate that ticket has been treated.
   * - :term:`Closed`
     - Flag to indicate that ticket is archived.
   * - Cancelled
     - Flag to indicate that ticket is cancelled.
   * - Target version
     - The target version of the product that will deliver the object of the ticket.	
   * - :term:`Result`
     - Complete description of the resolution of the ticket. 
 
**\* Required field**

.. note::

   * Except for status, all these fields are “readonly” and can only be updated through the Ticket view.



.. _multi-version-selection:

Multi-version selection
-----------------------

For version fields, it possible to set multi version of product.

.. topic:: Main and other version

   * The version with smaller id will appear in the select list and is considered as the main version.
   * Other versions are listed above. 
   * It is possible to set an ‘other’ version as the main version using the button |iconSwitch|.


* Click on |buttonAdd| to add a other version. 
* Click on |buttonIconDelete| to delete a version.

.. figure:: /images/GUI/BOX_AddOtherVersion.png
   :alt: Add other version dialog box
   :align: center

   Add other version dialog box









