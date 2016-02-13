.. include:: ImageReplacement.txt

.. index:: ! Expense

.. contents:: Expense
   :depth: 2
   :backlinks: top
   :local:


.. title:: Expense



.. index:: ! Expense (Individual)

.. _individual-expense:

Individual expense
------------------

An individual expense stores information about individual costs, such as travel costs or else.

Individual expense has detail listing for all items of expense.

This can for instance be used to detail all the expense on one month so that each user opens only one individual expense per month (per project), or detail all the elements of a travel expense.

.. rubric:: Planned amount

Planned amount will help to have an overview of project total costs, even before expense is realized.

.. sidebar:: Other sections

   * :ref:`expense-detail-lines`
   * :ref:`Linked element<linkElement-section>`
   * :ref:`Attachments<attachment-section>`
   * :ref:`Notes<note-section>`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the expense.
   * - **Name**
     - Short description of the expense.
   * - **Type**
     - Type of expense.
   * - **Resource**
     - Resource concerned by the expense.
   * - **Project**
     - The project concerned by the expense.
   * - :term:`Description`
     - Complete description of the expense.

**\* Required field**


.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - **Status**
     - Actual :term:`status` of the expense.
   * - Planned date
     - Planned date of the expense.
   * - Planned amount
     - Planned amount of the expense. 
   * - Real date
     - Real date of the expense.
   * - Real amount
     - Real amount of the expense. 
   * - :term:`Closed`
     - Flag to indicate that expense is archived.
   * - Cancelled
     - Flag to indicate that expense is cancelled.

**\* Required field**

.. topic:: Fields: Planned date and amount
  
   * When planned date or planned amount is set, other must also be set.

.. topic:: Fields: Real date and amount

   * When real date or real amount is set, other must also be set.

.. topic:: Field: Real amount 
 
   * If detail lines are entered, real amount is automatically calculated as sum of detail amounts, and is then locked.



.. raw:: latex

    \newpage


.. index:: ! Expense (Project)
.. index:: ! Project (Expense)

.. _project-expense:

Project expense
---------------

A project expense stores information about project costs that are not resource costs.

This can be used for all kinds of project cost : 

* Machines (rent or buy).
* Softwares.
* Office.
* Any logistic item.


.. rubric:: Planned amount

Planned amount will help to have an overview of project total costs, even before expense is realized.


.. sidebar:: Other sections

   * :ref:`expense-detail-lines`
   * :ref:`Linked element<linkElement-section>`
   * :ref:`Attachments<attachment-section>`
   * :ref:`Notes<note-section>`

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the expense.
   * - **Name**
     - Short description of the expense.
   * - **Type**
     - Type of expense.
   * - **Project**
     - The project concerned by the expense.
   * - :term:`Description`
     - Complete description of the expense.

**\* Required field**

.. raw:: latex

    \newpage

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - **Status**
     - Actual :term:`status` of the expense.
   * - Planned date
     - Planned date of the expense.
   * - Planned amount
     - Planned amount of the expense. 
   * - Real date
     - Real date of the expense.
   * - Real amount
     - Real amount of the expense. 
   * - :term:`Closed`
     - Flag to indicate that expense is archived.
   * - Cancelled
     - Flag to indicate that expense is cancelled.

**\* Required field**

.. topic:: Fields: Planned date and amount

   * When planned date or planned amount is set, other must also be set.

.. topic:: Fields: Real date and amount 

   * When real date or real amount is set, other must also be set.


.. raw:: latex

    \newpage

.. index::  ! Expense (Detail line)

.. _expense-detail-lines:

Expense detail lines
--------------------

.. rubric:: Section: Expense detail lines

This section is common to individual and project expenses.

It allows to enter detail on expense line.

.. topic:: Fields: Real amount and date

   * When a line is entered, expense real amount is automatically updated to sum of lines amount.
   * Real date is set with the date in the firts detail line.


.. tabularcolumns:: |l|l|

.. list-table::
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Date
     - Date of the detail line.
   * - Name
     - Name of the detail line.
   * - Type
     - Type of expense.
   * - Detail
     - Detail depends on the type of expense.
   * - Amount
     - Amount of the detail line.


.. rubric:: Detail lines management
 
* Click on |buttonAdd| to add a detail line.
* Click on |buttonEdit| to modify an existing detail line.
* Click on |buttonIconDelete| to delete the detail line.


.. figure:: /images/GUI/BOX_ExpenseDetail.png
   :alt: Expense detail dialog box
   :align: center

   Expense detail dialog box


.. list-table:: Fields of expense detail dialog box 
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Name
     - Name of the detail.
   * - Date
     - Date of the detail.
   * - Type
     - Type of expense.
   * - Amount
     - Amount of the detail.


.. topic:: Field: Date

   * This allows to input several items, during several days, for the same expense, to have for instance one expense per travel or per month.

.. topic:: Field: Type

   * Depending on type, new fields will appear to help calculate of amount.
   * Available types depending on whether individual or project expense.
   * See: :ref:`expense-detail-type`. 

.. topic:: Field: Amount 

   * Automatically calculated from fields depending on type.
   * May also be input for type “justified expense”.

