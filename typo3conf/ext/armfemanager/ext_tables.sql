#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (
  tx_femanager_branch int(11) unsigned DEFAULT '0' NOT NULL,
  tx_femanager_activepack tinyint(4) unsigned DEFAULT '0' NOT NULL,
  tx_femanager_responsible varchar(100) DEFAULT '' NOT NULL,
);