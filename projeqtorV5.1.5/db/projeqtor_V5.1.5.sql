-- ///////////////////////////////////////////////////////////
-- // PROJECTOR                                             //
-- //-------------------------------------------------------//
-- // Version : 5.1.5                                       //
-- // Date : 2015-12-09                                     //
-- ///////////////////////////////////////////////////////////

ALTER TABLE `${prefix}quotation` CHANGE `untaxedAmount` `untaxedAmount` DECIMAL(11,2);

ALTER TABLE `${prefix}command` CHANGE `untaxedAmount` `untaxedAmount` DECIMAL(11,2),
CHANGE `addUntaxedAmount` `addUntaxedAmount` DECIMAL(11,2),
CHANGE `totalUntaxedAmount` `totalUntaxedAmount` DECIMAL(11,2);