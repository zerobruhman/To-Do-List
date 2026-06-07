CREATE TABLE Todos (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id     INT NOT NULL,                        -- relasi ke tabel users
    judul       VARCHAR(255) NOT NULL,
    deskripsi   TEXT,
    status      ENUM('pending','selesai') DEFAULT 'pending',
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE
);