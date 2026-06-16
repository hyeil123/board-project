-- 기존 테이블 삭제
DROP TABLE IF EXISTS attachments;
DROP TABLE IF EXISTS comments;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS boards;
DROP TABLE IF EXISTS users;

-- 회원 테이블 생성
-- 사용자 아이디, 비밀번호, 가입일 저장
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 게시판 테이블 생성
-- 서로 다른 주제의 게시판 이름 저장
CREATE TABLE boards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- 기본 게시판 2개 생성
INSERT INTO boards (name) VALUES ('자유게시판'), ('질문게시판');

-- 게시글 테이블 생성
-- 게시판 번호, 작성자 번호, 제목, 본문, 작성 시각 저장
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    board_id INT NOT NULL,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (board_id) REFERENCES boards(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- 댓글 테이블 생성
-- 게시글 번호, 작성자 번호, 댓글 내용, 작성 시각 저장
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- 첨부파일 테이블 생성
-- 원본 파일명, 서버 저장 경로, 파일 크기 저장
CREATE TABLE attachments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    stored_path VARCHAR(255) NOT NULL,
    file_size INT NOT NULL,
    uploaded_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);
