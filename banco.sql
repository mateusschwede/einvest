CREATE DATABASE einvest;
USE einvest;

CREATE TABLE analista (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(30) NOT NULL,
    senha VARCHAR(5) NOT NULL
);
INSERT INTO analista(nome,senha) VALUES ("aaa","111"),("bbb","222");

CREATE TABLE cliente (
    cpf VARCHAR(11) NOT NULL,
    nome VARCHAR(60),
    email VARCHAR(60),
    telefone VARCHAR(11),
    senha VARCHAR(5)
);
INSERT INTO cliente(cpf,nome,email,celular,senha) VALUES ("00000000000","cliente x","cliente@outlook.com","51999415233","12345");

CREATE TABLE acao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cnpj VARCHAR(12) NOT NULL,
    nome VARCHAR(60) NOT NULL,
    atividade VARCHAR(60) NOT NULL,
    setor VARCHAR(60) NOT NULL,
    preco FLOAT NOT NULL
);
INSERT INTO acao(cnpj,nome,atividade,setor,preco) VALUES ("111111111111","empresa x","produção de alimentos","alimentício",26);

CREATE TABLE carteira (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(60) NOT NULL,
    precoInvestimento FLOAT NOT NULL,
    cpfCliente VARCHAR(11) NOT NULL
);
INSERT INTO carteira(nome,precoInvestimento,cpfCliente) VALUES ("carteira do filho",5000,"00000000000");

CREATE TABLE carteira_acao (
    idCarteira INT NOT NULL,
    idAcao INT NOT NULL,
    percentual INT NOT NULL
);
INSERT INTO carteira_acao(idCarteira,idAcao,percentual) VALUES (1,1,100);