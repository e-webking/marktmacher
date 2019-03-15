#
# Table structure for table 'tx_armpayments_domain_model_payment'
#
CREATE TABLE tx_armpayments_domain_model_payment (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	gateway varchar(100) DEFAULT '' NOT NULL,
	amount float(7,2) DEFAULT '0.00' NOT NULL,
	tax float(7,2) DEFAULT '0.00' NOT NULL,
	subtotal float(7,2) DEFAULT '0.00' NOT NULL,
	currency char(3) DEFAULT 'CHF' NOT NULL,
	orderid int(11) unsigned DEFAULT '0' NOT NULL,
	token varchar(100) DEFAULT '' NOT NULL,
	payer varchar(150) DEFAULT '' NOT NULL,
	transactionid varchar(100) DEFAULT '' NOT NULL,
	status tinyint(4) unsigned DEFAULT '0' NOT NULL,
	tablename varchar(150) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY language (l10n_parent,sys_language_uid)

);