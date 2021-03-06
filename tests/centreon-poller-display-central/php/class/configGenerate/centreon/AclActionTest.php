<?php
/**
 * Copyright 2016 Centreon
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

use \Centreon\Test\Mock\CentreonDB;
use \CentreonPollerDisplayCentral\ConfigGenerate\Centreon\AclActions;


/**
 * @package centreon-poller-display-central
 * @version 1.0.0
 * @author Centreon
 */
class CentreonPollerDisplayCentral_AclAction extends PHPUnit_Framework_TestCase
{
    protected static $db;
    protected static $pollerDisplay;
    protected static $acl;
    protected static $objectListIn;
    protected static $objectListOut;

    public function setUp()
    {
        self::$db = new CentreonDB();
        self::$pollerDisplay = 1;
        self::$acl = new AclActions(self::$db, self::$pollerDisplay);
        self::$objectListIn = array(
            array(
                'acl_group_id' => '1',
                'acl_action_id' => '2'
            ),
            array(
                'acl_group_id' => '14',
                'acl_action_id' => '6'
            )
        );
        self::$objectListOut = array(
            array(
                'acl_action_id' => '2',
                'acl_action_name' => 'user'
            ),
            array(
                'acl_action_id' => '6',
                'acl_action_name' => 'gest'
            )
        );
    }

    public function tearDown()
    {
        self::$db = null;
    }

    public function testGetList()
    {
        self::$db->addResultSet(
            "SELECT * FROM acl_actions WHERE acl_action_id IN (2,6)",
            array(
                array(
                    'acl_action_id' => '2',
                    'acl_action_name' => 'user'
                ),
                array(
                    'acl_action_id' => '6',
                    'acl_action_name' => 'gest'
                )
            )
        );
        $sql = self::$acl->getList(self::$objectListIn);
        $this->assertEquals($sql, self::$objectListOut);
    }

    public function testGenerateSql()
    {

        $expectedResult = "DELETE FROM acl_actions;
TRUNCATE acl_actions;
INSERT INTO `acl_actions` (`acl_action_id`,`acl_action_name`) VALUES ('2','user'),('6','gest');";

        $sql = self::$acl->generateSql(self::$objectListOut);
        $this->assertEquals($sql, $expectedResult);
    }
}
