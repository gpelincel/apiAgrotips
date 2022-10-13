DROP DATABASE IF EXISTS hotel;
CREATE DATABASE hotel;
USE hotel;
CREATE TABLE cliente(
    idcliente INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50),
    email VARCHAR(250),
    cep CHAR(8),
    estado CHAR(2),
    cidade VARCHAR(50),
    bairro VARCHAR(50),
    logradouro VARCHAR(200),
    numero VARCHAR(5)
);