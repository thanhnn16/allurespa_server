USE allure_dev;

INSERT INTO users (phone_number, email, password, role, remember_token, full_name, gender, address, date_of_birth, skin_condition, image, note, created_at, updated_at)
VALUES ('1234567890', 'email@example.com', 'password', 'users', 'token', 'Full Name', 0, 'Address', '2000-01-01', 'Normal', 'image_path', 'This is a note', NOW(), NOW()),
       ('1234567891', 'email1@example.com', 'password', 'users', 'token', 'Full Name 1', 0, 'Address 1', '2000-01-01', 'Normal', 'image_path', 'This is a note', NOW(), NOW()),
       ('1234567892', 'email2@example.com', 'password', 'users', 'token', 'Full Name 2', 0, 'Address 2', '2000-01-01', 'Normal', 'image_path', 'This is a note', NOW(), NOW()),
       ('1234567893', 'email3@example.com', 'password', 'users', 'token', 'Full Name 3', 0, 'Address 3', '2000-01-01', 'Normal', 'image_path', 'This is a note', NOW(), NOW()),
       ('1234567894', 'email4@example.com', 'password', 'users', 'token', 'Full Name 4', 0, 'Address 4', '2000-01-01', 'Normal', 'image_path', 'This is a note', NOW(), NOW());


INSERT INTO appointments (user_id, treatment_id, start_date, end_date, is_consultation, is_all_day, status, note, created_at, updated_at)
VALUES (1, 1, NOW(), NOW(), 0, 0, 'scheduled', 'This is a note', NOW(), NOW()),
       (2, 2, NOW(), NOW(), 0, 0, 'scheduled', 'This is a note', NOW(), NOW()),
       (3, 3, NOW(), NOW(), 0, 0, 'scheduled', 'This is a note', NOW(), NOW()),
       (4, 4, NOW(), NOW(), 0, 0, 'scheduled', 'This is a note', NOW(), NOW()),
       (5, 5, NOW(), NOW(), 0, 0, 'scheduled', 'This is a note', NOW(), NOW());

INSERT INTO chats (sender_id, receiver_id, message, sent_at, status, created_at, updated_at)
VALUES (1, 2, 'Hello, how can I help you?', NOW(), 'unseen', NOW(), NOW()),
       (1, 3, 'Hello, how can I help you?', NOW(), 'unseen', NOW(), NOW()),
       (1, 4, 'Hello, how can I help you?', NOW(), 'unseen', NOW(), NOW()),
       (1, 5, 'Hello, how can I help you?', NOW(), 'unseen', NOW(), NOW()),
       (1, 6, 'Hello, how can I help you?', NOW(), 'unseen', NOW(), NOW());

INSERT INTO notifications (user_id, image, content, status, created_at, updated_at)
VALUES (1, 'image_path', 'This is a notification', 'unseen', NOW(), NOW()),
       (2, 'image_path', 'This is a notification', 'unseen', NOW(), NOW()),
       (3, 'image_path', 'This is a notification', 'unseen', NOW(), NOW()),
       (4, 'image_path', 'This is a notification', 'unseen', NOW(), NOW()),
       (5, 'image_path', 'This is a notification', 'unseen', NOW(), NOW());

INSERT INTO favorites (user_id, treatment_id, cosmetics_id, created_at, updated_at)
VALUES (1, 1, 1, NOW(), NOW()),
       (2, 2, 2, NOW(), NOW()),
       (3, 3, 3, NOW(), NOW()),
       (4, 4, 4, NOW(), NOW()),
       (5, 5, 5, NOW(), NOW());

INSERT INTO ratings (user_id, cosmetics_id, treatment_id, text, image, stars, created_at, updated_at)
VALUES (1, 1, 1, 'This is a review', 'image_path', 5, NOW(), NOW()),
       (2, 2, 2, 'This is a review', 'image_path', 4, NOW(), NOW()),
       (3, 3, 3, 'This is a review', 'image_path', 3, NOW(), NOW()),
       (4, 4, 4, 'This is a review', 'image_path', 2, NOW(), NOW()),
       (5, 5, 5, 'This is a review', 'image_path', 1, NOW(), NOW());


-- Insert data into vouchers
INSERT INTO vouchers (code, description, stock, status, used_times, discount_percent, start_date, end_date, created_at, updated_at)
VALUES ('CODE123', 'This is a voucher', 100, 'active', 0, 10, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH), NOW(), NOW()),
       ('CODE124', 'This is a voucher', 100, 'active', 0, 10, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH), NOW(), NOW()),
       ('CODE125', 'This is a voucher', 100, 'active', 0, 10, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH), NOW(), NOW()),
       ('CODE126', 'This is a voucher', 100, 'active', 0, 10, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH), NOW(), NOW()),
       ('CODE127', 'This is a voucher', 100, 'active', 0, 10, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH), NOW(), NOW());

-- Insert data into user_vouchers
INSERT INTO user_vouchers (user_id, voucher_id, used_at, created_at, updated_at)
VALUES (1, 1, NOW(), NOW(), NOW()),
       (2, 2, NOW(), NOW(), NOW()),
       (3, 3, NOW(), NOW(), NOW()),
       (4, 4, NOW(), NOW(), NOW()),
       (5, 5, NOW(), NOW(), NOW());

-- Insert data into invoices
INSERT INTO invoices (user_id, voucher_id, note, status, created_at, updated_at)
VALUES (1, 1, 'This is a note', 'pending', NOW(), NOW()),
       (2, 2, 'This is a note', 'pending', NOW(), NOW()),
       (3, 3, 'This is a note', 'pending', NOW(), NOW()),
       (4, 4, 'This is a note', 'pending', NOW(), NOW()),
       (5, 5, 'This is a note', 'pending', NOW(), NOW());

-- Insert data into invoice_treatments
INSERT INTO invoice_treatments (invoice_id, treatment_id, treatment_quantity, total_amount, created_at, updated_at)
VALUES (1, 1, 1, 1000, NOW(), NOW()),
       (2, 2, 2, 2000, NOW(), NOW()),
       (3, 3, 3, 3000, NOW(), NOW()),
       (4, 4, 4, 4000, NOW(), NOW()),
       (5, 5, 5, 5000, NOW(), NOW());

-- Insert data into invoice_cosmetics
INSERT INTO invoice_cosmetics (invoice_id, cosmetic_id, cosmetic_quantity, total_amount, created_at, updated_at)
VALUES (1, 1, 1, 1000, NOW(), NOW()),
       (2, 2, 2, 2000, NOW(), NOW()),
       (3, 3, 3, 3000, NOW(), NOW()),
       (4, 4, 4, 4000, NOW(), NOW()),
       (5, 5, 5, 5000, NOW(), NOW());

-- Insert data into history
INSERT INTO history (user_id, table_name, row_id, action, action_timestamp)
VALUES (1, 'users', 1, 'insert', NOW()),
       (2, 'users', 2, 'insert', NOW()),
       (3, 'users', 3, 'insert', NOW()),
       (4, 'users', 4, 'insert', NOW()),
       (5, 'users', 5, 'insert', NOW());

update users set role = 'admin' where id = 1;
