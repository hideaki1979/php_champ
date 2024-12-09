INSERT INTO gs_an_table (name, mail, naiyou, indate) VALUES('test1', 'aaa@mail.com', 'ないよ！', sysdate());

INSERT INTO code_master (iden_cd, cd_key, cd_value, indate) VALUES('01', '01', '列に並ぶ前', sysdate());
INSERT INTO code_master (iden_cd, cd_key, cd_value, indate) VALUES('01', '02', '店員から声掛け', sysdate());
INSERT INTO code_master (iden_cd, cd_key, cd_value, indate) VALUES('01', '03', '入店直前', sysdate());
INSERT INTO code_master (iden_cd, cd_key, cd_value, indate) VALUES('01', '04', '入店直後', sysdate());
INSERT INTO code_master (iden_cd, cd_key, cd_value, indate) VALUES('01', '05', '着席前', sysdate());
INSERT INTO code_master (iden_cd, cd_key, cd_value, indate) VALUES('02', '01', '店員に食券提示時', sysdate());
INSERT INTO code_master (iden_cd, cd_key, cd_value, indate) VALUES('02', '02', '入店後店員から', sysdate());
INSERT INTO code_master (iden_cd, cd_key, cd_value, indate) VALUES('02', '03', '食券提示時', sysdate());
INSERT INTO code_master (iden_cd, cd_key, cd_value, indate) VALUES('02', '04', '事前コールなし', sysdate());
INSERT INTO code_master (iden_cd, cd_key, cd_value, indate) VALUES('03', '01', '通常メニュー', sysdate());
INSERT INTO code_master (iden_cd, cd_key, cd_value, indate) VALUES('03', '02', '限定メニュー', sysdate());
INSERT INTO code_master (iden_cd, cd_key, cd_value, indate) VALUES('03', '03', 'メニュー表（券売機）', sysdate());
INSERT INTO code_master (iden_cd, cd_key, cd_value, indate) VALUES('03', '04', '列の並び方などの補足情報', sysdate());


INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('17', 'KADOKAWA', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('18', 'Gakken', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('19', '第三文明社', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('20', '日本能率協会マネジメントセンター', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('21', '新潮社', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('22', 'かんき出版', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('23', 'トライエックス', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('24', '扶桑社', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('25', 'アリス館', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('26', '宝島社', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('27', '文響社', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('28', 'プレジデント社', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('29', 'ブックマン社', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('30', '大和書房', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('31', 'クレヴィス', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('32', '河出書房新社', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('33', '玄光社', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('34', 'ビジネス社', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('35', '文化学園　文化出版局', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('36', '文藝春秋', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('37', '学研教育出版', sysdate());
INSERT INTO code_master (iden_cd, cd_key, indate) VALUES('38', '日経BP', sysdate());

INSERT INTO gs_lifeflg (life_flg, name) VALUES(0, '在職中');
INSERT INTO gs_lifeflg (life_flg, name) VALUES(1, '退職');
INSERT INTO gs_lifeflg (life_flg, name) VALUES(2, '休職中');

INSERT INTO gs_an_table (name, mail, naiyou, indate) VALUES(:name, :mail, :naiyou, sysdate());

SELECT * FROM gs_an_table;
SELECT id, name FROM gs_an_table;

SELECT * FROM gs_an_table WHERE id=2;