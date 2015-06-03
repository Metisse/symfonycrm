SET FOREIGN_KEY_CHECKS=0;

TRUNCATE TABLE invoice_detail;
TRUNCATE TABLE invoice;
TRUNCATE TABLE contact;
TRUNCATE TABLE company;
TRUNCATE TABLE fos_user;
TRUNCATE TABLE province;
TRUNCATE TABLE country;

#Country
INSERT INTO country
  (id, name)
VALUES
  (1, 'Spain');

#Province
INSERT INTO province
  (id, id_country, name)
VALUES
  (1, 1, 'Barcelona'),
  (2, 1, 'Madrid');

#User
INSERT INTO fos_user
  (username, username_canonical, email, email_canonical, enabled, first_name, last_name, password, last_login, roles)
VALUES
  ('admin','admin','admin@test.com','admin@test.com',1,'Admin','Admin','nhDr7OyKlXQju+Ge/WKGrPQ9lPBSUFfpK+B1xqx/+8zLZqRNX0+5G1zBQklXUFy86lCpkAofsExlXiorUcKSNQ==', null, 'a:1:{i:0;s:10:"ROLE_ADMIN";}');

#Company
INSERT INTO company
  (id,id_user,name,tax_code,address,city,id_province,zip_code,id_country,email,phone,fax,website,created_at,updated_at)
VALUES
  (1, 1, 'Test Company 1', 'xxxxxxx', 'C/ Test Company 2', 'Barcelona', 1,'08016', 1, 'test@company1.com', '+34111111111', '+34111111111', 'http://test.company2.com', NOW(), NOW()),
  (2, 1, 'Test Company 2', 'yyyyyyy', 'C/ Test Company 2', 'Madrid', 2, '28001', 1, 'test@company2.com', '+34222222222', '+34222222222', 'http://test.company1.com', NOW(), NOW());

#Contact
INSERT INTO contact
  (id,id_company,id_user,name,surname,email,phone,created_at,updated_at)
VALUES
  (1, 1, 1, 'Chuck', 'Norris', 'gmail@chuck-norris.com', '+34333333333', NOW(), NOW()),
  (2, 2, 1, 'Peter', 'La Anguila', 'peter@la-anguila.com', '+34444444444', NOW(), NOW());

#Invoice
INSERT INTO invoice
  (id,reference,id_company,id_user,total_taxable,total_expenses,total_outlays,vat,tax,is_paid,due_date,created_at,updated_at)
VALUES
  (1, '201500001', 1, 1, 1200.59, 100.59, 100, '21', '9', 0, NOW(), NOW(), NOW()),
  (2, '201500002', 2, 1, 570.34, 0, 0, '21', '9', 0, NOW(), NOW(), NOW());

#Invoice_detail
INSERT INTO invoice_detail
  (id,id_invoice,`type`,description,amount,created_at,updated_at)
VALUES
  (1, 1, 'incoming', 'Service 1', 1000, NOW(), NOW()),
  (2, 1, 'expense', 'Expense 1', 100.59, NOW(), NOW()),
  (3, 1, 'outlay', 'Outlay 1', 100, NOW(), NOW()),
  (4, 2, 'incoming', 'Service 1', 400, NOW(), NOW()),
  (5, 2, 'incoming', 'Service 2', 170.34, NOW(), NOW());
