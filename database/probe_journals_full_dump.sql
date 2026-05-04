-- MySQL dump 10.13  Distrib 9.6.0, for macos26.3 (arm64)
--
-- Host: localhost    Database: probe_journals
-- ------------------------------------------------------
-- Server version	9.6.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '1059e63e-e17f-11f0-98bb-b032ea014558:1-248';

--
-- Table structure for table `admin_users`
--

DROP TABLE IF EXISTS `admin_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_users`
--

LOCK TABLES `admin_users` WRITE;
/*!40000 ALTER TABLE `admin_users` DISABLE KEYS */;
INSERT INTO `admin_users` VALUES (1,'admin','$2y$12$tDB0koCbir6JTpSnNQrOlutxW7/70XDSE3MMroSA9hYW8EpKLDCBK','admin@probejournals.com','Site Administrator','2026-04-15 17:33:53');
/*!40000 ALTER TABLE `admin_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `journal_id` int NOT NULL,
  `volume` int NOT NULL,
  `issue` int NOT NULL,
  `title` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authors` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abstract` text COLLATE utf8mb4_unicode_ci,
  `keywords` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pdf_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `doi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pages` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `accepted_date` date DEFAULT NULL,
  `published_date` date DEFAULT NULL,
  `views_count` int DEFAULT '0',
  `downloads_count` int DEFAULT '0',
  `is_retracted` tinyint DEFAULT '0',
  `retraction_note` text COLLATE utf8mb4_unicode_ci,
  `is_published` tinyint DEFAULT '1',
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_articles_journal` (`journal_id`),
  KEY `idx_articles_volume` (`journal_id`,`volume`,`issue`),
  CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (12,3,5,1,'A Prospective, Cross-Sectional, Multicenter Pilot Study to Assess the Efficacy of NerveVue...','Michel Smith','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:40:52','2026-05-03 07:40:52'),(13,3,5,1,'Understanding Brain Metastasis: from Molecular Mechanisms to Treatment Advances','Valeria La Rosa Sanchez, Angela Anaid Rios Angulo','Review Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:40:52','2026-05-03 07:40:52'),(14,3,5,1,'Ultrasound-Based Evaluation and Dermoaesthetic Recommendations for Secondary Lymphedema...','Mariantonietta Ariani, Emanuele Bartoletti and Loredana Cavalieri','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:40:52','2026-05-03 07:40:52'),(15,3,5,1,'Clinical and Functional Characteristics in ERM, MPH, ERM-FS, and LMH','Noriko Kubota*','Mini Review',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:40:52','2026-05-03 07:40:52'),(16,3,5,1,'Susceptibility to Aluminium Intoxication, the Male Gender Bias in Autism...','Stephen D. Kette','Mini Review',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:40:52','2026-05-03 07:40:52'),(17,3,5,1,'From Imaging to Prognosis: The prognostic Value of Vascular and Parenchymal Enhancement Patterns...','Francesco Giangregorio','Mini Review',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:40:52','2026-05-03 07:40:52'),(18,3,4,2,'Rare Presentation of Diffuse Large B-Cell Lymphoma in a Young Woman...','Chiung-Chang Liu*, Wei-Cheng Wen, Kuang-Yu Niu','Case Report',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:40:52','2026-05-03 07:40:52'),(19,3,4,2,'The Effect of Curcumin in the Recovery of Severe Traumatic Brain Injury...','Mohammadreza Saatian1, Masoumeh Roustaei1, Ebrahim Jalili2*, etc.','Mini Review',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:40:52','2026-05-03 07:40:52'),(20,3,4,1,'Pulmonary Thromboembolism in COVID-19 Pneumonia: A Case Series and Update','Som Biswas','Case Report',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:40:52','2026-05-03 07:40:52'),(21,3,4,1,'Practice of Extubation in the Emergency Department...','Mohammed Yousuf Iqbal1, Emad A Abdulkarim2, Sarah Albassam3, Fandi Alanazi4','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:40:52','2026-05-03 07:40:52'),(22,3,3,1,'Effects of Lipoprotein (A) in Aortic Dissection Patients...','Hongliang Zhang','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:40:52','2026-05-03 07:40:52'),(23,3,3,1,'Flash Pulmonary Odema-4 Rare Cases of Non-Cardiogenic...','Adheera Singh','Case Report',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:40:52','2026-05-03 07:40:52'),(24,3,3,1,'Latest Investigation on Impulsive Respiration and Developing Phenotypes...','Pavan Kumar','Mini Review',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:40:52','2026-05-03 07:40:52'),(25,3,2,1,'Barriers to the Implementation of Evidence Based Medicine in Ethiopia...','Delelegn Emwodew Yehualashet1,*, Atsike Belay Eshetu2, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:40:52','2026-05-03 07:40:52'),(26,3,2,1,'CT Images of Pyogenic and Amoebic Liver Abscess with K-Means Clustering...','Subhagata Chattopadhyay','Mini Review',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:40:52','2026-05-03 07:40:52'),(27,3,1,1,'A National Pediatric Emergency Medicine Perspective on Improving Education...','Akhila R Mandadi1,*, Kathleen Dully2, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:40:52','2026-05-03 07:40:52'),(28,1,5,1,'Fatty Acid Changes in Patin Waste Oil: Implications for Aquafeed','David John','Brief Commentary',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:57:07','2026-05-03 07:57:07'),(29,1,5,1,'Estimating LUCA’s Population in Hadean Oceans','José Antonio de Freitas Pacheco, Débora Dummer Meira','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:57:07','2026-05-03 07:57:07'),(30,1,5,1,'Comment on the Gadolinium and Chelation Therapy Controversy- An update','E Blaurock-Busch, Yvette M Busch','Commentary',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:57:07','2026-05-03 07:57:07'),(31,1,5,1,'Vimentin Intermediate Filaments Stimulate the Neurite Growth Independently of Mitochondria','Blen Amare Gebreselase, Olga I Parfenteva, Alexander A Minin','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:57:07','2026-05-03 07:57:07'),(32,1,4,1,'Bangla License Plate Detection Using YOLO v8 Model','Sinhad Hossain Fahim, Ahmed Abdal Shafi Rasel, Abdur Rahman Sarker, Tanzia Chowdhury','Review Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:57:07','2026-05-03 07:57:07'),(33,1,3,1,'Indoor and Outdoor Air Concentrations and Personal Exposure for Selected Hazardous Air Pollutants (HAPs) in European Cities','Dimitrios Kotzias','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:57:07','2026-05-03 07:57:07'),(34,1,3,1,'Development of Adaptive Processes of the Brain during Ischemia and Search for Methods of Correction...','Maksimovich N Ye, Bon EI, Martsun PV','Case Report',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:57:07','2026-05-03 07:57:07'),(35,1,2,1,'Sars cov-2 Spike Protein Derivates-ACE LINK-Graphene and Wireless Comunications Radiation...','Luisetto M, Naseer A, Edbey K, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:57:07','2026-05-03 07:57:07'),(36,1,2,1,'Anaerobic and Aerobic Glycolysis - Features of the Course in the Nervous System','Bon EI, Maksimovich N Ye, Dremza IK, etc.','Case Report',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:57:07','2026-05-03 07:57:07'),(37,1,1,1,'Amino Acid Pool Disorders in Rats in the Hippocampus in Modeling Partial Cerebral Ischemia','Bon EI, Maksimovich N Ye, Doroshenko Ye, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 07:57:07','2026-05-03 07:57:07'),(38,4,5,1,'Bilateral Radial Artery Approach for Subclavian Artery Stenting-a Promising Alternative','Tao Qiu','Brief Commentary',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:06:18','2026-05-03 08:06:18'),(39,4,5,1,'Review of Toward Individual Treatment in Cervical Artery Dissection: Subgroup Analysis of the TREAT-CAD Randomized Trial','Josefin E. Kaufmann*, Christopher Traenka, Stefan T. Engelter','Review Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:06:18','2026-05-03 08:06:18'),(40,4,4,1,'Use of 10,000-Fold Effect by a Nitric Oxide Donor (Sodium Nitroprusside) in Motor Neuron Disease via Intrathecal Super Fusion','Vinod Kumar Tewari*, Abhishek Gupta, Devesh Johari and Lori Tewari','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:06:18','2026-05-03 08:06:18'),(41,4,4,1,'Understanding Migraine: Causes, Symptoms and Treatment Options','Barreto George','Mini Review',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:06:18','2026-05-03 08:06:18'),(42,4,3,1,'Neuroimaging Findings of Polycythemia with Secondary Acute Ischemia','Mostafa Nabawy Ahmed Ali','Image Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:06:18','2026-05-03 08:06:18'),(43,4,3,1,'Neurologic Syndromes in Post-partum Women: Posterior Re-versible Encephalopathy Syndrome (PRES) vs. Reversible Cerebral Vasoconstriction Syndrome (RCVS), 2 Sides of One Coin?','Krishnendu Choudhury1* and Sitansu Sekhar Nandi2','Case Report',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:06:18','2026-05-03 08:06:18'),(44,4,2,2,'Multiple Sclerosis in East Africa','Mostafa Nabawy Ahmed Ali','Case Report',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:06:18','2026-05-03 08:06:18'),(45,4,2,2,'Intraparenchymal Hemorrhage Secondary to Rhino Orbital-cerebral Mucormycosis...','Jasper Gerald R. Cubias* and Raymond L. Rosales','Case Report',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:06:18','2026-05-03 08:06:18'),(46,4,2,1,'Fahr’s Syndrome with Hypoparathyroidism Presenting with Acute Ischemic Stroke','Krishnendu Choudhury*, Biswajit Paul, Koushik Ray, and Shibendu Ghosh','Case Report',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:06:18','2026-05-03 08:06:18'),(47,4,2,1,'Factors affecting Vestibular Schwannoma radiosurgery outcomes; First Gamma knife experience from KSA','Bilal Muhammad1*, Abdulaziz AL Hamad1, Marouf Adili1, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:06:18','2026-05-03 08:06:18'),(48,4,1,1,'Exploring Deep Brain Stimulation for Treatment-resistant Tinnitus: A Comprehensive Review','Subachhanda Behuriya','Image Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:06:18','2026-05-03 08:06:18'),(49,4,1,1,'Behçet\'s Disease Presenting as Cerebral Venous Thrombosis','Pratibha Prasad1* and Prem Shanker Verma2','Image Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:06:18','2026-05-03 08:06:18'),(50,5,4,2,'Effectiveness of Incentive Spirometry to Reduce Pulmonary Complications and Improve Respiratory Parameter after Coronary Artery Bypass Graft Surgery: A Narrative Review','Abdullah Ibn Abul Fazal, Kaniz Fatema, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:11:17','2026-05-03 08:11:17'),(51,5,4,2,'Manifestation, Effects and Medicaments of Pemphigus','Mihaela Hinescu','Image Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:11:17','2026-05-03 08:11:17'),(52,5,4,2,'Impact of Preoperative Anemia and Blood Transfusion on Long-Term Survival Outcomes in Colorectal Cancer Surgery','Gupta Abhishek','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:11:17','2026-05-03 08:11:17'),(53,5,4,1,'Overview and Allergic Sensitization of Atopic Dermatitis in a Lebanese Population: A Cross-sectional Study','Carla Irani, Souheil Hallit, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:11:17','2026-05-03 08:11:17'),(54,5,4,1,'Efficacy of Zyclara Cream (3.75% Imiquimod) Once a Day for one Week in Actinic Keratosis of the Face: Results from a Non-Randomized, Open-Label, Prospective Study','Natalee Schors, Pouria Keshoofy, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:11:17','2026-05-03 08:11:17'),(55,5,4,1,'Correlation between ABO/Rhesus Blood Group and a Sickle Cell Disease among Sicklers at the Sickle Cell Center, Alkuwity Teaching Hospital, Sudan','Wisal Abbas, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:11:17','2026-05-03 08:11:17'),(56,5,3,1,'Canary in the Cardiac-Valve Coal Mine: Flow Velocity and Inferred Shear during Prosthetic Valve Closure – Predictors of Blood Damage and Clotting','Lawrence N Scotten, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:11:17','2026-05-03 08:11:17'),(57,5,3,1,'Castleman Disease: Atypical Cause of Pneumonectomy','Mariana Conceição, etc.','Image Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:11:17','2026-05-03 08:11:17'),(58,5,2,1,'Bitumen Exposure and Risk of Leukemia: A Protocol of Systematic Review and Meta-Analysis','Yaser Soleimani, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:11:17','2026-05-03 08:11:17'),(59,5,2,1,'A Comprehensive Study on the Hematological Progression of Sickle Cell Disease Patients with COVID-19 at the Center for Research and Control of Sickle Cell Disease, Bamako','Aldiouma Guindo, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:11:17','2026-05-03 08:11:17'),(60,5,1,1,'Reducing Risks in Large Volume Liposuction: The Role of Oral Anticoagulants in Preventing Thromboembolism','Emmanuel de La Cruz, Brad P. Delacruz','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:11:17','2026-05-03 08:11:17'),(61,5,1,1,'Acceptability of an Online Brief Mindfulness Intervention for Sickle Cell Disease Pain','Seungjun Kim, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:11:17','2026-05-03 08:11:17'),(76,6,5,1,'Bilateral Radial Artery Approach for Subclavian Artery Stenting-a Promising Alternative','Tao Qiu','Brief Commentary',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:16:03','2026-05-03 08:16:03'),(77,6,5,1,'Review of Toward Individual Treatment in Cervical Artery Dissection: Subgroup Analysis of the TREAT-CAD Randomized Trial','Josefin E. Kaufmann, etc.','Review Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:16:03','2026-05-03 08:16:03'),(78,6,4,1,'Use of 10,000-Fold Effect by a Nitric Oxide Donor (Sodium Nitroprusside) in Motor Neuron Disease via Intrathecal Super Fusion','Vinod Kumar Tewari, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:16:03','2026-05-03 08:16:03'),(79,6,4,1,'Understanding Migraine: Causes, Symptoms and Treatment Options','Barreto George','Mini Review',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:16:03','2026-05-03 08:16:03'),(80,6,3,2,'Developing a PANoptosis Signature: Identification of Unique Immunotherapeutic Candidates for Osteosarcoma','Song Zhou, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:16:03','2026-05-03 08:16:03'),(81,6,3,2,'Change in Public Knowledge, Attitude and Practice on Antibiotic use After a Territory-Wide Health Promotion Campaign in Hong Kong','Edmond Ma, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:16:03','2026-05-03 08:16:03'),(82,6,3,1,'A Surgically Based Two Step Dual-Prep Nasal Decolonization Method for Preventing Infection in Long-Term Acute Care Hospital (LTCA)','Logan Walker, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:16:03','2026-05-03 08:16:03'),(83,6,3,1,'Association Between Neutrophil To-Lymphocyte Ratio (NLR) and Outcome of Septic Patients with Atrial Fibrillation (AF)...','Weiyi Tang, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:16:03','2026-05-03 08:16:03'),(84,6,2,2,'A Review on the Self-Administration of Alpha-1 Antitrypsin Therapy','Ana M Escribano Dueñasa, etc.','Review Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:16:03','2026-05-03 08:16:03'),(85,6,2,2,'A Novel Treatment Algorithem for Infected Diabetic Foot Ulcers- One Step Procedure','Gil Genuth, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:16:03','2026-05-03 08:16:03'),(86,6,2,1,'A Novel Approach of IORT: Efficacy and Safety of Intraoperative Radiation Therapy for Locally Advanced Laryngocarcinoma','Qiong Wu, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:16:03','2026-05-03 08:16:03'),(87,6,2,1,'An Anti-SARS-CoV-2 Formula Consisting Volatile Oil from Traditional Chinese Medicine (TCM) Through Inhibiting Multiple Targets In Vitro','Huan Zhang, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:16:03','2026-05-03 08:16:03'),(88,6,1,1,'Pragmatic Evaluation of an Augment to the Dental Operatory Disinfection Bundle','Cayouette MJ, etc.','Research Article',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:16:03','2026-05-03 08:16:03'),(89,6,1,1,'When Immunity is Weakened, Disease Occurs','Sinisa Franjic','Case Report',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,0,NULL,1,0,'2026-05-03 08:16:03','2026-05-03 08:16:03');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint DEFAULT '0',
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `editors`
--

DROP TABLE IF EXISTS `editors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `editors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `journal_id` int NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_editors_journal` (`journal_id`),
  CONSTRAINT `editors_ibfk_1` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `editors`
--

LOCK TABLES `editors` WRITE;
/*!40000 ALTER TABLE `editors` DISABLE KEYS */;
INSERT INTO `editors` VALUES (10,3,'Dr. Abu-Hussein Muhamad','Editor in Chief',NULL,'Department of Pediatric Dentistry, Aesthetics Dental Clinic, Athens, Greece',NULL,NULL,NULL,NULL,0,1,'2026-05-03 07:40:52'),(11,3,'Dr. Alireza Heidari','Editor in chief',NULL,'Faculty of Chemistry, California South University (CSU), Irvine, California, USA',NULL,NULL,NULL,NULL,0,1,'2026-05-03 07:40:52'),(12,3,'Dr. Shrikant Charde','Editor in Chief',NULL,'Vice President, Department of Clinical Pharmacology, Allucent, Cary, United States',NULL,NULL,NULL,NULL,0,1,'2026-05-03 07:40:52'),(13,3,'Dr. RobertoDe Vivo','Editor',NULL,'Department of Veterinary Medicine and Animal Production, University of Naples “Federico II”, Italy',NULL,NULL,NULL,NULL,0,1,'2026-05-03 07:40:52'),(14,3,'Dr. Mukul Machhindra Barwant','Editor',NULL,'Department of Botany, Sanjivani Arts Commerce and Science College, Maharshtra, India',NULL,NULL,NULL,NULL,0,1,'2026-05-03 07:40:52'),(15,3,'Dr. Sukalyan Kumar Kundu','Editor',NULL,'Department of Pharmacy, Jahangirnagar University, Dhaka, Bangladesh',NULL,NULL,NULL,NULL,0,1,'2026-05-03 07:40:52'),(16,3,'Dr. Yi Huang','Sr. Statistical Data Analyst / Editor',NULL,'Radiation Oncology, Washington University, Missouri, United States',NULL,NULL,NULL,NULL,0,1,'2026-05-03 07:40:52'),(17,3,'Dr. Chieh Chen','Editor',NULL,'Division of Family Medicine, Hualien Armed Forces General Hospital, Taiwan',NULL,NULL,NULL,NULL,0,1,'2026-05-03 07:40:52'),(18,1,'Dr. RobertoDe Vivo','Editor',NULL,'Department of Veterinary Medicine and Animal Production, University of Naples \"Federico II\", Italy',NULL,NULL,NULL,NULL,0,1,'2026-05-03 07:57:07'),(19,1,'Dr. Mukul Machhindra Barwant','Editor',NULL,'Department of Botany, Sanjivani Arts Commerce and Science College, India',NULL,NULL,NULL,NULL,0,1,'2026-05-03 07:57:07'),(20,1,'Dr. Sukalyan Kumar Kundu','Editor',NULL,'Department of Pharmacy, Jahangirnagar University, Bangladesh',NULL,NULL,NULL,NULL,0,1,'2026-05-03 07:57:07'),(21,1,'Dr. Yi Huang','Sr. Statistical Data Analyst / Editor',NULL,'Radiation Oncology, Washington University, Missouri, United States',NULL,NULL,NULL,NULL,0,1,'2026-05-03 07:57:07'),(22,1,'Dr. Hongxia Liu','Associated researcher / Editor',NULL,'Institute of Crop Sciences, Chinese Academic of Agricultural Sciences, Beijing, China',NULL,NULL,NULL,NULL,0,1,'2026-05-03 07:57:07'),(23,1,'Dr. Chieh Chen','Editor',NULL,'Division of Family Medicine, Hualien Armed Forces General Hospital, Taiwan',NULL,NULL,NULL,NULL,0,1,'2026-05-03 07:57:07'),(24,4,'Dr. Abu-Hussein Muhamad','Editor in Chief',NULL,'Department of Pediatric Dentistry, Aesthetics Dental Clinic, Athens, Greece',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:06:18'),(25,4,'Dr. Alireza Heidari','Editor in chief',NULL,'Faculty of Chemistry, California South University (CSU), Irvine, California, USA',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:06:18'),(26,4,'Dr. Shrikant Charde','Editor in Chief',NULL,'Vice President, Department of Clinical Pharmacology, Allucent, Cary, United States',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:06:18'),(27,4,'Dr. RobertoDe Vivo','Editor',NULL,'Department of Veterinary Medicine and Animal Production, University of Naples “Federico II”, Italy',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:06:18'),(28,4,'Dr. Mukul Machhindra Barwant','Editor',NULL,'Department of Botany, Sanjivani Arts Commerce and Science College, Maharshtra, India',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:06:18'),(29,4,'Dr. Sukalyan Kumar Kundu','Editor',NULL,'Department of Pharmacy, Jahangirnagar University, Dhaka, Bangladesh',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:06:18'),(30,4,'Dr. Yi Huang','Sr. Statistical Data Analyst / Editor',NULL,'Radiation Oncology, Washington University, Missouri, United States',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:06:18'),(31,4,'Dr. Chieh Chen','Editor',NULL,'Division of Family Medicine, Hualien Armed Forces General Hospital, Taiwan',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:06:18'),(32,5,'Dr. Yi Huang','Sr. Statistical Data Analyst / Editor',NULL,'Radiation Oncology, Washington University, United States',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:11:17'),(33,5,'Dr. Chieh Chen','Editor',NULL,'Division of Family Medicine, Hualien Armed Forces General Hospital, Taiwan',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:11:17'),(34,5,'Dr. Abu-Hussein Muhamad','Editor in Chief',NULL,'Department of Pediatric Dentistry, Aesthetics Dental Clinic, Athens, Greece',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:11:17'),(35,5,'Dr. Alireza Heidari','Editor in chief',NULL,'Faculty of Chemistry, California South University (CSU), Irvine, California, USA',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:11:17'),(36,5,'Dr. Shrikant Charde','Editor in Chief',NULL,'Vice President, Department of Clinical Pharmacology, Allucent, Cary, United States',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:11:17'),(37,5,'Dr. RobertoDe Vivo','Editor',NULL,'Department of Veterinary Medicine and Animal Production, University of Naples “Federico II”, Italy',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:11:17'),(38,5,'Dr. Mukul Machhindra Barwant','Editor',NULL,'Department of Botany, Sanjivani Arts Commerce and Science College, Maharshtra, India',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:11:17'),(39,5,'Dr. Sukalyan Kumar Kundu','Editor',NULL,'Department of Pharmacy, Jahangirnagar University, Dhaka, Bangladesh',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:11:17'),(40,5,'Dr. Yang I. Pachankis','Editor',NULL,'Universal Life Church, Communication University of China, Beijing, China',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:11:17'),(41,5,'Dr. Xudong Zhu','Editor',NULL,'Department of General Surgery, Cancer Hospital of China Medical University, China',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:11:17'),(42,5,'Dr. Lilach Soreq','Editor',NULL,'Marie Curie Research Associate, Department of Molecular Neuroscience, Institute of Neurology, UCL, London, UK',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:11:17'),(43,5,'Dr. Lilach Soreq','Editor',NULL,'Former Sen. Official of the European Commission’s Joint Research Centre, Ispra/Italy',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:11:17'),(44,5,'Dr. Anthony Isiwele','Lecturer / Editor',NULL,'GBS, Leeds Trinity University, 891 Greenford Road, London',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:11:17'),(45,5,'Dr. Mohammed Abdul Qader Mohammed AlMalmi','Dermatologist, Physician specialist / Editor',NULL,'GBS, Leeds Trinity University, 891 Greenford Road, London',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:11:17'),(46,5,'Dr. Luisa Maria Arvide Cambra','Editor',NULL,'University of Almeria, Spain',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:11:17'),(47,5,'Dr. Mofeed Al Nowihi','Editor',NULL,'Faculty of Science, Biology Department, Sana’a University, Yemen',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:11:17'),(48,5,'Dr. Nnodim Johnkennedy','Editor',NULL,'Faculty of Health Science, Department of Medical Laboratory Science, Imo State University, Owerri, Nigeria',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:11:17'),(57,6,'Dr. Abu-Hussein Muhamad','Editor in Chief',NULL,'Department of Pediatric Dentistry, Aesthetics Dental Clinic, Athens, Greece',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:16:03'),(58,6,'Dr. Alireza Heidari','Editor in chief',NULL,'Faculty of Chemistry, California South University (CSU), Irvine, California, USA',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:16:03'),(59,6,'Dr. Shrikant Charde','Editor in Chief',NULL,'Vice President, Department of Clinical Pharmacology, Allucent, Cary, United States',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:16:03'),(60,6,'Dr. RobertoDe Vivo','Editor',NULL,'Department of Veterinary Medicine and Animal Production, University of Naples “Federico II”, Italy',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:16:03'),(61,6,'Dr. Mukul Machhindra Barwant','Editor',NULL,'Department of Botany, Sanjivani Arts Commerce and Science College, Maharshtra, India',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:16:03'),(62,6,'Dr. Sukalyan Kumar Kundu','Editor',NULL,'Department of Pharmacy, Jahangirnagar University, Dhaka, Bangladesh',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:16:03'),(63,6,'Dr. Yi Huang','Sr. Statistical Data Analyst / Editor',NULL,'Radiation Oncology, Washington University, Missouri, United States',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:16:03'),(64,6,'Dr. Chaochao Qin','Editor',NULL,'Oncology Internal Medicine Treatment Unit, Guangyuan Traditional Chinese Medicine Hospital Affiliated to Chengdu University of Traditional Chinese Medicine, Guangyuan, China',NULL,NULL,NULL,NULL,0,1,'2026-05-03 08:16:03'),(65,7,'Dr. Yi Huang','Sr. Statistical Data Analyst / Editor',NULL,'Radiation Oncology, Washington University, United States',NULL,NULL,NULL,NULL,0,1,'2026-05-03 09:05:31'),(66,7,'Dr. Chieh Chen','Editor',NULL,'Division of Family Medicine, Hualien Armed Forces General Hospital, Taiwan',NULL,NULL,NULL,NULL,0,1,'2026-05-03 09:05:31'),(67,8,'Dr. Yi Huang','Sr. Statistical Data Analyst / Editor',NULL,'Radiation Oncology, Washington University, United States',NULL,NULL,NULL,NULL,0,1,'2026-05-03 09:11:58'),(68,8,'Dr. Chieh Chen','Editor',NULL,'Division of Family Medicine, Hualien Armed Forces General Hospital, Taiwan',NULL,NULL,NULL,NULL,0,1,'2026-05-03 09:11:58');
/*!40000 ALTER TABLE `editors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `indexing_partners`
--

DROP TABLE IF EXISTS `indexing_partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `indexing_partners` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint DEFAULT '1',
  `sort_order` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `indexing_partners`
--

LOCK TABLES `indexing_partners` WRITE;
/*!40000 ALTER TABLE `indexing_partners` DISABLE KEYS */;
/*!40000 ALTER TABLE `indexing_partners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journals`
--

DROP TABLE IF EXISTS `journals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `journals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_category` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `aim_and_scope` text COLLATE utf8mb4_unicode_ci,
  `cite_score` decimal(4,2) DEFAULT NULL,
  `impact_factor` decimal(4,2) DEFAULT NULL,
  `h_index` int DEFAULT NULL,
  `acceptance_time` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `processing_time` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `publishing_time` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue_frequency` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apc_amount` decimal(10,2) DEFAULT NULL,
  `apc_currency` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'EUR',
  `withdrawal_fee` decimal(10,2) DEFAULT NULL,
  `withdrawal_days` int DEFAULT '5',
  `submission_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `privacy_statement` text COLLATE utf8mb4_unicode_ci,
  `copyright_text` text COLLATE utf8mb4_unicode_ci,
  `oa_articles_count` int DEFAULT '0',
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint DEFAULT '1',
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `contact_info` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journals`
--

LOCK TABLES `journals` WRITE;
/*!40000 ALTER TABLE `journals` DISABLE KEYS */;
INSERT INTO `journals` VALUES (1,'Journal of Biology','journal-of-biology','JOB','General Sciences','Outstanding research in all fields of biology is published in the open access journal of Biology, whose publication policy combines selection for general appeal and significance with a dedication to providing excellent author services.','Journal of Biology is a broad-scope journal that publishes original research across all areas of biology, alongside a diverse and extensive selection of editorial content. One of the journal\'s core goals is to encourage communication between different branches of biology. It does this by featuring significant findings of broad interest from various fields and by offering editorial articles designed to be highly accessible to non-specialists.\n\nThe journal welcomes research papers that report findings from any area of biology, provided they have a strong claim to general interest. This could be because the discovery represents a major advance within a specific field or because it holds inherent interest for the wider biological community.\n\nThe journal accepting type of articles like research, review, mini review, short communication, commentary, case study, prospective, editorials, book reviews, thesis etc.\n\nIt covers a wide range of topics and is of interest to biologists in many areas of research, including:\n\nBrain and Neuroscience\nCancer Growth and Treatment\nCell Biology\nDevelopmental Biology\nEcology\nImmunology\nMathematical, Computational, Biophysical and Statistical Modeling\nMicrobiology, Molecular Biology, and Biochemistry\nPhysiology\nPharmacodynamics\nAnimal Behavior and Game Theory etc.\n\nAll Articles of Biology publications are made freely and permanently available online as soon as they are published, without any subscription fees or registration requirements.',2.45,4.30,8,'7-25 days','10-20 days','15-25 days','Bimonthly',1019.00,'EUR',219.00,5,'publish@probejournals.com','The names and email addresses entered in this journal site will be used exclusively for the stated purposes of this journal and will not be made available for any other purpose or to any other party.','The journal retains the copyright and any extensions or renewals thereof worldwide, including publication, dissemination, translation, and distribution in all formats and media.',0,NULL,1,1,'2026-04-15 17:33:53','2026-05-03 07:57:07','Registered Address: 91 Ivy Lane, Waltham Cros, United Kingdom, EN8\nAddress: Probe Publisher, 45 Highfield Road LONDON, UK\nEmail: contact@probejournals.com\nPhone: +44 3455007136'),(2,'Journal of Clinical Trials and Case Studies','journal-of-clinical-trials-and-case-studies','JCTCS','Clinical Sciences',NULL,NULL,2.10,3.80,6,'7-25 days','10-20 days','15-25 days','Bimonthly',1019.00,'EUR',219.00,5,'publish@probejournals.com',NULL,NULL,0,NULL,1,2,'2026-04-15 17:33:53','2026-04-15 17:33:53',NULL),(3,'Global Journal of Clinical Medicine','global-journal-of-clinical-medicine','GJCM','Medical Sciences','Global Journal of Clinical Medicine (JCM) is an academic, online, open Access, double-blind peer-reviewed, multidisciplinary area of clinical medicine, the journal focused on both clinical and basic science studies. The journal accepting type of articles like Research, review, mini review, short communication, commentary, case study, prospective, editorials, book reviews, thesis etc. Our goal is to persuade scientists to publish their theoretical and experimental findings in as much detail as they can.','The Global Journal of Clinical Medicine aims to support the global scientific and medical community by encouraging the publication of both experimental and theoretical research in complete detail, ensuring that every study is reproducible, transparent, and scientifically sound.\nOur mission is to promote excellence in clinical science by providing an open-access platform for high-quality research that enhances understanding of disease mechanisms, diagnostics, and therapeutic practices. The journal welcomes manuscripts reporting significant findings from any area of clinical or pre-clinical medicine, particularly those that contribute meaningful advancements or offer broad relevance to healthcare professionals and researchers.\nThe journal accepting type of articles like research, review, mini review, short communication, commentary, case study, prospective, editorials, book reviews, thesis etc.\nThis journal covers all topics related to clinical and pre-clinical practices. Topics of interest include (but are not limited to):\n\nCardiology\nGastroenterology & Hepatopancreatobiliary Medicine\nClinical Neurology\nOncology\nOrthopedics\nEndocrinology & Metabolism\nNephrology & Urology\nEpidemiology & Public Health\nStomatology\nPulmonology\nOphthalmology\nObstetrics & Gynecology\nImmunology\nHematology\nClinical Psychology & Psychiatry\nOtolaryngology\nDermatology\nClinical Pharmacology\n\nAll Articles of Clinical Medicine publications are made freely and permanently available online as soon as they are published, without any subscription fees or registration requirements.',1.61,3.10,8,'07-25 days','10-20 days','15-25 days','Bimonthly',1019.00,'EUR',219.00,5,'publish@probejournals.com','The names and email addresses entered in this journal site will be used exclusively for the stated purposes of this journal and will not be made available for any other purpose or to any other party.','The journal retains the copyright and any extensions or renewals thereof worldwide, including publication, dissemination, translation, and distribution in all formats and media.',0,NULL,1,3,'2026-04-15 17:33:53','2026-05-03 07:46:22','Registered Address: 91 Ivy Lane, Waltham Cros, United Kingdom, EN8\nAddress: 3rd Floor, Stanford, Andheri-West, Mumbai, Maharashtra, 400069\nEmail: publish@probejournals.com\nPhone: +44 3455007136'),(4,'Research Journal of Neurology','research-journal-of-neurology','RJN','Medical Sciences','Research Journal of Neurology (JN) is an academic, online, open Access, double-blind peer- reviewed, journal which publishes on all aspects of clinical neurology from diagnosis to treatment. The journal accepting type of articles like Research, review, mini review, short communication, commentary, case study, prospective, editorials, book reviews, thesis etc. Our goal is to persuade scientists to publish their theoretical and experimental findings in as much detail as they can.','Our mission is to support the scientific community by encouraging the publication of both experimental and theoretical research in full detail, ensuring that studies are reproducible and transparent.\n\nThe journal welcomes research papers that report findings from any area of Neurology, provided they have a strong claim to general interest. This could be because the discovery represents a major advance within a specific field or because it holds inherent interest for the wider biological community.\n\nThe journal accepting type of articles like research, review, mini review, short communication, commentary, case study, prospective, editorials, book reviews, thesis etc.\n\nThis journal covers all topics related to Neurology. Topics of interest include (but are not limited to):\n\nFunctional neurology\nSurgical neurology\nNeurological rehabilitation\nBehavioral neurology\nTraumatic brain injury\nBrain neurology\nNeurological brain disorders\nClinical neurology\nDegenerative neurology\nExperimental neurology\nnovel findings in neural development\nPlasticity\nTransplantation etc.\n\nAll Articles of Neurology publications are made freely and permanently available online as soon as they are published, without any subscription fees or registration requirements.',1.91,3.20,7,'07-25 days','10-20 days','15-25 days','Bimonthly',1019.00,'EUR',219.00,5,'publish@probejournals.com','The names and email addresses entered in this journal site will be used exclusively for the stated purposes of this journal and will not be made available for any other purpose or to any other party.','The journal retains the copyright and any extensions or renewals thereof worldwide, including publication, dissemination, translation, and distribution in all formats and media.',0,NULL,1,4,'2026-04-15 17:33:53','2026-05-03 08:06:18','Registered Address: 91 Ivy Lane, Waltham Cros, United Kingdom, EN8\nAddress: 3rd Floor, Stanford, Andheri-West, Mumbai, Maharashtra, 400069\nEmail: publish@probejournals.com\nPhone: +44 3455007136'),(5,'Journal of Diseases','journal-of-diseases','JOD','Medical Sciences','Journal of Diseases (JD) is an academic, online, open Access, double-blind peer-reviewed, journal which publishes articles on the latest and outstanding research on diseases and conditions. The Journal publishes research related to diagnostics, treatments and management of diseases. The journal accepting type of articles like Research, review, mini review, short communication, commentary, case study, prospective, editorials, book reviews, thesis etc. Our goal is to persuade scientists to publish their theoretical and experimental findings in as much detail as they can.','The Journal of Diseases (JD) is dedicated to delivering authoritative, up-to-date information on the latest developments and emerging trends in the study of diseases and health. The journal provides in-depth insights into the molecular and cellular mechanisms underlying various diseases, with a strong focus on identifying effective therapeutic strategies.\n\nThe journal welcomes research papers that report findings from any area of Neurology, provided they have a strong claim to general interest. This could be because the discovery represents a major advance within a specific field or because it holds inherent interest for the wider biological community.\n\nThe journal accepting type of articles like research, review, mini review, short communication, commentary, case study, prospective, editorials, book reviews, thesis etc.\n\nJournal of Diseases discipline to create a platform for the authors to make their contribution towards the journal and to aid in receiving high impact factor. The Journal wide range of fields which includes research on:\n\nCardiovascular diseases\nGastrointestinal and urological diseases\nEndocrine diseases\nNutritional diseases\nInfectious diseases\nNeurodegenerative diseases\nChronic diseases\nHereditary diseases\nNeuropsychiatric conditions and mental disorders\nImmunology\nRare syndromes\nPathology, therapy and pathogenesis of human diseases\nNeuropsychiatric conditions and mental disorders\nDiseases and society, including patient care etc.\n\nAll Articles of Diseases publications are made freely and permanently available online as soon as they are published, without any subscription fees or registration requirements.',2.91,3.30,8,'07-25 days','10-20 days','15-25 days','Bimonthly',1019.00,'EUR',219.00,5,'publish@probejournals.com','The names and email addresses entered in this journal site will be used exclusively for the stated purposes of this journal and will not be made available for any other purpose or to any other party.','The journal retains the copyright and any extensions or renewals thereof worldwide, including publication, dissemination, translation, and distribution in all formats and media.',0,NULL,1,5,'2026-04-15 17:33:53','2026-05-03 08:11:17','Registered Address: 91 Ivy Lane, Waltham Cros, United Kingdom, EN8\nAddress: Probe Publisher, 45 Highfield Road LONDON, UK\nEmail: contact@probejournals.com\nPhone: +44 3455007136'),(6,'Journal of Infectious Diseases and Therapy','journal-of-infectious-diseases-therapy','JIDT','Medical Sciences','Journal of Infectious Diseases & Therapy (JIDT) is an academic, online, open Access, double-blind peer- reviewed, journal which publishes original clinical and laboratory-based research, as well as reports of clinical trials, reviews, and case reports, all of which deal with the microbiology, immunology, epidemiology, clinical diagnosis, pathogenesis, treatment, and control of infectious diseases, with a focus on those that are most prevalent in underdeveloped nations.','Journal will cover bacterial and fungal infections, viral infections (such as HIV/AIDS and hepatitis), parasitic diseases, tuberculosis and other mycobacterial infections, as well as vaccinations and other preventive or therapeutic interventions.\n\nThe journal welcomes research papers that report findings from any area of biology, provided they have a strong claim to general interest. This could be because the discovery represents a major advance within a specific field or because it holds inherent interest for the wider biological community.\n\nThe journal accepting type of articles like research, review, mini review, short communication, commentary, case study, prospective, editorials, book reviews, thesis etc.\n\nCovering Topics\nJournal of Infectious Diseases & Therapy discipline to create a platform for the authors to make their contribution towards the journal and to aid in receiving high impact factor. The Journal wide range of fields which includes research on:\n\nAcute Flaccid Myelitis\nAdenovirus\nAdult (non-flu) Vaccines\nAnthrax\nAnti-science\nAntimicrobial Stewardship\nAvian Influenza (Bird Flu)\nBiosecurity Issues\nBioterrorism\nBotulism\nBusiness Preparedness\nCampylobacter\nCandida auris\nChagas Disease\nChikungunya\nChildhood Vaccines\nChlamydia\nCholera\nClimate Change\nClostridium difficile\nCOVID-19\nCryptosporidium\nCyclospora\nDengue\nDiagnostics\nDiphtheria\nDual-Use Research\nE coli\nEastern Equine Encephalitis\nEbola\nEnterovirus\nEnterovirus, Non-Polio\nFecal Transplant\nFoodborne Disease\nFungal Infection etc.\n\nAll Articles of Infectious Diseases & Therapy publications are made freely and permanently available online as soon as they are published, without any subscription fees or registration requirements.',2.11,3.00,10,'07-25 days','10-20 days','15-25 days','Bimonthly',1019.00,'EUR',219.00,5,'publish@probejournals.com','The names and email addresses entered in this journal site will be used exclusively for the stated purposes of this journal and will not be made available for any other purpose or to any other party.','The journal retains the copyright and any extensions or renewals thereof worldwide, including publication, dissemination, translation, and distribution in all formats and media.',0,NULL,1,6,'2026-04-15 17:33:53','2026-05-03 08:15:00','Registered Address: 91 Ivy Lane, Waltham Cros, United Kingdom, EN8\nAddress: Probe Publisher, 45 Highfield Road LONDON, UK\nEmail: contact@probejournals.com\nPhone: +44 3455007136'),(7,'International Journal of Engineering and Computer Science','international-journal-of-engineering-and-computer-science','IJECS','Engineering','The International Journal of Engineering and Computer Science (IJECS) is a peer-reviewed, online journal. It is dedicated to the rapid dissemination of high-quality research and review articles in the fields of engineering, computer science, and related technologies.\n\nIJECS offers full online access to all published papers, ensuring that cutting-edge research is readily available to the global scientific community. The journal is committed to maintaining an efficient publication process and strives to publish accepted articles in collaboration with authors.\n\nWe encourage contributions from researchers, scholars, academicians, industry professionals, and consultants. IJECS serves as a platform to support the advancement of science and technology by sharing innovative work and practical applications.','To provide a peer‑reviewed platform for publishing original, high‑quality research in engineering and computer science.\n\nTo disseminate theoretical, methodological, and applied work that advances knowledge in both disciplines.\n\nTo serve as a forum for researchers, practitioners, and academicians to share new ideas, innovations, and findings.\n\nIJECS invites authors to submit original research papers, case studies, review articles etc. that contribute to the progress of theory and practice in computing, engineering, and their real-world applications.\n\nThe journal welcomes submissions across all areas of engineering and computer science, including but not limited to:\n\nArtificial Intelligence\nBioinformatics\nComputational Statistics\nDatabases and Data Mining\nFinancial Engineering\nHardware and Embedded Systems\nImaging and Vision Engineering\nIndustrial Engineering\nInternet and Web Computing\nNetworking and Communications\nOperations Research\nScientific Computing\nSoftware Engineering and Applications etc.\n\nAll Articles of Engineering and Computer Science publications are made freely and permanently available online as soon as they are published, without any subscription fees or registration requirements.',NULL,NULL,NULL,'20-25 days',NULL,'15-25 days','Bimonthly',1019.00,'EUR',219.00,5,'publish@probejournals.com','The names and email addresses entered in this journal site will be used exclusively for the stated purposes of this journal and will not be made available for any other purpose or to any other party.','The journal retains the copyright worldwide, including the rights to publish, translate, and distribute the content in all formats and media.',0,NULL,1,7,'2026-04-15 17:33:53','2026-05-03 09:05:31','Registered Address: 91 Ivy Lane, Waltham Cros, United Kingdom, EN8\nAddress: 3rd Floor, Stanford, Andheri-West, Mumbai, Maharashtra, 400069\nEmail: publish@probejournals.com\nPhone: +44 3455007136'),(8,'Trends in Diabetes Obesity and Metabolism','trends-in-diabetes-obesity-and-metabolism','TDOM','Clinical Sciences','Trends in Diabetes, Obesity and Metabolism (TDOM) is an international, peer-reviewed, open-access journal dedicated to publishing high-quality research on diabetes, obesity, and metabolic disorders across clinical, translational, public health, and technological domains.','The journal aims to capture emerging trends, innovations, and interdisciplinary approaches that address the growing global burden of metabolic diseases. With a special emphasis on novel therapies, digital health, precision medicine, and population-specific research, TDOM serves as a platform for clinicians, researchers, policymakers, and industry professionals worldwide.\n\nThe journal publishes original and impactful work related to:\n\nCore Areas:\nType 1 and Type 2 diabetes mellitus\nObesity and metabolic syndrome\nCardiometabolic disorders\nInsulin resistance and beta-cell biology\nDyslipidemia and NAFLD/NASH\n\nEmerging & Priority Themes:\nDigital diabetes care and telemedicine\nArtificial intelligence and wearable technologies\nPrecision medicine and genomics\nLifestyle, nutrition, and behavioral interventions\nPharmacotherapy and novel drug targets\nBariatric and metabolic surgery\nGestational diabetes and women’s metabolic health\nDiabetes and obesity in LMICs\nHealth systems, policy, and implementation science\n\nArticle Types Accepted:\nOriginal Research Articles\nSystematic Reviews & Meta-Analyses\nNarrative Reviews & Mini-Reviews\nClinical Trials\nShort Communications\nCase Reports / Case Series\nPerspectives & Commentaries\nMethodology Papers\nEditorials (by invitation) etc.',NULL,NULL,NULL,'7-25 days','10-20 days','15-25 days','Bimonthly',1019.00,'EUR',319.00,5,'publish@probejournals.com','The names and email addresses entered in this journal site will be used exclusively for the stated purposes of this journal and will not be made available for any other purpose or to any other party.','The journal retains the copyright worldwide.',0,NULL,1,8,'2026-04-15 17:33:53','2026-05-03 09:11:58','Registered Address: 91 Ivy Lane, Waltham Cros, United Kingdom, EN8\nAddress: 3rd Floor, Stanford, Andheri-West, Mumbai, Maharashtra, 400069\nEmail: publish@probejournals.com\nPhone: +44 3455007136'),(9,'Research in Microbiology and Biotechnology','research-in-microbiology-and-biotechnology','RMB','General Sciences','Research in Microbiology and Biotechnology (RMB) is a peer-reviewed, international scholarly journal dedicated to publishing high-quality original research, reviews, and short communications across all areas of microbiology and biotechnology. The journal aims to serve as a platform for scientists, academicians, clinicians, and industry professionals to disseminate novel findings that advance fundamental knowledge and applied innovations involving microorganisms and biotechnological processes.\n\nRMB covers a broad spectrum of topics including, but not limited to, microbial physiology and genetics, molecular and cellular microbiology, medical and clinical microbiology, environmental and agricultural microbiology, industrial and food microbiology, microbial biotechnology, bioprocess engineering, bioinformatics, genomics, proteomics, and emerging biotechnological applications. The journal particularly encourages interdisciplinary studies that bridge microbiology with biotechnology, nanotechnology, bioengineering, and environmental sciences.\n\nThe journal is committed to maintaining high ethical standards, rigorous peer review, and timely publication. By promoting open scientific communication, RMB seeks to support global research collaboration and contribute to scientific progress and societal benefit.','Research in Microbiology and Biotechnology (RMB) aims to publish high-quality, peer-reviewed research that advances fundamental and applied knowledge in the fields of microbiology and biotechnology. The journal serves as an international platform for researchers, academicians, clinicians, and industry professionals to share innovative scientific findings related to microorganisms and biotechnological applications that contribute to scientific progress, public health, environmental sustainability, and industrial development.\n\nThe journal welcomes original research articles, reviews, mini-reviews, and short communications that address theoretical, experimental, and applied aspects of microbiology and biotechnology etc. Special emphasis is placed on interdisciplinary studies that integrate microbiology with molecular biology, bioengineering, environmental sciences, agriculture, medicine, and industrial processes.\n\nMicrobiology:\nBacteriology, virology, mycology, and parasitology\nMedical and clinical microbiology\nEnvironmental and agricultural microbiology\nMicrobial ecology and diversity\nMicrobial physiology, metabolism, and genetics\nMolecular and cellular microbiology\nAntimicrobial resistance and pathogenesis\nMicrobial biofilms and host–microbe interactions\n\nBiotechnology:\nMicrobial biotechnology and industrial microbiology\nBioprocess engineering and fermentation technology\nGenetic engineering and recombinant DNA technology\nEnzyme technology and biocatalysis\nAgricultural and food biotechnology\nEnvironmental biotechnology and bioremediation\nMedical and pharmaceutical biotechnology\nBioinformatics, genomics, proteomics, and metabolomics\nNanobiotechnology and synthetic biology\n\nArticle Types Accepted:\nOriginal Research Articles\nSystematic Reviews & Meta-Analyses\nNarrative Reviews & Mini-Reviews\nClinical Trials\nShort Communications\nCase Reports / Case Series\nPerspectives & Commentaries\nMethodology Papers\nEditorials (by invitation) etc.',NULL,NULL,NULL,'7-25 days','10-20 days','15-25 days','Bimonthly',1019.00,'EUR',319.00,5,'publish@probejournals.com','The names and email addresses entered in this journal site will be used exclusively for the stated purposes of this journal and will not be made available for any other purpose or to any other party.','The journal retains the copyright and any extensions or renewals thereof worldwide. This includes, but is not limited to, the rights to publish, disseminate, transmit, store, translate, distribute, sell, republish, and use the contribution and its contents in both print and electronic formats, as well as in derivative works.',0,NULL,1,9,'2026-04-15 17:33:53','2026-05-03 09:26:09','Registered Address: 91 Ivy Lane, Waltham Cros, United Kingdom, EN8\nAddress: Probe Publisher, 45 Highfield Road LONDON, UK\nEmail: publish@probejournals.com\nPhone: +44 3455007136');
/*!40000 ALTER TABLE `journals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_pages`
--

DROP TABLE IF EXISTS `site_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_pages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `page_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_key` (`page_key`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_pages`
--

LOCK TABLES `site_pages` WRITE;
/*!40000 ALTER TABLE `site_pages` DISABLE KEYS */;
INSERT INTO `site_pages` VALUES (1,'about_us','About Us','<p>Probe Journals was founded on the principle that research should be accessible to everyone.</p>',NULL,NULL,'2026-04-22 07:33:05'),(2,'membership_content','Membership Information','<p>Details about membership plans and benefits.</p>',NULL,NULL,'2026-04-22 07:33:05'),(3,'services_content','Our Services','<p>Details about publishing and editorial services.</p>',NULL,NULL,'2026-04-22 07:33:05'),(4,'publication_fees','Article Processing Charges','<p>Information about publication fees and waivers.</p>',NULL,NULL,'2026-04-22 07:33:05'),(5,'homepage_about','Homepage About Snippet','<p>Probe Journals is a global, independent, open-access publisher...</p>',NULL,NULL,'2026-04-22 07:33:05'),(6,'homepage_mission','Homepage Mission Snippet','<p>Our mission is to accelerate global scientific progress...</p>',NULL,NULL,'2026-04-22 07:33:05'),(7,'homepage_story','Homepage Story Snippet','<p>Probe Journals was founded with a singular vision...</p>',NULL,NULL,'2026-04-22 07:33:05');
/*!40000 ALTER TABLE `site_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_settings` (
  `setting_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_unicode_ci,
  `setting_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `setting_type` enum('text','textarea','email','url','number','image') COLLATE utf8mb4_unicode_ci DEFAULT 'text',
  PRIMARY KEY (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
INSERT INTO `site_settings` VALUES ('address_main','Probe Publisher, 45 Highfield Road, London, UK','Main Address','textarea'),('address_registered','91 Ivy Lane, Waltham Cross, United Kingdom, EN8','Registered Address','textarea'),('contact_email','contact@probejournals.com','Contact Email','email'),('oa_articles_total','102','Total OA Articles','number'),('oa_journals_total','9','Total OA Journals','number'),('phone','+44 3455007136','Phone Number','text'),('publish_email','publish@probejournals.com','Submissions Email','email'),('site_name','Probe Journals','Site Name','text'),('site_tagline','Global Open Access Scientific and Academic Journals','Tagline','text');
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submissions`
--

DROP TABLE IF EXISTS `submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `journal_id` int DEFAULT NULL,
  `author_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_country` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `co_authors` text COLLATE utf8mb4_unicode_ci,
  `article_title` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `article_type` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abstract` text COLLATE utf8mb4_unicode_ci,
  `keywords` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manuscript_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cover_letter` text COLLATE utf8mb4_unicode_ci,
  `comments` text COLLATE utf8mb4_unicode_ci,
  `status` enum('new','under_review','revision_requested','accepted','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `journal_id` (`journal_id`),
  KEY `idx_submissions_status` (`status`),
  CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submissions`
--

LOCK TABLES `submissions` WRITE;
/*!40000 ALTER TABLE `submissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `testimonials` (
  `id` int NOT NULL AUTO_INCREMENT,
  `journal_id` int DEFAULT NULL,
  `reviewer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reviewer_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reviewer_institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `review_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int DEFAULT '5',
  `is_active` tinyint DEFAULT '1',
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `journal_id` (`journal_id`),
  CONSTRAINT `testimonials_ibfk_1` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonials`
--

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` VALUES (1,NULL,'Sinisa Franjic',NULL,'Independent Researcher','Publishing with the Journal of Infectious Diseases & Therapy was a smooth and rewarding experience.',5,1,0,'2026-05-03 08:16:03'),(2,NULL,'Schmidt MG',NULL,'Medical University of South Carolina','I found the submission process to be very straightforward.',5,1,0,'2026-05-03 08:16:03');
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-04 12:09:34
