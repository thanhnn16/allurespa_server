use allure_dev;

INSERT INTO users (phone_number, email, password, role, full_name, gender, address, date_of_birth, skin_condition, note)
VALUES ('0111111111', 'user1@example.com', '', 'users', 'User One', 1, '123 Street, City, Country', '1990-01-01',
        'Normal', 'No allergies'),
       ('0111111112', 'user2@example.com', '', 'users', 'User Two', 0, '456 Avenue, City, Country', '1992-02-02',
        'Sensitive', 'Allergic to nuts'),
       ('0111111113', 'user3@example.com', '', 'users', 'User Three', 0, '789 Road, City, Country', '1994-04-06', 'Dry',
        'No allergies'),
       ('0111111114', 'user4@example.com', '', 'users', 'User Four', 1, '012 Lane, City, Country', '1994-01-06', 'Oily',
        'Allergic to dust');
INSERT INTO vouchers (code, description, stock, discount_percent, start_date, end_date)
VALUES ('VOUCHER10', '10% off', 100, 10, '2022-01-01 00:00:00', '2024-12-31 23:59:59'),
       ('VOUCHER20', '20% off', 50, 20, '2022-01-01 00:00:00', '2022-12-31 23:59:59'),
       ('VOUCHER30', '30% off', 25, 30, '2022-01-01 00:00:00', '2024-12-31 23:59:59'),
       ('VOUCHER40', '40% off', 10, 40, '2022-01-01 00:00:00', '2022-12-31 23:59:59'),
       ('VOUCHER50', '50% off', 5, 50, '2022-01-01 00:00:00', '2024-12-31 23:59:59');


INSERT INTO invoices (user_id, voucher_id)
VALUES (1, 1),
       (2, 3),
       (3, 2),
       (4, 3),
       (1, 4),
       (2, 5);

INSERT INTO invoice_details (invoice_id, treatment_id, is_cash, cosmetic_id, treatment_quantity, cosmetic_quantity,
                             total_amount, note, status)
VALUES (1, 1, 1, 1, 0, 0, 100000, 'Paid in cash', 'completed'),
       (2, 2, 0, 2, 0, 0, 200000, 'Paid with card', 'processing'),
       (3, 3, 1, 3, 0, 0, 300000, 'Paid in cash', 'completed'),
       (4, 4, 0, 4, 0, 0, 400000, 'Paid with card', 'processing'),
       (5, 3, 1, 5, 0, 0, 500000, 'Paid in cash', 'cancelled'),
       (6, 1, 0, 1, 0, 0, 600000, 'Paid with card', 'pending');

INSERT INTO shopping_cart (cosmetics_id, treatment_id, user_id, quantity)
VALUES (NULL, NULL, 1, 2),
       (NULL, NULL, 2, 1),
       (NULL, NULL, 3, 3),
       (NULL, NULL, 4, 4);

INSERT INTO ratings (user_id, cosmetics_id, treatment_id, text, stars)
VALUES (1, 1, NULL, 'Great service!', 5),
       (2, 2, NULL, 'Good experience', 4),
       (3, NULL, 1, 'Nice place', 3),
       (4, NULL, 2, 'Friendly staff', 2),
       (1, 1, NULL, 'Bad service', 1);

INSERT INTO favorites (user_id, treatment_id, cosmetics_id)
VALUES (1, 1, 2),
       (2, 2, 3),
       (3, 3, 1),
       (4, 4, 2),
       (1, 1, 3);

INSERT INTO notifications (user_id, content)
VALUES (1, 'Your appointment is confirmed'),
       (2, 'Your order is on the way'),
       (3, 'Your order is delivered'),
       (4, 'Your appointment is cancelled'),
       (1, 'Your appointment is confirmed');

INSERT INTO chats (sender_id, receiver_id, message, sent_at)
VALUES (1, 2, 'Hello', NOW()),
       (2, 1, 'Hi', NOW()),
       (3, 4, 'Hello', NOW()),
       (4, 3, 'Hi', NOW()),
       (1, 3, 'Hello', NOW());

INSERT INTO appointments (user_id, treatment_id, start_date, end_date, note)
VALUES (1, 1, '2022-01-01 10:00:00', '2022-01-01 11:00:00', 'First appointment'),
       (2, 2, '2022-01-02 10:00:00', '2022-01-02 11:00:00', 'Second appointment'),
       (3, 1, '2022-01-03 10:00:00', '2022-01-03 11:00:00', 'Third appointment'),
       (4, 3, '2022-01-04 10:00:00', '2022-01-04 11:00:00', 'Fourth appointment'),
       (1, 4, '2022-01-05 10:00:00', '2022-01-05 11:00:00', 'Fifth appointment');

INSERT INTO history (user_id, table_name, row_id, action, action_timestamp)
VALUES (1, 'invoices', 1, 'insert', NOW()),
       (2, 'invoices', 2, 'update', NOW()),
       (3, 'invoices', 3, 'delete', NOW()),
       (4, 'invoices', 4, 'insert', NOW()),
       (1, 'invoices', 5, 'update', NOW());
