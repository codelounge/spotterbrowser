<?php defined('SYSPATH') or die('No direct script access.'); ?>

2011-01-09 11:03:36 --- ERROR: ErrorException [ 1 ]: Call to undefined method SB_Update_400a1::steps() ~ MODPATH/spotterbrowser/classes/sb/upgrader.php [ 72 ]
2011-01-09 11:03:53 --- ERROR: ErrorException [ 1 ]: Call to undefined method SB_Update_400a1::steps() ~ MODPATH/spotterbrowser/classes/sb/upgrader.php [ 72 ]
2011-01-09 11:04:04 --- ERROR: ErrorException [ 1 ]: Call to undefined method SB_Update_400a1::steps() ~ MODPATH/spotterbrowser/classes/sb/upgrader.php [ 72 ]
2011-01-09 11:07:13 --- ERROR: ErrorException [ 8 ]: Undefined variable: steps ~ MODPATH/spotterbrowser/classes/sb/update/base.php [ 8 ]
2011-01-09 11:15:44 --- ERROR: ErrorException [ 1 ]: Call to undefined method SB_Upgrader::getCurrentStepStatus() ~ MODPATH/spotterbrowser/classes/controller/upgrade.php [ 28 ]
2011-01-09 11:16:29 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'step' in 'where clause' [ SELECT * FROM `updatelog` WHERE `version` = '400a1' AND `step` = 1 ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 179 ]
2011-01-09 11:22:27 --- ERROR: ErrorException [ 1 ]: Class 'Model_Updatelog' not found ~ MODPATH/orm/classes/kohana/orm.php [ 118 ]
2011-01-09 11:24:46 --- ERROR: ErrorException [ 1 ]: Class 'Model_Updatelog' not found ~ MODPATH/orm/classes/kohana/orm.php [ 118 ]
2011-01-09 11:25:56 --- ERROR: ErrorException [ 1 ]: Call to a member function as_array() on a non-object ~ MODPATH/spotterbrowser/classes/sb/update/base.php [ 36 ]
2011-01-09 11:32:26 --- ERROR: ReflectionException [ 0 ]: Method action_run does not exist ~ SYSPATH/classes/kohana/request.php [ 1196 ]
2011-01-09 11:34:16 --- ERROR: ErrorException [ 1 ]: Call to private method SB_Update_400a1::step1() from context 'SB_Update_Base' ~ MODPATH/spotterbrowser/classes/sb/update/base.php [ 52 ]
2011-01-09 18:44:07 --- ERROR: ErrorException [ 8 ]: Undefined property: Database_Query::$execute ~ MODPATH/spotterbrowser/classes/sb/update/base.php [ 62 ]
2011-01-09 18:44:16 --- ERROR: ErrorException [ 8 ]: Undefined property: Database_Query::$execute ~ MODPATH/spotterbrowser/classes/sb/update/base.php [ 62 ]
2011-01-09 18:45:19 --- ERROR: ErrorException [ 8 ]: Undefined property: Database_Query::$execute ~ MODPATH/spotterbrowser/classes/sb/update/base.php [ 62 ]
2011-01-09 18:47:59 --- ERROR: ErrorException [ 8 ]: Undefined property: Database_Query::$execute ~ MODPATH/spotterbrowser/classes/sb/update/base.php [ 62 ]
2011-01-09 18:48:22 --- ERROR: ErrorException [ 2 ]: mysql_num_rows() expects parameter 1 to be resource, boolean given ~ MODPATH/database/classes/kohana/database/mysql/result.php [ 20 ]
2011-01-09 20:43:49 --- ERROR: ErrorException [ 8 ]: Use of undefined constant cycle - assumed 'cycle' ~ MODPATH/spotterbrowser/classes/sb/update/base.php [ 68 ]
2011-01-09 20:53:55 --- ERROR: ErrorException [ 8 ]: Undefined index: cycle_size ~ MODPATH/spotterbrowser/classes/sb/update/400a1.php [ 49 ]
2011-01-09 21:01:03 --- ERROR: ErrorException [ 1 ]: Call to undefined method Database_Query::name() ~ MODPATH/spotterbrowser/classes/sb/update/400a1.php [ 55 ]
2011-01-09 21:01:27 --- ERROR: Database_Exception [ 1048 ]: Column 'name' cannot be null [ INSERT INTO airline (name) VALUES (NULL) ] ~ MODPATH/database/classes/kohana/database/mysql.php [ 179 ]
2011-01-09 21:33:15 --- ERROR: ErrorException [ 1 ]: Cannot pass parameter 2 by reference ~ MODPATH/spotterbrowser/classes/sb/update/400a1.php [ 68 ]
2011-01-09 21:34:44 --- ERROR: ErrorException [ 1 ]: Cannot pass parameter 2 by reference ~ MODPATH/spotterbrowser/classes/sb/update/400a1.php [ 68 ]
2011-01-09 21:38:38 --- ERROR: ErrorException [ 1 ]: Cannot pass parameter 2 by reference ~ MODPATH/spotterbrowser/classes/sb/update/400a1.php [ 68 ]
2011-01-09 21:42:47 --- ERROR: ErrorException [ 8 ]: Undefined variable: _cylce ~ MODPATH/spotterbrowser/classes/sb/update/400a1.php [ 69 ]
2011-01-09 21:43:21 --- ERROR: ErrorException [ 1 ]: Cannot pass parameter 2 by reference ~ MODPATH/spotterbrowser/classes/sb/update/400a1.php [ 69 ]
2011-01-09 21:44:05 --- ERROR: ErrorException [ 1 ]: Cannot pass parameter 2 by reference ~ MODPATH/spotterbrowser/classes/sb/update/400a1.php [ 70 ]
2011-01-09 21:44:31 --- ERROR: ErrorException [ 1 ]: Cannot pass parameter 2 by reference ~ MODPATH/spotterbrowser/classes/sb/update/400a1.php [ 70 ]
2011-01-09 22:30:34 --- ERROR: ErrorException [ 8 ]: Use of undefined constant _offset - assumed '_offset' ~ MODPATH/spotterbrowser/classes/sb/update/400a1.php [ 73 ]
2011-01-09 22:31:10 --- ERROR: ErrorException [ 1 ]: Cannot pass parameter 2 by reference ~ MODPATH/spotterbrowser/classes/sb/update/400a1.php [ 80 ]
2011-01-09 22:32:33 --- ERROR: ErrorException [ 2048 ]: Only variables should be passed by reference ~ MODPATH/spotterbrowser/classes/sb/update/400a1.php [ 83 ]
2011-01-09 22:35:38 --- ERROR: ErrorException [ 8 ]: Undefined offset: 0 ~ MODPATH/spotterbrowser/views/installer/update.php [ 56 ]
2011-01-09 22:35:51 --- ERROR: ErrorException [ 8 ]: Undefined offset: 0 ~ MODPATH/spotterbrowser/views/installer/update.php [ 56 ]
2011-01-09 23:07:22 --- ERROR: ErrorException [ 8 ]: Undefined offset: 0 ~ MODPATH/spotterbrowser/views/installer/update.php [ 53 ]
2011-01-09 23:09:02 --- ERROR: ErrorException [ 8 ]: Undefined offset: 0 ~ MODPATH/spotterbrowser/views/installer/update.php [ 53 ]
2011-01-09 23:13:46 --- ERROR: ErrorException [ 1 ]: Call to undefined method SB_Update_400a1::step2() ~ MODPATH/spotterbrowser/classes/sb/update/base.php [ 64 ]