-- 게시판 데이터베이스 생성
CREATE DATABASE IF NOT EXISTS board_db DEFAULT CHARACTER SET utf8mb4;
USE board_db;

-- 게시글 테이블
-- 게시글 번호(id), 제목(title), 본문(content), 작성 시각(created_at)을 저장
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 댓글 테이블
-- 게시글(post_id)에 달린 댓글 내용과 작성 시각 저장
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);

-- 첨부파일 테이블
-- 원본 파일명, 서버 저장 경로, 파일 크기를 저장
CREATE TABLE IF NOT EXISTS attachments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    stored_path VARCHAR(255) NOT NULL,
    file_size INT NOT NULL,
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);
