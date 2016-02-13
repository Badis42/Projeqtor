.. include:: ImageReplacement.txt

.. contents::
   :depth: 1
   :backlinks: top


.. title:: Requirements and Tests

.. index:: ! Requirement

.. _requirement:

Requirements
------------

Requirement is a rule that must be defined to a product or a project. It can be applied to both.

In most IT projects, requirement can be a functional rule for a software.

It allows to define and monitor cost and delays.

It can be linked to test cases, it's used to describe how you will test that a given requirement.

.. rubric:: Target version

* A given version of the product can be defined, meaning the rule is valid at this version.

.. rubric:: Rights management

* Linking requirements to a project will limit the visibility, respecting rights management at project level.

.. rubric:: Requirement link to test cases

* Test cases can be linked to a requirement in **linked element section**.
* Linking a requirement to a test case will display a summary of test case run (defined in test session).
* This way, you will have an instant display of test coverage for the requirement.

.. rubric:: Requirement link to tickets

* When test case run status is set to **failed**, the reference to a ticket must be defined (reference to the incident).
* When the requirement is linked to a test case with this run status, ticket is automatically linked to the requirement. 

.. rubric:: Initial and planned due dates

* Possibility to define indicators to follow the respect of dates values.
* See: :ref:`indicator` screen. 

.. rubric:: Predecessor and successor elements

* Requirements can have predecessors and successors.
* This defines some dependencies on the requirements.
* The dependencies don’t have specific effects. It is just an information.


.. raw:: latex

    \newpage

.. sidebar:: Other sections

   * :ref:`pe-predSuces-element-section-label`
   * :ref:`Summary of test cases <summary-test-case-section>`
   * :ref:`Linked element<linkElement-section>`   
   * :ref:`Attachments<attachment-section>`   
   * :ref:`Notes<note-section>`   

.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table:: Description section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the requirement.
   * - **Name**
     - Short description of the requirement.
   * - **Requirement type**
     - Type of requirement.
   * - Project
     - The project concerned by the requirement.
   * - Product
     - The product concerned by the requirement.
   * - :term:`External reference`
     - External reference for the requirement.
   * - :term:`Requestor`
     - Contact who requested the requirement.
   * - :term:`Origin`
     - Element which is the origin of the requirement.
   * - Urgency
     - Urgency of implementation of the requirement.
   * - Initial due date
     - Initial due date.
   * - Planned due date
     - Planned due date.
   * - :term:`Description`
     - Long description of the requirement.

**\* Required field**

.. topic:: Fields: Project and Product

   * Project or product must be set. 
   * You can set both.

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table:: Treatment section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Top requirement
     - Parent requirement, defining a hierarchic structure.
   * - **Status**
     - Actual :term:`status` of the requirement.
   * - :term:`Responsible`
     - Resource who is responsible for the requirement.
   * - Criticality
     - Level of criticality of the requirement for the product.
   * - Feasibility
     - Result of first analysis to check the feasibility of the implementation of the requirement.
   * - Technical risk
     - Result of first analysis to measure the technical risk of the implementation of the requirement.
   * - Estimated effort
     - Result of first analysis to measure the estimated effort of the implementation of the requirement.
   * - :term:`Handled`
     - Flag to indicate that requirement is taken into account.
   * - :term:`Done`
     - Flag to indicate that requirement has been treated.
   * - :term:`Closed`
     - Flag to indicate that requirement is archived.
   * - Cancelled
     - Flag to indicate that requirement is cancelled.
   * - Target version
     - Version of the product where the requirement will be active.	
   * - :term:`Result`
     - Description of the implementation of the requirement. 
 
**\* Required field**

.. rubric:: Section: Lock

A requirement can be locked to ensure that its definition has not changed during the implementation process.

   **Button: Lock/Unlock requirement**

   * Button to lock or unlock the requirement to preserve it from being changed.
   * Only the user who locked the requirement or a habilitated user can unlock a requirement.

   **Requirement locked**

   * When a requirement is locked the following fields are displayed.


.. tabularcolumns:: |l|l|

.. list-table:: Fields when the requirement is locked
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Locked
     - Flag to indicated that the requirement is locked.
   * - Locked by
     - User who locked the requirement.
   * - Locked since
     - Date and time when the requirement was locked.






.. raw:: latex

    \newpage

.. index:: ! Test case

.. _test-case:

Test cases
----------

Test cases are elementary actions executed to test a requirement.

You may define several tests to check a requirement, or check several requirements with one test.

Test case must be defined to a product or a project. It can be applied to both.

.. rubric:: Product version

* A given version of the product can be defined, meaning the test case is valid at this version.

.. rubric:: Rights management

* Linking test case to a project will limit the visibility, respecting rights management at project level.

.. rubric:: Predecessor and successor elements

* Test case can have predecessors and successors.
* This defines some dependencies on the test case.
* Dependencies don’t have specific effects. It is just an information.

.. sidebar:: Other sections

   * :ref:`pe-predSuces-element-section-label`
   * :ref:`Linked element<linkElement-section>`   
   * :ref:`Attachments<attachment-section>`   
   * :ref:`Notes<note-section>`   

.. raw:: latex

    \newpage


.. rubric:: Section: Description

.. tabularcolumns:: |l|l|

.. list-table:: Description section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the test case.
   * - **Name**
     - Short description of the test case.
   * - **Test type**
     - Type of test case.
   * - Project
     - The project concerned by the test case.
   * - Product
     - The product concerned by the test case.
   * - Product version
     - Version of the product where the test case will be valid.
   * - :term:`External reference`
     - External reference for the test case.
   * - Environment
     - List of 3 items describing the context of the test case.
   * - :term:`Description`
     - Complete description of the test case.

**\* Required field**

.. topic:: Fields: Project and Product

   * Project or product must be set. 
   * You can set both.

.. topic:: Field: Environment (Context)

   * Contexts are initialized for IT Projects as “Environment”, “OS” and “Browser”. 
   * This can be easily changed values in :ref:`context` screen.  

.. topic:: Field: Description

   * The description of test case should describe the steps to run the test.



.. raw:: latex

    \newpage


.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table:: Treatment section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Parent test case
     - Parent test case, defining a hierarchic structure for test cases.
   * - **Status**
     - Actual :term:`status` of the requirement.
   * - :term:`Responsible`
     - Resource who is responsible of the test case.
   * - Priority
     - Level of priority for the test case.
   * - :term:`Handled`
     - Flag to indicate that test case is taken into account.
   * - :term:`Done`
     - Flag to indicate that test case has been treated.
   * - :term:`Closed`
     - Flag to indicate that test case is archived.
   * - Cancelled
     - Flag to indicate that test case is cancelled.
   * - Prerequisite
     - List of steps that must be performed before running the test.	
   * - :term:`Expected result<Result>`
     - Description of expected result of the test.
   * - Summary
     - :term:`Summary of test case run status`. 
 
**\* Required field**

.. topic:: Field: Prerequisite

   * If left blank and test case has a parent, parent prerequisite will automatically be copied here. 

.. rubric:: Section: Test case runs

* This section allows to display a complete list of test case runs.
* These are links of the test to test sessions.
* This list also displays the current status of the test in the sessions.

.. note ::

   * To go, click on the corresponding test session.


.. tabularcolumns:: |l|l|

.. list-table:: Test case runs list fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Test session
     - Composed of session type, Id and description. 
   * - Status
     - Current status of the test case run in the test session.

.. raw:: latex

    \newpage

.. index:: ! Test session

.. _test-session:

Test sessions
-------------

A test session defines all the tests to be executed to reach a given target.

Define in the test case runs all test cases will be running to this test session.

----------

For each test case run sets the status of test results.

.. glossary::

    Test case run status

      Test case run status is:

      * |iconPlanned| **Planned:** Test to be executed.
      * |iconPassed| **Passed:** Test passed with success (result is conform to expected result).
      * |iconBlocked| **Blocked:** Impossible to run the test because of a prior incident  (blocking incident or incident on preceding test) or missing prerequisite.
      * |iconFailed| **Failed:** Test has returned wrong result.
      
      .. note:: 
        
         * When status is set to failed, the reference to a ticket must be defined (reference to the incident).
         * The referenced ticket is automatically added in linked element. 


----------

Test session must be defined to a product or a project. It can be applied to both.

.. rubric:: Product version

* A given version of the product can be defined, meaning the test session is valid at this version.

.. rubric:: Rights management

* Linking test session to a project will limit the visibility, respecting rights management at project level.

----------

.. rubric:: Planning element

* A test session is a planning element like activity.
* A test session is a task in a project planning.
* Allows to assigned resource and follow up progress.

.. rubric:: Predecessor and successor elements

* Test sessions can have predecessors and successors.
* This defines some dependencies on test cases or planning constraints.

.. sidebar:: Other sections

   * :ref:`pe-assignment-section-label`
   * :ref:`pe-progress-section-label`
   * :ref:`Summary of test cases <summary-test-case-section>`
   * :ref:`pe-predSuces-element-section-label`
   * :ref:`Linked element<linkElement-section>`   
   * :ref:`Attachments<attachment-section>`   
   * :ref:`Notes<note-section>`   

.. rubric:: Section: Description 

.. tabularcolumns:: |l|l|

.. list-table:: Description section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the test session.
   * - **Name**
     - Short description of the test session.
   * - **Session type**
     - Type of test session.
   * - Project
     - The project concerned by the test session.
   * - Product
     - The product concerned by the test session.
   * - Product version
     - Version of the product where the test session will be valid.
   * - :term:`External reference`
     - External reference for the test session.
   * - :term:`Description`
     - Complete description of the test session.

**\* Required field**

.. topic:: Fields: Project and Product

   * Project or product must be set. 
   * You can set both.

.. rubric:: Section: Treatment

.. tabularcolumns:: |l|l|

.. list-table:: Treatment section fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Parent activity
     - Parent activity, to define hierarchic position in the Gantt.
   * - Parent session
     - Parent session, to define session of sessions.
   * - **Status**
     - Actual :term:`status` of the test session.
   * - :term:`Responsible`
     - Resource who is responsible of the test session.
   * - :term:`Handled`
     - Flag to indicate that test session is taken into account.
   * - :term:`Done`
     - Flag to indicate that test session has been treated.
   * - :term:`Closed`
     - Flag to indicate that test session is archived.
   * - Cancelled
     - Flag to indicate that test session is cancelled.
   * - :term:`Result`
     - Summary result of the test session. 
 
**\* Required field**

.. rubric:: Section: Test case runs

This section allows to manage test case runs.

.. list-table:: Test case runs list fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Test case
     - Information about test case (type, Id and name).
   * - Detail
     - Detail of test case.
   * - Status
     - Status of test case run.

.. topic:: Field: Test case
   
   * This icon |Note| appears when the test case run comment field is filled.
   * Moving the mouse over the icon will display the test case run comments.

.. topic:: Field: Detail

   * Moving the mouse over the icon |Description| will display the test case description.
   * Moving the mouse over the icon |Result| will display the test case expected result.
   * Moving the mouse over the icon |Prerequisite| will display the test case prerequisite. 

.. topic:: Field: Status
 
   * If status of test case run is **failed**, information about selected ticket is displayed too.


.. raw:: latex

    \newpage


.. rubric:: Manage test case runs list

* Click on |buttonAdd| to add a test case run. A **Test case run dialog box** will be appear.
* Click on |buttonEdit| to edit a test case run. A **Test case run detail dialog box** will be appear.
* Click on |buttonIconDelete| to remove a test case run.
* Click on |iconPassed| to mark test case run as passed.
* Click on |iconFailed| to mark test case run as failed.
* Click on |iconBlocked| to mark test case run as blocked.

.. figure:: /images/GUI/BOX_TestCaseRun.png
   :alt: Test case run dialog box
   :align: center

   Test case run dialog box


.. list-table:: Test case run dialog box fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Test cases
     - Test cases list.
   * - Allow duplicate
     - Flag on if you permit that test case is use more one time in a test session.





.. figure:: /images/GUI/BOX_TestCaseRunDetail.png
   :alt: Test case run detail dialog box
   :align: center

   Test case run detail dialog box





.. list-table:: Test case run detail dialog box fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Test case
     - Selected test case.
   * - Status
     - List of :term:`test case run status`.
   * - Ticket
     - List of ticket.
   * - Comments
     - Comments of test case run.

.. topic:: Field: Ticket

   * Field appear only whether status of test case run is **failed**.



.. raw:: latex

    \newpage


.. _summary-test-case-section:

Summary of test cases section
-----------------------------

This section summarizes the status of test case runs to requirement and test session.

.. rubric:: Requirement

* This section summarizes the status of test case runs for test cases are linked to the requirement.

.. topic:: Field: Total 

    * Because a test case can be linked to several test sessions, total can be greater than linked to the requirement.

----------

.. rubric:: Test session

* This section summarizes the status of test case runs in the test session.

----------

.. glossary::

   Summary of test case run status


     * |iconNotPlanned| **Not planned:**  No test case planned.
     * |iconPlanned| **Planned:** No test failed or blocked, at least one test planned.
     * |iconPassed| **Passed:** All tests passed.
     * |iconFailed| **Failed:** At least one test failed.
     * |iconBlocked| **Blocked:** No test failed, at least one test blocked.

----------

.. list-table:: Summary of test cases fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Total
     - Number of test case runs whatever the status.
   * - Planned
     - Number of test case runs with the status **Planned**.
   * - Passed
     - Number of test case runs with the status **Passed**.
   * - Blocked
     - Number of test case runs with the status **Blocked**.
   * - Failed
     - Number of test case runs with the status **Failed**.
   * - Summary
     - :term:`Summary of test case run status`.
   * - Issues
     - Number of tickets linked to the requirement or the test session. 

.. note::

   * Percent to each status is displayed.




