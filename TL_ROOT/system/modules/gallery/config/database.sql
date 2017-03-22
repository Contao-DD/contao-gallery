-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************


-- --------------------------------------------------------

-- 
-- Table `tl_gallery`
-- 

CREATE TABLE `tl_gallery` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',

  `title` varchar(255) NOT NULL default '',
  `alias` varchar(64) NOT NULL default '',
  `author` int(10) unsigned NOT NULL default '0',
  `date` int(10) unsigned NOT NULL default '0',
	`location` varchar(255) NOT NULL default '',
  `artist` varchar(255) NOT NULL default '',
  `artsize` varchar(255) NOT NULL default '',
  `medium` varchar(32) NOT NULL default '',
  `substrate` varchar(32) NOT NULL default '',

  `description` text NULL,
  `singleSRC` blob NULL,
  `multiSRC` blob NULL,

  `setImages` char(1) NOT NULL default '',
  `posterSize` varchar(255) NOT NULL default '',
  `posterFullsize` char(1) NOT NULL default '',
  `size` varchar(255) NOT NULL default '',
  `imagemargin` varchar(255) NOT NULL default '',
  `perRow` smallint(5) unsigned NOT NULL default '0',
  `perPage` smallint(5) unsigned NOT NULL default '0',
  `sortBy` varchar(32) NOT NULL default '',
  `fullsize` char(1) NOT NULL default '',

  `cssClass` varchar(255) NOT NULL default '',
  `status` varchar(32) NOT NULL default '',
  `noComments` char(1) NOT NULL default '',
  `featured` char(1) NOT NULL default '',

  `published` char(1) NOT NULL default '',
  `start` varchar(10) NOT NULL default '',
  `stop` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_gallery_archive`
-- 

CREATE TABLE `tl_gallery_archive` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL default '0',
  `sorting` int(10) unsigned NOT NULL default '0',
  `tstamp` int(10) unsigned NOT NULL default '0',
 
  `title` varchar(255) NOT NULL default '',
  `description` text NULL,
  `jumpTo` smallint(5) unsigned NOT NULL default '0',

  `pgFilter` smallint(5) unsigned NOT NULL default '0',
  `sortmode` varchar(32) NOT NULL default '',

  `artgroups` blob NULL,

  `allowComments` char(1) NOT NULL default '',
  `notify` varchar(32) NOT NULL default '',
  `template` varchar(32) NOT NULL default '',
  `perPage` smallint(5) unsigned NOT NULL default '0',
  `sortOrder` varchar(32) NOT NULL default '',
  `moderate` char(1) NOT NULL default '',
  `bbcode` char(1) NOT NULL default '',
  `disableCaptcha` char(1) NOT NULL default '',
  `requireLogin` char(1) NOT NULL default '',

  `protected` char(1) NOT NULL default '',
  `groups` blob NULL,

  `makeFeed` char(1) NOT NULL default '',
  `format` varchar(32) NOT NULL default '',
  `language` varchar(32) NOT NULL default '',
  `source` varchar(32) NOT NULL default '',
  `maxItems` smallint(5) unsigned NOT NULL default '0',
  `feedBase` varchar(255) NOT NULL default '',
  `alias` varbinary(128) NOT NULL default '',
  `feeddescription` text NULL,

  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------


-- 
-- Table `tl_member`
-- 

CREATE TABLE `tl_member` (
  `description` text NULL,
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

-- 
-- Table `tl_user_group`
-- 

CREATE TABLE `tl_user_group` (
  `galleries` blob NULL
  `galleryp` blob NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_user`
-- 

CREATE TABLE `tl_user` (
  `galleries` blob NULL
  `galleryp` blob NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_module`
-- 

CREATE TABLE `tl_module` (
  `gallery` smallint(5) unsigned NOT NULL default '0',
  `galleries` smallint(5) unsigned NOT NULL default '0',
  `gallery_archives` blob NULL,
  `gallery_template` varchar(32) NOT NULL default '',
  `gallery_showQuantity` char(1) NOT NULL default '',
  `gallery_numberOfItems` smallint(5) unsigned NOT NULL default '0',
  `gallery_sort` varchar(32) NOT NULL default '',
  `gallery_featured` char(1) NOT NULL default '',

  `gallery_metaFields` varchar(255) NOT NULL default '',

  `gallery_posterSize` varchar(255) NOT NULL default '',
  `gallery_posterFullsize` char(1) NOT NULL default '',
  `gallery_showPreview` char(1) NOT NULL default '',
  `gallery_imagemargin` varchar(255) NOT NULL default '',
  `gallery_size` varchar(255) NOT NULL default '',
  `gallery_perRow` smallint(5) unsigned NOT NULL default '0',
  `gallery_perPage` smallint(5) unsigned NOT NULL default '0',
  `gallery_sortBy` varchar(32) NOT NULL default '',
  `gallery_fullsize` char(1) NOT NULL default '',
  `gallery_numberOfImages` smallint(5) unsigned NOT NULL default '0',

  `gallery_filters` blob NULL,
  `gallery_conditions` blob NULL,

) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

-- 
-- Table `tl_layout`
-- 

CREATE TABLE `tl_layout` (
  `galleryfeeds` blob NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

