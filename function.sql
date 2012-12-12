DROP FUNCTION `getUsertype`//
CREATE DEFINER=`root`@`localhost` FUNCTION `getUsertype`(tipe int) RETURNS varchar(50) CHARSET latin1
BEGIN
DECLARE usrtype varchar(50);

IF tipe = 0 THEN
    RETURN 'Customer';
ELSEIF tipe = 1 THEN
    RETURN 'System Administrator';
END IF;
END
