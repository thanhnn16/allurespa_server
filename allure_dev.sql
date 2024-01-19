# Create database
drop schema if exists allure_dev;
create database allure_dev;
use allure_dev;
#
# Create tables
CREATE TABLE treatment_categories
(
    id                      INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    treatment_category_name VARCHAR(255)                   NOT NULL,
    created_at              DATETIME                       NOT NULL DEFAULT NOW(),
    updated_at              DATETIME                       NOT NULL DEFAULT NOW()
);

CREATE TABLE treatments
(
    id                    INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    treatment_name        VARCHAR(255)                   NOT NULL,
    treatment_category_id INT                            NOT NULL,
    description           TEXT,
    execution_time        TEXT                           NOT NULL,
    price                 integer                        NOT NULL,
    image                 VARCHAR(255),
    created_at            DATETIME                       NOT NULL DEFAULT NOW(),
    updated_at            DATETIME                       NOT NULL DEFAULT NOW(),
    FOREIGN KEY (treatment_category_id) REFERENCES treatment_categories (id)
);

CREATE TABLE cosmetic_categories
(
    id                     INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    cosmetic_category_name VARCHAR(255)                   NOT NULL,
    created_at             DATETIME                       NOT NULL DEFAULT NOW(),
    updated_at             DATETIME                       NOT NULL DEFAULT NOW()
);

CREATE TABLE cosmetics
(
    id                   INT PRIMARY KEY AUTO_INCREMENT,
    cosmetic_name        VARCHAR(255) NOT NULL,
    cosmetic_category_id INT          NOT NULL,
    description          TEXT,
    price                integer      NOT NULL,
    purpose              TEXT,
    ingredients          TEXT,
    how_to_use           TEXT,
    image                VARCHAR(255),
    created_at           DATETIME     NOT NULL DEFAULT NOW(),
    updated_at           DATETIME     NOT NULL DEFAULT NOW(),
    FOREIGN KEY (cosmetic_category_id) REFERENCES cosmetic_categories (id)
);

CREATE TABLE users
(
    id             INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    phone_number   VARCHAR(15)                    NOT NULL UNIQUE,
    email          VARCHAR(255),
    password       TEXT                           NOT NULL,
    role           ENUM ('admin', 'users')        NOT NULL DEFAULT 'users',
    remember_token VARCHAR(100),
    full_name      VARCHAR(255),
    gender         TINYINT(1)                              DEFAULT 0,
    address        TEXT,
    date_of_birth  DATE,
    skin_condition TEXT,
    image          VARCHAR(255),
    note           TEXT,
    created_at     DATETIME                       NOT NULL DEFAULT NOW(),
    updated_at     DATETIME                       NOT NULL DEFAULT NOW()
);

CREATE TABLE inventory_in
(
    id            INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    cosmetic_id   INT                            NOT NULL,
    quantity      INT                            NOT NULL,
    user_id INT NOT NULL,
    date          DATETIME                       NOT NULL DEFAULT NOW(),
    FOREIGN KEY (cosmetic_id) REFERENCES cosmetics (id),
    FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE inventory_out
(
    id            INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    cosmetic_id   INT                            NOT NULL,
    quantity      INT                            NOT NULL,
    user_id INT NOT NULL,
    date          DATETIME                       NOT NULL DEFAULT NOW(),
    FOREIGN KEY (cosmetic_id) REFERENCES cosmetics (id),
    FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE vouchers
(
    id               INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    code             VARCHAR(255)                   NOT NULL UNIQUE,
    description      TEXT,
    stock            INT                            NOT NULL DEFAULT 0,
    status           ENUM ('active', 'inactive')    NOT NULL DEFAULT 'active',
    used_times       INT                            NOT NULL DEFAULT 0,
    discount_percent INT                            NOT NULL,
    start_date       DATETIME                       NOT NULL,
    end_date         DATETIME                       NOT NULL,
    created_at       DATETIME                       NOT NULL DEFAULT NOW(),
    updated_at       DATETIME                       NOT NULL DEFAULT NOW()
);

CREATE TABLE user_vouchers
(
    user_id    INT      NOT NULL,
    voucher_id INT      NOT NULL,
    used_at    DATETIME,
    created_at DATETIME NOT NULL DEFAULT NOW(),
    updated_at DATETIME NOT NULL DEFAULT NOW(),
    PRIMARY KEY (user_id, voucher_id),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (voucher_id) REFERENCES vouchers (id)
);

CREATE TABLE invoices
(
    id         INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user_id    INT             NOT NULL,
    voucher_id INT,
    note               VARCHAR(255),
    status             ENUM ('pending', 'processing', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    created_at DATETIME        NOT NULL DEFAULT NOW(),
    updated_at DATETIME        NOT NULL DEFAULT NOW(),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (voucher_id) REFERENCES vouchers (id)
);

CREATE TABLE invoice_treatments
(
    id                 INT PRIMARY KEY AUTO_INCREMENT                           NOT NULL,
    invoice_id         INT                                                      NOT NULL,
    treatment_id       INT                                                      NOT NULL,
    treatment_quantity INT                                                      NOT NULL,
    total_amount       integer                                                  NOT NULL,
    created_at         DATETIME                                                 NOT NULL DEFAULT NOW(),
    updated_at         DATETIME                                                 NOT NULL DEFAULT NOW(),
    FOREIGN KEY (invoice_id) REFERENCES invoices (id),
    FOREIGN KEY (treatment_id) REFERENCES treatments (id)
);

CREATE TABLE invoice_cosmetics
(
    id                 INT PRIMARY KEY AUTO_INCREMENT                           NOT NULL,
    invoice_id         INT                                                      NOT NULL,
    cosmetic_id        INT                                                      NOT NULL,
    cosmetic_quantity  INT                                                      NOT NULL,
    total_amount       integer                                                  NOT NULL,
    created_at         DATETIME                                                 NOT NULL DEFAULT NOW(),
    updated_at         DATETIME                                                 NOT NULL DEFAULT NOW(),
    FOREIGN KEY (invoice_id) REFERENCES invoices (id),
    FOREIGN KEY (cosmetic_id) REFERENCES cosmetics (id)
);

CREATE TABLE shopping_cart
(
    id           INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    cosmetics_id INT,
    treatment_id INT,
    user_id      INT                            NOT NULL,
    quantity     INT                            NOT NULL,
    created_at   DATETIME                       NOT NULL DEFAULT NOW(),
    updated_at   DATETIME                       NOT NULL DEFAULT NOW(),
    FOREIGN KEY (cosmetics_id) REFERENCES cosmetics (id),
    FOREIGN KEY (treatment_id) REFERENCES treatments (id),
    FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE ratings
(
    id           INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_id      INT                            NOT NULL,
    cosmetics_id INT,
    treatment_id INT,
    text         TEXT                           NOT NULL,
    image        VARCHAR(255),
    stars        INT                            NOT NULL CHECK (stars >= 1 AND stars <= 5),
    created_at   DATETIME                       NOT NULL DEFAULT NOW(),
    updated_at   DATETIME                       NOT NULL DEFAULT NOW(),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (cosmetics_id) REFERENCES cosmetics (id),
    FOREIGN KEY (treatment_id) REFERENCES treatments (id)
);

CREATE TABLE favorites
(
    id           INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_id      INT                            NOT NULL,
    treatment_id INT,
    cosmetics_id INT,
    created_at   DATETIME                       NOT NULL DEFAULT NOW(),
    updated_at   DATETIME                       NOT NULL DEFAULT NOW(),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (treatment_id) REFERENCES treatments (id),
    FOREIGN KEY (cosmetics_id) REFERENCES cosmetics (id)
);

CREATE TABLE notifications
(
    id         INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_id    INT                            NOT NULL,
    image      VARCHAR(255),
    content    TEXT                           NOT NULL,
    status     ENUM ('seen', 'unseen')        NOT NULL DEFAULT 'unseen',
    created_at DATETIME                       NOT NULL DEFAULT NOW(),
    updated_at DATETIME                       NOT NULL DEFAULT NOW(),
    FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE chats
(
    id          INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    sender_id   INT                            NOT NULL,
    receiver_id INT                            NOT NULL,
    message     TEXT                           NOT NULL,
    sent_at     DATETIME                       NOT NULL,
    status      ENUM ('seen', 'unseen')        NOT NULL DEFAULT 'unseen',
    created_at  DATETIME                       NOT NULL DEFAULT NOW(),
    updated_at  DATETIME                       NOT NULL DEFAULT NOW(),
    FOREIGN KEY (sender_id) REFERENCES users (id),
    FOREIGN KEY (receiver_id) REFERENCES users (id)
);

CREATE TABLE appointments
(
    id              INT PRIMARY KEY AUTO_INCREMENT                          NOT NULL,
    user_id         INT                                                     NOT NULL,
    treatment_id    INT                                                     NULL,
    start_date      DATETIME                                                NOT NULL,
    end_date        DATETIME                                                NOT NULL,
    is_consultation TINYINT(1)                                              NOT NULL DEFAULT 0,
    is_all_day      TINYINT(1)                                              NOT NULL DEFAULT 0,
    status          ENUM ('pending', 'scheduled', 'completed', 'cancelled') NOT NULL DEFAULT 'pending',
    note            TEXT,
    created_at      DATETIME                                                NOT NULL DEFAULT NOW(),
    updated_at      DATETIME                                                NOT NULL DEFAULT NOW(),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (treatment_id) REFERENCES treatments (id)
);

CREATE TABLE history
(
    id               INT PRIMARY KEY AUTO_INCREMENT      NOT NULL,
    user_id          INT                                 NOT NULL,
    table_name       VARCHAR(255)                        NOT NULL,
    row_id           INT                                 NOT NULL,
    action           ENUM ('insert', 'update', 'delete') NOT NULL,
    action_timestamp DATETIME                            NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users (id)
);

# Insert default data

INSERT INTO treatment_categories (treatment_category_name, created_at, updated_at)
VALUES ('FACIAL', NOW(), NOW()),
       ('MASSAGE', NOW(), NOW()),
       ('Giảm béo gói 10 lần', NOW(), NOW()),
       ('Triệt lông gói 10 lần', NOW(), NOW()),
       ('Gói VIP', NOW(), NOW());
INSERT INTO treatments (treatment_name, treatment_category_id, description, execution_time, price, image, created_at,
                        updated_at)
VALUES ('Facial Photo', 1, 'Chống lão hóa và phục hồi lão hóa da bằng ánh sáng photo', '45 phút', 1750000, './uploads/img/treatments/photo_facial.jpg', NOW(), NOW()),
       ('Facial Illustrious', 1, 'Dưỡng trắng - trị nám ILLUSTRIOUS', '80 phút', 3200000, './uploads/img/treatments/bionic_mask.jpg', NOW(), NOW()),
       ('Facial Amino', 1, 'Chống nhăn, thăm mụn, và nâng cơ cải thiện cấu trúc da', '60 phút', 2150000, './uploads/img/treatments/amino.jpg', NOW(), NOW()),
       ('Facil Collagen Tươi', 1, 'Hồi sinh làn da từ Collagen tươi', '55 phút', 1950000, './uploads/img/treatments/collagen.jpg', NOW(), NOW()),
       ('Facial Rose De Mer', 1, 'Pelling bằng phương pháp vật lý', '70 phút', 3950000, './uploads/img/treatments/rose_de_mer.png', NOW(), NOW()),
       ('Massage Body 1', 2, 'Thư giãn toàn thân', '65 phút', 450000, './uploads/img/treatments/massage_giam_mo.png', NOW(), NOW()),
       ('Massage Body 2', 2, 'Thải độc ruột', '55 phút', 750000, './uploads/img/treatments/massage_2.jpg', NOW(), NOW()),
       ('Massage Body 3', 2, 'Nâng cơ vòng 1', '65 phút', 950000, './uploads/img/treatments/massage_3.jpg', NOW(), NOW()),
       ('Gội đầu thư giãn', 2, 'Gội đầu thư giãn (đầu, cổ, vai, gáy)', '65 phút', 190000, './uploads/img/treatments/goidau.jpg', NOW(), NOW()),
       ('Giảm béo gói 10 lần: Bụng', 3, 'Giảm béo gói 10 lần: Bụng', '55 phút', 8500000, './uploads/img/treatments/massage_giam_mo.png', NOW(), NOW()),
       ('Giảm béo gói 10 lần: Eo', 3, 'Giảm béo gói 10 lần: Eo', '45 phút', 6500000, './uploads/img/treatments/massage_giam_mo.png', NOW(), NOW()),
       ('Giảm béo gói 10 lần: Lưng', 3, 'Giảm béo gói 10 lần: Lưng', '55 phút', 5500000, './uploads/img/treatments/massage_giam_mo.png', NOW(), NOW()),
       ('Giảm béo gói 10 lần: Tay', 3, 'Giảm béo gói 10 lần: Tay', '45 phút', 5500000, './uploads/img/treatments/massage_giam_mo.png', NOW(), NOW()),
       ('Giảm béo gói 10 lần: Chân', 3, 'Giảm béo gói 10 lần: Chân', '55 phút', 7500000, './uploads/img/treatments/massage_giam_mo.png', NOW(), NOW()),
       ('Giảm béo gói 10 lần: Mông', 3, 'Giảm béo gói 10 lần: Mông', '40 phút', 6500000, './uploads/img/treatments/massage_giam_mo.png', NOW(), NOW()),
       ('Triệt lông gói 10 lần: Nách', 4, 'Triệt lông gói 10 lần: Nách', '35 phút', 4500000, './uploads/img/treatments/trietlong.jpg', NOW(), NOW()),
       ('Triệt lông gói 10 lần: Bikini', 4, 'Triệt lông gói 10 lần: Bikini', '45 phút', 12500000, './uploads/img/treatments/trietlong.jpg', NOW(), NOW()),
       ('Triệt lông gói 10 lần: Mặt', 4, 'Triệt lông gói 10 lần: Mặt', '45 phút', 11500000, './uploads/img/treatments/trietlong.jpg', NOW(), NOW()),
       ('Triệt lông gói 10 lần: Chân', 4, 'Triệt lông gói 10 lần: Chân', '65 phút', 14500000, './uploads/img/treatments/trietlong.jpg', NOW(), NOW()),
       ('Triệt lông gói 10 lần: Tay', 4, 'Triệt lông gói 10 lần: Tay', '45 phút', 11500000, './uploads/img/treatments/trietlong.jpg', NOW(), NOW()),
       ('Triệt lông gói 10 lần: Toàn thân', 4, 'Triệt lông gói 10 lần: Toàn thân', '95 phút', 35000000, './uploads/img/treatments/trietlong.jpg', NOW(), NOW()),
       ('Gói VIP 1', 5, '5 Amino, 5 Collegen tươi, 2 Rose Demer, 3 massage body', '2 năm', 19500000, './uploads/img/treatments/vip.png', NOW(), NOW()),
       ('Gói VIP 2', 5, '10 Amino, 10 Collagen tươi, 2 Photo, 2 Rose, 5 massage', '2 năm', 39000000, './uploads/img/treatments/vip.png', NOW(), NOW()),
       ('Gói VIP 3', 5, '20 Amino, 20 Collagen tươi, 5 rose demer, 15 massage body', '2 năm', 59700000, './uploads/img/treatments/vip.png', NOW(),
        NOW()),
       ('Gói VIP 4', 5, '20 Amino, 20 Collagen tươi, 5 rose demer, 15 massage body', '1 năm', 79500000, './uploads/img/treatments/vip.png', NOW(),
        NOW()),
       ('Gói VIP 5', 5, '1 năm sử dụng toàn bộ dịch vụ', '1 năm', 99500000, './uploads/img/treatments/vip.png', NOW(), NOW());
INSERT INTO cosmetic_categories (cosmetic_category_name, created_at, updated_at)
VALUES ('Celbest', NOW(), NOW()),
       ('Faith', NOW(), NOW());

INSERT INTO cosmetics (cosmetic_name, cosmetic_category_id, description, price, purpose, ingredients, how_to_use,
                       image, created_at, updated_at)
VALUES ('Tinh chất LIPOCOLLAGE LAMELLAR', 1,
        'Tăng hiệu quả gấp 6 lần so với mỹ phẩm có chứa Collagen (phục hồi, bảo vệ và giữ nước cho làn da). Sửa lại lớp Lamella đã bị hỏng.',
        1000000,
        ' Làm trắng da, xoá tan nếp nhăn, đánh bay vết thâm quầng có trên khoé mắt. Ngăn ngừa mụn trứng cá và làm đầy lớp sẹo do mụn trứng cá để lại, mờ các vết sẹo và vết thâm trên da. Đặc biệt sẽ giúp nâng cơ mặt giúp khuôn mặt thon gọn tự nhiên hơn.', 'FAITH NANO COLLAGEN TƯƠI,FAITH NANO COLLAGEN GELATIN.VITAMIN C GLYCOSID.
    CHIẾT XUẤT HOA RÂU DÊ (MEADOWSWEET). CHIẾT XUẤT HẠT NHÃN.',
        'Nhấn 3-4 lần để lấy lượng gel vừa đủ vào lòng bàn tay. Thoa đều lên vùng da cần tẩy trang, kể cả mắt và môi sau đó massage da thật nhẹ nhàng. Rửa sạch bằng nước lạnh hoặc hơi ấm. Không cần dùng bông tẩy trang.',
        './uploads/img/cosmetics/lamellar_essence.jpg', NOW(), NOW()),
       ('CLEANSING LIPOCOLLAGE LAMELLAR', 2,
        'Gel tẩy trang sạch – dịu – nhẹ. Dùng cho cả mắt và môi. Tẩy sạch cả lớp trang điểm không thấm nước khó trôi.',
        1560000, 'Gel tẩy lớp trang điểm, vết bụi bẩn, lớp nhờn(dầu), bám trên da mặt duy trì làn da trắng đẹp.',
        'Hyaluronic Acid, Chiết xuất rễ nhân sâm, Elastin. Chiết xuất rễ cam thảo (Axit Glycyrrhizic 2K), chiết xuất lá diếp cá, chiết xuất đinh hương, chiết xuất hương thảo, nước hoa hồng Damask. Latic Acid. Faith Gelatin Collagen. Chiết xuất hạt sơ ri.',
        'Nhấn 3-4 lần để lấy lượng gel vừa đủ vào lòng bàn tay. Thoa đều lên vùng da cần tẩy trang, kể cả mắt và môi sau đó massage da thật nhẹ nhàng. Rửa sạch bằng nước lạnh hoặc hơi ấm. Không cần dùng bông tẩy trang.',
        './uploads/img/cosmetics/cleansing.jpg', NOW(), NOW()),
       ('SERUM DƯỠNG ẨM', 2,
        'Sản phẩm chứa Gelatin Collagen đã được cấp bằng sáng chế của Faith, toner thấm sâu vào lớp sừng của da để hydrat hóa từ trong ra ngoài và kích thích tăng sinh collagen và bảo vệ các lớp trong cùng của da. Da mềm mại, bổ sung và tươi sáng, với sự cân bằng độ pH được khôi phục.',
        2000000, 'Kem dưỡng ẩm bổ sung độ ẩm giúp làn da trở nên săn chắc.',
        'GLUCOSYLCERAMIDE. ACETYL HYDROXYPROLINE. HYDROLYZED PRUNUS DOMESTICA. PUNICA GRANATUM FRUIT EXTRACT.',
        'Xịt một lượng nhỏ ra lòng bàn tay hoặc vào một miếng bông. Quét lên toàn bộ khuôn mặt và vỗ nhẹ. Sử dụng ngày và đêm.',
        './uploads/img/cosmetics/serum_duong_am.jpg', NOW(), NOW()),
       ('HYDRATING TONIC(BỘT DƯỠNG ẨM)', 2,
        'Sản phẩm chứa Gelatin Collagen đã được cấp bằng sáng chế của Faith, toner thấm sâu vào lớp sừng của da để hydrat hóa từ trong ra ngoài và kích thích tăng sinh collagen và bảo vệ các lớp trong cùng của da. Da mềm mại, bổ sung và tươi sáng, với sự cân bằng độ pH được khôi phục.',
        1366000, 'Kem dưỡng ẩm bổ sung độ ẩm giúp làn da trở nên săn chắc.',
        'GLUCOSYLCERAMIDE. ACETYL HYDROXYPROLINE. HYDROLYZED PRUNUS DOMESTICA. PUNICA GRANATUM FRUIT EXTRACT.',
        'Xịt một lượng nhỏ ra lòng bàn tay hoặc vào một miếng bông. Quét lên toàn bộ khuôn mặt và vỗ nhẹ. Sử dụng ngày và đêm.',
        './uploads/img/cosmetics/hydrating_tonic.jpg', NOW(), NOW()),
       ('CALMING & MOIST PACK', 2,
        'Cấp nước cho làn da bị kích ứng bằng mặt nạ dạng gel thay thế chứa nhiều lợi ích chống lão hóa của collagen. Tế bào da chết, bụi bẩn và các chất ô nhiễm khác được loại bỏ nhẹ nhàng khỏi lỗ chân lông đồng thời độ ẩm được bổ sung. Một cảm giác nhẹ nhàng chảy khắp da, giúp da dịu lại, thoải mái và tái tạo.',
        2550000,
        'Gói gel bổ sung độ ẩm chăm sóc làn da mỏng manh. Loại bỏ bụi bẩn từ lỗ chân lông, giúp da ẩm mịn.',
        'SECTOIN. CITRULLUS VULGARIS FRUIT EXTRACT. ALLANTOIN. MAGNESIUM ASCORBYL PHOSPHATE. FUCUS VESICULOSUS EXTRACT. PROTEOGLYCAN.',
        'Sử dụng một hoặc hai lần một tuần sau khi rửa mặt. Bóp một lượng mặt nạ cỡ 1/4 vào lòng bàn tay. Tán một lớp dày khắp mặt – tránh vùng mắt và môi. Để trong năm phút. Rửa sạch bằng nước mát hoặc ấm.',
        './uploads/img/cosmetics/calming_moist.jpg', NOW(), NOW()),
       ('NOURISHING GEL(GEL NUÔI DƯỠNG)', 2,
        'Kem dưỡng ẩm giúp da trở nên mềm mại, rạng rỡ và tăng độ đàn hồi. Sản phẩm chứa Faith Gelatin Collagen được cấp bằng sáng chế độc quyền của Faith, khắc phục tình trạng thô ráp và mất nước.',
        1999000, 'Kem dạng gel chống thô ráp và mất nước cho da. Giúp da mịn màng, căng tràn sức sống.',
        'MEADOWSWEET. ACETYL HYDROXYPROLINE. MAGNESIUM ASCORBYL PHOSPHATE. CYCLIC LYSOPHOSPHATIDIC ACID. CENTELLA ASIATICA LEAF EXTRACT. CAPROOYL TETRAPEPTIDE-3. ACETYL DECAPEPTIDE-3.',
        'Sau khi thoa kem dưỡng, thoa một lượng nhỏ gel bằng cách ấn nhẹ vào da khắp mặt và vỗ nhẹ.', './uploads/img/cosmetics/nourishing_gel.jpg', NOW(), NOW());

# show timezone db
SELECT @@global.time_zone, @@session.time_zone;
