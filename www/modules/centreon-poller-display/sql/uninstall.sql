UPDATE topology SET topology_show = '1' WHERE topology_page = '102';
UPDATE topology SET topology_show = '1' WHERE topology_parent = '102';

UPDATE topology SET topology_show = '1' WHERE topology_page = '6';
UPDATE topology SET topology_show = '1' WHERE topology_parent = '6';
UPDATE topology SET topology_show = '1' WHERE topology_parent => '600' AND topology_parent < '700';

-- Administration
UPDATE topology SET topology_show = '1' WHERE topology_page = '50101';
UPDATE topology SET topology_show = '1' WHERE topology_parent = '50101';
UPDATE topology SET topology_show = '1' WHERE topology_page = '5010601';
UPDATE topology SET topology_show = '1' WHERE topology_page = '50104';
UPDATE topology SET topology_show = '1' WHERE topology_page = '50102';
UPDATE topology SET topology_show = '1' WHERE topology_parent = '50102';
UPDATE topology SET topology_show = '1' WHERE topology_page = '502';
UPDATE topology SET topology_show = '1' WHERE topology_parent = '502';
UPDATE topology SET topology_show = '1' WHERE topology_page = '508';
UPDATE topology SET topology_show = '1' WHERE topology_parent = '508';
UPDATE topology SET topology_show = '1' WHERE topology_page = '50502';
UPDATE topology SET topology_show = '1' WHERE topology_page = '50503';
