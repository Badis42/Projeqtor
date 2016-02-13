.. include:: ImageReplacement.txt


.. raw:: latex

    \newpage


.. title:: Common sections

.. _common-sections:

Common sections
===============

Some sections are displayed on almost all screens.

Those sections allows to set information or add information to an item of the element.



Description section
-------------------

This section allows to identify items of the element.

* Information grouped under this section are:

  * :term:`Id`
  * Element type
  * Name
  * Description
  * Current situation
  * Stakeholder
  * Objective
  * Reference
  * Link


Treatment section
-----------------

This section contains information about item treatment.

Depending on the element, this section  may have a different name.

* Information grouped under this section are:

  * Status and Dates
  * :term:`Responsible`
  * Link
  * Outcome
  * Comment





.. raw:: latex

    \newpage

.. index:: ! Project (Affectation section)

.. _affectations-section:

Affectations section
--------------------

.. sidebar:: Concepts 

   * :ref:`profiles-definition`
   * :ref:`project-affectation`

This section allows to manage project affectations.



.. list-table:: Fields of affectations list
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the affectation.
   * - **Project**
     - Project affected to.
   * - **Resource**
     - Name of the affected resource.
   * - Profile
     - Selected profile.
   * - Start date
     - Start date of affectation.
   * - End date
     - End date of affectation.
   * - Rate
     - Affectation rate for the project (%).

.. topic:: Fields: Project & Resource

   * If the project affectations management is done on the «:ref:`project`» screen, the field **«resource»** will be displayed.
   * If the project affectations management is done on the screen «:ref:`resource`», «:ref:`contact`» or «:ref:`user`», the field **«project»** will be displayed.
 

.. rubric:: Affectation list management

* Click on |buttonAdd| to create a new affectation. 
* Click on |buttonEdit| to update an existing affectation.
* Click on |buttonIconDelete| to delete the corresponding affectation.

.. _affectations-box:

.. figure:: /images/GUI/BOX_Affectation.png
   :alt: Affectation dialog box
   :align: center

   Affectation dialog box


.. tabularcolumns:: |l|l|

.. list-table:: Fields of affectation dialog box
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - **Project**
     - Project list.
   * - **Resource**
     - Resource list.
   * - **Profile**
     - Profile list.
   * - Rate
     - Rate (in %) of the affectation to the project.
   * - Start date
     - Start date of affectation.
   * - End date
     - End date of affectation.
   * - Closed
     - Flag to indicate that affectation in not active anymore, without deleting it.


**\* Required field**


.. topic:: Field: Resource

   * This field can contain a list of users, resources or contacts according to which screen comes from project affectation.

.. topic:: Field: Profile

   * The user profile defined will be displayed first. 
   * If the profile field is not available, the profile defined for each resource will be selected.  

.. topic:: Field: Rate

   * 100% means a full time affectation.

.. note::
 
   * Depending on which screen is used to manage project affectations, the behavior of fields will change. 
 



.. raw:: latex

    \newpage

.. _linkElement-section:

Linked Elements section
-----------------------

This section allows to manage link between items of elements.

.. tabularcolumns:: |l|l|

.. list-table:: Fields of linked elements list
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Element
     - Type and id of the linked element.
   * - Name
     - Name of the linked element.
   * - Date
     - Date of creation of the link.
   * - User
     - User who created the link.
   * - Status
     - Actual status of the linked element.


.. rubric:: Used for

* Allows to associate items on different elements in the same project.
* A project can be linked with other.
* Click on  an item name to directly move to it.


   .. note::

      * Click on |buttonIconBackNavigation| to return to the last screen. (More detail, see: :ref:`Top bar <navigation-buttons>`)


.. rubric:: Reciprocally interrelated

* If Item A is linked to Item B, Item B is automatically linked to Item A.

.. note::

   * A link between items has no impact on them treatment.

.. raw:: latex

    \newpage

.. rubric:: Linked elements management

* Click |buttonAdd| to create a new link.
* Click on |buttonIconDelete| to delete the corresponding link.

.. figure:: /images/GUI/BOX_AddLink.png
   :alt: Add a link with element dialog box
   :align: center

   Add a link with element dialog box


.. rubric:: Link with Document

* Click on |iconDownload| to download the file of document.

 .. compound:: **Specified version**

    * A link with a document element offer the possibility to select a specific version.
    * A direct link to version of the document is created.

 .. compound:: **Not specified version**

    * If the version is not specified, the last version will be selected.
    * The download will transfer always the last version of the document.

.. raw:: latex

    \newpage

.. _attachment-section:

Attachments section
-------------------

This section allows to attach files or hyperlinks to items of elements.

.. tabularcolumns:: |l|l|

.. list-table:: Fields of attachments list
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the attachment.
   * - File
     - File name or hyperlink.
   * - Date
     - Date of creation of the attachment.
   * - User
     - User who created the attachment.


.. rubric:: Select an attachment

* Select an attachment depends on whether is a file or a hyperlink.

  * Click on |iconDownload| to download attachment file.
  * Click on |iconLink| to access to hyperlink.
  * Click on |buttonIconPdf| to view the PDF file online.

.. rubric:: Delete an attachment

* Click on |buttonIconDelete| to delete an attachment.


.. raw:: latex

    \newpage

.. rubric:: Add an attachment

* Click on |buttonAdd| to add an attachment file to an item.

  * Dialog box "Attachment file" will be displayed.
 
* Click on |iconLink| to add hyperlink to an item.

  * Dialog box "Hyperlink" will be displayed. 

.. _attachment-file:

 .. compound:: **Attachment file**

     .. note:: To upload a file
 
        * Select file with "Browse" button or drop the file in "drop files here" area.
        * Attached files are stored on server side.
        * Attachments directory is defined in :ref:`Global parameters <file-directory-section>` screen.

    .. figure:: /images/GUI/BOX_attachmentFile.png
       :alt: Attachment file dialog box
       :align: center

       Attachment file dialog box
   

 .. compound:: **Hyperlink**

     .. note:: Hyperlink

        * Enter hyperlink in «Hyperlink» field.



    .. figure:: /images/GUI/BOX_attachmentHyperLink.png
       :alt: Attachment hyperlink dialog box
       :align: center

       Hyperlink dialog box


.. tabularcolumns:: |l|l|

.. list-table:: Fields of attachment dialog box
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Description
     - Description of attachment.
   * - Public
     - Attachment is visible to anyone.
   * - Team
     - Attachment is visible to every member of the creator’s team.
   * - Private
     - Attachment is visible only to the creator.


.. raw:: latex

    \newpage

.. index:: ! Note (section)

.. _note-section:

Notes section
-------------

This section allows to add notes on items of elements.

Notes are comments, that can be shared to track some information or progress.

.. tabularcolumns:: |l|l|

.. list-table:: Fields of notes list
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - :term:`Id`
     - Unique Id for the note.
   * - Note 
     - Text of the note.
   * - Date
     - Date of creation or modification of the note.
   * - User
     - Name of the user who created the note.

.. rubric:: Predefined note

* The list of values appears whether a predefined note exists for an element or an element type.
* Selecting a predefined note  will automatically fill in the note text field.
* Predefined notes are defined in :ref:`predefined-notes` screen.

.. rubric:: Note visibility

* Public: Visible to anyone.
* Team: Visible to every member of the creator’s team.
* Private:  Visible only to the creator.

.. rubric:: Notes list management

* Click on |buttonAdd| to add a note to an item. 
* Click on |buttonEdit| to edit the note.
* Click on |buttonIconDelete| to delete the note.

.. figure:: /images/GUI/BOX_Note.png
   :alt: Note dialog box
   :align: center

   Note dialog box


