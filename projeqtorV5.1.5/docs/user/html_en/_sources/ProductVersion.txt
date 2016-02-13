.. include:: ImageReplacement.txt

.. contents::
   :depth: 1
   :backlinks: top

.. title:: Product & Version

.. index:: ! Product

.. _product:

Products
--------

Product is the element a project is built for.

A project works on one or more versions of the product . 

A product is any element delivered by the project. For IT/IS projects, products are generally applications.

.. sidebar:: Other sections
   
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
     - Unique Id for the product.
   * - **Name**
     - Name of the product.
   * - Designation
     - Trade name of the product known outside the company.
   * - Customer
     - The customer the product should be delivered to.
   * - Prime contractor
     - The contact, into customer organization, who will be responsible for the product delivery.
   * - Is sub-product of 
     - Name of the top product if this product is a sub-product. 
   * - :term:`Closed`
     - Flag to indicate that product is archived.
   * - Description
     - Complete description of the product.

**\* Required field**

.. rubric:: Section: Product versions

List of the versions defined for the product.


.. raw:: latex

    \newpage

.. index:: ! Version 
.. index:: ! Product (Version)

.. _version:

Versions
--------

Version is the declination of the product life.

A project works on one or more versions of the product . 

A version of product is any stable status of the element delivered by the project.

For IT/IS projects, versions are generally applications versions.

.. sidebar:: Other sections

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
     - Unique Id for the version.
   * - **Product**
     - The product on which the version applies.
   * - **Name**
     - Name of the version.
   * - Prime contractor
     - The contact, into customer organization, who will be responsible for the version delivery.
   * - Responsible
     - Resource responsible of the version.
   * - Entry into service
     - Initial, planned and real entry into service date of the version. 
   * - End date
     - Initial, planned and real end dates of the version.  
   * - Description
     - Complete description of the version.

**\* Required field**

.. topic:: Field: Prime contractor
     
   * Can be different from product prime contractor.

.. topic:: Field: Entry into service

   * Done is checked when real is set.

.. topic:: Field: End date

   * Done is checked when real is set, corresponding to closed version.



.. raw:: latex

    \newpage

.. rubric:: Section: Projects linked to this version

Projects can be directly linked to version.

.. rubric:: Link version to projects management

* Click on |buttonAdd| to create a new link to project. 
* Click on |buttonEdit| to update an existing link to project.
* Click on |buttonIconDelete| to delete the corresponding link to project.


.. figure:: /images/GUI/BOX_ProjectVersionLink.png
   :alt: Project - Version link dialog box
   :align: center

   Project - Version link dialog box


.. list-table:: Project - Version link dialog box fields
   :widths: 20, 80
   :header-rows: 1

   * - Field
     - Description
   * - Project
     - Project linked to the version.
   * - Version
     - Current version.
   * - Start date
     - Start date for validity of the link.
   * - End date
     - End date for validity of the link.
   * - Closed
     - Flag to indicate that link is not active any more, without deleting it.

