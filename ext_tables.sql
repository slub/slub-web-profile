#
# Table structure for table 'tt_content'
#
CREATE TABLE tt_content (
    irre_parent_uid int(11) DEFAULT '0' NOT NULL,
    irre_parent_table VARCHAR(100) DEFAULT '' NOT NULL,
    tt_content int(11) DEFAULT '0' NOT NULL
);

