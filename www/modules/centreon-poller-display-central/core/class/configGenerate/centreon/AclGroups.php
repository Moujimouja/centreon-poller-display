<?php
/*
 * Copyright 2005-2017 Centreon
 * Centreon is developped by : Julien Mathis and Romain Le Merlus under
 * GPL Licence 2.0.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation ; either version 2 of the License.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
 * PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see <http://www.gnu.org/licenses>.
 *
 * Linking this program statically or dynamically with other modules is making a
 * combined work based on this program. Thus, the terms and conditions of the GNU
 * General Public License cover the whole combination.
 *
 * As a special exception, the copyright holders of this program give Centreon
 * permission to link this program with independent modules to produce an executable,
 * regardless of the license terms of these independent modules, and to copy and
 * distribute the resulting executable under terms of Centreon choice, provided that
 * Centreon also meet, for each linked independent module, the terms  and conditions
 * of the license of that module. An independent module is a module which is not
 * derived from this program. If you modify this program, you may extend this
 * exception to your version of the program, but you are not obliged to do so. If you
 * do not wish to do so, delete this exception statement from your version.
 *
 * For more information : contact@centreon.com
 *
 */

namespace CentreonPollerDisplayCentral\ConfigGenerate\Centreon;

use CentreonPollerDisplayCentral\ConfigGenerate\Object;

class AclGroups extends Object
{

    /**
     * @var table
     */
    protected $table = 'acl_groups';

    /**
     * @var array
     * columns wanted
     */
    protected $columns = array(
        '*'
    );

    public function getList($clauseContactObject = null, $clauseContactgObject = null)
    {
        $listAcl = array();
        $list = array();

        $contactgroups = $clauseContactgObject;
        $contacts = $clauseContactObject;

        $cgErrors = array_filter($contactgroups);
        $cErrors = array_filter($contacts);

        if (empty($cgErrors) && empty($cErrors)) {
            return '';
        }

        if (!empty($cgErrors)) {
            foreach ($contactgroups as $contactgroup) {
                array_push($listAcl, $contactgroup['acl_group_id']);
            }
        }

        if (!empty($cErrors)) {
            foreach ($contacts as $contact) {
                array_push($listAcl, $contact['acl_group_id']);
            }
        }

        $listAclUnique = array_unique($listAcl);
        $clauseQuery = ' WHERE acl_group_id IN (';
        $clauseQuery .= implode(',', $listAclUnique);
        $clauseQuery .= ')';

        $query = 'SELECT ' . implode(',', $this->columns) . ' '
            . 'FROM ' . $this->table . $clauseQuery;

        $result = $this->db->query($query);
        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
            $list[] = $row;
        }

        return $list;
    }
}
