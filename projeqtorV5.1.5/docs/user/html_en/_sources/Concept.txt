.. include:: ImageReplacement.txt


.. raw:: latex

    \newpage

.. _projeqtor-roles:

ProjeQtOr roles
---------------

A stakeholder can play many roles in ProjeQtOr.

Roles depends on :ref:`user-ress-contact-demystify`.

Specific roles are defined to allow:

* To categorize the stakeholders involved in the projects.
* To identify the stakeholders on items.
* To regroup the stakeholders to facilitate information broadcasting.


.. rubric:: Use to

* In items of elements.
* As reports parameters.
* As recipients list to mailing and alert.

--------------------------

.. glossary::

   Administrator

    * An administrator is a :term:`user` with "Administrator" profile.
    * Has a visibility over all the projects.

   Contact

    * A contact is a person in a business relationship.
    * A contact can be a person in the customer organization.
    * Used as contact person for contracts, sales and billing.
    * Contacts management is performed on :ref:`contact` screen.

   Issuer

    * An issuer is a :term:`user` who created the item.

    .. seealso:: Creation information

       * The issuer name and creation date of an item are displayed in the :ref:`Creation information zone<detail-window>`.

   Project leader

    * A project leader is a :term:`resource` affected to a project with a “Project Leader” profile.

   Project manager

    * A project manager is a :term:`resource` defined as the manager on a project.

    .. seealso:: Accelerator button

       * This button allows to set current user is the project manager.
       * More detail, see: :ref:`Assign to me button<assignToMe-button>`.  

   Project team

    * All :term:`resources<resource>` affected to a project.


   Requestor

    * A requestor is a :term:`contact`.
    * Used to specify the requestor for ticket, activity and requirement.
    * Only contacts affected to the selected project can be a requestor.  
 
   Responsible

    * A responsible is a :term:`resource` in charge of item treatment. 
    * Usually, the responsible is set when the status of the item is :term:`handled<Handled status>`.
    * Only resources affected to the selected project can be a responsible.  

    .. seealso:: GUI behavior

       * It is possible to define that responsible field is mandatory on handled status.
       * The element type screens allow to set this parameter to several elements. 
       * More detail, see: :ref:`behavior-section`. 

    .. seealso:: Set automatically the responsible

       * It is possible to set automatically the responsible.
       * More detail, see: :ref:`Global parameters<responsible-section>`. 	

    .. seealso:: Accelerator button

       * This button allows to set current user is the responsible.
       * More detail, see: :ref:`Assign to me button<assignToMe-button>`.

    .. seealso:: Access rights

       * It is possible to define a combination of rights to permit access for elements the user is responsible for.
       * More detail, see: :ref:`access-mode` screen.

   Resource

    * Human or material resource involved in the projects.
    * It is possible to define the resource availability to the projects.
    * Resources management is performed on the :ref:`resource` screen.


   User

    * User allows to connect to the application.
    * User profile define general access rights. But it does not necessarily give access to project data.
    * Users management is performed on the :ref:`user` screen.



.. raw:: latex

    \newpage


.. index:: ! Profile (Definition)

.. _profiles-definition:

Profiles definition 
-------------------

The profile is a group used to define application authorization and access rights to the data.

A user linked to a profile belongs to this group who share same application behavior.

.. note::

   * You can define profiles to be conformed to the roles defined in your organization.
   * Access rights management is done on :ref:`Access rights<profile>` screens 


.. rubric:: Used for

* The profile is used to define access rights to application and data, first.
* Also, the profile is used to send message, email and alert to groups.

.. rubric:: Selected profile in project affectation

* A profile can be selected to a user, resource or contact in project affectation.
* The profile selected is used to give data access to elements of the projects.

.. rubric:: Workflow definition

* The profile is used to define who can change from one status to another one.
* You can restrict or allow the state transition to another one according to the profile.
* Workflow definition is managed in :ref:`workflow` screen.

.. raw:: latex

    \newpage

.. rubric:: Predefined profiles

* ProjeQtOr offer some predefined profiles.

 .. glossary::

    Administrator profile

     * This profile group all administrator users. 
     * Only these users can manage the application and see all data without restriction.
     * The user "admin" is already defined.

    Supervisor profile

     * Users linked to this profile have a visibility over all the projects.
     * This profile allows to monitor projects.

    Project leader profile

     * Users of this profile are the project leaders.
     * The project leader has a complete access to owns projects.
  
    Project member profile

     * A project member is working on projects affected to it.
     * The user linked to this profile is a  member of  team projects.

    Project guest profile

     * Users linked to this profile have limited visibility to projects affected to them.
     * The user "guest" is already defined.

.. rubric:: Predefined profiles (External)

* ProjeQtOr allow to involve client employees in their projects.
* The distinction between this profile and its equivalent, user access is more limited.



.. raw:: latex

    \newpage



.. _user-ress-contact-demystify:

Stakeholder definition 
----------------------

ProjeQtOr allows to define roles of stakeholders.

The stakeholder definition is made with profile and a combination with user/resource/contact definition.

The combinations user/resource/contact allow to define:

* Connection to the application or not.
* Data visibility.
* Resource availability.
* Contact roles.

The next matrix shows the different possibilities.

.. list-table:: 
   :header-rows: 1
   :stub-columns: 1

   * - 
     - Connection
     - Visibility
     - Availability
   * - URC
     - |yes|
     - |yes|
     - |yes|
   * - UR
     - |yes|
     - |yes|
     - |yes|
   * - UC
     - |yes|
     - |yes|
     - |no|
   * - U
     - |yes|
     - |yes|
     - |no|
   * - R
     - |no|
     - |no|
     - |yes|
 


.. rubric:: Row legend

* U = User, R = Resource, C = Contact   

.. raw:: latex

    \newpage

.. rubric:: Data visibility

.. figure:: /images/Stakeholder-DataVisibility.png
   :alt: Stakeholder data visibility
   :align: center

   Data visibility diagram

|

 .. compound:: **User profile**

    * To a user, data visibility is based on its user profile.
    * User profile defined general access to application functionalities and data.
    * Base access rights defined if a user has access to own projects or over all projects.

 .. compound:: **All projects**

    * This access right is typically reserved for administrators and supervisors. 
    * Users have access to all elements of all projects.

 .. compound:: **Own projects**
    
    * Users with this access right must be affected to project to get data visibility.
    * Selected profile in affectation allows to define access rights on project elements.
    * For more detail, see: :ref:`project-affectation`.


.. raw:: latex

    \newpage


.. rubric:: Resource availability


.. figure:: /images/Stakeholder-ResourceAvailability.png
   :alt: Stakeholder resource availability
   :align: center

   Resource availability diagram

* Only resource can be assigned to project activities.
* Project affectation allows to define the resource availability on project.

 .. compound:: **Human resource**

    * Human resource is a project member.
    * Combined with a user, a human resource can connect to the application.

 .. compound:: **Material resource**

    * Material resources availability can be defined on projects
    * But,  material resource must not  be  connected to the application.
    


.. rubric:: Contact roles  

 
* ProjeQtOr allows to involve contacts in projects.
* Combined with a user, a contact can connect to the application
* Combined with a resource, contact availability can be planned in projects.

.. figure:: /images/Stakeholder-ContactRoles.png
   :alt: Stakeholder contact roles
   :align: center

   Contact roles diagram


.. raw:: latex

    \newpage

Shared data
"""""""""""

For a stakeholder, data on user, resource and contact are shared.

Project affection and user profile are also shared.

.. note::

   * For a stakeholder, you can define and redefine the combination without losing data.

.. raw:: latex

    \newpage


.. _project-affectation:

Project affectation
-------------------

Project affectation is used to:

* Defines project data visibility.
* Defines resource availability.
* Defines the period of access to project data by the user. 

.. note::

   * The :ref:`affectation` screen allows to manage overall project affectations. 

The following sections describe project affectation, performed for user, resource or contact.

User affectation
""""""""""""""""

Project affectation gives data visibility on a project.

Project affectation can be defined in the :ref:`user` screen.

.. rubric:: Profile selection

* Selected profile allows to define access rights on project elements.

.. hint::

   * Selected profile allows to define the role played by the user in a project.
   * For instance, the user might be a project manager in a project and it could be a project member in another. 

   .. note:: 

      * Profile defined in project affectation does not grant or revoke access to users.
      * General access to application functionalities and data is defined by user profile. 

.. rubric:: Period selection

* Allow to define the period of project data visibility.

  .. hint::
 
     * Can be used to limit access period, according to services agreement.


.. raw:: latex

    \newpage

Resource affectation
""""""""""""""""""""

Project affectation allows to define the resource availability on project.

A resource may be affected to projects at a specified rate for a period.

Project affectation can be defined in :ref:`project` and :ref:`resource` screens.

It is also possible to affect a team to a project in :ref:`team` screens.

.. note::

   * A resource affected to a project can be defined as :term:`responsible` of project items treatment.


.. rubric:: Period & Rate selection

* A resource may be affected to a project at a specified rate for a period. 

.. note::

   * If the period is not specified then the resource is affected throughout the project.

.. attention::

   * Activities planning process trying to plan the assigned work to the resource within the specified period.
   * If a incompletely planned tasks happen a brown bar appear in the Gantt view.	

Multi-project affectation
^^^^^^^^^^^^^^^^^^^^^^^^^

A resource can be affected to multiple projects in the same period.

Make sure that the affectation to projects for a period not exceeding 100%.

In the section **Affectations** in :ref:`resource` screen, a tool allows to displayed conflicts.

.. hint:: How resolve conflicts?

   * You can change affectation period to avoid overlap between projects.
   * You can change the rate of affectation for it does not exceed 100% for the period.


Contact affectation
"""""""""""""""""""

A contact affected to a project can be defined as :term:`requestor`.

Project affectation can be defined in :ref:`project` and :ref:`contact` screens.



.. raw:: latex

    \newpage

Activity assignment
-------------------

* Activity assignment is used to assign resource to project activities.
* Project activities are activity, meeting and test session. 
    
.. note::

   * Only resources affected to the project of the activity can be assigned to the activity.



.. raw:: latex

    \newpage


.. index:: ! Resource (Function & Cost)

.. _resource-function-cost:

Resource function and cost
--------------------------

.. rubric:: Function

* The function defines the generic competency of a resource.
* It is used to define the role play by the resource on specific activity.
* In real work allocation screen, the function name will be displayed in the real work entry in this activity.
* You can specify a function in field **main function** or in resource cost definition.
* You can manage function list in :ref:`function` screen.

.. rubric:: Main function

* A main function can be defined in a resource.
* Allows to define a default function to a resource.

--------------------------

.. rubric:: Resource cost definition

* Allows to define for a resource the **daily cost** for a **specific period of time**, for a **specific function**.
* Allows to define distinct cost for different resource function.

 .. admonition:: Example

    * A resource can work in a different function in a different department from the same company. 

* Allows to define distinct cost to the same function but for different period of time.

 .. admonition:: Example

    * You can set the salary increase of the resource (cost) for the next period. 

.. rubric:: Real cost calculation

* When real work is entered, the real cost is calculated with work of the day and daily cost for this period. 

.. rubric:: Planned cost calculation

* When the project planning is calculated, resource cost is used to calculate planned cost.
* Planned cost is calculated with planned work of the day and daily cost for this period. 

------------------

.. note::
 
   * Function and cost are defined in :ref:`resource` screen.


.. index:: ! Resource (Calendar) 

.. _resource-calendar:

Resource calendar
-----------------

A calendar defines the working days in a the year.

A calendar is defined for each resource.

.. rubric:: Used for

|

 .. compound:: **Planning process**

    * Calendars ares used in planning process whose dispatches work on every working day. 
    * During the planning process, the assigned work to a resource is planned in its working days.

    .. note:: 

       * You must re-calculate an existing planning to take into account changes on the calendar.

 .. compound:: **Shows the availability of resources**

    * Working days defined in a calendar allows to show availability of resources.

---------------

.. rubric:: Default calendar

* The default calendar is used to define the working days in the year.
* By default, this calendar is defined for all resources.

.. rubric:: Specific calendar

* A specific calendar can be created to define days off and work to a resource.


------------------

.. note::

   * A calendar is set in :ref:`resource` screen. 
   * The calendar can be defined in :ref:`calendar` screen.


------------------------

.. raw:: latex

    \newpage

.. rubric:: Use case

.. topic:: Public holiday

   * You can use the default calendar to set public holidays.

.. topic:: Personal calendar

   * You can create a calendar to a resource.
   * This calendar will indicate the personal days off and vacations.

.. topic:: Work schedule

   * You can define a different work schedule to some resources.
   * This calendar defined exceptions to normal working days.


.. raw:: latex

    \newpage


.. _photo:

Photo
-----

A photo can be defined for a user, a resource and a contact.

It is a visual identification associated with the name.

.. note::

   * To enlarge, move the cursor over the picture.

.. rubric:: Photo management

* Click on |buttonAdd| or photo frame to add an image file. To complete instruction see: :ref:`Attachment file<attachment-file>`.
* Click on |buttonIconDelete| to remove  the image.
* Click on image to display the photo.

.. note::

   * Photo management can be done in :ref:`user-parameters`, :ref:`user`, :ref:`resource` , :ref:`contact` screens.

