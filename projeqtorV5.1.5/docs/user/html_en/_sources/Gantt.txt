.. raw:: latex

    \newpage

.. contents:: Gantt
   :depth: 1
   :backlinks: top
   :local:

.. title:: Gantt

.. index:: ! Gantt chart

Gantt chart
-----------

.. rubric:: Scale

* Scale available : daily, weekly, monthly or quater

.. rubric:: chart detail

* Overdue tasks appear in red.


.. rubric:: Calculate planning


.. index:: ! Planning

Planning
--------

Planning is displayed as a Gantt chart, showing dependencies between tasks.

Overdue tasks appear in red, others in green.

Milestones appear as squares, filled if completed, empty if not. 

You can change the scale to have a daily, weekly or monthly view of the chart.

You can select to show tasks’ WBS before the names.

You can select to show resource name or initials (depending on parameter) on right on tasks.

You can change the starting                                   or ending                                  date to display the chart.

You can also choose to save these dates                      to retrieve the same display on every connection. 

You can select the columns displayed on the left part of the chart, except for the name of tasks (always displayed). 

You can reorder columns with drag & drop on the handle in the selection list. 

You can directly create a Project or an Activity or a Milestone using the           create button.

The result can be printed        or exported to MS-Project XML format. 

.. rubric:: Recalculate

To recalculate the planning, click on         . 

Calculation is not automatic.

You then have to select the project to re-calculate, and the start date for the new planning. 

As WBS is taken into account for planning priority, you may wish to change tasks order.

This can simply be done with a drag & drop method on tasks, using the handle on leftmost part of the task line.

You can also increase or decrease indent of task using corresponding buttons 

.. note::

   * If a resource is assigned to several projects, re-calculation for one will not impact the planning for the others, so new calculation will only use available time slots.

   * Use correct resource affectation rate to manage multi-projects affectations.

.. note:: 
   
   * If the planning of one project must not be impacted by new calculation, you can use the “fix planning” flag on this project.

   * This will avoid to change planned values for this project and its subprojects. 

Planning is calculated “as simply as possible”.

This means that no complex algorithm, with high level mathematic formula, is involved.

The principle is simply to reproduce what you could do on your own, with a simple Excel sheet, but automatically.

Planning is Cross-Project, through affectation rate on the projects. 

All the left work is planned, from starting date, to the max date to be able to plan the work.

Calculation is executed task by task, ordering thanks to :

 - dependencies (if an activity has a predecessor, the predecessor is calculated first),

 - planning mode : regular between dates are planned first 

 - priority : the smaller values are calculated first

	if projects have different priorities, all tasks of project with smaller value priority are planned first.

 - WBS : smaller WBS are planned first, so that planning is done from top to bottom of Gantt


Planning will distribute left work on future days, taking into account several constraints :

A resource has a capacity

Most of the time Capacity = 1 FTE (1 full time equivalent), but it may be more (if the resource is not a person but a team) or less (if the person work only partial time).

A resource is affected to a project, at a certain rate, possibly with start and end dates

If resources are not shared between projects, so rate will probably always be 100%.

But if resources are shared, then rate could be less than 100%. If a resource is equally shared between two projects, then each project should enter a rate of 50%. This will lead to control that planning 

for each project will not overtake rate capacity, so that first project planning its activity will not take all the availability of the resource. 

Project affectation capacity is controlled on a weekly basis. This means that planning for a project (including sub-projects) will not be more than (Resource Capacity) x (Resource affectation rate) x 5 for a given week.


.. index:: ! Projects portfolio

Projects portfolio
------------------

Planning can be displayed on a projects portfolio point of view.

Only projects and milestones are displayed.

This is a good way to display projects synthesis and projects dependencies, without messing with projects activities.. 

It is possible to select milestones to be displayed, from none to all, or select one milestones type to display only milestones of this type     

.. index:: ! Resource Planning

Resource Planning
-----------------

Planning can be displayed on a resource basis.

One group line is displayed for each resource.

One group line can be display for projects level, depending on selection                            . 

One line is displayed per activity. The Gantt bars for activities are hare split in two : real work in grey, planned work in green. This makes appear some planning gap between started work and planned work.

Links between activities are displayed only into the resource group. Links existing between tasks on different resources are not displayed.

Left work can be displayed on the right of task bars, using corresponding selection                          . 

All others behaviors are similar to the task planning screen.
                                             .

