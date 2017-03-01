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
use \CentreonPollerDisplayCentral\ConfigGenerate\Centreon\MetaContact;


/**
 * @package centreon-poller-display-central
 * @version 1.0.0
 * @author Centreon
 */
class CentreonPollerDisplayCentral_MetaContact extends PHPUnit_Framework_TestCase
{
    protected static $db;
    protected static $pollerDisplay;
    protected static $meta;

    public function setUp()
    {
        self::$db = new CentreonDB();
        self::$pollerDisplay = 1;
        self::$meta = new MetaContact(self::$db, self::$pollerDisplay);
    }

    public function tearDown()
    {
        self::$db = null;
    }

    public function testGenerateSql()
    {

        $expectedResult = 'TRUNCATE meta_contacts;
INSERT INTO `meta_contacts` (`meta_id`,`contact_id`) VALUES (\'5\',\'17\');';

        self::$db->addResultSet(
            'SELECT * FROM ns_host_relation WHERE nagios_server_id = 1',
            array(
                array(
                    'nagios_server_id' => '1',
                    'host_host_id' => '1'
                ),
                array(
                    'nagios_server_id' => '1',
                    'host_host_id' => '2'
                )
            )
        );

        self::$db->addResultSet(
            'SELECT * FROM meta_service_relation WHERE host_id IN (1,2)',
            array(
                array(
                    'msr_id' => '1',
                    'meta_id' => '1',
                    'host_id' => '1'
                ),
                array(
                    'msr_id' => '2',
                    'meta_id' => '5',
                    'host_id' => '2'
                )
            )
        );

        self::$db->addResultSet(
            'SELECT * FROM meta_contacts WHERE meta_id IN (1,5)',
            array(
                array(
                    'meta_id' => '5',
                    'contact_id' => '17'
                )
            )
        );

        $sql = self::$meta->generateSql();
        $this->assertEquals($sql, $expectedResult);
    }
}