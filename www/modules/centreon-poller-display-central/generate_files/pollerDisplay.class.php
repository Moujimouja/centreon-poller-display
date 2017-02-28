<?php
/*
 * Centreon
 *
 * Source Copyright 2005-2016 Centreon
 *
 * Unauthorized reproduction, copy and distribution
 * are not allowed.
 *
 * For more informations : contact@centreon.com
 *
 */

require_once dirname(__FILE__) . '/../centreon-poller-display-central.conf.php';

use \CentreonPollerDisplayCentral\ConfigGenerate\Bam;
use \CentreonPollerDisplayCentral\ConfigGenerate\Centreon;

class PollerDisplay extends \AbstractObject
{
    protected $engine = false;
    protected $broker = true;
    protected $generate_filename = 'bam-poller-display.sql';

    public function generateFromPollerId($poller_id, $localhost)
    {

        Bam::getInstance()->generateobjects($poller_id);
        Centreon::getInstance()->generateobjects($poller_id);


        /*
        $this->poller_id = $poller_id;

        $stmt = $this->backend_instance->db->prepare("SELECT id 
                                                    FROM mod_poller_display_server_relations 
                                                    WHERE nagios_server_id = :pollerId");
        $stmt->bindParam(':pollerId', $poller_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->fetch()) {
            Centreon::getInstance()->generateobjects($poller_id);

            $stmt = $this->backend_instance->db->prepare("SELECT ba_id 
                                                    FROM mod_bam_poller_relations
                                                    WHERE poller_id = :pollerId");
            $stmt->bindParam(':pollerId', $poller_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->fetch()) {
                Bam::getInstance()->generateobjects($poller_id);
            }
        }
        */
    }
}
