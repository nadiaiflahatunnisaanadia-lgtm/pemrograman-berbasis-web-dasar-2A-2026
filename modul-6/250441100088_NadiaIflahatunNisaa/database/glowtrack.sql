USE glowtrack;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    no_hp VARCHAR(20) NOT NULL UNIQUE,
    PASSWORD VARCHAR(255) NOT NULL COLLATE utf8mb4_general_ci,
    ROLE VARCHAR(20) NOT NULL DEFAULT 'user' COLLATE utf8mb4_general_ci,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE skincare (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_produk VARCHAR(150) NOT NULL,
    jenis VARCHAR(100) NOT NULL,
    brand VARCHAR(100) NOT NULL,
    manfaat TEXT NOT NULL,
    tanggal_rilis DATE,
    rating DECIMAL(3,1) DEFAULT 0,
    deskripsi LONGTEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE favorit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    skincare_id INT NOT NULL,
    catatan TEXT,
    status_pakai VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE,

    FOREIGN KEY (skincare_id)
    REFERENCES skincare(id)
    ON DELETE CASCADE
);

CREATE TABLE testimoni (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    skincare_id INT,
    catatan TEXT,
    status_pakai VARCHAR(50)
);

INSERT INTO users (nama, no_hp, PASSWORD, ROLE) VALUES
('pio', '082341567809', '$2y$10$LQv3c1yqBWVHxkd0LHAkCOYz6TtxMQJqhN8/LewY5YmMxSUIqMldi', 'user'),
('cale', '08123456789', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/tzO', 'user'),
('cyla', '08987654321', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/tzO', 'user');

INSERT INTO skincare (nama_produk, jenis, brand, manfaat, tanggal_rilis, rating, deskripsi) VALUES
('Facial Wash Gentle', 'Pembersih', 'CeraVe', 'Membersihkan wajah tanpa mengeringkan, cocok untuk kulit sensitif', '2023-01-15', 4.5, 'Facial wash yang lembut dengan formula ceramide dan hyaluronic acid. Aman untuk kulit sensitif dan tidak menyebabkan iritasi.'),
('Moisturizer Rich Cream', 'Pelembab', 'CeraVe', 'Memberikan kelembaban maksimal dan melindungi barrier kulit', '2023-02-20', 4.7, 'Pelembab kaya dengan ceramide dan hyaluronic acid untuk kulit kering dan sensitif.'),
('Retinol Night Serum', 'Serum', 'The Ordinary', 'Anti-aging, mengurangi garis halus, meratakan tekstur kulit', '2023-03-10', 4.3, 'Serum retinol berkualitas tinggi untuk penggunaan malam hari, membantu mengurangi tanda penuaan.'),
('Sunscreen SPF 50', 'Sunscreen', 'La Roche Posay', 'Proteksi UV maksimal, mencegah photoaging', '2023-04-05', 4.6, 'Sunscreen mineral dengan SPF 50+ yang memberikan perlindungan maksimal dari sinar UV.'),
('Vitamin C Brightening Serum', 'Serum', 'Timeless', 'Mencerahkan kulit, meningkatkan elastisitas, anti-aging', '2023-05-12', 4.4, 'Serum vitamin C 20% dengan ferulic acid dan vitamin E untuk hasil maksimal brightening.'),
('Clay Mask Detox', 'Masker', 'Aztec Secret', 'Detoxifying, membersihkan pori-pori dalam, mengangkat komedo', '2023-06-08', 4.2, 'Masker tanah liat Indian healing clay yang ampuh untuk membersihkan pori-pori dan mengangkat komedo.'),
('Eye Cream Anti-Aging', 'Eye Cream', 'Clinique', 'Mengurangi kerutan di sekitar mata, mengangkat bengkak', '2023-07-15', 4.5, 'Krim mata dengan peptide dan hyaluronic acid untuk area mata yang sensitif.'),
('Essence Hydrating', 'Essence', 'SK-II', 'Melembabkan, meningkatkan texture kulit, brightening', '2023-08-20', 4.8, 'Essence legendary dengan Pitera fermentation untuk kulit yang lebih cerah dan lembut.');

INSERT INTO ROUTINE (user_id, skincare_id, catatan, status_pakai, rating_user) VALUES
(2, 1, 'Digunakan setiap pagi sebelum skincare lainnya', 'aktif', 5),
(2, 2, 'Pelembab favorit, kulit jadi lembut', 'aktif', 5),
(2, 4, 'Wajib pakai setiap hari untuk proteksi UV', 'aktif', 5),
(3, 1, 'Cocok untuk kulit sensitif saya', 'aktif', 4),
(3, 3, 'Digunakan 3x seminggu sebelum tidur', 'aktif', 4),
(3, 5, 'Wajah terasa lebih cerah setelah 2 minggu', 'aktif', 4);

CREATE INDEX idx_user_id ON ROUTINE(user_id);
CREATE INDEX idx_skincare_id ON ROUTINE(skincare_id);

ALTER TABLE skincare
MODIFY rating DECIMAL(3,1);

ALTER TABLE skincare
ADD gambar VARCHAR(255);

ALTER TABLE skincare
ADD link_beli VARCHAR(255);

ALTER TABLE favorit
DROP COLUMN catatan;

ALTER TABLE favorit
DROP COLUMN status_pakai;

ALTER TABLE users
ADD UNIQUE (no_hp);

INSERT INTO users (nama, no_hp, PASSWORD, ROLE)
VALUES (
  'nadia',
  '088123456789',
  '$2y$10$EftkysP3PZZRkXMtwFony.o0XGXE7ZsF3wc/0ulzGJMCU8Af4IfxS',
  'admin'
);