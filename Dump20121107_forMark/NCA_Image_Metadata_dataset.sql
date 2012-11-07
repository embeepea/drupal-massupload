CREATE DATABASE  IF NOT EXISTS `NCA_Image_Metadata` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `NCA_Image_Metadata`;
-- MySQL dump 10.13  Distrib 5.5.24, for osx10.5 (i386)
--
-- Host: 10.0.1.30    Database: NCA_Image_Metadata
-- ------------------------------------------------------
-- Server version	5.1.61

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dataset`
--

DROP TABLE IF EXISTS `dataset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dataset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `type` varchar(256) DEFAULT NULL,
  `version` varchar(45) DEFAULT NULL,
  `description` varchar(2048) DEFAULT NULL,
  `native_id` varchar(45) DEFAULT NULL,
  `publication_dt` datetime DEFAULT NULL,
  `organization` varchar(128) DEFAULT NULL,
  `access_dt` datetime DEFAULT NULL,
  `url` varchar(128) DEFAULT NULL,
  `data_qualifier` varchar(45) DEFAULT NULL,
  `scale` varchar(45) DEFAULT NULL,
  `spatial_ref_sys` varchar(45) DEFAULT NULL,
  `cite_source` varchar(45) DEFAULT NULL,
  `cite_metadata` varchar(45) DEFAULT NULL,
  `scope` varchar(45) DEFAULT NULL,
  `spatial_extent` varchar(512) DEFAULT NULL,
  `temporal_extent` varchar(512) DEFAULT NULL,
  `vertical_extent` varchar(45) DEFAULT NULL,
  `processing_level` varchar(45) DEFAULT NULL,
  `spatial_res` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dataset`
--

LOCK TABLES `dataset` WRITE;
/*!40000 ALTER TABLE `dataset` DISABLE KEYS */;
INSERT INTO `dataset` VALUES (1,'CMIP3','Simulated',NULL,'Coupled Model Intercomparison Project Phase 3',NULL,NULL,'The Program for Climate Model Diagnosis and Intercomparison (PCMDI)','2012-08-30 00:00:00','http://www-pcmdi.llnl.gov/ipcc/about_ipcc.php',NULL,NULL,NULL,NULL,NULL,NULL,'All grids; 1971 - 1999 for 20th Century runs; 2021 - 2050, 2041 - 2070, and 2070 - 2099 for 21st Century runs',NULL,NULL,NULL,NULL),(2,'CMIP3_TTest','Simulated',NULL,'CMIP3 Multi-model T Test of',NULL,NULL,'CICS-NC',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Subset of CMIP3 models; see git repo for details',NULL,NULL,NULL,NULL),(3,'GHCN-D','Observed',NULL,'Global Historical Climatology Network - Daily',NULL,NULL,'NOAA NCDC/Russ Vose','2011-06-06 00:00:00','ftp://ftp.ncdc.noaa.gov/pub/data/ghcn/daily/',NULL,NULL,NULL,NULL,NULL,NULL,'National','1895-01-01 to 2011-12-31',NULL,NULL,'1 km'),(4,'Climate Division Database','Observed','2 beta','Monthly time series of…',NULL,NULL,'NOAA/NCDC','2011-06-06 00:00:00','ftp://ncdcftp/pub/upload/7days','QA for all elements...','N/A','Geographic coordinates (lat/lon)',NULL,NULL,NULL,'Conterminous U.S.','1895-01-01 to present','Surface',NULL,'5 km'),(5,'NARCCAP','Simulated',NULL,'North American Regional Climate Change Assessment Program',NULL,NULL,'University Corporation for Atmospheric Research (UCAR)',NULL,'http://www.narccap.ucar.edu/data/index.html',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,'PRISM',NULL,NULL,'Parameter-elevation Regressions on Independent Slopes Model',NULL,NULL,'http://www.prism.oregonstate.edu/.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,'IPCC',NULL,NULL,'Global greenhouse gas (GHG) emissions (GtCO2-equivalent per year) from 2000 to 2100',NULL,NULL,'http://www.ipcc-data.org/ddc_co2.html',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,'SURGEDAT ','Observed',NULL,'Maximum observed storm surge data',NULL,NULL,'Southern Regional Climate Center',NULL,'http://surge.srcc.lsu.edu',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,'DATES OF LAKE CHAMPLAIN CLOSING',NULL,NULL,'Data below are for informational and non-scientific purposes only and should be used as such given uncertainty in the historical record of observation location and/or source. Below is a partial record of historical reference sources of the data.\r\nData from 1816-1871 recorded c. 1910 in the U.S. Weather Bureau Climatological Record Book for Burlington, VT, and cited from a older Burlington Free Press clipping (Data sources unknown).\r\n\r\nData from 1872-1886 recorded by Charles E. Allen.\r\n\r\nData from 1886-1906 recorded by cooperative weather observer Mr. W. B. Gates.\r\n\r\nData from 1906 onward recorded by either the U.S. Weather Bureau or National Weather Service.',NULL,NULL,'National Weather Service Forcast Office Burlington, VT',NULL,'http://www.erh.noaa.gov/btv/climo/lakeclose.shtml',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(10,'PSMSL',NULL,NULL,'The PSMSL receives monthly and annual mean values of sea level from\nalmost 200 national authorities, distributed around the world,\nresponsible for sea level monitoring in each country or region.  Data\nfrom each station are entered directly as received from the authority\ninto the PSMSL raw data file for that station (usually called the\nMETRIC file in PSMSL publications).  The monthly and annual means so\nentered for any one year are necessarily required to be measured to a\ncommon datum, although, at this stage, datum continuity between years\nis not essential.  While the PSMSL makes every attempt to spot\ninconsistent or erroneous data, the responsibility for the monthly and\nannual means entered into the METRIC files in this way is entirely that\nof the supplying authority.  A description of data checks routinely\nmade by the PSMSL is given below and in Woodworth, Spencer and Alcock\n(1990) and IOC (1992).',NULL,NULL,'Permanent Service for Mean Sea Level',NULL,'http://www.psmsl.org/data/obtaining/',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,'North American Freezing Level Tracker',NULL,NULL,'Track through time the height of the freezing level above sea level.',NULL,NULL,'Western Regional Climate Center',NULL,'http://www.wrcc.dri.edu/cwd/products/',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(12,'Lake Levels in the Great Salt Lake',NULL,NULL,'Great Salt Lake elevation, estimated and observed, from USGS. Taken from www.greatsaltlakeinfo.org.',NULL,NULL,'Utah Department of Natural Resources',NULL,'http://greatsaltlakeinfo.org/Data/LakeLevels',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(13,'CLIMAS',NULL,NULL,'Climate Assessment for the Southwest',NULL,NULL,'University of Arizona',NULL,'http://www.climas.arizona.edu/feature-articles/february-2009',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(14,'Illinois State Water Survey',NULL,NULL,NULL,NULL,NULL,'Midwest Regional Climate Center',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(15,'CRUTEM3',NULL,NULL,'land air temperature anomalies on a 5° by 5° grid-box basis (to be superceded by CRUTEM4)',NULL,NULL,'University of East Anglia - Climatic Research Unit',NULL,'http://www.cru.uea.ac.uk/cru/data/temperature/#datdow',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,'Integrated Surface Hourly ',NULL,NULL,'DS3505',NULL,NULL,'NOAA/NCDC',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(17,'GLERL',NULL,NULL,NULL,NULL,NULL,'NOAA Great Lakes Environmental Research Laboratory',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(18,'SEAICE',NULL,NULL,'University of Illinois Sea Ice Dataset',NULL,NULL,'University of Illinois',NULL,'http://arctic.atmos.uiuc.edu/SEAICE/',NULL,NULL,NULL,NULL,NULL,NULL,'Northern Hemisphere','1870 to 2011',NULL,NULL,NULL),(19,'GIPL',NULL,'?','Geophysical Institute Permafrost Lab',NULL,NULL,'University of Alaska Fairbanks',NULL,'http://permafrost.gi.alaska.edu/content/modeling',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(20,'ERSST',NULL,NULL,'NOAA Extended Reconstructed Sea Surface Temperature',NULL,NULL,'NOAA/ESRL',NULL,'http://www.esrl.noaa.gov/psd/data/gridded/data.noaa.ersst.html',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(21,'CMIP5 - HadGEM2-ES','Simulated',NULL,'Hadley Centre HADGEM2-ES model (RCP4.5 and Historical simulations)',NULL,NULL,'UK Met Office',NULL,'http://www.metoffice.gov.uk/research/modelling-systems/unified-model/climate-models/hadgem2',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(22,'WRF-ARW',NULL,NULL,'Weather Research and Forecasting - Advanced Research ',NULL,NULL,'University Corporation for Atmospheric Research (UCAR)',NULL,'http://www.mmm.ucar.edu/wrf/users/index.html',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `dataset` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-11-07 13:19:52
