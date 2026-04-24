-- Run this in MySQL / phpMyAdmin

-- ADMIN USERS
CREATE TABLE admin_users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  email VARCHAR(255),
  full_name VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- JOURNALS
CREATE TABLE journals (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  slug VARCHAR(255) NOT NULL UNIQUE,          -- e.g. journal-of-biology
  short_name VARCHAR(100),                    -- e.g. JOB
  subject_category VARCHAR(100),              -- Clinical Sciences / Medical Sciences / General Sciences / Engineering
  description TEXT,
  aim_and_scope TEXT,
  cite_score DECIMAL(4,2),
  impact_factor DECIMAL(4,2),
  h_index INT,
  acceptance_time VARCHAR(100),               -- e.g. 7-25 days
  processing_time VARCHAR(100),               -- e.g. 10-20 days
  publishing_time VARCHAR(100),               -- e.g. 15-25 days
  issue_frequency VARCHAR(100),               -- e.g. Bimonthly
  apc_amount DECIMAL(10,2),                   -- e.g. 1019.00
  apc_currency VARCHAR(10) DEFAULT 'EUR',
  withdrawal_fee DECIMAL(10,2),               -- e.g. 219.00
  withdrawal_days INT DEFAULT 5,
  submission_email VARCHAR(255),
  privacy_statement TEXT,
  copyright_text TEXT,
  oa_articles_count INT DEFAULT 0,
  cover_image VARCHAR(255),
  is_active TINYINT DEFAULT 1,
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- EDITORIAL BOARD MEMBERS
CREATE TABLE editors (
  id INT AUTO_INCREMENT PRIMARY KEY,
  journal_id INT NOT NULL,
  full_name VARCHAR(255) NOT NULL,
  role VARCHAR(100),                          -- Editor in Chief / Editor / Associate Editor
  department VARCHAR(255),
  institution VARCHAR(255),
  country VARCHAR(100),
  photo VARCHAR(255),
  email VARCHAR(255),
  bio TEXT,
  sort_order INT DEFAULT 0,
  is_active TINYINT DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (journal_id) REFERENCES journals(id) ON DELETE CASCADE
);

-- ARTICLES
CREATE TABLE articles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  journal_id INT NOT NULL,
  volume INT NOT NULL,
  issue INT NOT NULL,
  title VARCHAR(500) NOT NULL,
  authors TEXT NOT NULL,
  article_type VARCHAR(100),                  -- Research Article / Review Article / Case Report etc.
  abstract TEXT,
  keywords VARCHAR(500),
  pdf_file VARCHAR(255),                      -- path to uploaded PDF
  doi VARCHAR(255),
  pages VARCHAR(50),                          -- e.g. 1-12
  received_date DATE,
  accepted_date DATE,
  published_date DATE,
  views_count INT DEFAULT 0,
  downloads_count INT DEFAULT 0,
  is_retracted TINYINT DEFAULT 0,
  retraction_note TEXT,
  is_published TINYINT DEFAULT 1,
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (journal_id) REFERENCES journals(id) ON DELETE CASCADE
);

-- ARTICLE SUBMISSIONS (from public submission form)
CREATE TABLE submissions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  journal_id INT,
  author_name VARCHAR(255) NOT NULL,
  author_email VARCHAR(255) NOT NULL,
  author_institution VARCHAR(255),
  author_country VARCHAR(100),
  co_authors TEXT,
  article_title VARCHAR(500) NOT NULL,
  article_type VARCHAR(100),
  abstract TEXT,
  keywords VARCHAR(500),
  manuscript_file VARCHAR(255),
  cover_letter TEXT,
  comments TEXT,
  status ENUM('new','under_review','revision_requested','accepted','rejected') DEFAULT 'new',
  admin_notes TEXT,
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (journal_id) REFERENCES journals(id) ON DELETE SET NULL
);

-- TESTIMONIALS
CREATE TABLE testimonials (
  id INT AUTO_INCREMENT PRIMARY KEY,
  journal_id INT,                             -- NULL = homepage testimonial
  reviewer_name VARCHAR(255) NOT NULL,
  reviewer_title VARCHAR(255),
  reviewer_institution VARCHAR(255),
  review_text TEXT NOT NULL,
  rating INT DEFAULT 5,
  is_active TINYINT DEFAULT 1,
  sort_order INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (journal_id) REFERENCES journals(id) ON DELETE SET NULL
);

-- INDEXING PARTNERS (scrolling logos)
CREATE TABLE indexing_partners (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  logo VARCHAR(255),
  website_url VARCHAR(500),
  is_active TINYINT DEFAULT 1,
  sort_order INT DEFAULT 0
);

-- SITE PAGES (editable content blocks)
CREATE TABLE site_pages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  page_key VARCHAR(100) NOT NULL UNIQUE,     -- e.g. homepage_about, homepage_mission
  page_title VARCHAR(255),
  content LONGTEXT,
  meta_title VARCHAR(255),
  meta_description TEXT,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- SITE SETTINGS (key-value store)
CREATE TABLE site_settings (
  setting_key VARCHAR(100) PRIMARY KEY,
  setting_value TEXT,
  setting_label VARCHAR(255),
  setting_type ENUM('text','textarea','email','url','number','image') DEFAULT 'text'
);

-- CONTACT MESSAGES
CREATE TABLE contact_messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100),
  last_name VARCHAR(100),
  email VARCHAR(255) NOT NULL,
  subject VARCHAR(255),
  message TEXT NOT NULL,
  is_read TINYINT DEFAULT 0,
  submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed default admin user (password: Admin@123 — MUST change after first login)
INSERT INTO admin_users (username, password_hash, email, full_name) VALUES
('admin', '$2y$12$6wqTw9SegoUAMiK25cVK1O4KwfhxJ6tNkt433sbywJi/8UqIm6GTy', 'admin@probejournals.com', 'Site Administrator');

-- Seed default site settings
INSERT INTO site_settings (setting_key, setting_value, setting_label, setting_type) VALUES
('site_name', 'Probe Journals', 'Site Name', 'text'),
('site_tagline', 'Global Open Access Scientific and Academic Journals', 'Tagline', 'text'),
('contact_email', 'contact@probejournals.com', 'Contact Email', 'email'),
('publish_email', 'publish@probejournals.com', 'Submissions Email', 'email'),
('phone', '+44 3455007136', 'Phone Number', 'text'),
('address_registered', '91 Ivy Lane, Waltham Cross, United Kingdom, EN8', 'Registered Address', 'textarea'),
('address_main', 'Probe Publisher, 45 Highfield Road, London, UK', 'Main Address', 'textarea'),
('oa_articles_total', '102', 'Total OA Articles', 'number'),
('oa_journals_total', '7', 'Total OA Journals', 'number');

-- Seed all 9 journals
INSERT INTO journals (name, slug, short_name, subject_category, cite_score, impact_factor, h_index, acceptance_time, processing_time, publishing_time, issue_frequency, apc_amount, withdrawal_fee, submission_email, is_active, sort_order) VALUES
('Journal of Biology', 'journal-of-biology', 'JOB', 'General Sciences', 2.45, 4.3, 8, '7-25 days', '10-20 days', '15-25 days', 'Bimonthly', 1019.00, 219.00, 'publish@probejournals.com', 1, 1),
('Journal of Clinical Trials and Case Studies', 'journal-of-clinical-trials-and-case-studies', 'JCTCS', 'Clinical Sciences', 2.10, 3.8, 6, '7-25 days', '10-20 days', '15-25 days', 'Bimonthly', 1019.00, 219.00, 'publish@probejournals.com', 1, 2),
('Global Journal of Clinical Medicine', 'global-journal-of-clinical-medicine', 'GJCM', 'Medical Sciences', 2.20, 3.9, 7, '7-25 days', '10-20 days', '15-25 days', 'Bimonthly', 1019.00, 219.00, 'publish@probejournals.com', 1, 3),
('Research Journal of Neurology', 'research-journal-of-neurology', 'RJN', 'Medical Sciences', 2.30, 4.0, 7, '7-25 days', '10-20 days', '15-25 days', 'Bimonthly', 1019.00, 219.00, 'publish@probejournals.com', 1, 4),
('Journal of Diseases', 'journal-of-diseases', 'JOD', 'Medical Sciences', 2.00, 3.5, 5, '7-25 days', '10-20 days', '15-25 days', 'Bimonthly', 1019.00, 219.00, 'publish@probejournals.com', 1, 5),
('Journal of Infectious Diseases and Therapy', 'journal-of-infectious-diseases-and-therapy', 'JIDT', 'Medical Sciences', 2.15, 3.7, 6, '7-25 days', '10-20 days', '15-25 days', 'Bimonthly', 1019.00, 219.00, 'publish@probejournals.com', 1, 6),
('International Journal of Engineering and Computer Science', 'international-journal-of-engineering-and-computer-science', 'IJECS', 'Engineering', 1.90, 3.2, 5, '7-25 days', '10-20 days', '15-25 days', 'Bimonthly', 1019.00, 219.00, 'publish@probejournals.com', 1, 7),
('Trends in Diabetes Obesity and Metabolism', 'trends-in-diabetes-obesity-and-metabolism', 'TDOM', 'Clinical Sciences', 2.25, 3.9, 6, '7-25 days', '10-20 days', '15-25 days', 'Bimonthly', 1019.00, 219.00, 'publish@probejournals.com', 1, 8),
('Research in Microbiology and Biotechnology', 'research-in-microbiology-and-biotechnology', 'RMB', 'General Sciences', 2.05, 3.4, 5, '7-25 days', '10-20 days', '15-25 days', 'Bimonthly', 1019.00, 219.00, 'publish@probejournals.com', 1, 9);

-- Add DB indexes
CREATE INDEX idx_articles_journal ON articles(journal_id);
CREATE INDEX idx_articles_volume ON articles(journal_id, volume, issue);
CREATE INDEX idx_editors_journal ON editors(journal_id);
CREATE INDEX idx_submissions_status ON submissions(status);
